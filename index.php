<?php

require( 'system/config/config.php' );

// Only need these if this isn't an AJAX request
if ( !REQUEST_IS_AJAX ) {
	require( DIR_LIB . '/FormStatusMessage/FormStatusMessage.php' );
	require( DIR_HELPERS . '/view_helpers.php' );
	// Create a new Form status message
	$status_message = new FormStatusMessage;
}

// Connect to the database
require( DIR_MODELS . '/db/Db.php' );
if ( !$db = Db::connect( $config['db_host'], $config['db_user'], $config['db_password'], $config['db_name'] ) ) {
	header("HTTP/1.1 500 Internal Server Error");
	$status_message->setStatus( 'error' );
	$status_message->setMessage( "Unable to connect to the database" );
	require( DIR_VIEWS . '/pages/error.php' );
	exit;
}

// Require necessary files
require( DIR_MODELS . '/StoreTableGateway.php' );
require( DIR_MODELS . '/Store.php' );
require( DIR_CONFIG . '/routes.php' );

// Create a new table gateway
$stg = new StoreTableGateway( $db, $config['db_table'], $config['column_map'] );

// Get columns
$vars['column_info'] = $stg->getColumns();
$vars['columns'] = array_keys( $vars['column_info'] );
$vars['columns_list'] = array_values( array_diff( $vars['columns'], array( $config['column_map']['id'], $config['column_map']['lat'], $config['column_map']['lng'] ) ) );
$vars['columns_edit'] = array_values( array_diff( $vars['columns'], array( $config['column_map']['id'] ) ) );

// Find appropriate route and set variables
foreach( $routes as $url => $controller ) {
	if ( preg_match( sprintf( '~^%s$~', $url ), REQUEST, $url_data ) ) {
		preg_match_all( '~P<(.*?)>~', $url, $url_vars );
		$vars['controller'] = $controller;
		foreach ( $url_vars[1] as $var ) {
			if ( isset( $url_data[$var] ) ) {
				$vars[$var] = $url_data[$var];
			}
		}
		require( sprintf( '%s/%s.php', DIR_CONTROLLERS, $controller ) );
		exit;
	}
}

// No route found, send 404
header("HTTP/1.1 404 Not Found");
$status_message->setStatus( 'error' );
$status_message->setMessage( "This page doesn't exist" );
require( DIR_VIEWS . '/pages/error.php' );
exit;

