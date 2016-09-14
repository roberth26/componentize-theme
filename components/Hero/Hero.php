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
		<?php $c = $this->get_classes(); ?>
		<section class="<?= $c[ 'block' ]; ?> <?php if ( $props[ 'tall' ] ) echo $c[ 'block--tall' ]; ?>">
			<div class="<?= $c[ 'container' ]; ?>">
				<h1 class="<?= $c[ 'title' ]; ?>"><?php echo $props[ 'title' ]; ?></h1>
				<h2 class="<?= $c[ 'subtitle' ]; ?>"><?php echo $props[ 'subtitle' ]; ?></h2>
			</div>
		</section>
	<?php }
}
?>