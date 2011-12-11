<?php

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if ( !isset( $registry->request->params->location_id ) || isset( $_POST[$config['column_map']['id']] ) && $_POST[$config['column_map']['id']] != $registry->request->params->location_id ) {
		header("HTTP/1.1 400 Invalid Request");
		die( json_encode( array( 'message' => 'Invalid Request' ) ) );
	}
	if ( $stg->deleteLocation( $registry->request->params->location_id ) ) {
		$json = array( 'message' => 'Location deleted successfully' );
	}
	else {
		header("HTTP/1.1 500 Internal Deleting Resource");
		$json = array( 'message' => 'Error deleting the location' );
	}
	die( json_encode( $json ) );
}

header("HTTP/1.1 400 Invalid Request Method");
die( json_encode( array( 'message' => 'Invalid Request Method' ) ) );