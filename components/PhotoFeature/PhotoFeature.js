(function( $ ) {
	var css = require( './PhotoFeature.css.json' );
	
	$( '.' + css.block ).each( function() {
		var $current_slide = $( this ).find( '.current-slide' );
		$( this ).find( '.slider' ).show().bxSlider({
			pager: false,
			onSlidePrev: function( $slide_element, old_index, new_index ) {
				$current_slide.text( new_index + 1 );
			},
			onSlideNext: function( $slide_element, old_index, new_index ) {
				$current_slide.text( new_index + 1 );
			}
		});
	});
}( jQuery ));