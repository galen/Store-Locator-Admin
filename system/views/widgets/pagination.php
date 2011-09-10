<div class="pagination">
	<ul>
		<li class="prev<?php if( !$registry->prev_page ): ?> disabled<?php endif; ?>"><a href="<?php if( !$registry->prev_page ): ?>#<?php else: ?><?php e( sprintf( '%s/%s/page/%s%s', URL_ROOT, $registry->controller, $registry->prev_page, $registry->controller == 'search' ? '?'.$_SERVER['QUERY_STRING'] : '' ) ) ?><?php endif; ?>">&larr; Previous</a></li>
		<?php foreach( $registry->page_array as $page ): ?>
		<li<?php if( $registry->page_number == $page ): ?> class="active"<?php endif; ?>><a href="<?php e( sprintf( '%s/%s/page/%s%s', URL_ROOT, $registry->controller, $page, $registry->controller == 'search' ? '?'.$_SERVER['QUERY_STRING'] : ''  ) ) ?>" class="page"><?php echo $page ?></a></li>
		<?php endforeach; ?>
		<li class="next<?php if( !$registry->next_page ): ?> disabled<?php endif; ?>"><a href="<?php if( !$registry->next_page ): ?>#<?php else: ?><?php e( sprintf( '%s/%s/page/%s%s', URL_ROOT, $registry->controller, $registry->next_page, $registry->controller == 'search' ? '?'.$_SERVER['QUERY_STRING'] : ''  ) ) ?><?php endif; ?>">Next &rarr;</a></li>
	</ul>
</div>