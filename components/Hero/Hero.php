<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Hero extends AbstractComponent {
	function __construct() {
		// set the default props
		$this->set_default_props( array(
			'tall' => false,
			'title' => 'Feature Block Title',
			'subtitle' => 'Feature Block Subtitle'
		));
	}
	function render( $props ) { ?>
		<section class="hero <?php echo ( $props[ 'tall' ] ? 'hero--tall' : '' ); ?>">
			<div class="hero__content">
				<h1 class="hero__title"><?php echo $props[ 'title' ]; ?></h1>
				<h2 class="hero__subtitle"><?php echo $props[ 'subtitle' ]; ?></h2>
			</div>
		</section>
	<?php }
}
?>