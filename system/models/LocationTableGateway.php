<?php

/**
 * @package Locations Admin
 * @author Galen Grover <galenjr@gmail.com>
 */

class LocationTableGateway {

	/**
	 * DB Instance
	 * Must be of type PDO
	 * @var PDO
	 */
	protected $db;

	/**
	 * Table that holds the locations
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * Column map
	 *
	 * Map of column names
	 *
	 * @var array
	 */
	protected $column_map;

	/**
	 * Geocode constants
	 */
	const GEOCODE_STATUS_ALL = 3;
	const GEOCODE_STATUS_TRUE = 2;
	const GEOCODE_STATUS_FALSE = 1;

	/**
	 * Constructor
	 *
	 * @param PDO $db
	 * @param string $table
	 * @param array $column_map
	 * @return LocationTableGateway
	 */
	public function __construct( PDO $db, $table, array $column_map ) {
		$this->db = $db;
		$this->table = $table;
		$this->column_map = $column_map;
	}

	/**
	 * Set the table to use
	 * 
	 * @param string $table
	 * @return void
	 */
	public function setTable( $table ) {
		$this->table = $table;
	}

	/**
	 * Backup the table
	 * 
	 * @param string $file
	 * @return boolean
	 */
	public function backup( $file ) {
		$sql = sprintf( sprintf( 'select * into outfile :file from %s', $this->table ) );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->bindValue( ':file', $file );
		if ( $stmnt->execute() ) {
			return true;
		}
		return false;
	}

	/**
	 * restore from backup
	 * 
	 * @param string $file
	 * @return boolean
	 */
	public function restore( $file ) {
		$sql = sprintf( sprintf( 'truncate table %1$s; load data infile :file into table %1$s', $this->table ) );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->bindValue( ':file', $file );
		if ( $stmnt->execute() ) {
			return true;
		}
		return false;
	}

	/**
	 * Get the total number of results for a page
	 * 
	 * @param array $search_params (default: null)
	 * @param int $geocode_status (default: null)
	 * @return int
	 */
	public function getLocationCount( array $search_params=null, $geocode_status=null ) {
		$sql = sprintf( 'select count(id) from %s %s', $this->table, isset( $search_params ) || isset( $geocode_status ) ? $this->buildSearchString( (array)$search_params, $geocode_status ) : '' );
		unset( $search_params['geocode_status'] );
		$stmnt = $this->db->prepare( $sql );
		if ( is_array( $search_params ) ) {
			foreach( $search_params as $sp ) {
				if ( strtolower( $sp['value'] ) != 'null' && strtolower( $sp['value'] ) != 'not null' ) {
					$stmnt->bindValue( ':'.$sp['variable'], $sp['compare'] == 'like' ? '%'.$sp['value'].'%' : $sp['value'] );
				}
			}
		}
		$stmnt->execute();
		return $stmnt->fetchColumn();
	}

	/**
	 * Get locations
	 *
	 * Returns a set of locations from the table matching the given arguments
	 * 
	 * @param int $start Limit start (default: null)
	 * @param int $length Limit length (default: null)
	 * @param array $search_params The search parameters (default: null)
	 * @param int $geocode_status geocode status (default: null)
	 * @return void
	 */
	public function getLocations( $start=null, $length=null, array $search_params=null, $geocode_status=null, $order_by = null, $order_dir = null ) {
		$sql = sprintf( 'select * from %s %s', $this->table, isset( $search_params ) || isset( $geocode_status ) ? $this->buildSearchString( (array)$search_params, $geocode_status ) : '' );
		if ( $order_by ) {
			if ( $order_dir != 'asc' && $order_dir != 'desc' ) {
				$order_dir = 'asc';
			}
			$sql .= sprintf( " order by %s %s", $order_by, $order_dir );
		}
		if ( $start !== null ) {
			$sql .= ' limit :start, :length';
		}
		$stmnt = $this->db->prepare( $sql );
		if ( $start !== null ) {
			$stmnt->bindValue( ':start', $start, PDO::PARAM_INT );
			$stmnt->bindValue( ':length', $length, PDO::PARAM_INT );
		}
		if ( is_array( $search_params ) ) {
			foreach( $search_params as $sp ) {
				$stmnt->bindValue( ':'.$sp['variable'], $sp['compare'] == 'like' ? '%'.$sp['value'].'%' : $sp['value'] );
			}
		}
		$stmnt->execute();
		$locations = array();
		foreach( $stmnt->fetchAll( PDO::FETCH_ASSOC ) as $data ) {
			$locations[] = new Location( $this->column_map, $data );
		}
		return $locations;
	}

	/**
	 * Geocode all locations
	 * 
	 * @return int Returns the number of locations that were geocoded
	 */
	function geocodeAll() {
		$updated = 0;
		$locations = array();
		$sql = sprintf( 'select * from %s where ( %2$s is null || %2$s = 0 || %3$s is null and %3$s = 0 )', $this->table, $this->column_map['lat'], $this->column_map['lng'] );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->execute();
		foreach( $stmnt->fetchAll( PDO::FETCH_ASSOC ) as $data ) {
			$locations[] = new Location( $this->column_map, $data );
		}
		foreach( $locations as $location ) {
			$req = Request::factory( URL_ROOT_ABSOLUTE . '/api/geocode?' . http_build_query( $location->getData() ) );
			$resp = $req->execute();
			if ( $resp->status == 200 ) {
				$req2 = Request::factory( URL_ROOT_ABSOLUTE . '/api/edit/' . $location->getID() );
				$req2->post = array(
					$this->column_map['id'] => $location->getID(),
					$this->column_map['lat'] => $resp->data->lat,
					$this->column_map['lng'] => $resp->data->lng
				);
				$req2->method = 'post';
				$resp2 = $req2->execute();
				if ( $resp2->status == 200 ) {
					$updated++;
				}
			}
		}
		return $updated;
	}


	/**
	 * Ungeocode all locations
	 * 
	 * @return void
	 */
	function ungeocodeAll() {
		$updated = 0;
		$locations = array();
		$sql = sprintf( 'update %s set %s=null, %s=null', $this->table, $this->column_map['lat'], $this->column_map['lng'] );
		$stmnt = $this->db->prepare( $sql );
		return (bool) $stmnt->execute();
	}

	/**
	 * Get locationstatistics
	 *
	 * Returns the number of locations in the table as well as the number of
	 * geocoded/ungeocoded locations 
	 *
	 * @return array
	 */
	function getLocationStats() {
		$sql = sprintf( "select count(id) as count from %s", $this->table );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->execute();
		$all_count = $stmnt->fetchColumn();
		$sql = sprintf( 'select count(id) as count from %s where ( %2$s is not null and %2$s != 0 && %3$s is not null and %3$s != 0 )', $this->table, $this->column_map['lat'], $this->column_map['lng'] );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->execute();
		$geocoded_count = $stmnt->fetchColumn();
		$ungeocoded_count = $all_count - $geocoded_count;
		return array (
			'all'			=> $all_count,
			'geocoded'		=> $geocoded_count,
			'ungeocoded'	=> $ungeocoded_count,			
		);
	}

	function getLocationsWithIds( array $ids ) {
		foreach( $ids as $idn => $id ) {
			$in[] = sprintf( ':id%s', $idn );
		}

		$sql = sprintf( 'select * from %s where %s in(%s)', $this->table, $this->column_map['id'], implode( ',', $in ) );
		$stmnt = $this->db->prepare( $sql );
		foreach( $ids as $idn => $id ) {
			$stmnt->bindValue( sprintf( ':id%s', $idn ), $id );
		}
		$stmnt->execute();
		foreach( $stmnt->fetchAll( PDO::FETCH_ASSOC ) as $data ) {
			$locations[] = new Location( $this->column_map, $data );
		}
		return $locations;
	}

	/**
	 * Build the search string SQL
	 * 
	 * @param array $search_params The search parameters
	 * @param int $geocode_status The geocode status
	 * @return string Returns an SQL string representing the search parameters
	 */
	private function buildSearchString( array $search_params, $geocode_status ) {
		$columns = implode( ' and ', array_map( function($a) { return sprintf( '%s %s :%s', $a['variable'], $a['compare'],$a['variable'] ); }, $search_params ) );
		$sql = sprintf( 'where 1 = 1%s', $columns ? ' and ' : '' ) . $columns; 

		if ( $geocode_status === self::GEOCODE_STATUS_FALSE ) {
			$sql .= sprintf( ' and ( ( %1$s is null or %1$s = 0 ) || ( %2$s is null or %2$s = 0 ) )', $this->column_map['lat'], $this->column_map['lng'] );
		}
		elseif ( $geocode_status === self::GEOCODE_STATUS_TRUE ) {
			$sql .= sprintf( ' and ( %1$s is not null and %1$s != 0 && %2$s is not null and %2$s != 0 )', $this->column_map['lat'], $this->column_map['lng'] );
		}
		return $sql;
	}

	/**
	 * Get the table columns
	 * 
	 * @return array Returns an array of table columns and their types
	 */
	function getColumns() {
		$tmp_columns = $this->db->query( sprintf( 'show columns from %s', $this->table ) )->fetchAll( PDO::FETCH_ASSOC );
		foreach( $tmp_columns as $column ) {
			$type = $column['Type'];
			if ( strpos( $type, 'text' ) !== FALSE ) {
				$columns[$column['Field']] = array (
					'type'		=> 'textarea'
				);
			}
			elseif ( strpos( $type, 'enum' ) !== FALSE ) {
				$columns[$column['Field']] = array (
					'type'		=> 'select',
					'values'	=> array_map( function( $v ) use( $type ){ return str_replace( "'", '', $v ); }, explode( ',', end( explode( '(', trim( $type, ')' ) ) ) ) )
				);
				sort( $columns[$column['Field']]['values'] );
			}
			else {
				$columns[$column['Field']] = array (
					'type'		=> 'textbox'
				);
			}
		}
		return $columns;
	}

	/**
	 * Get a location
	 *
	 * @param int $id
	 * @return mixed The locationon success, false on error
	 */
	function getLocation( $id ) {
		$sql = sprintf( 'select * from %s where id=:id', $this->table );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->bindValue( ':id', $id, PDO::PARAM_INT );
		$stmnt->execute();
		$data = current( $stmnt->fetchAll( PDO::FETCH_ASSOC ) );
		if ( !$data ) {
			return false;
		}
		return new Location( $this->column_map, $data );
	}

	/**
	 * Delete a location
	 * 
	 * @param int $id
	 * @return boolean True on success, false on error
	 */
	function deleteLocation( $id ) {
		$sql = sprintf( 'delete from %s where %s = :id', $this->table, $this->column_map['id'] );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->bindValue( ':id', $id );
		if( $stmnt->execute() && $stmnt->rowCount() ) {
			return true;
		}
		return false;
	}

	/**
	 * Create a location
	 * 
	 * @param Location $location
	 * @return boolean True on success, false on error
	 */
	function createLocation( Location $location ) {
		$vars = $location->getData();
		unset( $vars['id'] );
		$sql = sprintf( 'insert into %s (%s) values(%s)', $this->table, implode( ',', array_keys( $vars ) ), implode( ',', array_map( function( $v ) { return ':'.$v; }, array_keys( $vars ) ) ) );
		$stmnt = $this->db->prepare( $sql );
		foreach( $vars as $var => $val ) {
			$stmnt->bindValue( ':'.$var, $val );
		}
		if( $stmnt->execute() && $stmnt->rowCount() ) {
			return $this->db->lastInsertId();
		}
		return false;
	}

	/**
	 * Save a location
	 * 
	 * @param Location $location locationto save
	 * @return boolean True on success, false on error
	 */
	function saveLocation( Location $location ) {
		if ( !$this->getLocation( $location->getID() ) ) {
			return false;
		}
		$id = $location->getID();
		$location_array = $location->getData();
		unset( $location_array['id'] );

		$sql = sprintf( 'update %s set %s where id = :id',
			$this->table,
			implode( ', ', array_map( function( $c ) { return sprintf( '%1$s = :%1$s', $c ); }, array_keys( $location_array ) ) )
		);
		$stmnt = $this->db->prepare( $sql );
		$stmnt->bindValue( ':id', $id );
		foreach( $location_array as $property => $value ) {
			$stmnt->bindValue( ':'.$property, $value );
		}
		if ( $stmnt->execute() ) {
			return true;
		}
		return false;
	}

	/**
	 * Validate the table structure
	 *
	 * Validates that the table exists and that id, lat, and lng columns are present
	 *
	 * @return boolean
	 */
	function validateTable() {
		$query = $this->db->query( sprintf( 'show columns from %s', $this->table ) );
		if ( !$query ) {
			return false;
		}
		foreach( $query->fetchAll( PDO::FETCH_ASSOC ) as $c ) {
			$columns[$c['Field']] = true;
		}
		return isset( $columns[$this->column_map['id']], $columns[$this->column_map['lat']], $columns[$this->column_map['lng']] );
	}

}

