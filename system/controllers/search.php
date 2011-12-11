<?php

$registry->geocode_status = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == LocationTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == LocationTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;

$registry->search_params = null;

if ( isset( $_GET['search_params'] ) && count( $_GET['search_params'] ) ) {
	$registry->search_params = get_search_params( $_GET['search_params'], $registry->column_info );
}

require( DIR_CONTROLLERS . '/list.php' );