<?php

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$store = new Store( $config['column_map'], array_intersect_key( $_POST, array_flip( $registry->columns ) ) );
	if ( $store_id = $stg->createStore( $store ) ) {
		$json = array( 'message' => 'Store created successfully', 'store_id' => $store_id );
	}
	else {
		header("HTTP/1.1 500 Error Creating Resource");
		$json = array( 'message' => 'Error creating the store' );
	}
	die( json_encode( $json ) );
}

header("HTTP/1.1 400 Invalid Request Method");
die( json_encode( array( 'message' => 'Invalid Request Method' ) ) );