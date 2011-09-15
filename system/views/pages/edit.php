<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/map_edit.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>

<h2><?php if( $registry->controller == 'edit' ): ?>Editing Store #<?php echo $registry->request->getParam( 'store_id' ) ?><?php else: ?>Create Store<?php endif; ?></h2>

<?php require( DIR_VIEWS . '/widgets/page_status_message.php' ) ?>

<form action="<?php if( $registry->controller == 'edit' ): ?><?php echo URL_EDIT ?>/<?php echo $registry->request->params->store_id ?>/<?php else: ?><?php echo URL_CREATE ?>/<?php endif; ?>" method="post" id="store_edit">

	<fieldset>
		<div id="form_fields">
			<?php if( $registry->controller == 'edit' ): ?>
			<input type="hidden" name="<?php echo $config['column_map']['id'] ?>" value="<?php echo $store->getID() ?>" id="store_id">
			<?php endif; ?>
			<?php foreach( $registry->columns_edit as $property ): ?>
			<?php if( $property == $config['column_map']['lat'] ): ?>
			<div id="store_lat_lng">
			<?php endif; ?>
			<div>
				<label><?php echo prettify_var( $property ) ?></label>
				<input type="text" name="<?php echo $property ?>" id="<?php echo $property ?>" value="<?php if ( isset( $store ) ): ?><?php e( $store->$property ) ?><?php endif; ?>">
			</div>
			<?php if( $property == $config['column_map']['lng'] ): ?>
			<?php if( $registry->controller == 'create' ): ?><p id="create_geocode_note">You will be able to geocode the store after creation</p><?php endif; ?>
			</div>
			<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<div id="map" style="width:550px;height:500px;"><p id="map_msg"><a href="http://www.activatejavascript.org/">Enable javascript</a> to view the map</p></div>	
		<div class="well" id="store_edit_actions">
			<input type="submit" class="btn primary" value="<?php if( $registry->controller == 'create' ): ?>Create<?php else: ?>Save<?php endif; ?>" name="<?php if( $registry->controller == 'create' ): ?>create<?php else: ?>save<?php endif; ?>">
			<?php if( $registry->controller == 'edit' ): ?><input type="submit" class="geocode_form btn success" id="geocode_form_button" name="geocode" value="Geocode"><div id="geocode_ajax_status_wrapper"><span id="geocode_ajax_status_text"></span><span><a href="#" class="close">&times;</a></span></div><img src="<?php echo URL_PUBLIC ?>/images/ajax_loader.gif" id="geocode_ajax_loader"><?php endif; ?>
			<?php if( $registry->controller == 'edit' ): ?><a href="<?php echo URL_DELETE ?>/<?php echo $store->getID() ?>/?c=<?php echo URL_ROOT . '/' . REQUEST ?>" id="delete_store" class="btn danger">Delete this store</a><?php endif; ?>
		</div>
	</fieldset>

</form>

<?php require( DIR_VIEWS . '/footer.php' ) ?>