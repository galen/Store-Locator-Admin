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
	var answer = confirm( "Delete store #" + $(this).data("id") + "?" );
	if ( !answer ) {
		return false
	}
	obj = $(this);
	$.post(
		url_api_delete + "/" + $(this).data("id"),
		{},
		function(data) {
			if ( data.status == 1 ) {
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

$(".geocode_form").click(function(){
	$("#geocode_ajax_loader").show();
	var obj = $(this);
	var form_data = {};
	$.get(
		url_api_geocode,
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
				$("#geocode_ajax_loader").hide();
				$("#geocode_status").html( data.message ).show().delay(3000).fadeOut();
			}
			else {
				alert( data.message );
				$("#geocode_ajax_loader").hide();
			}
		},
		'json'
	);
	return false;
});

$(".geocode_table").click(function( event, all ){

	var obj = $(this);
	obj.html('<img src="' + $("#store_table").data('ajax-loader-image') + '">');
	var data = $(this).parent().parent().data('geocode');
	var store_id = $(this).parent().parent().data('store-id');
	$.ajax({
		type: 'GET',
		url: url_api_geocode + data,
		complete: function( jqxhr ) {
			data = jQuery.parseJSON( jqxhr.responseText );
			console.log(data);
			if ( jqxhr.status == 200 ) {
				$.ajax({
					type: 'POST',
					data: column_map.id + "=" + store_id + "&" + column_map.lat + "=" + data.lat + "&" + column_map.lng + "=" + data.lng,
					url: url_api_edit + '/' + store_id,
					complete: function( jqxhr ) {
						data = jQuery.parseJSON( jqxhr.responseText );
						if ( jqxhr.status == 200 ) {
							obj.parent().html("Yes");
							obj.remove();
						}
						else {
							obj.html("No");
							if ( !all ) {
								alert( data.message );
							}
						}
					},
				});
			}
			else {
				obj.html("No");
				if ( !all ) {
					alert( data.message );
				}
			}
		},
	});
	return false;
});

// status messagestuff
$(".alert-message:not(.block-message) .close").show();
$(".alert-message .close").click(function(){
	$(this).parent().fadeOut();
	return false;
});
if ( $(".autoremove_statuses").length ) {
	$(".alert-message:not(.remain)").delay($("body").data("autoremove-statuses-time")).fadeOut();
}

// Geocode stuff
$(".geocode_all").click(function(){
	$(".geocode_table").trigger('click', [true]);
	return false;
});

// Search stuff
$(".show_search_form").click(function(){
	$("#search_modal").show();
	return false;
});
$("#search_modal .close").click(function(){
	$("#search_modal").hide();
	return false;
});
if ( $(".no_results").length == 0 && $(".show_search_modal").length == 0 ) {
	$("#search_modal").hide();
}

// Pagination stuff
$(".pagination .disabled a").click(function(){
	return false;
});

// Create store page
if ( $("body#create").length ) {
	$("#create #geocode_form_button").show();
}



});