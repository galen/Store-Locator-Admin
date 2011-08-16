<?php
require( '../config/config.php' );
require( DIR_LIB . '/PHPGoogleMaps/Core/Autoloader.php' );
$map_loader = new SplClassLoader( 'PHPGoogleMaps', DIR_LIB );
$map_loader->register();

$geocode = \PHPGoogleMaps\Service\Geocoder::geocode( $_GET['address'] );
if ( $geocode instanceof \PHPGoogleMaps\Service\GeocodeResult ) {
	$json = array( 'status' => 1, 'lat' => $geocode->getLat(), 'lng' => $geocode->getLng(), 'message' => 'Store geocoded successfully' );
}
else {
	$json = array( 'status' => 0, 'message' => 'Unable to geocode address' );
}
die( json_encode( $json ) );
?>