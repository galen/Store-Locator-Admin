<?php

$registry->geocode_status = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;
$registry->search_params = null;

if ( isset( $_GET['search_params'] ) ) {
	foreach( $_GET['search_params'] as $index => $search_param ) {
		if ( $registry->column_info[$search_param[0]]['type'] == 'select' && $search_param[2] != sprintf( 'select_%s', $search_param[0] ) ) {
			$registry->search_params[$index] = array(
				$search_param[0],
				'=',
				$search_param[2]
			);
		}
		elseif ( !empty( $search_param[0] ) && !empty( $search_param[1] ) ) {
			$registry->search_params[$index] = $search_param;
		}
	}
}

$registry->stores = $stg->getStores( null, null, $registry->search_params, $registry->geocode_status );
$csv = implode( "\n", array_map( function( $s ) { return $s->getCSV(); }, $registry->stores ) );
$columns = implode( ',', $registry->columns );
$filename = isset( $_GET['filename'] ) ? $_GET['filename'] : 'expsort.csv';

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Type: text/csv");
header("Content-Disposition: attachment;filename=$filename" );
header("Content-Length: " . strlen( $csv ) );
echo $columns . "\n";
echo $csv;
exit();

