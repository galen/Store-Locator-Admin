<?php

// Backup the table
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

// Restore from backup
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
	if ( $geocode_all_result = $stg->geocodeAll() ) {
		$status_message->setStatus( 'success' );
		$status_message->setMessage( sprintf( '<p>%s store%s successfully geocoded</p>', $geocode_all_result, $geocode_all_result > 1 ? 's' : '' ) );
	}
	else {
		header("HTTP/1.1 500 Internal Server Error");
		$status_message->setStatus( 'error' );
		$status_message->setMessage( '<p>No stores were geocoded</p>' );
	}
}

$counts = $stg->getStoreCounts();
$vars->count_all = $counts['all'];
$vars->count_geocoded = $counts['geocoded'];
$vars->count_ungeocoded = $counts['ungeocoded'];
$vars->backup_file = array_map( 'basename', glob( DIR_BACKUPS . '/*' ) );

date_default_timezone_set( 'America/New_York' );
$vars->backup_file_name_suggestion = date( 'Y-m-d' );

$backup_file_name_suggestion_suffix = 2;
while( file_exists( DIR_BACKUPS . '/' . $vars->backup_file_name_suggestion . '.sql' ) ) {
	$vars->backup_file_name_suggestion = sprintf( '%s_%s', current( explode( '_', $vars->backup_file_name_suggestion ) ), $backup_file_name_suggestion_suffix++ );
}
$vars->backup_file_name_suggestion .= '.sql';
$vars->backup_dir_perms = substr( decoct( fileperms( DIR_BACKUPS ) ), 2 );
require( DIR_VIEWS . '/pages/tools.php' );