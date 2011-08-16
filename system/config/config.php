<?php

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

define( 'STORE_LOCATIONS_TABLE',	'store_locations' );
define( 'STORES_PER_PAGE',			100 );

define( 'COLUMN_LAT',				'lat' );
define( 'COLUMN_LNG',				'lng' );
define( 'COLUMN_ID',				'id' );

define( 'DIR_BASE',		 			dirname( dirname( __DIR__ ) ) );
define( 'DIR_SYSTEM',	 			dirname( __DIR__ ) );
define( 'DIR_LIB',	 				DIR_SYSTEM . '/lib' );

define( 'URL_ROOT',					dirname( $_SERVER['SCRIPT_NAME'] ) );
define( 'URL_LIST',					URL_ROOT . '/list' );
define( 'URL_DELETE',				URL_ROOT . '/delete' );
define( 'URL_EDIT',					URL_ROOT . '/edit' );
define( 'URL_SEARCH',				URL_ROOT . '/search' );
define( 'URL_PUBLIC',				URL_ROOT . '/public' );
define( 'URL_PAGE_BASE',			'/'. implode( '/', array_slice( explode( '/', trim( $_SERVER['REQUEST_URI'], '/' ) ), 0, 2 ) ) );
define( 'URL_PAGE_BASE_WITH_QUERY',	URL_PAGE_BASE . '?' . $_SERVER['QUERY_STRING'] );