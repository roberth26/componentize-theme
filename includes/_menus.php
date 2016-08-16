<?php
// render shortcodes in menus
add_filter( 'wp_nav_menu_items', function( $items, $args ) {
	return do_shortcode( $items );
}, 10, 2 );
?>