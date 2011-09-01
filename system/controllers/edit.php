<?php

if ( isset( $_POST['geocode'] ) ) {
	$address = preg_replace_callback( '~\{(.*?)\}~', function( $m ) use( $_POST ){ return $_POST[$m[1]]; }, $config['geocode_string'] );
	// Register the map autoloader
	require( DIR_LIB . '/Geocoder/Geocoder.php' );
	$geocode = Geocoder::geocode( $address );
	if ( $geocode instanceof StdClass ) {
		$_POST[$config['column_map']['lat']] = $geocode->getLat();
		$_POST[$config['column_map']['lng']] = $geocode->getLng();
		$_POST['save'] = true;
		$status_message->setStatus( 'success' );
		$status_message->setMessage( '<p>Store geocoded successfully</p>' );
	}
	else {
		$status_message->setStatus( 'error' );
		$status_message->setMessage( '<p>Error geocoding the store</p>' );
	}
}


// Save the store
if ( isset( $_POST['save'] ) ) {
	$store_save = new Store( $config['column_map'], array_intersect_key( $_POST, array_flip( $vars['columns'] ) ) );
	if ( $stg->saveStore( $store_save ) ) {
		if ( !isset( $geocode ) ) {
			$status_message->setStatus( 'success' );
			$status_message->setMessage( '<p>Store saved successfully</p>' );
		}
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		$status_message->setStatuses( array( 'error', 'remain' ) );
		$status_message->setMessage( '<p>Error saving the store<p>' );
	}
}

// Get the store
$store = $stg->getStore( $vars['store_id'] );

// Invalid store, send 404
if ( !$store ) {
	header("HTTP/1.1 404 Not Found");
	$status_message->setStatuses( array( 'error', 'block-message', 'remain' ) );
	$status_message->setMessage( "<p><strong>This store does not exist</strong></p>" );
	require( DIR_VIEWS . '/pages/error.php' );
	exit;
}
require( DIR_VIEWS . '/pages/edit.php' );

?>