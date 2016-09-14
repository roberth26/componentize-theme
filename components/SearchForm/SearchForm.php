<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class SearchForm extends AbstractComponent {
	function render( $props ) { ?>
		<?php $c = $this->get_classes(); ?>
		<form role="search" method="get" class="<?= $c[ 'form' ]; ?>" action="<?php echo home_url( '/' ); ?>">
			<input type="search" class="<?= $c[ 'field' ]; ?>" placeholder="Search…" name="s" />
			<button type="submit" class="<?= $c[ 'button' ]; ?>">Go</button>
		</form>
	<?php }
}
?>