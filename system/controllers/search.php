<?php
$vars->geocode_status = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;
$vars->search_params = null;

if ( isset( $_GET['search_params'] ) ) {
	foreach( $_GET['search_params'] as $index => $search_param ) {
		if ( $vars->column_info[$search_param[0]]['type'] == 'select' && $search_param[2] != sprintf( 'select_%s', $search_param[0] ) ) {
			$vars->search_params[$index] = array(
				$search_param[0],
				'=',
				$search_param[2]
			);
		}
		elseif ( !empty( $search_param[0] ) && !empty( $search_param[1] ) ) {
			$vars->search_params[$index] = $search_param;
		}
	}
}

$vars->search_status = $vars->geocode_status || $vars->search_params;

require( DIR_CONTROLLERS . '/list.php' );