<table>
	<thead>
		<tr>
			<?php foreach( $vars['table_columns'] as $tc ): ?>
				<td><?php e( prettify_table_name( $tc ) ) ?></td>
			<?php endforeach; ?>
			<td>Location</td>
		</tr>
	</thead>
	<tbody>
	<?php foreach( $vars['locations'] as $location ): ?>
	<tr>
		<?php foreach( $vars['table_columns'] as $tc ): ?>
			<td><?php e( $location->$tc ) ?></td>
		<?php endforeach; ?>
		<td><?php if( $location->isGeocoded() ): ?>View Map<?php else: ?>Geocode<?php endif; ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>