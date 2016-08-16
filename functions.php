<?php

$components = array();
$current_template = array(
	'name' => '',
	'scripts' => array(),
	'stylesheets' => array()
);

add_theme_support( 'post-thumbnails' ); 
add_theme_support( 'menus' );
add_theme_support( 'widgets' );
add_theme_support( 'html5' );

// remove emoji crap
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

include_once( 'includes/_widgets.php' );
include_once( 'includes/_custom-post-types.php' );
include_once( 'includes/_shortcodes.php' );
include_once( 'includes/_menus.php' );
include_once( 'includes/_custom-fields.php' );

// load components
add_action( 'init', function() {
	global $components;
	// find all components
	foreach( glob( get_template_directory() . '/components/{[!_]*.php,*/[!_]*.php}', GLOB_BRACE ) as $component_file ) {
		$component_name = str_replace( '.php', '', basename( $component_file ) );
		if ( $component_name == 'AbstractComponent' )
			continue;
		include( $component_file );
		$component = new $component_name();
		$component->set_name( $component_name );
		$component->set_directory( dirname( $component_file ) );
		if ( $component->has_shortcode() ) {
			register_component_shortcode( $component );
		}

		// component's directory URI
		$dir = '/' . basename( dirname( $component_file ) );
		if ( $dir == '/components' )
			$dir = '';
		$dir = get_stylesheet_directory_uri() . '/components' . $dir;
		$component->set_directory_uri( $dir );

		// component's assets
		foreach( glob( $component->get_directory() . '/*.min.{css,js}', GLOB_BRACE ) as $asset_file ) {
			$file = basename( $asset_file );
			$dir = basename( dirname( $asset_file ) ) . '/';
			if ( $dir == 'components/' )
				$dir = '';
			$uri = get_stylesheet_directory_uri() . '/components/' . $dir . $file;
			$asset = array(
				'path' => $asset_file,
				'uri' => $uri
			);
			switch( pathinfo( $asset_file, PATHINFO_EXTENSION ) ) {
				case 'js': {
					$component->add_script( $asset );
					break;
				}
				case 'css': {
					$component->add_stylesheet( $asset );
					break;
				}
			}
		}

		$components[ $component_name ] = $component;
	}
});

// auto import components rendered via shortcodes
add_action( 'wp_head', function() {
	global $components;
	global $post;
	foreach( $components as $component ) {
		if ( $component->has_shortcode() ) {
			if ( has_shortcode( $post->post_content, $component->get_name() ) ) {
				import( $component->get_name() );
			}
		}
	}
});

function import( $component_name, $above_fold = true ) {
	global $components;
	if ( !array_key_exists( $component_name, $components ) )
		return; // return empty if component doesnt exist
	$component = $components[ $component_name ];
	if ( $component->is_imported() ) {
		// this component is already imported, but needs to be promoted to above-the-fold
		if ( !$component->is_above_fold() && $above_fold ) {
			$component->set_above_fold( true );
			$components[ $component_name ] = $component;
		}
		return; // return early if component is already imported
	}

	$component->set_above_fold( $above_fold );
	$component->set_imported( true );
	$component->on_import();
	$components[ $component_name ] = $component;
}

function register_component_shortcode( $component ) {
	add_shortcode( $component->get_name(), function( $props = array() ) use ( $component ) {
		$props = shortcode_atts( $component->get_default_props(), $props, $component->get_name() );
		ob_start();
		render( $component->get_name(), $props );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	});
}

// render a component
function render( $component, $props = array() ) {
    global $components;
    if ( !array_key_exists( $component, $components ) )
    	return; // return empty if component doesnt exist
    $component = $components[ $component ];
    $props = array_merge( $component->get_default_props(), $props );
    $component->render( $props );
}

add_filter( 'template_include', function( $t ) {
	global $current_template;
	$current_template[ 'name' ] = str_replace( '.php', '', basename( $t ) );

	// move jquery to footer and use cdn
	wp_deregister_script( 'jquery' );
	wp_register_script(
		'jquery',
		'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
		'',
		'2.1.3',
		true
	);
	wp_enqueue_script( 'jquery' );

	// gather the template's js and css assets
	foreach( glob( get_template_directory() . '/' . $current_template[ 'name' ] . '/*.min.{css,js}', GLOB_BRACE ) as $asset ) {
		switch( pathinfo( $asset, PATHINFO_EXTENSION ) ) {
			case 'js': {
				$current_template[ 'scripts' ][] = $asset;
				/*
				// external scripts
				$file = basename( $asset );
				$dir = basename( dirname( $asset ) );
				$path = get_stylesheet_directory_uri() . '/' . $dir . '/' . $file;
				wp_enqueue_script(
					$current_template[ 'name' ],
					$path,
					'jquery',
					'1',
					true
				);
				*/
				break;
			}
			case 'css': {
				$current_template[ 'stylesheets' ][] = $asset;
				break;
			}
		}
	}

	return $t;
});

/*
	Automatically import the search-form component
	when the Search widget is active
*/
add_action( 'wp_head', function() {
	global $wp_registered_sidebars;
	$search_widget = false;
	foreach( $wp_registered_sidebars as $name => $sidebar ) {
		foreach( get_option( 'sidebars_widgets' )[ $name ] as $index => $widget_name ) {
			if ( strpos( $widget_name, 'search-' ) !== false ) {
			    $search_widget = true;
			    break;
			}
		}
		if ( $search_widget ) break;
	}
	if ( $search_widget ) import( 'SearchForm' );
});

// print above-the-fold css as inline
add_action( 'wp_head', function() {
	global $current_template;
	global $components;
	echo '<style id="above-fold">';
	$global_css = get_template_directory() . '/css/global.min.css';
	if ( file_exists( $global_css ) ) {
		echo file_get_contents( $global_css );
	}
	foreach( $components as $component ) {
		if ( $component->is_imported() && $component->is_above_fold() ) {
			foreach( $component->get_stylesheets() as $stylesheet ) {
				echo file_get_contents( $stylesheet[ 'path' ] );
			}
		}
	}
	foreach( $current_template[ 'stylesheets' ] as $stylesheet ) {
		echo file_get_contents( $stylesheet );
	}
	echo '</style>';
});

// print below-the-fold css as inline, then hoist
add_action( 'wp_footer', function() {
	global $current_template;
	global $components;
	$below_fold_styles = '';
	foreach( $components as $component ) {
		if ( $component->is_imported() && !$component->is_above_fold() ) {
			foreach( $component->get_stylesheets() as $stylesheet ) {
				$below_fold_styles .= file_get_contents( $stylesheet[ 'path' ] );
			}
		}
	}
	// remove newlines
	$below_fold_styles = trim( preg_replace( '/\r|\n/', '', $below_fold_styles ) );
	?>
	<script>
		(function() {
			var above_fold_styles = document.getElementById( 'above-fold' );
			var below_fold_styles = document.createElement( 'style' );
			below_fold_styles.setAttribute( 'id', 'below-fold' );
			below_fold_styles.innerHTML = '<?php echo str_replace( "'", '"', $below_fold_styles ); ?>';
			above_fold_styles.parentNode.insertBefore( below_fold_styles, above_fold_styles.nextSibling );
		}());
	</script>
	<?php
});

/* // external scripts
add_action( 'wp_footer', function() use ( $component ) {
	foreach( $component->get_scripts() as $index => $script ) { ?>
		<script src="<?php echo $script[ 'uri' ]; ?>"></script>
	<?php }
}, PHP_INT_MAX );
*/

// inline scripts
add_action( 'wp_footer', function() {
	global $components;
	global $current_template;
	$output = '';
	foreach( $components as $component ) {
		if ( $component->is_imported() ) {
			if ( count( $component->get_scripts() ) ) {
				foreach( $component->get_scripts() as $index => $script ) {
					$output .= file_get_contents( $script[ 'path' ] );
				}
			}
		}
	}
	foreach( $current_template[ 'scripts' ] as $script ) {
		$output .= file_get_contents( $script );
	}
	if ( strlen( $output ) ) {
		echo '<script>';
		echo $output;
		echo '</script>';
	}
}, PHP_INT_MAX );

/*
	Public function to retrieve the directory URI of a component
	Can be called with the string name of a component, anywhere in the theme.
	Can be called within a component, by passing in __FILE__ to retrieve
	the current directory URI.
*/
function get_component_directory_uri( $component = null ) {
	if ( is_null( $component ) )
		return get_stylesheet_directory_uri() . '/components';
	global $components;
	if ( is_file( $component ) ) {
		$dir = basename( dirname( $component ) );
		if ( $dir == 'components' )
			$dir = '';
		return get_stylesheet_directory_uri() . '/components/' . $dir;
	} else {
		if ( !array_key_exists( $component, $components ) )
			return null; // return null if component doesnt exists
		return $components[ $component ]->get_directory_uri();
	}
}

/*
	Public function to retrieve the directory path of a component
	Can be called with the string name of a component, anywhere in the theme.
	Can be called within a component, by passing in __FILE__ to retrieve
	the current directory path.
*/
function get_component_directory( $component = null ) {
	if ( is_null( $component ) )
		return get_template_directory() . '/components';
	global $components;
	if ( is_file( $component ) ) {
		return dirname( $component );
	} else {
		if ( !array_key_exists( $component, $components ) )
			return null; // return null if component doesnt exists
		return $components[ $component ]->get_directory();
	}
}

?>