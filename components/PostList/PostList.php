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
		<?php foreach( $props[ 'posts' ] as $post ) : ?>
			<article class="post" id="<?php echo $post->ID; ?>">
				<a href="<?php echo get_permalink( $post->ID ); ?>">
					<img class="post__image" width="200px" height="200px"
						src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) )[ 0 ]; ?>" />
					<h1 class="post__title"><?php echo $post->post_title; ?></h1>
				</a>
				<div class="post__excerpt"><?php echo apply_filters( 'the_content', $post->post_content ); ?></div>
			</article>
		<?php endforeach; ?>
	<?php }
}
?>