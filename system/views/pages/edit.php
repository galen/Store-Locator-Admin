<?php require( DIR_VIEWS . '/header.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/map_edit.php' ) ?>
<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>

<h2><?php if( $registry->controller == 'edit' ): ?>Editing Location #<?php e(  $registry->request->getParam( 'location_id' ) ) ?><?php else: ?>Create Location<?php endif; ?></h2>

<?php require( DIR_VIEWS . '/widgets/page_status_message.php' ) ?>

<form action="<?php if( $registry->controller == 'edit' ): ?><?php e(  URL_EDIT ) ?>/<?php e(  $registry->request->params->location_id ) ?>/<?php else: ?><?php e(  URL_CREATE ) ?>/<?php endif; ?>" method="post" id="location_edit">

	<fieldset>
		<div id="form_fields">
			<?php if( $registry->controller == 'edit' ): ?>
				<input type="hidden" name="<?php e(  $config['column_map']['id'] ) ?>" value="<?php e(  $location->getID() ) ?>" id="location_id">
			<?php endif; ?>
			<?php foreach( $config['column_map'] as $table_column => $property ): ?>
				<?php if( $table_column == 'lat' ): ?>
					<div id="location_lat_lng">
				<?php endif; ?>
					<div>
						<label><?php e(  prettify_var( $property ) ) ?></label>
						<input type="text" name="<?php e(  $table_column ) ?>" id="<?php e( $table_column ) ?>" value="<?php if ( isset( $location ) ): ?><?php e( $location->$property ) ?><?php endif; ?>">
					</div>
				<?php if( $table_column == 'lng' ): ?>
				<?php if( $registry->controller == 'create' ): ?><p id="create_geocode_note">You will be able to geocode the location after creation</p><?php endif; ?>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<div id="map" style="width:550px;height:500px;"><p id="map_msg"><a href="http://www.activatejavascript.org/">Enable javascript</a> to view the map</p></div>	
		<div class="well" id="location_edit_actions">
			<input type="submit" class="btn primary" value="<?php if( $registry->controller == 'create' ): ?>Create<?php else: ?>Save<?php endif; ?>" name="<?php if( $registry->controller == 'create' ): ?>create<?php else: ?>save<?php endif; ?>">
			<?php if( $registry->controller == 'edit' ): ?><input type="submit" class="geocode_form btn success" id="geocode_form_button" name="geocode" value="Geocode"><div id="geocode_ajax_status_wrapper"><span id="geocode_ajax_status_text"></span><a href="#" class="close">&times;</a></div><img src="<?php e(  URL_PUBLIC ) ?>/images/ajax_loader.gif" id="geocode_ajax_loader"><?php endif; ?>
			<?php if( $registry->controller == 'edit' ): ?>
				<a href="<?php e(  URL_DELETE ) ?>/<?php e(  $location->getID() ) ?>/?c=<?php e(  URL_ROOT . '/' . REQUEST ) ?>/" id="delete_location" class="btn danger">Delete Location</a>
			<?php else: ?>
				<a href="<?php e( isset( $_GET['c'] ) ? $_GET['c'] : URL_LIST ) ?>/" class="btn danger">Cancel</a>
			<?php endif; ?>
		</div>
	</fieldset>

</form>

<?php require( DIR_VIEWS . '/footer.php' ) ?>