<?php

/**
 * @package Locations Admin
 * @author Galen Grover <galenjr@gmail.com>
 */
 
class Location {

	/**
	 * Column map
	 * This lets the class know the names of your table columns
	 * It is set in your config file
	 *
	 * @var array
	 */
	private $column_map = array();

	/**
	 * locationdata
	 *
	 * @var array
	 */
	private $data = array();

	/**
	 * Constructor
	 *
	 * @param array $column_map column map
	 * @param array $data locationdata
	 * @return Location
	 */
	function __construct( array $column_map, array $data = null ) {
		$this->column_map = $column_map;
		if ( $data ) {
			$this->data = $data;
		}
		/*
		 * These next lines set the lat/lng to '' if the lat/lng is null or 0.000000
		 * This helps to account for the default values of more table structures
		 *
		 * Also assumes that there will be no locations at 0,0
		 */
		if ( !(int)$this->getLat() ) {
			$this->setLat( '' );
		}
		if ( !(int)$this->getLng() ) {
			$this->setLng( '' );
		}
	}

	/**
	 * Get locationgeocode status
	 *
	 * Returns true if the locationis geocoded, false otherwise
	 *
	 * @return boolean
	 */
	function isGeocoded() {
		return ( $this->getLat() && $this->getLng() );
	}

	/**
	 * Fake getters and setters
	 *
	 * Allows for the use of setVar() and getVar()
	 *
	 * @param string $method Method that was called
	 * @param array $args Arguments sent to method
	 * @return mixed
	 */
	function __call( $method, array $args ) {
		$var = strtolower( substr( $method, 3 ) );
		if ( strpos( $method, 'get' ) === 0 ) {
			return $this->{$this->column_map[$var]};
		}
		if ( strpos( $method, 'set' ) === 0 ) {
			$this->data[$this->column_map[$var]] = $args[0];
		}
	}

	/**
	 * Get the locationdata array
	 *
	 * @return array Returns the array of locationdata
	 */
	function getData() {
		return $this->data;
	}

	/**
	 * Set locationdata
	 *
	 * @param string $var Variable to set
	 * @param mixed $val Value to set the variable to
	 * @return void
	 */
	function __set( $var, $val ) {
		$var = strtolower( $var );
		if ( $var != 'id' && isset( $this->data[$this->column_map[$var]] ) ) {
			$this->data[$this->column_map[$var]] = $val;
		}
	}

	/**
	 * Get locationdata
	 *
	 * @param string $var Variable to set
	 * @return mixed Returns the data
	 */
	function __get( $var ) {
		$var = strtolower( $var );
		return isset( $this->data[$this->column_map[$var]] ) ? $this->data[$this->column_map[$var]] : null;
	}

	/**
	 * Get editable locationproperties
	 *
	 * Id is not editable, we need a way to get all data except for the id
	 *
	 * @return array Returns an array of locationdata minus the id
	 */
	function getEditableProperties() {
		return array_diff( array_keys( $this->data ), array( $this->column_map['id'], 'column_map' ) );
	}

	/**
	 * Get the locationin CSV format
	 *
	 * @return string
	 */
	function getCSV() {
		return implode( ',', $this->getData() );
	}

	function hasState() {
		return isset( $this->data[$this->column_map['state']] );
	}

	/**
	 * Get the locationin query string format
	 *
	 * @return string Returns the locationin query string format
	 */
	function getQueryString() {
		$str = '?';
		foreach( $this->data as $k => $v ) {
			if ( in_array( $k, array( 'column_map' ) ) ) {
				continue;
			}
			$str .= sprintf( '%s=%s&', $k, urlencode( $v ) );
		}
		return $str;
	}

}