<?php

$registry->page_number = isset( $registry->request->params->page_number ) ? $registry->request->params->page_number : 1;

if ( $registry->controller == 'list' ) {
	$registry->total_location_count = $stg->getLocationCount();
}
else {
	$registry->total_location_count = $stg->getLocationCount( $registry->search_params, $registry->geocode_status );
	$registry->search_results_exist = (bool) $registry->total_location_count;
	$registry->active_search = (bool)count( $_GET );
}


$registry->total_pages = ceil( $registry->total_location_count / $config['locations_per_page'] );
if ( $registry->page_number < 1 || ( $registry->page_number > $registry->total_pages && $registry->total_pages != 0 ) ) {
	header("HTTP/1.1 404 Not Found");
	$status_message->setStatuses( array( 'error', 'block-message', 'remain' ) );
	$status_message->setMessage( "<p><strong>Page not found</strong></p>" );
	require( DIR_VIEWS . '/pages/error.php' );
	exit;
}

// Pagination size error checking
if ( $config['pagination_viewport'] < 0 || $config['pagination_viewport'] > 7 ) {
	$config['pagination_viewport'] = 4;
}

$start_page = max( $registry->page_number - $config['pagination_viewport'], 1 ); // 22
$end_page = min( $start_page + ( $config['pagination_viewport']*2 ), $registry->total_pages ); // 28
$start_page = max( $end_page - ( $config['pagination_viewport']*2 ), 1 );

$registry->page_array = range($start_page,$end_page);
$registry->query = '?' . $_SERVER['QUERY_STRING'];

$registry->prev_page = $registry->page_number != 1 ? $registry->page_number - 1 : null;
$registry->next_page = $registry->page_number + 1 <= $registry->total_pages ? $registry->page_number + 1 : null;

if ( $registry->controller == 'list' ) {
	$registry->locations = $stg->getLocations( ($registry->page_number-1)*$config['locations_per_page'], $config['locations_per_page'], null, null, isset( $_GET['order_by'] ) ? $_GET['order_by'] : null, isset( $_GET['order_dir'] ) ? $_GET['order_dir'] : null );
}
else {
	$registry->locations = $stg->getLocations( ($registry->page_number-1)*$config['locations_per_page'], $config['locations_per_page'], $registry->search_params, $registry->geocode_status, isset( $_GET['order_by'] ) ? $_GET['order_by'] : null, isset( $_GET['order_dir'] ) ? $_GET['order_dir'] : null  );
}

$registry->location_ids = array_map( function($s){return $s->getId();}, $registry->locations );

$registry->all_locations_geocoded = true;
foreach( $registry->locations as $location ) {
	if ( !$location->isGeocoded() ) {
		$registry->all_locations_geocoded = false;
	}
}

$registry->page_location_count = count( $registry->locations );

$registry->page_location_first_num = ($registry->page_number-1)*$config['locations_per_page']+1;
$registry->page_location_last_num = ($registry->page_number-1)*$config['locations_per_page'] + ( $registry->page_location_count < $config['locations_per_page'] ? $registry->page_location_count : $config['locations_per_page'] );

require( DIR_VIEWS . '/pages/' . $registry->controller . '.php' );