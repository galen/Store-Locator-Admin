<?php

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	$location = $stg->getLocation( $registry->request->params->location_id );
	if ( !$location ) {
		header("HTTP/1.1 404 Not Found");
		die( json_encode( array( 'message' => 'Location not found' ) ) );
	}
	die( json_encode( $location->getData() ) );
}

header("HTTP/1.1 400 Invalid Request Method");
die( json_encode( array( 'message' => 'Invalid Request Method' ) ) );