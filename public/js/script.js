$(document).ready(function(){

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

$(".delete_store").click(function( event, all ){
	if ( !all ) {
		var answer = confirm( "Delete store #" + $(this).data("id") + "?" );
		if ( !answer ) {
			return false
		}
	}
	obj = $(this);
	$.post(
		url_delete + "/" + $(this).data("id"),
		{},
		function(data) {
			if ( data.status == 1 ) {
				obj.parent().parent().hide();
				if ( !all ) {
					alert( data.message );
				}
			}
			else {
				if ( !all ) {
					alert( data.message );
				}
			}
		},
		'json'
	);
	return false;
});

$(".geocode_form").click(function(){

	var obj = $(this);
	var form_data = {};

	$.get(
		url_geocode,
		$("#store_edit input:text").serializeObject(),
		function(data) {
			if ( data.status == 1 ) {
				$("#lat").val( data.lat );
				$("#lng").val( data.lng );
				if ( map.markers ) {
					map.markers[0].setPosition( new google.maps.LatLng( data.lat, data.lng ) );
					map.map.setCenter( new google.maps.LatLng( data.lat, data.lng ) );
					map.map.setZoom( 14 );
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

$(".geocode_table").click(function( event, all ){

	var obj = $(this);
	obj.html('<img src="' + $("#store_table").data('ajax-loader-image') + '">');
	var data = $(this).parent().parent().data('geocode') + '&save_store=1';
	$.get(
		url_geocode + data,
		{},
		function(data) {
			if ( data.status == 1 ) {
				obj.parent().html("Yes");
				obj.remove();
				if ( !all ) {
					alert( data.message );
				}
			}
			else {
				obj.html("No");
				if ( !all ) {
					alert( data.message );
				}
			}
		},
		'json'
	);
	return false;
});

$("#geocode_all").click(function(){
	$(".geocode_table").trigger('click', [true]);
	return false;
});


});