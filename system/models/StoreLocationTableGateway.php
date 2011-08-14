<?php

class StoreLocationTableGateway {

	protected $db;
	protected $table;
	
	public function __construct( PDO $db, $table ) {
	
		$this->db = $db;
		$this->table = $table;
	
	}

	public function getCount( array $search_params=null ) {
	
		$sql = sprintf( 'select count(id) from %s %s', $this->table,isset( $search_params ) ? $this->buildSearchString( $search_params ) : '' );
		$stmnt = $this->db->prepare( $sql );
		if ( is_array( $search_params ) ) {
			foreach( $search_params as $sp ) {
				$stmnt->bindParam( ':'.$sp[0], $sp[2] );
			}
		}
		$stmnt->execute();
		return $stmnt->fetchColumn();
	
	}

	public function getLocations( $start, $length, array $search_params=null ) {
	
		$sql = sprintf( 'select * from %s %s limit :start, :length', $this->table, isset( $search_params ) ? $this->buildSearchString( $search_params ) : '' );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->bindValue( ':start', $start, PDO::PARAM_INT );
		$stmnt->bindValue( ':length', $length, PDO::PARAM_INT );
		if ( is_array( $search_params ) ) {
			foreach( $search_params as $sp ) {
				$stmnt->bindParam( ':'.$sp[0], $sp[2] );
			}
		}
		$stmnt->execute();
		return $stmnt->fetchAll( PDO::FETCH_CLASS, 'Store', array( COLUMN_LAT, COLUMN_LNG ) );
	
	}

	public function buildSearchString( array $search_params ) {
	
		return 'where 1 = 1 and ' . implode( ' and ', array_map( function($a){ return sprintf( '%s %s :%s', $a[0], $a[1], $a[0] ); }, $search_params ) );
	
	}

	public function getColumns() {
		return array_diff(
			array_map(
				function( $c ){ return $c['Field']; },
				$this->db->query( sprintf( 'show columns from %s', $this->table ) )->fetchAll( PDO::FETCH_ASSOC )
			),
			array( COLUMN_LAT, COLUMN_LNG )
		);
	}

}

