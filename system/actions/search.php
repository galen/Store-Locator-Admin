<?php

/*
$search_params = array (
	array( 'country', '=', 'US' ),
	array( 'state', '=', 'CT' )
);
*/

$search_params = isset( $_GET['search_params'] ) ? $_GET['search_params'] : null;

$vars['total_store_count'] = $stg->getCount( $search_params );
$vars['total_pages'] = ceil( $vars['total_store_count'] / STORES_PER_PAGE );

$vars['prev_page'] = $vars['page_number'] != 1 ? $vars['page_number'] - 1 : null;

$vars['next_page'] = $vars['page_number'] + 1 <= $vars['total_pages'] ? $vars['page_number'] + 1 : null;

$vars['stores'] = $stg->getStores( ($vars['page_number']-1)*STORES_PER_PAGE, STORES_PER_PAGE, $search_params );
$vars['page_store_count'] = count( $vars['stores'] );

$vars['page_store_first_num'] = ($vars['page_number']-1)*STORES_PER_PAGE+1;
$vars['page_store_last_num'] = ($vars['page_number']-1)*STORES_PER_PAGE + ( $vars['page_store_count'] < STORES_PER_PAGE ? $vars['page_store_count'] : STORES_PER_PAGE );

require( DIR_SYSTEM . '/views/search.php' );