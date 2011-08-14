<?php

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

define( 'REQUEST_PARAM',			$_SERVER['REQUEST_URI'] );
define( 'REQUEST',					strtolower( str_replace( str_replace( $_SERVER['DOCUMENT_ROOT'], '', dirname( dirname( __FILE__ ) ) ), '',sprintf( '/%s', trim( preg_replace( '~/+~', '/', REQUEST_PARAM ), '/' ) ) ) ) );
define( 'REQUEST_METHOD',			$_SERVER['REQUEST_METHOD'] );

define( 'DIR_BASE',		 			dirname( __DIR__ ) );
define( 'DIR_SYSTEM',	 			__DIR__ );

define( 'STORE_LOCATIONS_TABLE',	'store_locations' );

define( 'LOCATIONS_PER_PAGE',		100 );

define( 'URL_ROOT',					dirname( $_SERVER['SCRIPT_NAME'] ) );
define( 'URL_PAGE_BASE',			'/'. implode( '/', array_slice( explode( '/', trim( $_SERVER['REQUEST_URI'], '/' ) ), 0, 2 ) ) );

// These must match your database
define( 'COLUMN_LAT',				'lat' );
define( 'COLUMN_LNG',				'lng' );