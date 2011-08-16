$(document).ready(function(){


$(".delete_store").click(function(){
	var answer = confirm( "Delete store #" + $(this).data("id") + "?" );
	if ( !answer ) {
		return false
	}
	obj = $(this);
	$.post(
		"/admin/system/actions/delete.php",
		{ id: $(this).data("id") },
		function(data) {
			if ( data.status == 1 ) {
				alert( data.message );
				obj.parent().parent().fadeOut();
			}
			else {
				alert( data.message );
			}
		},
		'json'
	);
	return false;
});

$(".geocode").click(function(){

	obj = $(this);
	$.get(
		"/admin/system/ajax/geocode.php",
		{ address: $("#address1").val() + " " + $("#city").val() + " " + $("#country").val() },
		function(data) {
			if ( data.status == 1 ) {
				$("#lat").val( data.lat );
				$("#lng").val( data.lng );
				if ( map.markers ) {
					map.markers[0].setPosition( new google.maps.LatLng( data.lat, data.lng ) );
				}
				else {
					var marker = new google.maps.Marker({
						position:  new google.maps.LatLng( data.lat, data.lng ), 
						map: map.map
					});
					map.map.setCenter( new google.maps.LatLng( data.lat, data.lng ) );
					map.map.setZoom( 14 );
				}
				alert( data.message );
			}
			else {
				alert( data.message );
			}
		},
		'json'
	);
	return false;
});

});