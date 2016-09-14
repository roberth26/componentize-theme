<?php
import( 'Page' );
import( 'Sidebar', false ); // below the fold
import( 'Hero' );
import( 'PostList' );

$qo = get_queried_object();
$menu_items = wp_get_nav_menu_items( 'Primary' );
$social_menu_items = wp_get_nav_menu_items( 'Social' );
$search_results = $wp_query->get_posts();

render( 'Page', array(
	'title' => 'Blog',
	'menu_items' => $menu_items,
	'social_menu_items' => $social_menu_items,
	'current_page_id' => $qo->ID,
	'content' => function() use ( $search_results ) { ?>
		<?php render( 'Hero', array(
			'title' => 'The &ldquo;Search&rdquo; Template',
			'subtitle' => 'Showing results for &ldquo;' . get_search_query() . '&rdquo;:'
		)); ?>
		<div class="container">
			<div class="row">
				<div class="col-12-mobile col-8-desktop">
					<main class="main">
						<?php render( 'PostList', array(
							'posts' => $search_results
						)); ?>
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