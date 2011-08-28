<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>

<h2><?php if ( isset( $store ) ): ?>Editing Store #<?php echo $vars['store_id'] ?><?php else: ?>Create Store<?php endif; ?></h2>

<?php require( DIR_VIEWS . '/widgets/page_status_message.php' ) ?>

<form action="<?php if( $vars['controller'] == 'edit' ): ?><?php echo URL_EDIT ?>/<?php echo $vars['store_id'] ?>/<?php else: ?><?php echo URL_CREATE ?>/<?php endif; ?>" method="post" id="store_edit">

	<fieldset>
		<div id="form_fields">
			<?php if ( isset( $store ) ): ?>
			<input type="hidden" name="<?php echo $config['column_map']['id'] ?>" value="<?php echo $store->getID() ?>" id="store_id">
			<?php endif; ?>
			<?php foreach( $vars['columns_edit'] as $property ): ?>
			<div>
				<label><?php echo prettify_var( $property ) ?></label>
				<input type="text" name="<?php echo $property ?>" id="<?php echo $property ?>" value="<?php if ( isset( $store ) ): ?><?php echo $store->raw( $property ) ?><?php endif; ?>">
			</div>
			<?php endforeach; ?>
		</div>
		<?php $map->printMap() ?>		
		
		<div class="well" id="store_edit_actions">
			<input type="submit" class="btn primary" value="<?php if( $vars['controller'] == 'create' ): ?>Create<?php else: ?>Save<?php endif; ?>" name="<?php if( $vars['controller'] == 'create' ): ?>create<?php else: ?>save<?php endif; ?>">
			<a href="#" class="geocode_form btn success">Geocode</a>
			<?php if( isset( $store ) ): ?><a href="<?php echo URL_DELETE ?>/<?php echo $store->getID() ?>/" id="delete_store" class="btn danger">Delete this store</a><?php endif; ?>
		</div>
	</fieldset>

</form>

<?php require( DIR_VIEWS . '/footer.php' ) ?>