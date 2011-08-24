<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>
<h2>Delete Store <?php echo $vars['store_id'] ?></h2>
<form action="" method="post">
	<fieldset>
		<p>Are you sure you want to delete this store?</p>
		<input type="submit" value="Yes" name="delete">
		<input type="submit" value="Cancel" name="cancel">
	</fieldset>
</form>
<?php require( DIR_VIEWS . '/footer.php' ) ?>