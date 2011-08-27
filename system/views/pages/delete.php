<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/page_status_message.php' ) ?>
<h2>Delete Store <?php echo $vars['store_id'] ?></h2>
<form action="" method="post">
	<fieldset>
		<p>Are you sure you want to delete this store?</p>
		<input type="submit" value="Yes" name="delete" class="btn danger">
		<input type="submit" value="Cancel" name="cancel" class="btn">
	</fieldset>
</form>
<?php require( DIR_VIEWS . '/footer.php' ) ?>