<div class="table_actions well">
	<p>Table Actions</p>
	<a href="<?php echo URL_MAP ?>?ids=<?php echo implode( ',', $registry->store_ids ) ?>" class="btn">View Map</a>
	<a href="<?php echo URL_EXPORT ?>?<?php echo $_SERVER['QUERY_STRING'] ?>" data-export-url="<?php echo URL_EXPORT ?>?<?php echo $_SERVER['QUERY_STRING'] ?>" class="btn export" title="Export to CSV">Export</a>
	<a href="#"></a></a><a href="#" class="btn success geocode_all<?php if( $registry->all_stores_geocoded ): ?> disabled<?php endif; ?>" title="<?php if( $registry->all_stores_geocoded ): ?>All stores are geocoded<?php else: ?>Geocode all stores on the page<?php endif; ?>">Geocode all stores</a>
</div>