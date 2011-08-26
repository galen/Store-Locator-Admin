<table id="store_table" data-ajax-loader-image="<?php echo URL_PUBLIC  ?>/images/ajax_loader.gif">
	<thead>
		<tr>
			<?php foreach( $vars['columns_list'] as $tc ): ?>
				<td><?php e( prettify_var( $tc ) ) ?></td>
			<?php endforeach; ?>
			<td>Geocoded [<a href="#" id="geocode_all">A</a>]</td>
			<td>Edit</td>
			<td>X</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach( $vars['stores'] as $store ): ?>
	<tr data-geocode="<?php echo $store->getQueryString() ?>">
		<?php foreach( $vars['columns_list'] as $tc ): ?>
			<td><?php e( $store->raw( $tc ) ) ?></td>
		<?php endforeach; ?>
		<td><?php if( $store->isGeocoded() ): ?>Yes<?php else: ?><a href="#" class="geocode_table">No</a><?php endif; ?></td>
		<td><a href="<?php echo URL_EDIT ?>/<?php echo $store->getID() ?>/">edit</a></td>
		<td><a href="<?php echo URL_DELETE ?>/<?php echo $store->getID() ?>/" data-id="<?php echo $store->getID() ?>" class="delete_store">X</a></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>