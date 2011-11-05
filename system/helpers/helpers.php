<?php

function get_search_params( $raw_search_params, $column_info ) {
	$search_params = null;
	foreach( $raw_search_params as $var => $vals ) {
		if ( $column_info[$var]['type'] == 'select' && $vals["value"] != sprintf( 'select_%s', $var ) ) {
			$search_params[$var] = array(
				$var,
				'=',
				$vals["value"]
			);
		}
		elseif ( !empty( $vals['compare'] ) ) {
			$search_params[$var] = $vals;
			$search_params[$var]['variable'] = $var;
		}
	}
	return $search_params;
}