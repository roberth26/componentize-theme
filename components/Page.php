<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Page extends AbstractComponent {
	function __construct() {
		// set the default props
		$this->set_default_props( array(
			'title' => 'Page Title',
			'content' => function() {},
			'menu_items' => array(),
			'social_menu_items' => array(),
			'current_page_id' => 0
		));
	}
	function on_import() {
		import( 'Header' );
		import( 'Footer', false ); // below the fold
	}
	function render( $props ) { ?>
		<!doctype html>
		<html>
			<head>
			    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
			    <title><?php echo $props[ 'title' ]; ?></title>
			    <?php wp_head(); ?>
			</head>
			<body <?php body_class(); ?>>
				<?php render( 'Header', array(
					'menu_items' => $props[ 'menu_items' ],
					'current_page_id' => $props[ 'current_page_id' ]
				)); ?>
				<?php call_user_func( $props[ 'content' ] ); ?>
				<?php render( 'Footer', array(
					'menu_items' => $props[ 'menu_items' ],
					'social_menu_items' => $props[ 'social_menu_items' ],
					'current_page_id' => $props[ 'current_page_id' ]
				)); ?>
				<?php wp_footer(); ?>
			</body>
		</html>
	<?php }
}
?>