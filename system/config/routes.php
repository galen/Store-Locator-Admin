<?php

/**
 * Defines routes for the app
 */

Router::connect( '~^list(?:/page/(?P<page_number>\d+))?$~', 'list' );
Router::connect( '~^search(?:/page/(?P<page_number>\d+))?$~', 'search' );
Router::connect( '~^edit/(?P<store_id>\d+)$~', 'edit' );
Router::connect( '~^delete/(?P<store_id>\d+)$~', 'delete' );
Router::connect( '~^create$~', 'create' );
Router::connect( '~^tools$~', 'tools' );
Router::connect( '~^export$~', 'export' );
Router::connect( '~^documentation$~', 'documentation' );

Router::connect( '~^api(?:/(?P<sub_controller>\w+)/?(?P<store_id>\d*)?)?~', 'api' );

/*
Router::connect( '~^api$~', 'api/index' );
Router::connect( '~^api/geocode/?(?P<all>all)?$~', 'api/geocode' );
Router::connect( '~^api/edit/(?P<store_id>\d+)$~', 'api/edit' );
Router::connect( '~^api/delete/(?P<store_id>\d+)$~', 'api/delete' );
Router::connect( '~^api/get/(?P<store_id>\d+)$~', 'api/get' );
Router::connect( '~^api/create$~', 'api/create' );
*/

Router::connect( '~^$~', 'list' );