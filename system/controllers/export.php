<?php

$registry->geocode_status = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;
$registry->search_params = null;

if ( isset( $_GET['search_params'] ) && count( $_GET['search_params'] ) ) {
	$registry->search_params = get_search_params( $_GET['search_params'], $registry->column_info );
}

$registry->stores = $stg->getStores( null, null, $registry->search_params, $registry->geocode_status );
$csv = implode( "\n", array_map( function( $s ) { return $s->getCSV(); }, $registry->stores ) );
$columns = implode( ',', $registry->columns );
$filename = isset( $_GET['filename'] ) ? $_GET['filename'] : 'export.csv';

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Type: text/csv");
header("Content-Disposition: attachment;filename=$filename" );
header("Content-Length: " . strlen( $columns . "\n" . $csv ) );
echo $columns . "\n";
echo $csv;
exit;

