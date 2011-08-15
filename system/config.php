<?php

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

define( 'REQUEST',					trim( str_replace( dirname( $_SERVER['PHP_SELF'] ), '', preg_replace( '~/+~', '/' , parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) ) ), '/' ) );
define( 'REQUEST_METHOD',			$_SERVER['REQUEST_METHOD'] );

define( 'DIR_BASE',		 			dirname( __DIR__ ) );
define( 'DIR_SYSTEM',	 			__DIR__ );

define( 'STORE_LOCATIONS_TABLE',	'store_locations' );

define( 'LOCATIONS_PER_PAGE',		100 );

define( 'URL_ROOT',					dirname( $_SERVER['SCRIPT_NAME'] ) );
define( 'URL_LIST',					dirname( $_SERVER['SCRIPT_NAME'] ) . '/list/' );
define( 'URL_PAGE_BASE',			'/'. implode( '/', array_slice( explode( '/', trim( $_SERVER['REQUEST_URI'], '/' ) ), 0, 2 ) ) );
define( 'URL_PAGE_BASE_WITH_QUERY',	URL_PAGE_BASE . '?' . $_SERVER['QUERY_STRING'] );


// These must match your database
define( 'COLUMN_LAT',				'lat' );
define( 'COLUMN_LNG',				'lng' );