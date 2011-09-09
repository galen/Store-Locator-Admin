<?php

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

// Database configuration
$config['db_user'] = '';
$config['db_password'] = '';
$config['db_host'] = '';
$config['db_name'] = '';
$config['db_type'] = '';
$config['db_table'] = '';

// Max number of pages to show in the pagination
// If this is not odd 1 will be subtracted from it
$config['pagination_viewport'] = 4;

// Number of stores to display on the list/search page
$config['stores_per_page'] = 5;

// Edit this to reflect your table columns
$config['column_map'] = array (
	'lat'		=> 'lat',
	'lng'		=> 'lng',
	'id'		=> 'id',
	'address'	=> 'address',
	'city'		=> 'city',
	'state'		=> 'state',
	'country'	=> 'country',
	'name'		=> 'name'
);

/**
 * This gets translated into the address that will be geocoded
 *
 * Put table column names in {}
 */
$config['geocode_string'] = '{address}, {city}, {state}';

/**
 * Time in milliseconds for the status messages to remain before being faded out
 *
 * Set to 0 to disable
 */
$config['autoremove_statuses'] = 0;

/**
 * Do not edit below
 */

// Directories
define( 'DIR_BASE',		 			dirname( dirname( __DIR__ ) ) );
define( 'DIR_SYSTEM',	 			dirname( __DIR__ ) );
define( 'DIR_LIB',	 				DIR_SYSTEM . '/lib' );
define( 'DIR_CORE',	 				DIR_SYSTEM . '/core' );
define( 'DIR_CONTROLLERS',			DIR_SYSTEM . '/controllers' );
define( 'DIR_MODELS',				DIR_SYSTEM . '/models' );
define( 'DIR_HELPERS',				DIR_SYSTEM . '/helpers' );
define( 'DIR_BACKUPS',				DIR_SYSTEM . '/backups' );
define( 'DIR_CONFIG', 				DIR_SYSTEM . '/config' );
define( 'DIR_VIEWS', 				DIR_SYSTEM . '/views' );

// URLs
define( 'URL_ROOT',					dirname( $_SERVER['SCRIPT_NAME'] ) );
define( 'URL_LIST',					URL_ROOT . '/list' );
define( 'URL_DELETE',				URL_ROOT . '/delete' );
define( 'URL_CREATE',				URL_ROOT . '/create' );
define( 'URL_EDIT',					URL_ROOT . '/edit' );
define( 'URL_SEARCH',				URL_ROOT . '/search' );
define( 'URL_EXPORT',				URL_ROOT . '/export' );
define( 'URL_PUBLIC',				URL_ROOT . '/public' );
define( 'URL_API',	 				URL_ROOT . '/api' );

// Requests
define( 'REQUEST',					trim( str_replace( dirname( $_SERVER['PHP_SELF'] ), '', preg_replace( '~/+~', '/' , parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) ) ), '/' ) );
define( 'REQUEST_METHOD',			$_SERVER['REQUEST_METHOD'] );
define( 'REQUEST_IS_AJAX',			(bool)isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' );