<?php

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$location = new Location( $config['column_map'], array_intersect_key( $_POST, array_flip( $registry->columns ) ) );
	if ( !isset( $registry->request->params->location_id ) || $location->getID() && $location->getID() != $registry->request->params->location_id ) {
		header("HTTP/1.1 400 Invalid Request");
		die( json_encode( array( 'message' => 'Invalid Request' ) ) );
	}
	if ( $stg->saveLocation( $location ) ) {
		$json = array( 'message' => 'Location saved successfully' );
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		$json = array( 'message' => 'Error saving the location' );
	}
	die( json_encode( $json ) );
}

header("HTTP/1.1 400 Invalid Request Method");
die( json_encode( array( 'message' => 'Invalid Request Method' ) ) );