<?php include( DIR_VIEWS . '/widgets/store_listing_table_actions.php' ) ?>

<table id="store_table" data-ajax-loader-image="<?php echo URL_PUBLIC  ?>/images/ajax_loader.gif">
	<thead>
		<tr>
			<?php foreach( $registry->columns_list as $tc ): ?>
				<td><?php e( prettify_var( $tc ) ) ?></td>
			<?php endforeach; ?>
			<td class="center">Geocoded</td>
			<td class="center">Actions</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach( $registry->stores as $store ): ?>
	<tr data-store-id="<?php echo $store->getID() ?>" data-geocode="<?php echo $store->getQueryString() ?>">
		<?php foreach( $registry->columns_list as $tc ): ?>
			<td><?php e( $store->$tc ) ?></td>
		<?php endforeach; ?>
		<td class="center"><?php if( $store->isGeocoded() ): ?>Yes<?php else: ?><a href="<?php echo URL_EDIT ?>/<?php echo $store->getID() ?>/" class="geocode_table btn small success" title="Click to geocode this store">No</a><?php endif; ?></td>
		<td class="store_actions center">
			<a class="btn small primary" href="<?php echo URL_EDIT ?>/<?php echo $store->getID() ?>/" title="Edit this store">edit</a>
			<a class="btn small danger delete_store" href="<?php echo URL_DELETE ?>/<?php echo $store->getID() ?>/" class="delete_store" title="Delete this store">X</a>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<?php if( $registry->page_store_count > 20 ): ?>
<?php include( DIR_VIEWS . '/widgets/store_listing_table_actions.php' ) ?>
<?php endif; ?>