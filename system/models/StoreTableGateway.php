<?php

class StoreTableGateway {

	protected $db;
	protected $table;
	protected $column_map;
	
	public function __construct( PDO $db, $table, array $column_map ) {
		$this->db = $db;
		$this->table = $table;
		$this->column_map = $column_map;
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

	public function getStores( $start, $length, array $search_params=null ) {
	
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
		return $stmnt->fetchAll( PDO::FETCH_CLASS, 'Store', array( $this->column_map ) );
	
	}

	public function buildSearchString( array $search_params ) {
		return 'where 1 = 1 and ' . implode( ' and ', array_map( function($a){ return sprintf( '%s %s :%s', $a[0], $a[1], $a[0] ); }, $search_params ) );
	}

	public function getColumns() {
		return array_map(
			function( $c ){ return $c['Field']; },
			$this->db->query( sprintf( 'show columns from %s', $this->table ) )->fetchAll( PDO::FETCH_ASSOC )
		);
	}

	public function getStore( $id ) {
		$sql = sprintf( 'select * from %s where id=:id', $this->table );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->bindValue( ':id', $id, PDO::PARAM_INT );
		$stmnt->execute();
		return $stmnt->fetchObject( 'Store', array( $this->column_map ) );
	}

	function deleteStore( $id ) {
	
		$sql = sprintf( 'delete from %s where %s = :id', $this->table, $this->column_map['id'] );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->bindValue( ':id', $id );
		if( $stmnt->execute() && $stmnt->rowCount() ) {
			return true;
		}
		return false;
	
	}

	function saveStore( Store $store ) {
	
		$id = $store->id;
		$store_array = get_object_vars( $store );
		unset( $store_array['id'] );
		foreach( $store_array as $property => $value ) {
			if ( strpos( $property, '_' ) === 0 ) {
				unset( $store_array[$property] );
			}
		}
		
		$sql = sprintf( 'update %s set %s where id = :id', $this->table, implode( ', ', array_map( function( $c ){ return sprintf( '%1$s = :%1$s', $c ); }, array_keys( $store_array ) ) ) );
		$stmnt = $this->db->prepare( $sql );
		$stmnt->bindValue( ':id', $id );
		foreach( $store_array as $property => $value ) {
			$stmnt->bindValue( ':'.$property, $value );
		}
		
		if ( $stmnt->execute() ) {
			return true;
		}
		return false;
	}

}

