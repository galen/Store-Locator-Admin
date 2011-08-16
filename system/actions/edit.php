<?php

if ( isset( $_POST['save'] ) ) {
	
	$store_save = new Store( COLUMN_ID, COLUMN_LAT, COLUMN_LNG,array_intersect_key( $_POST,array_combine( $vars['table_columns'], array_fill( 0, count( $vars['table_columns'] ), '!' ) ) ) );

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
	$map->setCenter( \PHPGoogleMaps\Service\Geocoder::geocode( 'USA' ) );
	$map->disableAutoEncompass();
	$map->setZoom( 1 );
}


require( DIR_SYSTEM . '/views/edit.php' );

?>