<?php

$vars['page_number'] = isset( $vars['page_number'] ) ? $vars['page_number'] : 1;
$vars['search_params'] = isset( $_GET['search_params'] ) ? array_filter( $_GET['search_params'], function($s){ return !empty( $s[1] ) && !empty( $s[2] ); } ) : null;
$vars['geocode_status'] = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;

$vars['total_store_count'] = $stg->getCount( $vars['search_params'], $vars['geocode_status'] );
$vars['total_pages'] = ceil( $vars['total_store_count'] / $config['stores_per_page'] );

$vars['prev_page'] = $vars['page_number'] != 1 ? $vars['page_number'] - 1 : null;

$vars['next_page'] = $vars['page_number'] + 1 <= $vars['total_pages'] ? $vars['page_number'] + 1 : null;

$vars['stores'] = $stg->getStores( ($vars['page_number']-1)*$config['stores_per_page'], $config['stores_per_page'], $vars['search_params'], $vars['geocode_status'] );
$vars['page_store_count'] = count( $vars['stores'] );

$vars['page_store_first_num'] = ($vars['page_number']-1)*$config['stores_per_page']+1;
$vars['page_store_last_num'] = ($vars['page_number']-1)*$config['stores_per_page'] + ( $vars['page_store_count'] < $config['stores_per_page'] ? $vars['page_store_count'] : $config['stores_per_page'] );

require( DIR_VIEWS . '/pages/search.php' );