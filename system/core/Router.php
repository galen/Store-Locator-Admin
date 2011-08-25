<?php

class Router {

	private static $routes = array();
	private static $vars = array();

	function __construct(){}
	
	static function connect( $url_pattern, $controller ) {
		self::$routes[$url_pattern] = $controller;
	}

	static function route( $request ) {
		foreach( self::$routes as $url_pattern => $controller ) {
			if ( preg_match( $url_pattern, $request, $url_data ) ) {
				preg_match_all( '~P<(.*?)>~', $url_pattern, $url_vars );
				foreach ( $url_vars[1] as $var ) {
					if ( isset( $url_data[$var] ) ) {
						self::$vars[$var] = $url_data[$var];
					}
				}
				return $controller;
			}
		}

	}

	static function getVars() {
		return self::$vars;
	}

}