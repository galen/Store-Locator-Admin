<?php

function e( $str ) {
	echo htmlentities( $str, ENT_QUOTES, 'UTF-8' );
}

function prettify_var( $table_name ) {
	return ucwords( preg_replace( '~-|_~', ' ', $table_name ) );
}

function get_body_classes( $config ) {
	$classes = array();
	if ( $config['autoremove_statuses'] > 0 ) $classes[] = 'autoremove_statuses';
	return implode( ' ', $classes );
}

function get_body_data( $config ) {
	$data = array();
	if ( $config['autoremove_statuses'] > 0 ) $data[] = sprintf('data-autoremove-statuses-time="%s"', (int)$config['autoremove_statuses'] );
	return sprintf( "%s%s", count( $data ) ? ' ' : '', implode( ' ', $data ) );
}

function add_to_query( $query, array $add_to_query ) {
	parse_str( trim( $query, '?' ), $a );
	return http_build_query( array_merge( $a, $add_to_query ) );
}