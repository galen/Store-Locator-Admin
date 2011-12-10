<?php

// Turn on error reporting if the site is in development
if ( SITE_DEV ) {
	error_reporting( E_ALL );
	ini_set( 'display_errors', 'On' );
}

// Requests
define( 'REQUEST',					trim( str_replace( dirname( $_SERVER['PHP_SELF'] ), '', preg_replace( '~/+~', '/' , parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) ) ), '/' ) );
define( 'REQUEST_METHOD',			$_SERVER['REQUEST_METHOD'] );
define( 'REQUEST_IS_AJAX',			(bool)isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' );

if ( REQUEST == 'index.php' ) {
    Header( 'HTTP/1.1 301 Moved Permanently' ); 
    header( 'Location: /' );
    exit;
}

//Check for a config file
if( !@include( 'system/config/config.php' ) ){
	header("HTTP/1.1 500 Internal Server Error");
	if ( REQUEST_IS_AJAX ) {
		die( json_encode( array( 'message' => 'No config file found. Rename system/config/config_sample.php to config.php and edit it to reflect your needs.' ) ) );
	}
	echo "<p><strong>No config file found.</strong> Rename system/config/config_sample.php to config.php and edit it to reflect your needs.</p>";
	exit;
}

// Only need these if this isn't an AJAX request
if ( !REQUEST_IS_AJAX ) {
	require( DIR_LIB . '/FormStatusMessage/FormStatusMessage.php' );
	require( DIR_HELPERS . '/view_helpers.php' );
	$status_message = new FormStatusMessage;
}

// Simple registry
$registry = new StdClass;

// Require necessary files
require( DIR_CORE . '/Router.php' );
require( DIR_CONFIG . '/routes.php' );
require( DIR_CORE . '/Request.php' );
require( DIR_CORE . '/Response.php' );

if ( $registry->request = Router::route( REQUEST ) ) {

	// Connect to the database
	require( DIR_CORE . '/Db.php' );
	if ( !$db = Db::connect( $config['db_user'], $config['db_password'], $config['db_name'], $config['db_host'], $config['db_type'] ) ) {
		header("HTTP/1.1 500 Internal Server Error");
		if ( REQUEST_IS_AJAX ) {
			die( json_encode( array( 'message' => 'Unable to connect to the database. Please check your config and try again.' ) ) );
		}
		$status_message->setStatuses( array( 'error', 'block-message', 'remain' ) );
		$status_message->setMessage( "<p><strong>Unable to connect to the database</strong>. Please check your config and try again.</p>" );
		require( DIR_VIEWS . '/pages/error.php' );
		exit;
	}

	// We will use a store table gateway on every page so we will create one here
	require( DIR_MODELS . '/StoreTableGateway.php' );
	require( DIR_MODELS . '/Store.php' );
	$stg = new StoreTableGateway( $db, $config['db_table'], $config['column_map'] );

	if ( !$stg->validateTable() ) {
		header("HTTP/1.1 500 Internal Server Error");
		if ( REQUEST_IS_AJAX ) {
			die( json_encode( array( 'message' => 'Invalid table setup. Please check your config and try again.' ) ) );
		}
		$status_message->setStatuses( array('error', 'block-message', 'remain' ) );
		$status_message->setMessage( "<p><strong>Invalid table setup</strong>. Please check your config and try again.</p>" );
		require( DIR_VIEWS . '/pages/error.php' );
		exit;
	}

	// Set variables
	$registry->controller = Router::$controller;
	$registry->column_info = $stg->getColumns();

	if ( $config['store_name'] ) {
		unset( $registry->column_info['name'] );
	} 

	$registry->columns = array_keys( $registry->column_info );
	$registry->columns_list = array_values( array_diff( $registry->columns, array( $config['column_map']['id'], $config['column_map']['lat'], $config['column_map']['lng'] ) ) );
	$registry->columns_edit = array_merge( array_values( array_diff( $registry->columns, array( $config['column_map']['id'], $config['column_map']['lat'], $config['column_map']['lng'] ) ) ), array( $config['column_map']['lat'], $config['column_map']['lng'] ) );

	if ( isset( $_GET['status'], $_GET['message'] ) ) {
		$status_message->setStatus( $_GET['status'] );
		$status_message->setMessage($_GET['message'] );
	}

	require( DIR_HELPERS . '/helpers.php' );

	require( sprintf( "%s/%s.php", DIR_CONTROLLERS, $registry->controller ) );
	exit;
}

// No route found, send 404
header("HTTP/1.1 404 Not Found");
if ( REQUEST_IS_AJAX ) {
	die( json_encode( array( 'message' => 'File not found' ) ) );
}
$status_message->setStatuses( array( 'error', 'block-message', 'remain' ) );
$status_message->setMessage( "<p><strong>Page not found</strong></p>" );
require( DIR_VIEWS . '/pages/error.php' );
exit;

