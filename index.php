<?php

require( 'system/config.php' );

// Connect to the database
require( DIR_SYSTEM . '/core/Db.php' );
try {
	$db = new PDO( sprintf( 'mysql:dbname=%s;host=%s', 'development', 'localhost' ), 'mysql', 'mariokartyoshi' );
}
catch ( PDOException $e ) {
	print_r( $e );
}

// Require necessary files
require( DIR_SYSTEM . '/models/StoreTableGateway.php' );
require( DIR_SYSTEM . '/models/Store.php' );
require( DIR_SYSTEM . '/helpers/helpers.php' );
require( DIR_SYSTEM . '/routes.php' );

// Create a new table gateway
$stg = new StoreTableGateway( $db, STORE_LOCATIONS_TABLE );

// Get the column names from the table
$vars['table_columns'] = $stg->getColumns();

// find appropriate route
foreach( $routes as $url => $action ) {
	if ( preg_match( sprintf( '~^%s$~', $url ), REQUEST, $m ) ) {
		$vars['action'] = $action;
		$vars['page_number'] = isset( $m['page_number'] ) ? $m['page_number'] : 1;
		require( DIR_SYSTEM . '/actions/' . $action . '.php' );
		exit;
	}
}

// Redirect to the list
header( 'Location:' . URL_LIST );
exit;

