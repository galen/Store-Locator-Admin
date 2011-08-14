<?php

function e( $str ) {
	echo htmlentities( $str, ENT_QUOTES, 'UTF-8' );
}

function prettify_table_name( $table_name ) {
	return ucwords( preg_replace( '~-|_~', ' ', $table_name ) );
}