<?php

$vars->geocode_status = isset( $_GET['geocode_status'] ) && ( $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_FALSE || $_GET['geocode_status'] == StoreTableGateway::GEOCODE_STATUS_TRUE ) ? (int)$_GET['geocode_status'] : null;
$vars->search_params = null;

if ( isset( $_GET['search_params'] ) ) {
	foreach( $_GET['search_params'] as $index => $search_param ) {
		if ( $vars->column_info[$search_param[0]]['type'] == 'select' && $search_param[2] != sprintf( 'select_%s', $search_param[0] ) ) {
			$vars->search_params[$index] = array(
				$search_param[0],
				'=',
				$search_param[2]
			);
		}
		elseif ( !empty( $search_param[0] ) && !empty( $search_param[1] ) ) {
			$vars->search_params[$index] = $search_param;
		}
	}
}

$vars->stores = $stg->getStores( null, null, $vars->search_params, $vars->geocode_status );
$csv = implode( "\n", array_map( function( $s ) { return $s->getCSV(); }, $vars->stores ) );
$columns = implode( ',', $vars->columns );
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

