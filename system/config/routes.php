<?php

$routes = array (
	'list(?:/page/(?P<page_number>\d+))?'	=> 'list',
	'search(?:/page/(?P<page_number>\d+))?'	=> 'search',
	'edit/(?P<store_id>\d+)'				=> 'edit',
	'delete/(?P<store_id>\d+)'				=> 'delete',
	'create'								=> 'create',
	'tools'									=> 'tools',
	''										=> 'list'
);