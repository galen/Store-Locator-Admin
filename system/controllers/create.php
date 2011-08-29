<?php

// Create store
if ( isset( $_POST['create'] ) ) {
	$store = new Store( $config['column_map'], array_intersect_key( $_POST, array_flip( $vars['columns'] ) ) );
	if ( $created_id = $stg->createStore( $store ) ) {
		header( sprintf( 'Location: %s/%s/?status=success&message=Store+created+successfully', URL_EDIT, $created_id ) );
		exit;
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		$status_message->setStatuses( array( 'error', 'remain' ) );
		$status_message->setMessage( 'Error creating the store' );

		require( DIR_LIB . '/PHPGoogleMaps/PHPGoogleMaps/Core/Autoloader.php' );
		$map_loader = new SplClassLoader( 'PHPGoogleMaps', DIR_LIB . '/PHPGoogleMaps' );
		$map_loader->register();
		$map = new \PHPGoogleMaps\Map( array( 'width' => '525px', 'height' => '525px' ) );
		$map->setCenter( new \PHPGoogleMaps\Core\LatLng( 23, 23 ) );
		$map->setZoom( 2 );
		$map->disableAutoEncompass();
		
		require( DIR_VIEWS . '/pages/edit.php' );
	}
}


require( DIR_LIB . '/PHPGoogleMaps/PHPGoogleMaps/Core/Autoloader.php' );
$map_loader = new SplClassLoader( 'PHPGoogleMaps', DIR_LIB . '/PHPGoogleMaps' );
$map_loader->register();
$map = new \PHPGoogleMaps\Map( array( 'width' => '525px', 'height' => '525px' ) );
$map->setCenter( new \PHPGoogleMaps\Core\LatLng( 23, 23 ) );
$map->setZoom( 2 );
$map->disableAutoEncompass();

require( DIR_VIEWS . '/pages/edit.php' );