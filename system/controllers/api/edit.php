<?php

if ( isset( $_POST[$config['column_map']['id']] ) ) {
	$store_save = new Store( $config['column_map'], array_intersect_key( $_POST, array_flip( $vars['columns'] ) ) );
	if ( $stg->saveStore( $store_save ) ) {
		$json = array( 'status' => 1, 'message' => 'Store saved successfully' );
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		$json = array( 'status' => 0, 'message' => 'Error saving the store' );
	}
	die( json_encode( $json ) );
}
header("HTTP/1.1 404 File Not Found");
die( json_encode( array( 'message' => 'Invalid Request' ) ) );