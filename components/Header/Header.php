<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Header extends AbstractComponent {
	function __construct() {
		// expose this component as a shortcode
		$this->enable_shortcode();
		// set the default props
		$this->set_default_props( array(
			'menu_items' => array(),
			'current_page_id' => 0
		));
	}
	function on_import() {
		// import other components
		import( 'Menu' );
	}
	function render( $props ) { ?>
		<header class="header">
			<div class="header__container">
				<a class="header__logo-link" href="<?php echo get_home_url(); ?>">
					<h1 class="header__logo">Logo</h1>
				</a>
				<nav class="header__nav">
					<?php render( 'Menu', array(
						'menu_items' => $props[ 'menu_items' ],
						'current_page_id' => $props[ 'current_page_id' ]
					)); ?>
				</nav>
			</div>
		</header>
	<?php }
}
?>