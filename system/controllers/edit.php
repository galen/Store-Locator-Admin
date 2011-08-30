<?php

if ( isset( $_POST['geocode'] ) ) {
	$address = preg_replace_callback( '~\{(.*?)\}~', function( $m ) use( $_POST ){ return $_POST[$m[1]]; }, $config['geocode_string'] );
	$geocode = \PHPGoogleMaps\Service\Geocoder::geocode( $address );

	if ( $geocode instanceof \PHPGoogleMaps\Service\GeocodeResult ) {
		$_POST[$config['column_map']['lat']] = $geocode->getLat();
		$_POST[$config['column_map']['lng']] = $geocode->getLng();
		$_POST['save'] = true;
		$status_message->setStatus( 'success' );
		$status_message->setMessage( 'Store geocoded successfully' );
	}
	else {
		$status_message->setStatus( 'error' );
		$status_message->setMessage( 'Error geocoding the store' );
	}
}


// Save the store
if ( isset( $_POST['save'] ) ) {
	$store_save = new Store( $config['column_map'], array_intersect_key( $_POST, array_flip( $vars['columns'] ) ) );
	if ( $stg->saveStore( $store_save ) ) {
		if ( !isset( $geocode ) ) {
			$status_message->setStatus( 'success' );
			$status_message->setMessage( 'Store saved successfully' );
		}
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		$status_message->setStatuses( array( 'error', 'remain' ) );
		$status_message->setMessage( 'Error saving the store' );
		require( DIR_VIEWS . '/pages/error.php' );
		exit;
	}
}

// Get the store
$store = $stg->getStore( $vars['store_id'] );

// Invalid store, send 404
if ( !$store ) {
	header("HTTP/1.1 404 Not Found");
	$status_message->setStatuses( array( 'error', 'important' ) );
	$status_message->setMessage( "Store does not exist" );
	require( DIR_VIEWS . '/pages/error.php' );
	exit;
}

// Map code
$map = new \PHPGoogleMaps\Map( array( 'width' => '550px', 'height' => '500px' ) );
$map->enableStreetView();
$map->setLoadingContent('<p id="map_msg"><a href="http://www.activatejavascript.org/">Enable javascript</a> to view the map</p>');

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
		$map->setZoom( 2 );
	}
	$map->disableAutoEncompass();
}

require( DIR_VIEWS . '/pages/edit.php' );

?>