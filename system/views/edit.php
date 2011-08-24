<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widget_navigation.php' ) ?>

<h2><?php if ( isset( $store ) ): ?>Editing Store #<?php echo $vars['store_id'] ?><?php else: ?>Create Store<?php endif; ?></h2>

<?php require( DIR_VIEWS . '/widget_page_status_message.php' ) ?>

<form action="<?php echo URL_EDIT ?>/<?php echo $vars['store_id'] ?>/" method="post" id="store_edit">

	<fieldset>
		<?php if ( isset( $store ) ): ?>
		<input type="hidden" name="<?php echo $config['column_map']['id'] ?>" value="<?php echo $store->getID() ?>" id="store_id">
		<?php endif; ?>
		<?php foreach( $vars['columns_edit'] as $property ): ?>
		<div>
			<label><?php echo prettify_var( $property ) ?></label>
			<input type="text" name="<?php echo $property ?>" id="<?php echo $property ?>" value="<?php if( isset( $store->$property ) ): ?><?php echo $store->$property ?><?php endif; ?>">
		</div>
		<?php endforeach; ?>
		
		<p><a href="#" class="geocode_form">Geocode</a></p>
		<?php $map->printMap() ?>
	
		<input type="submit" value="<?php if( $vars['action'] == 'create' ): ?>Create<?php else: ?>Save<?php endif; ?>" name="<?php if( $vars['action'] == 'create' ): ?>create<?php else: ?>save<?php endif; ?>">
	</fieldset>

</form>
<?php if ( isset( $store ) ): ?>
<form action="<?php echo URL_DELETE ?>/<?php echo $store->getID() ?>/" method="get">
	<input type="hidden" name="c" value="<?php echo URL_EDIT ?>/<?php echo $store->getID() ?>/">
	<input type="submit" value="Delete this store">
</form>
<?php endif; ?>
<?php require( DIR_VIEWS . '/footer.php' ) ?>