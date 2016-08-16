<?php
import( 'Page' );
import( 'Sidebar', false ); // below the fold
import( 'Hero' );
import( 'PostList' );

$qo = get_queried_object();
$menu_items = wp_get_nav_menu_items( 'Primary' );
$social_menu_items = wp_get_nav_menu_items( 'Social' );
$posts = $wp_query->get_posts();

render( 'Page', array(
	'title' => 'Blog',
	'menu_items' => $menu_items,
	'social_menu_items' => $social_menu_items,
	'current_page_id' => $qo->ID,
	'content' => function() use ( $posts ) { ?>
		<?php render( 'Hero', array(
			'title' => 'The &ldquo;Category&rdquo; Template',
			'subtitle' => 'A Bloggy Subtitle Full of Buzzwords'
		)); ?>
		<div class="container">
			<div class="row">
				<div class="col-12-mobile col-8-desktop">
					<main class="main">
						<?php render( 'PostList', array(
							'posts' => $posts
						)); ?>
					</main>
				</div>
				<div class="col-12-mobile col-4-desktop">
					<?php render( 'Sidebar' ); ?>
				</div>
			</div>
		</div>
	<?php }
));
?>