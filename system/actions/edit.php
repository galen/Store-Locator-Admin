<?php

if ( REQUEST_IS_AJAX ) {
	require( '../config/config.php' );
	require( DIR_SYSTEM . '/core/Db.php' );
	$db = Db::connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME ) or die( json_encode( array( 'status' => 0, 'message' => 'Error connecting to database' ) ) );
	require( DIR_SYSTEM . '/models/StoreTableGateway.php' );
	$stg = new StoreTableGateway( $db, STORE_LOCATIONS_TABLE, $config['column_map'] );
	$store_save = new Store( $config['column_map'], array_intersect_key( $_POST,array_combine( $vars['columns'], array_fill( 0, count( $vars['columns'] ), '!' ) ) ) );
	if ( $stg->saveStore( $store_save ) ) {
		$json = array( 'status' => 1, 'message' => 'Store saved successfully' );
	}
	else {
		$json = array( 'status' => 0, 'message' => 'Error saving the store' );
	}
	die( json_encode( $json ) );
}

// Save store
if ( isset( $_POST['save'] ) ) {
	$store_save = new Store( $config['column_map'], array_intersect_key( $_POST,array_combine( $vars['columns'], array_fill( 0, count( $vars['columns'] ), '!' ) ) ) );
	if ( $stg->saveStore( $store_save ) ) {
		$status_message->setStatus( 'success' );
		$status_message->setMessage( 'Store saved successfully' );
	}
	else {
		$status_message->setStatus( 'error' );
		$status_message->setMessage( 'Error saving the store' );
	}
}

if ( isset( $_GET['status'], $_GET['message'] ) ) {
	$status_message->setStatus( $_GET['status'] );
	$status_message->setMessage($_GET['message'] );
}

$store = $stg->getStore( $vars['store_id'] );

// Create the map
require( DIR_LIB . '/PHPGoogleMaps/Core/Autoloader.php' );
$map_loader = new SplClassLoader( 'PHPGoogleMaps', DIR_LIB );
$map_loader->register();
$map = new \PHPGoogleMaps\Map( array( 'width' => '600px', 'height' => '300px' ) );

if ( $store->isGeocoded() ) {
	$marker = \PHPGoogleMaps\Overlay\Marker::createFromPosition( new \PHPGoogleMaps\Core\LatLng( $store->getLat(), $store->getLng() ), array( 'draggable' => true ) );
	$marker_map = $map->addObject( $marker );
	$event = new \PHPGoogleMaps\Event\EventListener( $marker_map, 'dragend', sprintf( 'function(){ $("#lat").val(Math.round(map.markers[0].getPosition().lat()*1000000)/1000000);$("#lng").val(Math.round(map.markers[0].getPosition().lng()*1000000)/1000000); }', $marker_map ) );
	$map->addObject( $event );
	$map->disableAutoEncompass();
	$map->setCenter( new \PHPGoogleMaps\Core\LatLng( $store->getLat(), $store->getLng() ) );
	$map->setZoom( 14 );
}
else {
	$location = sprintf( "%s, %s%s",  $store->getCity(), $store->getState() ? $store->getState().', ' : '', $store->getCountry() );
	if ( ( $geocode = \PHPGoogleMaps\Service\Geocoder::geocode( $location ) ) instanceof \PHPGoogleMaps\Service\GeocodeResult ) {
		$map->setCenter( $geocode );
		$map->setZoom( 9 );
	}
	else {
		$map->setCenter( new \PHPGoogleMaps\Core\LatLng( 23, 23 ) );
		$map->setZoom( 1 );
	}
	$map->disableAutoEncompass();
}

require( DIR_SYSTEM . '/views/edit.php' );

?>