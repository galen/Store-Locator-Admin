<?php

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$location = new Location( $config['column_map'], array_intersect_key( $_POST, array_flip( $registry->columns ) ) );
	if ( $location_id = $stg->createLocation( $location ) ) {
		$json = array( 'message' => 'Location created successfully', 'location_id' => $location_id );
	}
	else {
		header("HTTP/1.1 500 Error Creating Resource");
		$json = array( 'message' => 'Error creating the location' );
	}
	die( json_encode( $json ) );
}

header("HTTP/1.1 400 Invalid Request Method");
die( json_encode( array( 'message' => 'Invalid Request Method' ) ) );