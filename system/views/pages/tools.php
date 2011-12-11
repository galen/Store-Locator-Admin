<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>

<h2>Tools</h2>
<?php require( DIR_VIEWS . '/widgets/page_status_message.php' ) ?>


<h3>Backup</h3>
<?php if( $registry->backup_dir_perms == '777' ): ?>
<form action="" method="post">
<fieldset>
	<p>Backup your table</p>
	<label for="backup_file_name">File name</label>
	<input type="text" name="backup_file_name" value="<?php e( $registry->backup_file_name_suggestion ) ?>" id="backup_file_name">
	<input type="submit" value="Backup" class="btn primary">
</fieldset>
</form>
<?php else: ?>
<p>Chmod the backup directory to 777 for the ability to create backups.</p>
<?php endif; ?>

<hr>

<h3>Existing Backups</h3>
<?php if ( count( $registry->backup_file ) ): ?>
<form action="" method="post">
<fieldset>
	<p>Restore from backup. This will delete all existing data.<?php if( $registry->backup_dir_perms != '777' ): ?> Chmod the backup directory to 777 for the ability to delete backups<?php endif; ?></p>
	<label for="backup_filee">Backup File</label>
	<select name="backup_file" id="backup_file">
	<?php foreach( $registry->backup_file as $backup_file ): ?>
		<option value="<?php e( $backup_file ) ?>"><?php e( $backup_file ) ?></option>
	<?php endforeach; ?>
	</select>
	<input type="submit" name="restore_backup" value="Restore Backup" class="btn primary">
	<?php if( $registry->backup_dir_perms == '777' ): ?>
	<input type="submit" name="delete_backup" value="Delete backup" class="btn danger">
	<?php endif; ?>
</fieldset>
</form>
<?php else: ?>
<p>No backups exist</p>
<?php endif; ?>

<hr>

<h3>Geocode All Locations</h3>
<dl id="geocode_stats">
	<dt>Geocoded</dt><dd id="geocode_stats_geocoded"><?php if( $registry->count_geocoded ): ?><a href="<?php e( sprintf( '%s?geocode_status=%s', URL_SEARCH, LocationTableGateway::GEOCODE_STATUS_TRUE ) ) ?>"><?php endif; ?><?php echo $registry->count_geocoded ?><?php if( $registry->count_geocoded ): ?></a><?php endif; ?></dd>
	<dt>Ungeocoded</dt><dd id="geocode_stats_ungeocoded"><?php if( $registry->count_ungeocoded ): ?><a href="<?php e( sprintf( '%s?geocode_status=%s', URL_SEARCH, LocationTableGateway::GEOCODE_STATUS_FALSE ) ) ?>"><?php endif; ?><?php echo $registry->count_ungeocoded ?><?php if( $registry->count_ungeocoded ): ?></a><?php endif; ?></dd>
</dl>
<p><?php if( $registry->count_ungeocoded == 0 ): ?>All locations are geocoded!<?php endif; ?></p>
<form action="" method="post">
	<input type="submit"<?php if( $registry->count_ungeocoded == 0 ): ?> disabled="true"<?php endif; ?> class="btn success<?php if( $registry->count_ungeocoded == 0 ): ?> disabled<?php endif; ?>" name="geocode_all" id="geocode_all" value="Geocode All">
	<input type="submit"<?php if( $registry->count_geocoded == 0 ): ?> disabled="true"<?php endif; ?> class="btn error<?php if( $registry->count_geocoded == 0 ): ?> disabled<?php endif; ?>" name="ungeocode_all" id="ungeocode_all" value="Delete All Geocode Info">
	<img src="<?php e( URL_PUBLIC ) ?>/images/ajax_loader.gif" id="geocode_ajax_loader">
</form>
<?php require( DIR_VIEWS . '/footer.php' ) ?>