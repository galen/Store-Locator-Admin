<?php

class Store {

	private $column_map;

	function __construct( array $column_map, array $data = null ) {
		$this->column_map = $column_map;
		if ( $data ) {
			foreach( $data as $var => $val ) {
				$this->$var = $val;
			}
		}
		/*
		 * These next lines set the lat/lng to '' if the lat/lng is null or 0.000000
		 * This helps to account for the default values of more table structures
		 *
		 * Also assumes that there will be no stores at 0,0
		 */
		if ( !(int)$this->getLat() ) {
			$this->setLat( '' );
		}
		if ( !(int)$this->getLng() ) {
			$this->setLng( '' );
		}
	}

	function isGeocoded() {
		return ( $this->getLat() && $this->getLng() );
	}

	function __call( $method, array $args ) {
		if ( strpos( $method, 'get' ) === 0 ) {
			$var = strtolower( substr( $method, 3 ) );
			return isset( $this->{$this->column_map[$var]} ) ? $this->{$this->column_map[$var]} : null;
		}
		if ( strpos( $method, 'set' ) === 0 ) {
			$var = strtolower( substr( $method, 3 ) );
			if ( $var != 'id' ) {
				$this->{$this->column_map[$var]} = $args[0];
			}			
		}
	}

	function getEditableProperties() {
		return array_diff( array_keys( get_object_vars( $this ) ), array( $this->column_map['id'], 'column_map' ) );
	}

	function getQueryString() {
		$str = '?';
		foreach( get_object_vars( $this ) as $k => $v ) {
			if ( in_array( $k, array( 'column_map' ) ) ) {
				continue;
			}
			$str .= sprintf( '%s=%s&', $k, urlencode( $v ) );
		}
		return $str;
	}

}