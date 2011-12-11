<?php

if ( isset( $_POST['backup_file_name'] ) ) {
	if ( $stg->backup( $b = DIR_BACKUPS . '/' . basename( $_POST['backup_file_name'] ) ) ) {
		$status_message->setStatus( 'success' );
		$status_message->setMessage( sprintf( '<p>Backup created sucessfully (%s)</p>', $b ) );
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		$status_message->setStatus( 'error' );
		$status_message->setMessage( '<p>Error during backup</p>' );
	}
}

if ( isset( $_POST['backup_file'] ) ) {
	if ( isset( $_POST['restore_backup'] ) ) {
		if ( $stg->restore( $b = DIR_BACKUPS . '/' . basename( $_POST['backup_file'] ) ) ) {
			$status_message->setStatus( 'success' );
			$status_message->setMessage( sprintf( '<p>Backup restored successfully (%s)</p>', $b ) );
		}
		else {
			header("HTTP/1.1 500 Internal Server Error");
			$status_message->setStatus( 'error' );
			$status_message->setMessage( 'Error during restore' );
		}
	}
	if ( isset( $_POST['delete_backup'] ) ) {
		if ( @unlink( DIR_BACKUPS . '/' . basename( $_POST['backup_file'] ) ) ) {
			$status_message->setStatus( 'success' );
			$status_message->setMessage( '<p>Backup deleted successfully</p>' );
		}
		else {
			header("HTTP/1.1 500 Internal Server Error");
			$status_message->setStatus( 'error' );
			$status_message->setMessage( '<p>Error deleting backup</p>' );
		}
	}
}

if ( isset( $_POST['geocode_all'] ) ) {
	set_time_limit( $registry->count_ungeocoded );
	if ( $geocode_all_result = $stg->geocodeAll() ) {
		$status_message->setStatus( 'success' );
		$status_message->setMessage( sprintf( '<p>%s location%s successfully geocoded</p>', $geocode_all_result, $geocode_all_result > 1 ? 's' : '' ) );
	}
	else {
		$status_message->setStatus( 'error' );
		$status_message->setMessage( '<p>No locations were able to be geocoded</p>' );
	}
}

if ( isset( $_POST['ungeocode_all'] ) ) {
	if ( $geocode_all_result = $stg->ungeocodeAll() ) {
		$status_message->setStatus( 'success' );
		$status_message->setMessage( '<p>Location location data removed</p>' );
	}
	else {
		$status_message->setStatus( 'error' );
		$status_message->setMessage( '<p>Error removing location data</p>' );
	}
}

$counts = $stg->getLocationStats();
$registry->count_all = $counts['all'];
$registry->count_geocoded = $counts['geocoded'];
$registry->count_ungeocoded = $counts['ungeocoded'];
$registry->backup_file = array_map( 'basename', glob( DIR_BACKUPS . '/*' ) );

date_default_timezone_set( 'America/New_York' );
$registry->backup_file_name_suggestion = date( 'Y-m-d' );

$backup_file_name_suggestion_suffix = 2;
while( file_exists( DIR_BACKUPS . '/' . $registry->backup_file_name_suggestion . '.sql' ) ) {
	$registry->backup_file_name_suggestion = sprintf( '%s_%s', current( explode( '_', $registry->backup_file_name_suggestion ) ), $backup_file_name_suggestion_suffix++ );
}
$registry->backup_file_name_suggestion .= '.sql';
$registry->backup_dir_perms = substr( decoct( fileperms( DIR_BACKUPS ) ), 2 );

require( DIR_VIEWS . '/pages/tools.php' );