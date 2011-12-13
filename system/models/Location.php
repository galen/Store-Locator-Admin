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
	 * location data
	 *
	 * @var array
	 */
	private $data = array();

	/**
	 * Constructor
	 *
	 * @param array $column_map column map
	 * @param array $data location data
	 * @return Location
	 */
	function __construct( array $column_map, array $data = null ) {
		$this->column_map = $column_map;
		if ( $data ) {
			$this->data = $data;
		}
	}

	/**
	 * Get location geocode status
	 *
	 * Returns true if the location is geocoded, false otherwise
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
	 * Get the location data array
	 *
	 * @return array Returns the array of location data
	 */
	function getData() {
		return $this->data;
	}

	/**
	 * Set location data
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
	 * Get location data
	 *
	 * If retreiving the lat/lng this will check if the lat/lng is 0 or null and convert it to ''
	 *
	 * @param string $var Variable to set
	 * @return mixed Returns the data
	 */
	function __get( $var ) {
		$var = strtolower( $var );
		if ( $var == 'lat' || $var == 'lng' ) {
			if ( !(int)$this->data[$this->column_map[$var]] ) {
				return '';
			}
			return $this->data[$this->column_map[$var]];
		}
		return isset( $this->data[$this->column_map[$var]] ) ? $this->data[$this->column_map[$var]] : null;
	}

	/**
	 * Get editable location properties
	 *
	 * Id is not editable, we need a way to get all data except for the id
	 *
	 * @return array Returns an array of location data minus the id
	 */
	function getEditableProperties() {
		return array_diff( array_keys( $this->data ), array( $this->column_map['id'], 'column_map' ) );
	}

	/**
	 * Get the location in CSV format
	 *
	 * @return string
	 */
	function getCSV() {
		return implode( ',', $this->getData() );
	}

	/**
	 * Returns true/false depending on whether the current location can have a state
	 *
	 * @return boolean
	 */
	function hasState() {
		return isset( $this->data[$this->column_map['state']] );
	}

	/**
	 * Get the location in query string format
	 *
	 * @return string Returns the location in query string format
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