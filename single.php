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
						<h1><?php the_title(); ?></h1>
						<?php the_content(); ?>
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