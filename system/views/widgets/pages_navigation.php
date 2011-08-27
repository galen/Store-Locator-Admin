<div class="pagination">
	<ul>
	<li class="prev<?php if( !$vars['prev_page'] ): ?> disabled<?php endif; ?>"><a href="<?php e( sprintf( '%s/%s/page/%s%s', URL_ROOT, $vars['controller'], $vars['prev_page'], $vars['controller'] == 'search' ? '?'.$_SERVER['QUERY_STRING'] : '' ) ) ?>">&larr; Previous</a></li>
	<?php foreach( $vars['page_array'] as $page ): ?>
	<li<?php if( $vars['page_number'] == $page ): ?> class="active"<?php endif; ?>><a href="<?php e( sprintf( '%s/%s/page/%s%s', URL_ROOT, $vars['controller'], $page, $vars['controller'] == 'search' ? '?'.$_SERVER['QUERY_STRING'] : ''  ) ) ?>"><?php echo $page ?></a></li>
	<?php endforeach; ?>
	<li class="next<?php if( !$vars['next_page'] ): ?> disabled<?php endif; ?>"><a href="<?php e( sprintf( '%s/%s/page/%s%s', URL_ROOT, $vars['controller'], $vars['next_page'], $vars['controller'] == 'search' ? '?'.$_SERVER['QUERY_STRING'] : ''  ) ) ?>">Next &rarr;</a></li>
	</ul>
</div>