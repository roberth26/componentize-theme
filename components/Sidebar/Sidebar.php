<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Sidebar extends AbstractComponent {
	function render( $props ) { ?>
		<aside class="sidebar">
			<?php
				if ( is_active_sidebar( 'sidebar' ) ) {
					dynamic_sidebar( 'sidebar' );
				}
			?>
		</aside>
	<?php }
}
?>