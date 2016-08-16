<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Footer extends AbstractComponent {
	function __construct() {
		// expose this component as a shortcode
		$this->enable_shortcode();
		// set the default props
		$this->set_default_props( array(
			'menu_items' => array(),
			'social_menu_items' => array(),
			'current_page_id' => 0
		));
	}
	function on_import() {
		// import other components
		import( 'Menu' );
	}
	function render( $props ) { ?>
		<footer class="footer">
			<div class="container">
				<h1 class="footer__logo">Logo</h1>
				<nav class="footer__nav">
					<?php render( 'Menu', array(
						'vertical' => true,
						'center' => true,
						'dark' => true,
						'menu_items' => $props[ 'menu_items' ],
						'current_page_id' => $props[ 'current_page_id' ]
					)); ?>
				</nav>
				<?php render( 'Menu', array(
					'menu_items' => $props[ 'social_menu_items' ],
					'icon_menu' => true,
					'center' => true
				)); ?>
			</div>
		</footer>
	<?php }
}
?>