<?php

// Backup the table
if ( isset( $_POST['backup_file'] ) ) {
	if ( $stg->backup( DIR_BACKUPS . '/' . basename( $_POST['backup_file'] ) ) ) {
		$status_message->setStatus( 'success' );
		$status_message->setMessage( 'Backup created sucessfully' );
	}
	else {
		$status_message->setStatus( 'error' );
		$status_message->setMessage( 'Error during backup' );
	}
}

// Restore from backup
if ( isset( $_POST['restore_file'] ) ) {
	if ( $stg->restore( DIR_BACKUPS . '/' . basename( $_POST['restore_file'] ) ) ) {
		$status_message->setStatus( 'success' );
		$status_message->setMessage( 'Table restored successfully' );
	}
	else {
		$status_message->setStatus( 'error' );
		$status_message->setMessage( 'Error during restore' );
	}
}


$vars['restore_files'] = array_map( 'basename', glob( DIR_BACKUPS . '/*' ) );

date_default_timezone_set( 'America/New_York' );
$vars['backup_file_suggestion'] = date( 'Y-m-d' );
$i=2;
while( file_exists( DIR_BACKUPS . '/' . $vars['backup_file_suggestion'] . '.sql' ) ) {
	$vars['backup_file_suggestion'] = sprintf( '%s_%s', current( explode( '_', $vars['backup_file_suggestion'] ) ), $i++ );
}
$vars['backup_file_suggestion'] .= '.sql';

require( DIR_VIEWS . '/pages/tools.php' );