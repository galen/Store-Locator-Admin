<?php

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	$address = preg_replace_callback( '~\{(.*?)\}~', function( $m ) use( $_GET ){ return isset($_GET[$m[1]]) ? $_GET[$m[1]] : null; }, $config['geocode_string'] );

	if ( strpos( $address, '{' ) !== false ) {
		header("HTTP/1.1 400 Error Parsing Address");
		$json = array( 'message' => 'Error geocoding the location' );
		die( json_encode( $json ) );
	}
	
	require( DIR_LIB . '/Geocoder/Geocoder.php' );
	$geocode = Geocoder::geocode( $address );
	
	if ( $geocode instanceof StdClass ) {
		$json = array( 'lat' => round( $geocode->lat, 6 ), 'lng' => round( $geocode->lng, 6 ), 'message' => 'Location geocoded successfully' );
	}
	else {
		header("HTTP/1.1 405 Geocode Failed");
		$json = array( 'message' => 'Error geocoding the location' );
	}
	
	die( json_encode( $json ) );
}

header("HTTP/1.1 400 Invalid Request Method");
die( json_encode( array( 'message' => 'Invalid Request Method' ) ) );