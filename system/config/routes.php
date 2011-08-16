<?php

$routes = array (
	'list(?:/page/(?<page_number>\d+))?'	=> 'list',
	'search(?:/page/(?<page_number>\d+))?'	=> 'search',
	'edit/(?<store_id>\d+)'				=> 'edit',
	'delete/(?<store_id>\d+)'			=> 'delete'
);