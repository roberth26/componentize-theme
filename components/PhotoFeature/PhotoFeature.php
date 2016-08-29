<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class PhotoFeature extends AbstractComponent {
	function __construct() {
		// expose this component as a shortcode
		$this->enable_shortcode();
		// set the default props
		$this->set_default_props( array(
			'images' => array()
		));
	}
	function on_import() {
		wp_enqueue_script(
			'bxslider',
			'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.5/jquery.bxslider.min.js',
			'jquery',
			'4.2.5',
			true
		);
	}
	function render( $props ) { ?>
		<?php
			$images = $props[ 'images' ];
			if ( is_string( $props[ 'images' ] ) )
				$images = explode( ',', $props[ 'images' ] );
			if ( !count( $images ) ) { // if images weren't provided, use /img folder
				$images = glob( get_component_directory( __FILE__ ) . '/img/*.jpg' );
				foreach( $images as $index => $image ) {
					$images[ $index ] = get_component_directory_uri( __FILE__ ) . '/img/' . basename( $image );
				}
			}
		?>
		<section class="<?php echo $this->get_css( 'block' ); ?>">
			<header class="<?php echo $this->get_css( 'header' ); ?>">
				<h1 class="<?php echo $this->get_css( 'title' ); ?>">PhotoFeature</h1>
				<h3 class="<?php echo $this->get_css( 'count' ); ?>">
					<span class="current-slide">1</span> of <span class="total-slides"><?php echo count( $images ); ?></span>
				</h3>
			</header>
			<ul class="slider" style="display: none;">
				<?php foreach( $images as $image ) : ?>
					<li class="slide">
						<img class="<?php echo $this->get_css( 'image' ); ?>" src="<?php echo $image; ?>" />
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php }
}
?>