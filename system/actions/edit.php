<?php

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
	$status_message->setMessage( $_GET['message'] );
}

$store = $stg->getStore( $vars['store_id'] );

if ( !$store ) {
	header("HTTP/1.0 404 Not Found");
	$status_message->setStatus( 'error' );
	$status_message->setMessage( 'Invalid Store ID' );
	require( DIR_SYSTEM . '/views/header.php' );
	require( DIR_SYSTEM . '/views/widget_navigation.php' );
	require( DIR_SYSTEM . '/views/widget_page_status_message.php' );
	require( DIR_SYSTEM . '/views/footer.php' );
	exit;
}

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