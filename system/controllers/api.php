<?php

if ( !isset( $registry->request->params->sub_controller ) ) {
	require( DIR_API . '/index.php' );
	exit;
}

if ( file_exists( DIR_API . '/' . $registry->request->params->sub_controller . '.php' ) ) {
	require( DIR_API . '/' . $registry->request->params->sub_controller . '.php' );
	exit;
}
header("HTTP/1.1 400 Invalid Request");
die( json_encode( array( 'message' => 'Invalid Request' ) ) );