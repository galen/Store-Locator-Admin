<?php

$routes = array (
	'list(?:/page/(?<page_number>\d+))?'	=> 'list',
	'search(?:/page/(?<page_number>\d+))?'	=> 'search',
	'edit/(?<page_number>\d+)'				=> 'edit',
	'delete/(?<page_number>\d+)'			=> 'delete'
);