<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>
<h2>Delete location#<?php echo $registry->request->params->location_id ?></h2>
<?php require( DIR_VIEWS . '/widgets/page_status_message.php' ) ?>
<form action="" method="post">
	<fieldset>
		<p>Are you sure you want to delete this location?</p>
		<input type="submit" value="Yes" name="delete" class="btn danger">
		<input type="submit" value="Cancel" name="cancel" class="btn">
	</fieldset>
</form>
<?php require( DIR_VIEWS . '/footer.php' ) ?>