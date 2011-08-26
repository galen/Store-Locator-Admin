<?php

class Db extends PDO {

	public $type, $charset;

	function __construct( $user, $password, $name, $host='localhost', $type='mysql', $persistent=false, $charset='utf8' ) {

		$dsn = sprintf( '%s:dbname=%s;host=%s', $type, $name, $host );

		if ( $persistent ) {
			$driver_options[PDO::ATTR_PERSISTENT] = TRUE;
		}
		
		try {
			$driver_options[PDO::MYSQL_ATTR_INIT_COMMAND] = sprintf( "SET NAMES %s", $charset );
			$this->type = $type;
			$this->charset = $charset;
			return parent::__construct($dsn, $user, $password, $driver_options);
		}
		catch (PDOException $e) {
			return false;
		}

	}

	static function connect( $user, $password, $name, $host='localhost', $type='mysql', $persistent=false, $charset='utf8' ) {
		return new self( $user, $password, $name, $host, $type, $persistent, $charset );
	}

}

?>