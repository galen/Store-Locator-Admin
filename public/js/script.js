$(document).ready(function(){

if( $("th.editable").length ) {
	$("th.editable").each(function(){
		$(this).data("width", $(this).width() );
	});
}

// Turns a form into an object
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

$(".export").click(function( e ){
	answer = prompt( "Enter the filename", "export.csv" );
	if ( answer ) {
		e.preventDefault();
		window.location = $(this).data("export-url") + '&filename=' + answer
		return false;
	}
	return false;
});

$(".delete_location").click(function( event, all ){
	obj = $(this);
	tr = obj.closest('tr');
	var answer = confirm( "Delete location #" + tr.data("location-id") + "?" );
	if ( !answer ) {
		return false
	}
	$.ajax({
		type: 'POST',
		url: url_api_delete + "/" + tr.data("location-id"),
		complete: function( jqxhr ) {
			data = jQuery.parseJSON( jqxhr.responseText );
			if ( jqxhr.status == 200 ) {
				tr.fadeOut();
			}
			else {
				alert( data.message );
			}
		},
	});
	return false;
});

$("#geocode_ajax_status_wrapper a.close").click(function(){
	$("#geocode_ajax_status_wrapper").fadeOut();
	return false;
});

$(".geocode_form").click(function(){
	$("#geocode_ajax_status_wrapper").hide();
	for ( geocode_required_field in geocode_required ) {
		if ( $.trim( $( "#" + geocode_required[geocode_required_field] ).val() ) == '' ) {
			alert( geocode_required[geocode_required_field] + " is a required field for geocoding" );
			return false;
		}
	}
	$("#geocode_ajax_loader").show();
	var obj = $(this);
	var location_id = $('#location_id').val();
	$.ajax({
		type: 'GET',
		url: url_api_geocode,
		data: $("#location_edit input:text").serializeObject(),
		complete: function( jqxhr ) {
			geocode_data = jQuery.parseJSON( jqxhr.responseText );
			if ( jqxhr.status == 200 ) {
				$.ajax({
					type: 'POST',
					data: column_map.id + "=" + location_id + "&" + column_map.lat + "=" + geocode_data.lat + "&" + column_map.lng + "=" +geocode_data.lng,
					url: url_api_edit + '/' + location_id,
					complete: function( jqxhr ) {
						save_data = jQuery.parseJSON( jqxhr.responseText );
						if ( jqxhr.status == 200 ) {
							$("#lat").val( geocode_data.lat );
							$("#lng").val( geocode_data.lng );
							if ( map.markers ) {
								map.markers[0].setPosition( new google.maps.LatLng( geocode_data.lat, geocode_data.lng ) );
								map.map.setCenter( new google.maps.LatLng( geocode_data.lat, geocode_data.lng ) );
								map.map.setZoom( 14 );
							}
							else {
								var marker = new google.maps.Marker({
									position: new google.maps.LatLng( geocode_data.lat, geocode_data.lng ),
									map: map.map
								});
								map.map.setCenter( new google.maps.LatLng( geocode_data.lat, geocode_data.lng ) );
								map.map.setZoom( 14 );
							}
							$("#geocode_ajax_loader").hide();
							$("#geocode_ajax_status_text").html(save_data.message).parent().css({display:"inline"});
						}
						else {
							alert( save_data.message );
							$("#geocode_ajax_loader").hide();
						}
					},
				});
			}
			else {
				$("#geocode_ajax_loader").hide();
				alert( geocode_data.message );
			}
		},
	});
	return false;
});

$(".geocode_table").click(function( event, all ){
	var obj = $(this);
	tr = obj.closest('tr');
	obj.html('<img src="' + $("#location_table").data('ajax-loader-image') + '">');
	var data = tr.data('geocode');
	var location_id = tr.data('location-id');
	$.ajax({
		type: 'GET',
		url: url_api_geocode + data,
		complete: function( jqxhr ) {
			data = jQuery.parseJSON( jqxhr.responseText );
			if ( jqxhr.status == 200 ) {
				$.ajax({
					type: 'POST',
					data: column_map.id + "=" + location_id + "&" + column_map.lat + "=" + data.lat + "&" + column_map.lng + "=" + data.lng,
					url: url_api_edit + '/' + location_id,
					complete: function( jqxhr ) {
						data = jQuery.parseJSON( jqxhr.responseText );
						if ( jqxhr.status == 200 ) {
							obj.parent().html("Yes");
							obj.remove();
							if ( $('.geocode_table').length == 0 ) {
								$('.geocode_all').remove();
							}
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
					alert( data.message + ( data.details ? " (" + data.details + ")" : '' ) );
				}
			}
		},
	});
	return false;
});

// status message stuff
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
	if ( $(this).hasClass('disabled') ) {
		return false;
	}
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

if ( $("#location_table").length ) {
	$(".table_actions").show();
}

// Create locationpage
if ( $("body#create").length ) {
	$("#create #geocode_form_button").show();
}

$("#tools #geocode_all").click(function(){
	$("#geocode_ajax_loader").show();
});

$(".clear_search_field").click(function(){
	$(this).prev().val('').prev().val('');
	$(this).blur();
	return false;
});

$("input").live( "keyup", function( event ){
		td = $(this).parent();
		tr = td.parent();
		value = $(this).val();
		textbox = $(this);
		location_id = tr.data("location-id");
		old_content = td.data('content');
		if ( event.keyCode == 27 ) {
			$(this).remove();
			td.html(old_content);
			td.removeData();
		}
		if ( event.keyCode == 13 ) {
			if ( $(this).val() != td.data("content") ) {
				$.ajax({
					type: 'POST',
					data: column_map.id + "=" + location_id + "&" + td.data("column") + "=" + escape( value ),
					url: url_api_edit + '/' + location_id,
					complete: function( jqxhr ) {
						save_data = jQuery.parseJSON( jqxhr.responseText );
						if ( jqxhr.status == 200 ) {
							textbox.remove();
							td.html(value);
							td.removeData();
						}
						else {
							alert( save_data.message );
						}
					},
				});
			}
			else {
				textbox.remove();
				td.html(old_content);
				td.removeData();
			}
		}
});

$("td.editable").dblclick(function(){
	width = $( "#" + $(this).data("column") + "-th" ).data("width");
	if( !$(this).data('content') ) {
		$(this).data( 'content', $(this).html() ).html('');
		$(this).append('<input type="text" style="width:' + (width-20) + 'px" value="' + $(this).data( 'content' ) + '" class="quickedit_textbox">').children("input").focus().select();
	}
});



});