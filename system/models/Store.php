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
	}

	function isGeocoded() {
		return !( is_null( $this->getLat() ) || is_null( $this->getLng() ) );
	}

	function __call( $method, $args ) {
		if ( strpos( $method, 'get' ) === 0 ) {
			$var = strtolower( substr( $method, 3 ) );
		}
		return isset( $this->{$this->column_map[$var]} ) ? $this->{$this->column_map[$var]} : null;
	}

	function getEditableProperties() {
		return array_diff( array_keys( get_object_vars( $this ) ), array( $this->column_map['id'], 'column_map' ) );
	}

}