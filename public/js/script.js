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

$(".delete_all").click(function(){
	var answer = confirm( "This will delete all store on this page. Are you sure?" );
	if ( !answer ) {
		return false
	}
	$(".delete_store").each(function(){
		$(this).trigger( 'click', [true] );
	});
})

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
				obj.parent().parent().fadeOut();
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
	$("#geocode_ajax_loader").show();
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
	var data = $(this).parent().parent().data('geocode') + '&save_store=1';
	$.get(
		url_geocode + data,
		{},
		function(data) {
			if ( data.status == 1 ) {
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
		'json'
	);
	return false;
});

$(".alert-message .close").show();

$(".geocode_all").click(function(){
	$(".geocode_table").trigger('click', [true]);
	return false;
});

$(".show_search_form").click(function(){
	$("#search_modal").show();
	return false;
});

$("#search_modal .close").click(function(){
	$("#search_modal").hide();
	return false;
});

$(".alert-message .close").click(function(){
	$(this).parent().fadeOut();
	return false;
});

$(".pagination .disabled a").click(function(){
	return false;
});

if ( $(".no_results").length == 0 && $(".show_search_modal").length == 0 ) {
	$("#search_modal").hide();
}

if ( $(".autoremove_statuses").length ) {
	$(".alert-message:not(.remain)").delay($("body").data("autoremove-statuses-time")).fadeOut();
}

// Create store page
if ( $("body#create").length ) {
	$("#create #geocode_form_button").show();
}



});