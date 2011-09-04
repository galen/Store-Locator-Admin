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

$vars->page_array = array_slice( range( 1, $vars->total_pages ), $vars->page_number-ceil($config['pagination_size']/2) > 0 ? $vars->page_number-ceil($config['pagination_size']/2) : 0, $config['pagination_size'] );

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