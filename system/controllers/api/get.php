<?php

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	$store = $stg->getStore( $vars['request']->store_id );
	if ( !$store ) {
		header("HTTP/1.1 404 Not Found");
		die( json_encode( array( 'message' => 'Store not found' ) ) );
	}
	die( json_encode( $store->getData() ) );
}

header("HTTP/1.1 400 Bad Request");
die( json_encode( array( 'message' => 'Invalid Request' ) ) );