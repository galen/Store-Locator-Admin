<?php

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$store = new Store( $config['column_map'], array_intersect_key( $_POST, array_flip( $vars['columns'] ) ) );
	if ( $store->getID() && $store->getID() != $vars['request']->store_id ) {
		header("HTTP/1.1 400 Bad Request");
		die( json_encode( array( 'message' => 'Invalid Request' ) ) );
	}
	if ( $stg->saveStore( $store ) ) {
		$json = array( 'message' => 'Store saved successfully' );
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		$json = array( 'message' => 'Error saving the store' );
	}
	die( json_encode( $json ) );
}

header("HTTP/1.1 400 Bad Request");
die( json_encode( array( 'message' => 'Invalid Request' ) ) );