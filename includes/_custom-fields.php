<?php
add_filter( 'acf/load_field/name=route', function( $field ) {
	$choices = array();
	$choices[] = '-- None --';
	foreach( glob( get_template_directory() . '/routes/{[!_]*.php,*/[!_]*.php}', GLOB_BRACE ) as $route ) {
		$choices[] = str_replace( '.php', '', basename( $route ) );
	}
    $field[ 'choices' ] = $choices;
    return $field;    
});
?>