<?php

// AJAX request
if ( REQUEST_IS_AJAX ) {
	if ( $stg->deleteStore( $vars['store_id'] ) ) {
		$json = array( 'status' => 1, 'message' => 'Store deleted Successfully' );
	}
	else {
		$json = array( 'status' => 0, 'message' => 'Error deleting the store' );
	}
	die( json_encode( $json ) );
}

// Delete the store
if ( isset( $_POST['delete'] ) || isset( $_POST['cancel'] ) ) {
	if ( isset( $_POST['cancel'] ) ) {
		$c = isset( $_GET['c'] ) ? $_GET['c'] : URL_LIST;
		header( 'Location: ' . $c );
		exit;
	}
	if ( isset( $_POST['delete'] ) ) {
		if ( $stg->deleteStore( $vars['store_id'] ) ) {
			header( sprintf( 'Location: %s?status=success&message=Store+%s+deleted+successfully', URL_LIST, $vars['store_id'] ) );
			exit;
		}
		else {
			$status_message->setStatus( 'error' );
			$status_message->setMessage( 'Error deleting the store' );
		}
	}
}

require( DIR_VIEWS . '/delete.php' );
