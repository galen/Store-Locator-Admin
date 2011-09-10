<?php
$registry->geocode_status = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;
unset( $_GET['geocode_status'] );
$registry->search_params = null;

if ( count( $_GET ) ) {
	foreach( $_GET as $var => $vals ) {
		if ( $registry->column_info[$var]['type'] == 'select' && $vals[1] != sprintf( 'select_%s', $var ) ) {
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

require( DIR_CONTROLLERS . '/list.php' );