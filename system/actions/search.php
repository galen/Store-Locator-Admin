<?php

$vars['search_params'] = isset( $_GET['search_params'] ) ? array_filter( $_GET['search_params'], function($s){ return !empty( $s[1] ) && !empty( $s[2] ); } ) : null;
$vars['geocode_status'] = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;

$vars['total_store_count'] = $stg->getCount( $vars['search_params'], $vars['geocode_status'] );
$vars['total_pages'] = ceil( $vars['total_store_count'] / STORES_PER_PAGE );

$vars['prev_page'] = $vars['page_number'] != 1 ? $vars['page_number'] - 1 : null;

$vars['next_page'] = $vars['page_number'] + 1 <= $vars['total_pages'] ? $vars['page_number'] + 1 : null;

$vars['stores'] = $stg->getStores( ($vars['page_number']-1)*STORES_PER_PAGE, STORES_PER_PAGE, $vars['search_params'], $vars['geocode_status'] );
$vars['page_store_count'] = count( $vars['stores'] );

$vars['page_store_first_num'] = ($vars['page_number']-1)*STORES_PER_PAGE+1;
$vars['page_store_last_num'] = ($vars['page_number']-1)*STORES_PER_PAGE + ( $vars['page_store_count'] < STORES_PER_PAGE ? $vars['page_store_count'] : STORES_PER_PAGE );

require( DIR_SYSTEM . '/views/search.php' );