<?php

class Store {

	function __construct( $column_lat, $column_lng ) {
		$this->column_lat = $column_lat;
		$this->column_lng = $column_lng;
	}

	function isGeocoded() {
		return !( is_null( $this->{$this->column_lat} ) || is_null( $this->{$this->column_lng} ) );
	}

}