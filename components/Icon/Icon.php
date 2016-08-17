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
		// cache the svg files
		$this->svgs = array();
	}
	function render( $props ) {
		$svg = null;
		if ( array_key_exists( $props[ 'icon' ], $this->svgs ) ) {
			// load from cache
			$svg = simplexml_load_string( $this->svgs[ $props[ 'icon' ] ] );
		} else {
			// load from file
			$svg_file = file_get_contents( get_component_directory( __FILE__ ) . '/svg/' . $props[ 'icon' ] . '.svg' );
			$this->svgs[ $props[ 'icon' ] ]  = $svg_file;
			$svg = simplexml_load_string( $svg_file );
		}

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