<?php

$vars['page_number'] = isset( $vars['page_number'] ) ? $vars['page_number'] : 1;
$vars['total_store_count'] = $stg->getCount();
$vars['total_pages'] = ceil( $vars['total_store_count'] / STORES_PER_PAGE );

$vars['prev_page'] = $vars['page_number'] != 1 ? $vars['page_number'] - 1 : null;

$vars['next_page'] = $vars['page_number'] + 1 <= $vars['total_pages'] ? $vars['page_number'] + 1 : null;

$vars['stores'] = $stg->getStores( ($vars['page_number']-1)*STORES_PER_PAGE, STORES_PER_PAGE );
$vars['page_store_count'] = count( $vars['stores'] );

$vars['page_store_first_num'] = ($vars['page_number']-1)*STORES_PER_PAGE+1;
$vars['page_store_last_num'] = ($vars['page_number']-1)*STORES_PER_PAGE + ( $vars['page_store_count'] < STORES_PER_PAGE ? $vars['page_store_count'] : STORES_PER_PAGE );

if ( isset( $_GET['status'], $_GET['message'] ) ) {
	$status_message->setStatus( $_GET['status'] );
	$status_message->setMessage($_GET['message'] );
}

require( DIR_VIEWS . '/list.php' );