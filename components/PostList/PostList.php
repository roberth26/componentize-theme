<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class PostList extends AbstractComponent {
	function __construct() {
		// set the default props
		$this->set_default_props( array(
			'posts' => array()
		));
	}
	function render( $props ) { ?>
		<?php $c = $this->get_classes(); ?>
		<?php foreach( $props[ 'posts' ] as $post ) : ?>
			<article class="<?= $c[ 'post' ]; ?>" id="<?php echo $post->ID; ?>">
				<a href="<?php echo get_permalink( $post->ID ); ?>">
					<h1 class="<?= $c[ 'title' ]; ?>"><?php echo $post->post_title; ?></h1>
					<img class="<?= $c[ 'image' ]; ?>" width="200px" height="200px"
						src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) )[ 0 ]; ?>" />
				</a>
				<div class="<?= $c[ 'excerpt' ]; ?>"><?php echo apply_filters( 'the_content', $post->post_content ); ?></div>
			</article>
		<?php endforeach; ?>
	<?php }
}
?>