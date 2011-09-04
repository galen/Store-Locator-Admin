<!DOCTYPE html>
<html>
<head>
	<title>Store Locator Admin<?php if( isset( $vars->page_title ) ): ?> - <?php echo ucwords( $vars->page_title ) ?><?php endif; ?></title>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&v=3&language=&region=&libraries="></script>
	<script type="text/javascript">
	url_api_delete = "<?php echo URL_API ?>/delete";
	url_api_geocode = "<?php echo URL_API ?>/geocode";
	url_api_edit = "<?php echo URL_API ?>/edit";
	column_map = <?php echo json_encode( $config['column_map'] ) ?>;
	geocode_required = ["<?php echo trim( implode( '","', preg_split( '~\}.*?\{~', $config['geocode_string'] ) ), '{}' ) ?>"];
	</script>
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo URL_PUBLIC ?>/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo URL_PUBLIC ?>/css/style.css">
	<script type="text/javascript" src="<?php echo URL_PUBLIC ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo URL_PUBLIC ?>/js/script.js"></script>
</head>
<body id="<?php if( isset( $vars->controller ) ): ?><?php e( str_replace( '/', '_', $vars->controller ) ) ?><?php endif; ?>" class="<?php echo get_body_classes( $config ) ?>"<?php echo get_body_data( $config ) ?>>

<div id="wrapper">