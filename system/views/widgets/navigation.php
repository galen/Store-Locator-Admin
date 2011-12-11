<div class="topbar-wrapper" style="z-index: 5;">
	<div class="topbar">
		<div class="fill">
			<div class="container">
				<h3 id="page_title"><a href="<?php echo URL_ROOT ?>" style="background-image:url(<?php e( URL_PUBLIC ) ?>/images/logo.png);"><?php e( $config['app_title'] ) ?></a></h3>
				<ul>
					<li<?php if( $registry->controller == 'list' ): ?> class="active"<?php endif; ?>><a href="<?php echo URL_ROOT ?>/list/">List</a></li>
					<li<?php if( $registry->controller == 'search' ): ?> class="active"<?php endif; ?>><a href="<?php echo URL_ROOT ?>/search/">Search</a></li>
					<li<?php if( $registry->controller == 'create' ): ?> class="active"<?php endif; ?>><a href="<?php echo URL_ROOT ?>/create/?c=<?php echo URL_ROOT . '/' . REQUEST ?>">Create</a></li>
					<li<?php if( $registry->controller == 'tools' ): ?> class="active"<?php endif; ?>><a href="<?php echo URL_ROOT ?>/tools/">Tools</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>