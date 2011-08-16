<?php

class Store {

	private $_column_id, $_column_lat, $_column_lng;

	function __construct( $column_id, $column_lat, $column_lng, array $data = null ) {
		$this->_column_id = $column_id;
		$this->_column_lat = $column_lat;
		$this->_column_lng = $column_lng;
		
		if ( $data ) {
			foreach( $data as $var => $val ) {
				$this->$var = $val;
			}
		}
		
	}

	function isGeocoded() {
		return !( is_null( $this->getLat() ) || is_null( $this->getLng() ) );
	}

	function getLat() {
		return $this->{$this->_column_lat};
	}

	function getLng() {
		return $this->{$this->_column_lng};
	}

	function getID() {
		return $this->{$this->_column_id};
	}
	
	function getEditableProperties() {
		return array_diff( array_keys( get_object_vars( $this ) ), array( $this->_column_id, '_column_id', '_column_lat', '_column_lng' ) );
	}

}