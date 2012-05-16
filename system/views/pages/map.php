<?php require( DIR_VIEWS . '/header.php' ) ?>

<script type="text/javascript">

var map;
function phpgooglemap_map() {

this.initialize = function() {

	var self = this;
	this.map_options = {
		navigationControl: true,
		mapTypeControl: true,
		scaleControl: false,
		navigationControlOptions: {
		},
		mapTypeControlOptions: {
		},
		scaleControlOptions: {
		},
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	this.map = new google.maps.Map(document.getElementById("fullmap"), this.map_options);
	this.info_window = new google.maps.InfoWindow();
	this.markers = [];
	this.event_listeners = [];
	this.bounds = new google.maps.LatLngBounds();
	<?php foreach( $registry->locations as $index => $location ): ?>
	this.markers[<?php echo $index ?>] = new google.maps.Marker({
		position: new google.maps.LatLng(<?php e( $location->getLat() ) ?>,<?php e( $location->getLng() ) ?>),
		map: this.map,
		content: '<div class="infowindow"><address><strong><?php e( $location->getName() ) ?></strong><br><?php e( $location->getAddress() ) ?><br><?php e( $location->getCity() ) ?><?php if( $location->hasState() ): ?>, <?php e( $location->getState() ) ?><br><a href="<?php e( URL_EDIT ) ?>/<?php e( $location->getId() ) ?>/">Edit this location</a><?php endif; ?></address></div>'
	});
	this.bounds.extend(this.markers[<?php echo $index ?>].position);
	this.map.fitBounds(this.bounds);
	google.maps.event.addListener(this.markers[<?php echo $index ?>], 'click', function() { self.info_window.setContent(self.markers[<?php echo $index ?>].content);self.info_window.open(self.map,self.markers[<?php echo $index ?>]); });
	<?php endforeach; ?>
	<?php if( $config['map_cluster_limit'] === null || count( $registry->locations ) > $config['map_cluster_limit'] ): ?>
	var markerCluster = new MarkerClusterer(self.map, self.markers, {"maxZoom":4,"gridSize":null});
	<?php endif; ?>
	
};

}
function initialize_map() {
	map = new phpgooglemap_map();
	map.initialize();
}

google.maps.event.addDomListener(window, "load", initialize_map );

</script>

<?php require( DIR_VIEWS . '/widgets/navigation.php' ) ?>

<h2>Map <span>Showing <?php e( count( $registry->locations ) ) ?> locations</span></h2>
<div id="fullmap" style="width:100%;height:500px;"><p id="map_msg"><a href="http://www.activatejavascript.org/">Enable javascript</a> to view the map</p></div>	

<?php require( DIR_VIEWS . '/footer.php' ) ?>