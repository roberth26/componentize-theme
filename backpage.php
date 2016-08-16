<?php
// Template Name: Backpage
import( 'Page' );
import( 'Sidebar', false ); // below the fold
import( 'Hero' );
import( 'PhotoFeature', false ); // below the fold

the_post();
$menu_items = wp_get_nav_menu_items( 'Primary' );
$social_menu_items = wp_get_nav_menu_items( 'Social' );

render( 'Page', array(
	'title' => 'backpage',
	'menu_items' => $menu_items,
	'social_menu_items' => $social_menu_items,
	'current_page_id' => get_the_id(),
	'content' => function() { ?>
		<?php render( 'Hero', array(
			'title' => 'The &ldquo;Backpage&rdquo; Template',
			'subtitle' => 'A Cool Subtitle Was Once Here'
		)); ?>
		<div class="container">
			<div class="row">
				<div class="col-12-mobile col-8-desktop">
					<main class="main">
						<h1><?php the_title(); ?></h1>
						<?php the_content(); ?>
						<p>This PhotoFeature is rendered by the theme:</p>
						<?php render( 'PhotoFeature' ); ?>
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