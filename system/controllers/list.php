<?php

$registry->page_number = isset( $registry->request->params->page_number ) ? $registry->request->params->page_number : 1;

if ( $registry->controller == 'list' ) {
	$registry->total_store_count = $stg->getStoreCount();
}
else {
	$registry->total_store_count = $stg->getStoreCount( $registry->search_params, $registry->geocode_status );
	$registry->search_results_exist = (bool) $registry->total_store_count;
	$registry->active_search = (bool)count( $_GET );
}


$registry->total_pages = ceil( $registry->total_store_count / $config['stores_per_page'] );
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
$registry->search_query = $registry->controller == 'search' && isset( $registry->search_params ) ? '?' . $_SERVER['QUERY_STRING'] : '';

$registry->prev_page = $registry->page_number != 1 ? $registry->page_number - 1 : null;
$registry->next_page = $registry->page_number + 1 <= $registry->total_pages ? $registry->page_number + 1 : null;

if ( $registry->controller == 'list' ) {
	$registry->stores = $stg->getStores( ($registry->page_number-1)*$config['stores_per_page'], $config['stores_per_page'] );
}
else {
	$registry->stores = $stg->getStores( ($registry->page_number-1)*$config['stores_per_page'], $config['stores_per_page'], $registry->search_params, $registry->geocode_status );
}

$registry->store_ids = array_map( function($s){return $s->getId();}, $registry->stores );

$registry->all_stores_geocoded = true;
foreach( $registry->stores as $store ) {
	if ( !$store->isGeocoded() ) {
		$registry->all_stores_geocoded = false;
	}
}

$registry->page_store_count = count( $registry->stores );

$registry->page_store_first_num = ($registry->page_number-1)*$config['stores_per_page']+1;
$registry->page_store_last_num = ($registry->page_number-1)*$config['stores_per_page'] + ( $registry->page_store_count < $config['stores_per_page'] ? $registry->page_store_count : $config['stores_per_page'] );

require( DIR_VIEWS . '/pages/' . $registry->controller . '.php' );