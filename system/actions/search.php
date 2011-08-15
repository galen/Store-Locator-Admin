<?php

/*
$search_params = array (
	array( 'country', '=', 'US' ),
	array( 'state', '=', 'CT' )
);
*/

$search_params = isset( $_GET['search_params'] ) ? $_GET['search_params'] : null;

$vars['total_location_count'] = $stg->getCount( $search_params );
$vars['total_pages'] = ceil( $vars['total_location_count'] / LOCATIONS_PER_PAGE );

$vars['prev_page'] = $vars['page_number'] != 1 ? $vars['page_number'] - 1 : null;

$vars['next_page'] = $vars['page_number'] + 1 <= $vars['total_pages'] ? $vars['page_number'] + 1 : null;

$vars['locations'] = $stg->getLocations( ($vars['page_number']-1)*LOCATIONS_PER_PAGE, LOCATIONS_PER_PAGE, $search_params );
$vars['page_location_count'] = count( $vars['locations'] );

$vars['page_location_first_num'] = ($vars['page_number']-1)*LOCATIONS_PER_PAGE+1;
$vars['page_location_last_num'] = ($vars['page_number']-1)*LOCATIONS_PER_PAGE + ( $vars['page_location_count'] < LOCATIONS_PER_PAGE ? $vars['page_location_count'] : LOCATIONS_PER_PAGE );


require( DIR_SYSTEM . '/views/search.php' );