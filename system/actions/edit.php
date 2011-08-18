<?php

// Save store
if ( isset( $_POST['save'] ) ) {
	$store_save = new Store( $config['column_map'], array_intersect_key( $_POST,array_combine( $vars['table_columns'], array_fill( 0, count( $vars['table_columns'] ), '!' ) ) ) );
	if ( $stg->saveStore( $store_save ) ) {
		$status_message->setStatus( 'success' );
		$status_message->setMessage( 'The store has been saved' );
	}
	else {
		$status_message->setStatus( 'error' );
		$status_message->setMessage( 'Error saving the store' );
	}
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