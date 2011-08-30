<?php

require( 'system/config/config.php' );

// Only need these if this isn't an AJAX request
if ( !REQUEST_IS_AJAX ) {
	require( DIR_LIB . '/FormStatusMessage/FormStatusMessage.php' );
	require( DIR_HELPERS . '/view_helpers.php' );
	$status_message = new FormStatusMessage;
}

// Require necessary files
require( DIR_CORE . '/Router.php' );
require( DIR_CONFIG . '/routes.php' );

if ( $controller = Router::route( REQUEST ) ) {

	// Connect to the database
	require( DIR_CORE . '/Db.php' );
	if ( !$db = Db::connect( $config['db_user'], $config['db_password'], $config['db_name'], $config['db_host'], $config['db_type'] ) ) {
		header("HTTP/1.1 500 Internal Server Error");
		$status_message->setStatuses( array( 'error',  'remain' ) );
		$status_message->setMessage( "Unable to connect to the database" );
		require( DIR_VIEWS . '/pages/error.php' );
		exit;
	}

	// We will use a store table gateway on every page so we will create one here
	require( DIR_MODELS . '/StoreTableGateway.php' );
	require( DIR_MODELS . '/Store.php' );
	$stg = new StoreTableGateway( $db, $config['db_table'], $config['column_map'] );

	// Register the map autoloader
	require( DIR_LIB . '/PHPGoogleMaps/PHPGoogleMaps/Core/Autoloader.php' );
	$map_loader = new SplClassLoader( 'PHPGoogleMaps', DIR_LIB . '/PHPGoogleMaps' );
	$map_loader->register();

	if ( !$stg->validateTable() ) {
		header("HTTP/1.1 500 Internal Server Error");
		$status_message->setStatuses( array('error', 'remain' ) );
		$status_message->setMessage( "Invalid table setup" );
		require( DIR_VIEWS . '/pages/error.php' );
		exit;
	}

	// Set variables
	$vars = Router::getVars();
	$vars['controller'] = $controller;
	$vars['column_info'] = $stg->getColumns();
	$vars['columns'] = array_keys( $vars['column_info'] );
	$vars['columns_list'] = array_values( array_diff( $vars['columns'], array( $config['column_map']['id'], $config['column_map']['lat'], $config['column_map']['lng'] ) ) );
	$vars['columns_edit'] = array_values( array_diff( $vars['columns'], array( $config['column_map']['id'] ) ) );

	if ( isset( $_GET['status'], $_GET['message'] ) ) {
		$status_message->setStatus( $_GET['status'] );
		$status_message->setMessage($_GET['message'] );
	}

	// Require the controller and exit
	require( DIR_CONTROLLERS . '/' . $controller . '.php' );
	exit;
}

// No route found, send 404
header("HTTP/1.1 404 Not Found");
$status_message->setStatus( array( 'error', 'remain' ) );
$status_message->setMessage( "This page doesn't exist" );
require( DIR_VIEWS . '/pages/error.php' );
exit;

