<?php

class Db extends PDO {

	function __construct( $user, $pw, $db, $host='localhost', $persistent=false, $charset='utf8' ) {

		$dsn = sprintf( 'mysql:dbname=%s;host=%s', $db, $host );

		if ( $persistent ) {
			$driver_options[PDO::ATTR_PERSISTENT] = TRUE;
		}
		
		try {
			$driver_options[PDO::MYSQL_ATTR_INIT_COMMAND] = sprintf( "SET NAMES %s", $charset );
			return parent::__construct($dsn, $user, $pw, $driver_options);
		}
		catch (PDOException $e) {
			return false;
		}

	}

	static function connect( $host, $user, $pw, $db, $persistent=false, $charset='utf8' ) {
		$dsn = sprintf( 'mysql:dbname=%s;host=%s', $db, $host );
		return new self( $host, $user, $pw, $db, $persistent, $charset );
	}

}

?>