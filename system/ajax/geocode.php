<?php
require( '../config/config.php' );

if ( !isset( $_GET[$config['column_map']['address1']], $_GET[$config['column_map']['city']], $_GET[$config['column_map']['country']] ) ) {
	die( json_encode( array( 'status' => 0, 'message' => 'Error geocoding address' ) ) );
}

require( DIR_LIB . '/PHPGoogleMaps/Core/Autoloader.php' );
$map_loader = new SplClassLoader( 'PHPGoogleMaps', DIR_LIB );
$map_loader->register();

$geocode = \PHPGoogleMaps\Service\Geocoder::geocode( sprintf( "%s, %s, %s%s", $_GET[$config['column_map']['address1']], $_GET[$config['column_map']['city']], isset( $_GET[$config['column_map']['state']] ) ? $_GET[$config['column_map']['state']].', ' : '', $_GET[$config['column_map']['country']] ) );
if ( $geocode instanceof \PHPGoogleMaps\Service\GeocodeResult ) {
	$json = array( 'status' => 1, 'lat' => $geocode->getLat(), 'lng' => $geocode->getLng(), 'message' => 'Store geocoded successfully' );
}
else {
	$json = array( 'status' => 0, 'message' => 'Unable to geocode address' );
}
die( json_encode( $json ) );
?>