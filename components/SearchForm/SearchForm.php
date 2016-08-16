<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class SearchForm extends AbstractComponent {
	function render( $props ) { ?>
		<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
			<input type="search" class="search-form__field" placeholder="Search…" name="s" />
			<button type="submit" class="search-form__button">Go</button>
		</form>
	<?php }
}
?>