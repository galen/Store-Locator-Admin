<?php include( DIR_VIEWS . '/widgets/location_listing_table_actions.php' ) ?>

<table id="location_table" data-ajax-loader-image="<?php e( URL_PUBLIC ) ?>/images/ajax_loader.gif" class="bordered-table zebra-striped">
	<thead>
		<tr>
			<?php foreach( $registry->columns_list_titles as $tc ): ?>
				<th<?php if( isset( $config['column_alignment'][$tc] ) && strcasecmp( $config['column_alignment'][$tc], 'left' ) != 0 ): ?> class="<?php e( $config['column_alignment'][$tc] ) ?>"<?php endif; ?>><?php e( prettify_var( $tc ) ) ?></td>
			<?php endforeach; ?>
			<th class="center">Geocoded</td>
			<th class="center">Actions</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach( $registry->locations as $location ): ?>
	<tr data-location-id="<?php e( $location->getID() ) ?>" data-geocode="<?php e( $location->getQueryString() ) ?>">
		<?php foreach( $registry->columns_list as $tc ): ?>
			<td data-column="<?php e( $tc ) ?>" class="editable<?php if( isset( $config['column_alignment'][$tc] ) && strcasecmp( $config['column_alignment'][$tc], 'left' ) != 0 ): ?> <?php e( $config['column_alignment'][$tc] ) ?><?php endif; ?>"><?php e( $location->$tc ) ?></td>
		<?php endforeach; ?>
		<td class="center"><?php if( $location->isGeocoded() ): ?>Yes<?php else: ?><a href="<?php e( URL_EDIT ) ?>/<?php e( $location->getID() ) ?>/" class="geocode_table btn small success" title="Click to geocode this location">No</a><?php endif; ?></td>
		<td class="location_actions center">
			<a class="btn small primary" href="<?php e( URL_EDIT ) ?>/<?php e( $location->getID() ) ?>/" title="Edit this location">edit</a>
			<a class="btn small danger delete_location" href="<?php e( URL_DELETE ) ?>/<?php e( $location->getID() ) ?>/" class="delete_location" title="Delete this location">X</a>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php if( $registry->page_location_count > 20 ): ?>
<?php include( DIR_VIEWS . '/widgets/location_listing_table_actions.php' ) ?>
<?php endif; ?>