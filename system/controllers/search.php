<?php
$vars->geocode_status = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;
unset( $_GET['geocode_status'] );
$vars->search_params = null;

if ( count( $_GET ) ) {
	foreach( $_GET as $var => $vals ) {
		if ( $vars->column_info[$var]['type'] == 'select' && $vals[1] != sprintf( 'select_%s', $var ) ) {
			$vars->search_params[$var] = array(
				$var,
				'=',
				$vals[1]
			);
		}
		elseif ( !empty( $vals[1] ) ) {
			$vars->search_params[$var] = $vals;
			array_unshift( $vars->search_params[$var], $var );
		}
	}
}

require( DIR_CONTROLLERS . '/list.php' );