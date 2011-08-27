<?php

$vars['page_number'] = isset( $vars['page_number'] ) ? $vars['page_number'] : 1;
$vars['total_store_count'] = $stg->getCount();
$vars['total_pages'] = ceil( $vars['total_store_count'] / $config['stores_per_page'] );

$vars['page_array'] = array_slice( range( 1, $vars['total_pages'] ), $vars['page_number']-ceil($config['pagination_size']/2) > 0 ? $vars['page_number']-ceil($config['pagination_size']/2) : 0, $config['pagination_size'] );

$vars['prev_page'] = $vars['page_number'] != 1 ? $vars['page_number'] - 1 : null;

$vars['next_page'] = $vars['page_number'] + 1 <= $vars['total_pages'] ? $vars['page_number'] + 1 : null;

$vars['stores'] = $stg->getStores( ($vars['page_number']-1)*$config['stores_per_page'], $config['stores_per_page'] );
$vars['page_store_count'] = count( $vars['stores'] );

$vars['page_store_first_num'] = ($vars['page_number']-1)*$config['stores_per_page']+1;
$vars['page_store_last_num'] = ($vars['page_number']-1)*$config['stores_per_page'] + ( $vars['page_store_count'] < $config['stores_per_page'] ? $vars['page_store_count'] : $config['stores_per_page'] );

if ( isset( $_GET['status'], $_GET['message'] ) ) {
	$status_message->setStatus( $_GET['status'] );
	$status_message->setMessage($_GET['message'] );
}

require( DIR_VIEWS . '/pages/list.php' );