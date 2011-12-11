<?php

$registry->search_params = null;

if ( isset( $_GET['search_params'] ) && count( $_GET['search_params'] ) ) {
	$registry->search_params = get_search_params( $_GET['search_params'], $registry->column_info );
}

$registry->locations = $stg->getLocations( null, null, $registry->search_params, LocationTableGateway::GEOCODE_STATUS_TRUE );

require( DIR_VIEWS . '/pages/map.php' );

?>