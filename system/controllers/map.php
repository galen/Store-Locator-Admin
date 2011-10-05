<?php

$stores = $stg->getStoresWithIds( explode( ',', $_GET['ids'] ) );

foreach( $stores as $index => $store ) {
	if ( !$store->isGeocoded() ) {
		
		unset( $stores[$index] );
	}
}

require( DIR_VIEWS . '/pages/map.php' );

?>