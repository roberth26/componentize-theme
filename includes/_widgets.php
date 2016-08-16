<?php
add_action( 'widgets_init', function() {
	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar',
		'before_widget' => '<div class="sidebar__widget">',
		'after_widget'  => '</div>'
	));
});
?>