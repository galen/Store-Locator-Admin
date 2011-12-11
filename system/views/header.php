<!DOCTYPE html>
<html>
<head>
	<title><?php e( $config['app_title'] ) ?><?php if( isset( $registry->page_title ) ): ?> - <?php e( ucwords( $registry->page_title ) ) ?><?php endif; ?></title>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&v=3&language=&region=&libraries="></script>
	<script type="text/javascript">
	url_api_delete = "<?php e( URL_API ) ?>/delete";
	url_api_geocode = "<?php e( URL_API ) ?>/geocode";
	url_api_edit = "<?php e( URL_API ) ?>/edit";
	column_map = <?php echo json_encode( $config['column_map'] )?>;
	geocode_required = ["<?php echo trim( implode( '","', preg_split( '~\}.*?\{~', $config['geocode_string'] ) ), '{}' ) ?>"];
	</script>
	<link rel="stylesheet" type="text/css" media="all" href="<?php e( URL_PUBLIC ) ?>/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" media="all" href="<?php e( URL_PUBLIC ) ?>/css/style.css">
	<script type="text/javascript" src="<?php e( URL_PUBLIC ) ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php e( URL_PUBLIC ) ?>/js/script.js"></script>
	<script type="text/javascript" src="<?php e( URL_PUBLIC ) ?>/js/marker_clusterer.js"></script>
</head>
<body id="<?php if( isset( $registry->controller ) ): ?><?php e( str_replace( '/', '_', $registry->controller ) ) ?><?php endif; ?>" class="<?php e( get_body_classes( $config ) ) ?>"<?php e( get_body_data( $config ) ) ?>>

<div id="wrapper">