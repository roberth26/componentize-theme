<?php
import( 'Page' );
import( 'Sidebar', false ); // below the fold
import( 'Hero' );

$qo = get_queried_object();
$menu_items = wp_get_nav_menu_items( 'Primary' );
$social_menu_items = wp_get_nav_menu_items( 'Social' );
the_post();

render( 'Page', array(
	'title' => 'Post',
	'menu_items' => $menu_items,
	'social_menu_items' => $social_menu_items,
	'current_page_id' => $qo->ID,
	'content' => function() { ?>
		<?php render( 'Hero', array(
			'title' => 'The &ldquo;Single&rdquo; Template',
			'subtitle' => 'A Single Blog Post'
		)); ?>
		<div class="container">
			<div class="row">
				<div class="col-12-mobile col-8-desktop">
					<main class="main">
						<article class="post">
							<h1 class="post__title"><?php the_title(); ?></h1>
							<img class="post__image" width="200px" height="200px"
								src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) )[ 0 ]; ?>" />
							<div class="post__content">
								<?php the_content(); ?>
							</div>
						</article>
					</main>
				</div>
				<div class="col-12-mobile col-4-desktop">
					<?php render( 'Sidebar', array(
						'sidebar' => 'sidebar'
					)); ?>
				</div>
			</div>
		</div>
	<?php }
));
?>