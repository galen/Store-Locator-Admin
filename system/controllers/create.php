<?php

if ( isset( $_POST['create'] ) ) {
	$store = new Store( $config['column_map'], array_intersect_key( $_POST, array_flip( $vars['columns'] ) ) );
	if ( $created_id = $stg->createStore( $store ) ) {
		header( sprintf( 'Location: %s/%s/?status=success&message=Store+created+successfully', URL_EDIT, $created_id ) );
		exit;
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		$status_message->setStatuses( array( 'error', 'block-message', 'remain' ) );
		$status_message->setMessage( '<p><strong>Error creating the store</strong></p>' );
		require( DIR_VIEWS . '/pages/edit.php' );
	}
}

require( DIR_VIEWS . '/pages/edit.php' );