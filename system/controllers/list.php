<?php

$vars->page_number = isset( $vars->request->params->page_number ) ? $vars->request->params->page_number : 1;

if ( $vars->controller == 'list' ) {
	$vars->total_store_count = $stg->getCount();
}
else {
	$vars->total_store_count = $stg->getCount( $vars->search_params, $vars->geocode_status );
}
$vars->total_pages = ceil( $vars->total_store_count / $config['stores_per_page'] );
if ( $vars->page_number < 1 || ( $vars->page_number > $vars->total_pages && $vars->total_pages != 0 ) ) {
	header("HTTP/1.1 404 Not Found");
	$status_message->setStatuses( array( 'error', 'block-message', 'remain' ) );
	$status_message->setMessage( "<p><strong>Page not found</strong></p>" );
	require( DIR_VIEWS . '/pages/error.php' );
	exit;
}

// Pagination size error checking
if ( $config['pagination_size'] % 2 == 0 ) {
	$config['pagination_size']--;
}
if ( $config['pagination_size'] < 1 || $config['pagination_size'] > 12 ) {
	$config['pagination_size'] = 9;
}
$vars->page_array = range( $vars->page_number - floor( $config['pagination_size']/2 ), $vars->page_number + floor( $config['pagination_size']/2 ) );
if ( $vars->page_array[0] < 1 ) {
	$end_page = end( $vars->page_array ) + abs( $vars->page_array[0] ) + 1;
	$vars->page_array = range( 1, $end_page > $vars->total_pages ? $vars->total_pages : $end_page );
}
if ( end( $vars->page_array ) > $vars->total_pages ) {
	$start_page = $vars->page_number - abs( $vars->total_pages - $vars->page_number - ( $config['pagination_size'] - 1 ) );
	$vars->page_array = array_reverse( range( $vars->total_pages, $start_page < 1 ? 1 : $start_page ) );
}

$vars->prev_page = $vars->page_number != 1 ? $vars->page_number - 1 : null;

$vars->next_page = $vars->page_number + 1 <= $vars->total_pages ? $vars->page_number + 1 : null;

if ( $vars->controller == 'list' ) {
	$vars->stores = $stg->getStores( ($vars->page_number-1)*$config['stores_per_page'], $config['stores_per_page'] );
}
else {
	$vars->stores = $stg->getStores( ($vars->page_number-1)*$config['stores_per_page'], $config['stores_per_page'], $vars->search_params, $vars->geocode_status );
}

$vars->all_stores_geocoded = true;
foreach( $vars->stores as $store ) {
	if ( !$store->isGeocoded() ) {
		$vars->all_stores_geocoded = false;
	}
}

$vars->page_store_count = count( $vars->stores );

$vars->page_store_first_num = ($vars->page_number-1)*$config['stores_per_page']+1;
$vars->page_store_last_num = ($vars->page_number-1)*$config['stores_per_page'] + ( $vars->page_store_count < $config['stores_per_page'] ? $vars->page_store_count : $config['stores_per_page'] );

require( DIR_VIEWS . '/pages/' . $vars->controller . '.php' );