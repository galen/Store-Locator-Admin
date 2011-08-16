<table>
	<thead>
		<tr>
			<?php foreach( $vars['table_columns_list'] as $tc ): ?>
				<td><?php e( prettify_var( $tc ) ) ?></td>
			<?php endforeach; ?>
			<td>Location</td>
			<td>Edit</td>
			<td>X</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach( $vars['stores'] as $store ): ?>
	<tr>
		<?php foreach( $vars['table_columns_list'] as $tc ): ?>
			<td><?php e( $store->$tc ) ?></td>
		<?php endforeach; ?>
		<td><?php if( $store->isGeocoded() ): ?>View Map<?php else: ?>Geocode<?php endif; ?></td>
		<td><a href="<?php echo URL_EDIT ?>/<?php echo $store->id ?>/">edit</a></td>
		<td><a href="<?php echo URL_DELETE ?>/<?php echo $store->id ?>/" data-id="<?php echo $store->id ?>" class="delete_store">X</a></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>