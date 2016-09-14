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
		<?php $c = $this->get_classes(); ?>
		<header class="<?= $c[ 'block' ]; ?>">
			<div class="<?= $c[ 'container' ]; ?>">
				<a class="<?= $c[ 'logo-link' ]; ?>" href="<?php echo get_home_url(); ?>">
					<h1 class="<?= $c[ 'logo' ]; ?>">Logo</h1>
				</a>
				<nav class="<?= $c[ 'nav' ]; ?>">
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