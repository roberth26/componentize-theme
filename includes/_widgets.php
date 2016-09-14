<?php
add_action( 'widgets_init', function() {
	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar',
		'before_widget' => '<div class="sidebar-widget">',
		'after_widget'  => '</div>'
	));
});

add_filter( 'widget_text', 'do_shortcode' );
?>