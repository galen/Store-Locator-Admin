<?php

// Save store
if ( isset( $_POST['create'] ) ) {
	$store_save = new Store( $config['column_map'], array_intersect_key( $_POST,array_combine( $vars['columns'], array_fill( 0, count( $vars['columns'] ), '!' ) ) ) );
	if ( $created_id = $stg->createStore( $store_save ) ) {
		header( 'Location: ' . URL_EDIT . '/' . $created_id . '/?status=success&message=Store+created+successfully' );
		exit;
	}
	else {
		$status_message->setStatus( 'error' );
		$status_message->setMessage( 'Error creating the store' );
	}
}

require( DIR_LIB . '/PHPGoogleMaps/Core/Autoloader.php' );
$map_loader = new SplClassLoader( 'PHPGoogleMaps', DIR_LIB );
$map_loader->register();
$map = new \PHPGoogleMaps\Map( array( 'width' => '600px', 'height' => '300px' ) );

$map->setCenter( new \PHPGoogleMaps\Core\LatLng( 23, 23 ) );
$map->setZoom( 1 );
$map->disableAutoEncompass();

require( DIR_SYSTEM . '/views/edit.php' );