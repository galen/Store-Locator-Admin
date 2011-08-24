<?php

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

// Database configuration
$config['db_user'] = '';
$config['db_password'] = '';
$config['db_host'] = 'localhost';
$config['db_name'] = '';
$config['db_table'] = '';

// Number of stores to display on the list/search page
$config['stores_per_page'] = 100;

// Edit this to reflect your table columns
$config['column_map'] = array (
	'lat'		=> 'lat',
	'lng'		=> 'lng',
	'id'		=> 'id',
	'address1'	=> 'address1',
	'city'		=> 'city',
	'state'		=> 'state',
	'country'	=> 'country',
	'name'		=> 'name'
);

$config['geocode_string'] = '{address1}, {city}, {state}';

/**
 * Do not edit below
 */

// Directories
define( 'DIR_BASE',		 			dirname( dirname( __DIR__ ) ) );
define( 'DIR_SYSTEM',	 			dirname( __DIR__ ) );
define( 'DIR_LIB',	 				DIR_SYSTEM . '/lib' );
define( 'DIR_VIEWS', 				DIR_SYSTEM . '/views' );

// URLs
define( 'URL_ROOT',					dirname( $_SERVER['SCRIPT_NAME'] ) );
define( 'URL_LIST',					URL_ROOT . '/list' );
define( 'URL_DELETE',				URL_ROOT . '/delete' );
define( 'URL_EDIT',					URL_ROOT . '/edit' );
define( 'URL_SEARCH',				URL_ROOT . '/search' );
define( 'URL_PUBLIC',				URL_ROOT . '/public' );
define( 'URL_AJAX',					URL_PUBLIC . '/ajax' );
define( 'URL_GEOCODE',				URL_AJAX . '/geocode.php' );

// Requests
define( 'REQUEST',					trim( str_replace( dirname( $_SERVER['PHP_SELF'] ), '', preg_replace( '~/+~', '/' , parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) ) ), '/' ) );
define( 'REQUEST_METHOD',			$_SERVER['REQUEST_METHOD'] );
define( 'REQUEST_IS_AJAX',			(bool)isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' );
