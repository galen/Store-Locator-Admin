<?php

$address = preg_replace_callback( '~\{(.*?)\}~', function( $m ) use( $_GET ){ return $_GET[$m[1]]; }, $config['geocode_string'] );

if ( strpos( $address, '{' ) !== false ) {
	header("HTTP/1.1 400 Bad Request");
	$json = array( 'message' => 'Error geocoding the store' );
	die( json_encode( $json ) );
}

require( DIR_LIB . '/Geocoder/Geocoder.php' );
$geocode = Geocoder::geocode( $address );

if ( $geocode instanceof StdClass ) {
	$json = array( 'lat' => $geocode->lat, 'lng' => $geocode->lng, 'message' => 'Store geocoded successfully' );
}
else {
	header("HTTP/1.1 404 Not Found");
	$json = array( 'message' => 'Error geocoding the store' );
}

die( json_encode( $json ) );