<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class FeatureBlock extends AbstractComponent {
	function __construct() {
		// expose this component as a shortcode
		$this->enable_shortcode();
		// set the default props
		$this->set_default_props( array(
			'title' => 'Feature Block',
			'alt' => false,
			'image' => get_component_directory_uri( __FILE__ ) . '/img/slo.jpg'
		));
	}
	function render( $props ) { ?>
		<?php $c = $this->get_classes(); ?>
		<div class="<?= $c[ 'block' ]; ?> <?php if ( $props[ 'alt' ] ) echo $c[ 'block--alt' ]; ?>">
			<h2 class="<?= $c[ 'title' ]; ?>"><?php echo $props[ 'title' ]; ?></h2>
			<img class="<?= $c[ 'image' ]; ?>" src="<?php echo $props[ 'image' ]; ?>" />
			<p class="<?= $c[ 'excerpt' ]; ?>">Donec eget mi lectus. Nulla condimentum purus quis justo convallis, vitae pharetra dolor facilisis. Nunc eu lacus enim. Quisque magna odio, semper sed consectetur at, auctor sit amet mi.</p>
		</div>
	<?php }
}
?>