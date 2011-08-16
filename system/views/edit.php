<?php require( DIR_SYSTEM . '/views/header.php' ) ?>
<?php require( DIR_SYSTEM . '/views/widget_navigation.php' ) ?>

<h2>Editing Store #<?php echo $store->getID() ?></h2>
<form action="" method="post">

	<fieldset>
		<?php if ( $status_message->getStatus() ): ?>
		<p id="status_message" class="<?php echo $status_message->getStatuses() ?>"><?php echo $status_message->getMessage(); ?></p>
		<?php endif; ?>
		<input type="hidden" name="<?php echo COLUMN_ID ?>" value="<?php echo $store->getID() ?>">
		<?php foreach( $store->getEditableProperties() as $property ): ?>
		<div>
			<label><?php echo prettify_var( $property ) ?></label>
			<input type="text" name="<?php echo $property ?>" id="<?php echo $property ?>" value="<?php if( isset( $store->$property ) ): ?><?php echo $store->$property ?><?php endif; ?>">
		</div>
		<?php endforeach; ?>
		
		<p><a href="#" class="geocode">Geocode</a></p>
		<?php $map->printMap() ?>
	
		<input type="submit" value="Save" name="save">
	</fieldset>

</form>
<form action="<?php echo URL_DELETE ?>/<?php echo $store->getID() ?>/?b=<?php echo URL_EDIT ?>/<?php echo $store->getID() ?>/" method="post">
	<input type="submit" value="Delete this store" name="delete">
</form>