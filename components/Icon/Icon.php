<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Icon extends AbstractComponent {
	function __construct() {
		// expose this component as a shortcode
		$this->enable_shortcode();
		// set the default props
		$this->set_default_props( array(
			'icon' => 'email',
			'fill' => '',
			'class' => '',
			'width' => '',
			'height' => ''
		));
	}
	function render( $props ) {
		$svg = simplexml_load_file( get_component_directory( __FILE__ ) . '/svg/' . $props[ 'icon' ] . '.svg' );
		$svg = dom_import_simplexml( $svg );

		if ( strlen( $props[ 'class' ] ) ) {
			$class = $svg->getAttribute( 'class' );
			$svg->setAttribute( 'class', $class . ' ' . $props[ 'class' ] );
		}

		if ( strlen( $props[ 'width' ] ) ) {
			$svg->setAttribute( 'width', $props[ 'width' ] );
		}

		if ( strlen( $props[ 'height' ] ) ) {
			$svg->setAttribute( 'height', $props[ 'height' ] );
		}

		if ( strlen( $props[ 'fill' ] ) ) {
			foreach ( $svg->getElementsByTagName( 'path' ) as $path ) {
			    $path->setAttribute( 'fill', $props[ 'fill' ] );
			}
		}

		echo $svg->ownerDocument->saveXML( $svg->ownerDocument->documentElement );
	}
}
?>