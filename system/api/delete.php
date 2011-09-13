<?php

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if ( isset( $_POST[$config['column_map']['id']] ) && $_POST[$config['column_map']['id']] != $registry->request->params->store_id ) {
		header("HTTP/1.1 400 Invalid Request");
		die( json_encode( array( 'message' => 'Invalid Request' ) ) );
	}
	if ( $stg->deleteStore( $registry->request->params->store_id ) ) {
		$json = array( 'message' => 'Store deleted successfully' );
	}
	else {
		header("HTTP/1.1 500 Internal Deleting Resource");
		$json = array( 'message' => 'Error deleting the store' );
	}
	die( json_encode( $json ) );
}

header("HTTP/1.1 400 Invalid Request Method");
die( json_encode( array( 'message' => 'Invalid Request Method' ) ) );