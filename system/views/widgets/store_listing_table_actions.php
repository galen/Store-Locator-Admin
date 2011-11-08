<div class="table_actions well">
	<p>Table Actions</p>
	<a href="<?php e( URL_MAP ) ?>/<?php e( $registry->search_query ) ?>" class="btn">View Map</a>
	<a href="<?php e( URL_EXPORT ) ?>/<?php e( $registry->search_query ) ?>" data-export-url="<?php e( URL_EXPORT ) ?>/<?php e( $registry->search_query ) ?>" class="btn export" title="Export to CSV">Export</a>
	<?php if( $registry->all_stores_geocoded != true ): ?><a href="#"></a></a><a href="#" class="btn success geocode_all" title="<?php if( $registry->all_stores_geocoded ): ?>All stores are geocoded<?php else: ?>Geocode all stores on the page<?php endif; ?>">Geocode all stores</a><?php endif; ?>
</div>