<?php

require( 'system/config/config.php' );

define( 'REQUEST',					trim( str_replace( dirname( $_SERVER['PHP_SELF'] ), '', preg_replace( '~/+~', '/' , parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) ) ), '/' ) );
define( 'REQUEST_METHOD',			$_SERVER['REQUEST_METHOD'] );
define( 'REQUEST_IS_AJAX',			(bool)isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' );

// Connect to the database
require( DIR_SYSTEM . '/core/Db.php' );
$db = Db::connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME ) or die( 'error connecting to database' );

// Require necessary files
require( DIR_SYSTEM . '/models/StoreTableGateway.php' );
require( DIR_SYSTEM . '/models/Store.php' );
require( DIR_SYSTEM . '/helpers/view_helpers.php' );
require( DIR_SYSTEM . '/config/routes.php' );
require( DIR_LIB . '/FormStatusMessage/FormStatusMessage.php' );
require( DIR_LIB . '/Breadcrumbs/Breadcrumbs.php' );

// Create a new Form status message
$status_message = new FormStatusMessage;

// Create a new table gateway
$stg = new StoreTableGateway( $db, STORE_LOCATIONS_TABLE, $config['column_map'] );

// Get the column names from the table
$vars['table_columns'] = $stg->getColumns();
$vars['table_columns_list'] = array_values( array_diff( $vars['table_columns'], array( $config['column_map']['id'],$config['column_map']['lat'],$config['column_map']['lng'] ) ) );

// find appropriate route
foreach( $routes as $url => $action ) {
	if ( preg_match( sprintf( '~^%s$~', $url ), REQUEST, $m ) ) {
		$vars['action'] = $action;
		$vars['page_number'] = isset( $m['page_number'] ) ? $m['page_number'] : 1;
		$vars['store_id'] = isset( $m['store_id'] ) ? $m['store_id'] : null;
		require( DIR_SYSTEM . '/actions/' . $action . '.php' );
		exit;
	}
}

// Redirect to the list
header( 'Location:' . URL_LIST );
exit;

