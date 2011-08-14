<?php

$vars['current_page'] = isset( $request_parts[1] ) && $request_parts[1] == 'page' && is_numeric( $request_parts[2] ) && $request_parts[2] > 1 ? $request_parts[2] : 1;
$vars['prev_page'] = $vars['current_page'] - 1 > 0 ? $vars['current_page'] - 1 : null;

$vars['total_location_count'] = $sltg->getCount();
$vars['total_pages'] = ceil( $vars['total_location_count'] / LOCATIONS_PER_PAGE );

$vars['next_page'] = $vars['current_page'] + 1 <= $vars['total_pages'] ? $vars['current_page'] + 1 : null;

$vars['locations'] = $sltg->getLocations( ($vars['current_page']-1)*LOCATIONS_PER_PAGE, LOCATIONS_PER_PAGE );
$vars['page_location_count'] = count( $vars['locations'] );

$vars['page_location_first_num'] = ($vars['current_page']-1)*LOCATIONS_PER_PAGE+1;
$vars['page_location_last_num'] = ($vars['current_page']-1)*LOCATIONS_PER_PAGE + ( $vars['page_location_count'] < LOCATIONS_PER_PAGE ? $vars['page_location_count'] : LOCATIONS_PER_PAGE );

//echo "<br><br>" . $page_location_count . " locations<br><br>";
//echo "showing stores " . $page_location_first_num . " to " . $page_location_last_num ." of " . $total_location_count . "<br><br>";

//print_r($locations);

require( DIR_SYSTEM . '/views/list.php' );