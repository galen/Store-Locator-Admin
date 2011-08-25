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
Router::connect( '~^$~', 'list' );