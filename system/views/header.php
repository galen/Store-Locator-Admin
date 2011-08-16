<!DOCTYPE html>
<html>
<head>
	<title>Store Admin</title>
	<?php if( $vars['action'] == 'edit' ): ?>
		<?php $map->printHeaderJS() ?>
		<?php $map->printMapJS() ?>
	<?php endif; ?>
	<script type="text/javascript" src="<?php echo URL_PUBLIC ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo URL_PUBLIC ?>/js/script.js"></script>
</head>
<h1>Admin</h1>
<body>