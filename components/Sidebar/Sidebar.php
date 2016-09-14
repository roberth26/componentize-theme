<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Sidebar extends AbstractComponent {
	function render( $props ) { ?>
		<?php $c = $this->get_classes(); ?>
		<aside class="<?= $c[ 'sidebar' ]; ?>">
			<?php
				if ( is_active_sidebar( $props[ 'sidebar' ] ) ) {
					dynamic_sidebar( $props[ 'sidebar' ] );
				}
			?>
		</aside>
	<?php }
}
?>