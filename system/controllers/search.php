<?php
$vars['page_number'] = isset( $vars['page_number'] ) ? $vars['page_number'] : 1;

if ( isset( $_GET['search_params'] ) ) {
	foreach( $_GET['search_params'] as $index => $search_param ) {
		if ( $vars['column_info'][$search_param[0]]['type'] == 'select' && $search_param[2] != sprintf( 'select_%s', $search_param[0] ) ) {
			$vars['search_params'][$index] = array(
				$search_param[0],
				'=',
				$search_param[2]
			);
		}
		elseif ( !empty( $search_param[0] ) && !empty( $search_param[1] ) ) {
			$vars['search_params'][$index] = $search_param;
		}
		
	}
}
else {
	$vars['search_params'] = null;
}

$vars['geocode_status'] = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;

$vars['total_store_count'] = $stg->getCount( $vars['search_params'], $vars['geocode_status'] );
$vars['total_pages'] = ceil( $vars['total_store_count'] / $config['stores_per_page'] );

$vars['page_array'] = array_slice( range( 1, $vars['total_pages'] ), $vars['page_number']-5 > 0 ? $vars['page_number']-5 : 0, 10 );

$vars['prev_page'] = $vars['page_number'] != 1 ? $vars['page_number'] - 1 : null;

$vars['next_page'] = $vars['page_number'] + 1 <= $vars['total_pages'] ? $vars['page_number'] + 1 : null;

$vars['stores'] = $stg->getStores( ($vars['page_number']-1)*$config['stores_per_page'], $config['stores_per_page'], $vars['search_params'], $vars['geocode_status'] );
$vars['page_store_count'] = count( $vars['stores'] );

$vars['page_store_first_num'] = ($vars['page_number']-1)*$config['stores_per_page']+1;
$vars['page_store_last_num'] = ($vars['page_number']-1)*$config['stores_per_page'] + ( $vars['page_store_count'] < $config['stores_per_page'] ? $vars['page_store_count'] : $config['stores_per_page'] );

require( DIR_VIEWS . '/pages/search.php' );