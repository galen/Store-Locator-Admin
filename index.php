<?php

require( 'system/config.php' );

// Get the action and id
$request_parts = explode( '/', trim( REQUEST, '/' ) );
print_r($request_parts);
define( 'ACTION',	isset( $request_parts[1] ) ? ( in_array( $request_parts[1], array( 'add', 'edit', 'delete', 'search' ) ) ? $request_parts[1] : 'list' ) : 'list' );
define( 'ID',		isset( $request_parts[2] ) ? (int)$request_parts[2] : null );

// Connect to the database
require( DIR_SYSTEM . '/core/Db.php' );
try {
	$db = new PDO( sprintf( 'mysql:dbname=%s;host=%s', 'development', 'localhost' ), 'mysql', 'mariokartyoshi' );
}
catch ( PDOException $e ) {
	print_r( $e );
}

// Require necessary files
require( DIR_SYSTEM . '/models/StoreLocationTableGateway.php' );
require( DIR_SYSTEM . '/models/Store.php' );
require( DIR_SYSTEM . '/helpers/helpers.php' );

// Create a new table gateway
$sltg = new StoreLocationTableGateway( $db, STORE_LOCATIONS_TABLE );

$vars['table_columns'] = $sltg->getColumns();

// Require the appropriate action
require( DIR_SYSTEM . '/actions/' . ACTION . '.php' );
