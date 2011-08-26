<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/page_status_message.php' ) ?>

<h2>Backup</h2>
<?php if( $vars['backup_dir_perms'] == '777' ): ?>
<form action="" method="post">
<fieldset>
	<p>Backup your table</p>
	<label for="backup_file">File name</label><input type="text" name="backup_file" value="<?php e( $vars['backup_file_suggestion'] ) ?>" id="backup_file">
	<input type="submit" value="Backup">
</fieldset>
</form>
<?php else: ?>
<p>You must chmod the backup directory to 777.</p>
<?php endif; ?>

<form action="" method="post">
<fieldset>
	<p>Restore from backup. This will delete all existing data.</p>
	<label for="restore_file">Restore File</label>
	<select name="restore_file" id="restore_file">
	<?php foreach( $vars['restore_files'] as $restore_file ): ?>
		<option value="<?php e( $restore_file ) ?>"><?php e( $restore_file ) ?></option>
	<?php endforeach; ?>
	</select>
	<input type="submit" value="Restore">
</fieldset>
</form>

<?php require( DIR_VIEWS . '/footer.php' ) ?>