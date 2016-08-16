<?php
import( 'Page' );
import( 'Hero' );
import( 'FeatureBlock' );

the_post();
$menu_items = wp_get_nav_menu_items( 'Primary' );
$social_menu_items = wp_get_nav_menu_items( 'Social' );

render( 'Page', array(
	'title' => 'Home',
	'menu_items' => $menu_items,
	'social_menu_items' => $social_menu_items,
	'current_page_id' => get_the_id(),
	'content' => function() { ?>
		<?php render( 'Hero', array(
			'title' => 'The &ldquo;Front Page&rdquo; Template',
			'subtitle' => 'A Neat Subtitle Goes Here',
			'tall' => true
		)); ?>
		<div class="container">
			<div class="row">
				<div class="col-12-mobile col-12-desktop">
					<?php render( 'FeatureBlock' ); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-12-mobile col-12-desktop">
					<section class="features">
						<div class="features__item">
							<?php echo get_field( 'feature1' ); ?>
						</div>
						<div class="features__item">
							<?php echo get_field( 'feature2' ); ?>
						</div>
						<div class="features__item">
							<?php echo get_field( 'feature3' ); ?>
						</div>
					</section>
					<section class="section">
						<?php the_content(); ?>
					</main>
				</div>
			</div>
		</div>
	<?php }
));
?>