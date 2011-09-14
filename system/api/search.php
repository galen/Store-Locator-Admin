<?php
$registry->geocode_status = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;
unset( $_GET['geocode_status'] );
$registry->search_params = null;

if ( count( $_GET ) ) {
	foreach( $_GET as $var => $vals ) {
		if ( isset( $registry->column_info[$var]['type'] ) && $registry->column_info[$var]['type'] == 'select' && $vals[1] != sprintf( 'select_%s', $var ) ) {
			$registry->search_params[$var] = array(
				$var,
				'=',
				$vals[1]
			);
		}
		elseif ( !empty( $vals[1] ) ) {
			$registry->search_params[$var] = $vals;
			array_unshift( $registry->search_params[$var], $var );
		}
	}
}

$registry->stores = $stg->getStores( null, null, $registry->search_params, $registry->geocode_status );

$result = new StdClass;
$result->num_results = count( $registry->stores );
$result->search_params = $registry->search_params;
$result->results = array_map( function( $s ){ return $s->getData(); }, $registry->stores );

die( json_encode( $result ) );
