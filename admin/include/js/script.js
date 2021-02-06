jQuery(document).on('click', ".delete_category_btn", function(event) {
	event.preventDefault();
	var id = $(this).attr('id');
	if (confirm("Are you sure you want to delete this category?")) {
		$.ajax({
		  type: 'POST',
		  data: 'id='+id,
		  url: './listeners/delete_category.php',
		  success: function(msg) {
		  	if(msg!='') alert(msg);
		  	else {
			  	window.location.reload();
		  	}
		  }
		});
	}
});

jQuery(document).on('click', "#add_category_btn", function(event) {
	event.preventDefault();
	var name = $('#name').val();
	var marker_icon = $('#marker_icon').val();
	$.ajax({
	  type: 'POST',
	  data: 'name='+name+'&marker_icon='+marker_icon,
	  url: './listeners/add_category.php',
	  success: function(msg) {
	  	if(msg!='') alert(msg);
	  	else {
		  	window.location.reload();
	  	}
	  }
	});
});

jQuery(document).on('click', "#edit_category_btn", function(event) {
	event.preventDefault();
	var category_id = $('#category_id').val();
	var name = $('#name').val();
	var marker_icon = $('#marker_icon').val();
	$.ajax({
	  type: 'POST',
	  data: 'category_id='+category_id+'&name='+name+'&marker_icon='+marker_icon,
	  url: './listeners/edit_category.php',
	  success: function(msg) {
	  	if(msg!='') alert(msg);
	  	else {
		  	window.location = './categories.php';
	  	}
	  }
	});
});

jQuery(document).on('click', "#add_store_btn", function(event) {
	event.preventDefault();
	var serialized_data = jQuery("#add_store_form").serialize();
	$.ajax({
	  type: 'POST',
	  data: serialized_data,
	  url: './listeners/add_store.php',
	  success: function(msg) {
	  	if(msg!='') alert(msg);
	  	else {
		  	window.location = './list.php';
	  	}
	  }
	});
});

jQuery(document).on('click', "#edit_store_btn", function(event) {
	event.preventDefault();
	var serialized_data = jQuery("#edit_store_form").serialize();
	$.ajax({
	  type: 'POST',
	  data: serialized_data,
	  url: './listeners/edit_store.php',
	  success: function(msg) {
	  	if(msg!='') alert(msg);
	  	else {
		  	window.location = './list.php';
	  	}
	  }
	});
});

jQuery(document).on('click', ".delete_store_btn", function(event) {
	event.preventDefault();
	var id = $(this).attr('id');
	if (confirm("Are you sure you want to delete this store?")) {
		$.ajax({
		  type: 'POST',
		  data: 'id='+id,
		  url: './listeners/delete_store.php',
		  success: function(msg) {
		  	if(msg!='') alert(msg);
		  	else {
			  	window.location.reload();
		  	}
		  }
		});
	}
});

jQuery(document).on('click', "#geocode_address_btn", function(event) {
	event.preventDefault();
	
	var address = $('#location2geocode').val();
	
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode( {'address': address}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
	  	//lat = results[0].geometry.location.Ha;
	  	//lng = results[0].geometry.location.Ia;
	  	
	  	var latLng = String(results[0].geometry.location);
	  	latLng = latLng.substr(1);
	  	var pos = strpos(latLng, ',');
	  	lat = latLng.substr(0,pos);
	  	var pos2 = strpos(latLng, ')');
	  	latLng = latLng.substr(0,pos2);
	  	lng = latLng.substr((pos+2));
	  	
	  	if(lat!=''&&lng!='') {
	  		var img = '<img src="http://maps.google.com/maps/api/staticmap?center='+lat+','+lng+'&zoom=15&size=300x200&markers=color:red|label:P|'+lat+','+lng+'&key='+Store_locator.googleAPIKey+'" style="margin-right:20px;"><a href="#" id="edit_address_btn">Edit address</a>';
	  		$('#address_thumbnail').html(img);
	  		$('#address').val(address);
	  		//$('#address').attr('disabled', 'disabled');
			$('#geocode_section').hide();
			$('#form_section').show();
			$('#lat').val(lat);
			$('#lng').val(lng);
	  	}
	  }
	  else {
	  		alert('Please enter a valid address');
	  }
	});
});

jQuery(document).on('click', "#edit_address_btn", function(event) {
	event.preventDefault();
	$('#form_section').hide();
	$('#geocode_section').show();
	$('#address_thumbnail').html('');
	$('#location2geocode').val($('#address').val());
});

function load_thumbnail_map(lat, lng) {
	var img = '<img src="http://maps.google.com/maps/api/staticmap?center='+lat+','+lng+'&zoom=15&size=300x200&markers=color:red|label:P|'+lat+','+lng+'&key='+Store_locator.googleAPIKey+'" style="margin-right:20px;"><a href="#" id="edit_address_btn">Edit address</a>';
	$('#address_thumbnail').html(img);
}

function strpos(haystack, needle, offset) {
    var i = (haystack + '').indexOf(needle, (offset || 0));
    return i === -1 ? false : i;
}