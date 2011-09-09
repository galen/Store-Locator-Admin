<?php

$vars->page_number = isset( $vars->request->params->page_number ) ? $vars->request->params->page_number : 1;

if ( $vars->controller == 'list' ) {
	$vars->total_store_count = $stg->getCount();
}
else {
	$vars->total_store_count = $stg->getCount( $vars->search_params, $vars->geocode_status );
	$vars->search_results_exist = (bool) $vars->total_store_count;
	$vars->active_search = (bool)count( $_GET );
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
if ( $config['pagination_viewport'] < 0 || $config['pagination_viewport'] > 7 ) {
	$config['pagination_viewport'] = 4;
}

$start_page = max( $vars->page_number - $config['pagination_viewport'], 1 ); // 22
$end_page = min( $start_page + ( $config['pagination_viewport']*2 ), $vars->total_pages ); // 28
$start_page = max( $end_page - ( $config['pagination_viewport']*2 ), 1 );
$vars->page_array = range($start_page,$end_page);

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