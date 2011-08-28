<?php

// Create store
if ( isset( $_POST['create'] ) ) {
	$store = new Store( $config['column_map'], array_intersect_key( $_POST, array_flip( $vars['columns'] ) ) );
	if ( $created_id = $stg->createStore( $store ) ) {
		header( sprintf( 'Location: %s/%s/?status=success&message=Store+created+successfully', URL_EDIT, $created_id ) );
		exit;
	}
	else {
		$status_message->setStatus( 'error' );
		$status_message->setMessage( 'Error creating the store' );
	}
}

// Create map
require( DIR_LIB . '/PHPGoogleMaps/PHPGoogleMaps/Core/Autoloader.php' );
$map_loader = new SplClassLoader( 'PHPGoogleMaps', DIR_LIB . '/PHPGoogleMaps' );
$map_loader->register();
$map = new \PHPGoogleMaps\Map( array( 'width' => '525px', 'height' => '525px' ) );
$map->setCenter( new \PHPGoogleMaps\Core\LatLng( 23, 23 ) );
$map->setZoom( 1 );
$map->disableAutoEncompass();

require( DIR_VIEWS . '/pages/edit.php' );