<?php
require( '../config/config.php' );

require( DIR_LIB . '/PHPGoogleMaps/Core/Autoloader.php' );
$map_loader = new SplClassLoader( 'PHPGoogleMaps', DIR_LIB );
$map_loader->register();

// This turns {address}, {city}, {state} from the config
// into 123 main st, san diego, ca
preg_match_all( '~{(.*?)}~', $config['geocode_string'], $gs );
$geocode_string = $config['geocode_string'];
foreach( $_GET as $k => $v ) {
	if ( in_array( $k, $gs[1] ) ) {
		$geocode_string = preg_replace( "~\{$k\}~", $v, $geocode_string );
	}
}

$geocode = \PHPGoogleMaps\Service\Geocoder::geocode( $geocode_string );

if ( $geocode instanceof \PHPGoogleMaps\Service\GeocodeResult ) {
	if ( isset( $_GET['save_store'] ) ) {
		require( DIR_SYSTEM . '/models/StoreTableGateway.php' );
		require( DIR_SYSTEM . '/models/Store.php' );
		require( DIR_SYSTEM . '/core/Db.php' );
		$db = Db::connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME ) or die( json_encode( array( 'status' => 0, 'message' => 'Unable to connect to database' ) ) );
		$stg = new StoreTableGateway( $db, STORE_LOCATIONS_TABLE, $config['column_map'] );
		$store = new Store( $config['column_map'], array( $config['column_map']['id'] => $_GET[$config['column_map']['id']], $config['column_map']['lat'] => $geocode->getLat(), $config['column_map']['lng'] => $geocode->getLng() ) );
		if ( $stg->saveStore( $store ) ) {
			$json = array( 'status' => 1, 'message' => 'Geocoding successful' );
		}
		else {
			$json = array( 'status' => 0, 'message' => 'Error saving the store' );
		}
	}
	else {
		$json = array( 'status' => 1, 'lat' => $geocode->getLat(), 'lng' => $geocode->getLng(), 'message' => 'Store geocoded successfully' );
	}
}
else {
	$json = array( 'status' => 0, 'message' => 'Unable to geocode address' );
}
die( json_encode( $json ) );
?>