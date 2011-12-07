<script type="text/javascript">

var map;
function phpgooglemap_map() {

this.initialize = function() {

	var self = this;
	this.map_options = {
		zoom: <?php if( isset( $store ) && $store->isGeocoded() ): ?>14<?php else: ?><?php e( $config['map_default_properties']['zoom'] ) ?><?php endif; ?>,
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

	this.map = new google.maps.Map(document.getElementById("map"), this.map_options);
	this.info_window = new google.maps.InfoWindow();

	<?php if( isset( $store ) && $store->isGeocoded() ): ?>
	this.markers = [];
	this.markers[0] = new google.maps.Marker({
		position: new google.maps.LatLng(<?php e( $store->getLat() ) ?>,<?php e( $store->getLng() ) ?>),
		map: this.map,
		draggable:true,
		content: '<div class="infowindow"><address><strong><?php e( $store->getName() ) ?></strong><br><?php e( $store->getAddress() ) ?><br><?php e( $store->getCity() ) ?><?php if( $store->hasState() ): ?>, <?php e( $store->getState() ) ?><?php endif; ?></address></div>'

	});
	<?php endif; ?>
	<?php if( isset( $store ) && $store->isGeocoded() ): ?>
	this.map.setCenter( new google.maps.LatLng( <?php e( $store->getLat() ) ?>,<?php e( $store->getLng() ) ?> ) );
	<?php else:?>
	this.map.setCenter( new google.maps.LatLng( <?php e( $config['map_default_properties']['lat'] ) ?>,<?php e( $config['map_default_properties']['lng'] ) ?> ) );
	<?php endif; ?>
	<?php if( isset( $store ) && $store->isGeocoded() ): ?>
	this.event_listeners = [];
	this.event_listeners[0] = google.maps.event.addListener(map.markers[0], 'dragend', function(){ $("#lat").val(Math.round(map.markers[0].getPosition().lat()*1000000)/1000000);$("#lng").val(Math.round(map.markers[0].getPosition().lng()*1000000)/1000000); });
	<?php endif; ?>
	this.streetview = new google.maps.StreetViewPanorama(document.getElementById("map"), {
		visible:false,
		enableCloseButton:true,
		pov:{"heading":90,"zoom":1,"pitch":0}
	});
	this.map.setStreetView(this.streetview);
	google.maps.event.addListener(this.markers[0], 'click', function() { self.info_window.setContent(self.markers[0].content);self.info_window.open(self.map,self.markers[0]); });
};

}
function initialize_map() {
	map = new phpgooglemap_map();
	map.initialize();
}

google.maps.event.addDomListener(window, "load", initialize_map );

</script>