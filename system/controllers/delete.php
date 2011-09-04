<?php

if ( isset( $_POST['delete'] ) || isset( $_POST['cancel'] ) ) {
	if ( isset( $_POST['cancel'] ) ) {
		$c = isset( $_GET['c'] ) ? $_GET['c'] : URL_LIST;
		header( 'Location: ' . $c );
		exit;
	}
	if ( isset( $_POST['delete'] ) ) {
		$req = Request::factory( URL_ROOT . '/api/delete/' . $vars->request->params->store_id );
		$req->method = 'post';
		$resp = $req->execute();
		if ( $resp->status == 200 ) {
			header( sprintf( 'Location: %s?status=success&message=%s', URL_LIST, urlencode( $resp->data->message ) ) );
			exit;
		}
		else {
		$status_message->setMessage( sprintf( '<p>%s</p>', $resp->data->message ) );
		}

	}
}

require( DIR_VIEWS . '/pages/delete.php' );


