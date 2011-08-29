<!DOCTYPE html>
<html>
<head>
	<title>Store Admin<?php if( isset( $vars['page_title'] ) ): ?> - <?php echo ucwords( $vars['page_title'] ) ?><?php endif; ?></title>
	<?php if( isset( $map ) ): ?>
		<?php $map->printHeaderJS() ?>
		<?php $map->printMapJS() ?>
	<?php endif; ?>
	<script type="text/javascript">
	url_delete = "<?php echo URL_DELETE ?>";
	url_geocode = "<?php echo URL_GEOCODE ?>";
	</script>
	<script type="text/javascript" src="<?php echo URL_PUBLIC ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo URL_PUBLIC ?>/js/script.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo URL_PUBLIC ?>/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo URL_PUBLIC ?>/css/style.css">
</head>
<body id="<?php if( isset( $vars['controller'] ) ): ?><?php e( $vars['controller'] ) ?><?php endif; ?>" class="<?php echo get_body_classes( $config ) ?>"<?php echo get_body_data( $config ) ?>>

<div id="wrapper">