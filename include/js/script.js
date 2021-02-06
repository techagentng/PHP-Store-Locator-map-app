"use strict";
var map;
var markers = [];
var markersIds = [];
var infoWindow;
var panorama;
var img_loading = '<img src="./include/graph/icons/ajax-loader.gif">';

$(document).ready(function() {
	init_locations();
	$('#address').focus();
})

//Detect User's Location
function detectLocation() {
	var location_timeout = setTimeout("init_locations2()", 2000);
	if (navigator.geolocation) {
  		navigator.geolocation.getCurrentPosition(
	  		function(position) {
		  		clearTimeout(location_timeout);
				var lat = position.coords.latitude;
				var lng = position.coords.longitude;
				Store_locator.current_lat = lat;
				Store_locator.current_lng = lng;
				Store_locator.lat = lat;
				Store_locator.lng = lng;
				init_locations2();
			}
			, function(error) {
				clearTimeout(location_timeout);
				init_locations2();
			},
			{maximumAge:Infinity}
		);
	}
	else {
		init_locations2();
	}
}

function strpos(haystack, needle, offset) {
    var i = (haystack + '').indexOf(needle, (offset || 0));
    return i === -1 ? false : i;
}

//Execute First on Page Load
function init_locations() {
	var lat='';
	var lng='';
	
	if ( $("#category_id").length > 0 ) Store_locator.category_id = $('#category_id').val();
	if ( $("#max_distance").length > 0 ) Store_locator.max_distance = $('#max_distance').val();
	
	if ($("#address").length>0 && $("#address").val()!='') {
		var address = $('#address').val();
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( {'address': address}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
		  	var latLng = String(results[0].geometry.location);
		  	latLng = latLng.substr(1);
		  	var pos = strpos(latLng, ',');
		  	lat = latLng.substr(0,pos);
		  	var pos2 = strpos(latLng, ')');
		  	latLng = latLng.substr(0,pos2);
		  	lng = latLng.substr((pos+2));
		  	//alert(results[0].geometry.location);
			Store_locator.lat = lat;
			Store_locator.lng = lng;
		  	init_locations2();
		  }
		});
	}
	else {
		if(Store_locator.autodetect_location=='1') detectLocation();
		else init_locations2();
	}
}

//Execute Second on Locator Load
function init_locations2() {
	init_map();
	display_locations();
	display_locations_list();
}

function init_map() {
	map = new google.maps.Map(document.getElementById("sl_map"), {
		zoom: 4,
		mapTypeId: 'roadmap',
		scrollwheel: false,
		mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
	});
	
	infoWindow = new google.maps.InfoWindow();
}

function init_location(lat,lng,zoom) {
	if(lat===undefined) lat=40;
	if(lng===undefined) lng=-100;
	if(zoom===undefined) zoom=4;
	
	map = new google.maps.Map(document.getElementById("sl_map"), {
		center: new google.maps.LatLng(lat, lng),
		zoom: zoom,
		mapTypeId: 'roadmap',
		//scrollwheel: false,
		mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
	});
}

function setStreetView(latlng) {
    panorama = map.getStreetView();
    panorama.setPosition(latlng);
    panorama.setPov({
      heading: 265,
      zoom:1,
      pitch:0}
    );
}

jQuery(document).on('click', "#displayStreetViewBtn", function(event) {
	event.preventDefault();
	panorama.setVisible(true);
});

jQuery(document).on('click', "#store_locator_next", function(event) {
	event.preventDefault();
	$('#sl_pagination_loading').html(img_loading);
	Store_locator.page_number = (Store_locator.page_number+1);
	display_locations_list();
	
	if(Store_locator.map_all_stores!=1) {
		display_locations();
		clearLocations();
	}
});

jQuery(document).on('click', "#store_locator_previous", function(event) {
	event.preventDefault();
	$('#sl_pagination_loading').html(img_loading);
	Store_locator.page_number = (Store_locator.page_number-1);
	display_locations_list();
	
	if(Store_locator.map_all_stores!=1) {
		display_locations();
		clearLocations();
	}
});

function clearLocations() {
	for (var i = 0; i < markersIds.length; i++) {
		if(markersIds[i]>0) markers[markersIds[i]].setMap(null);
	}
	markersIds = [];
}

function set_current_location_marker() {
	if(Store_locator.current_lat!='' && Store_locator.current_lng!='') {
		var latlng = new google.maps.LatLng(
			parseFloat(Store_locator.current_lat),
			parseFloat(Store_locator.current_lng)
		);
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'latLng': latlng}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
		    if (results[1]) {
		    	var address = results[0].formatted_address;
		    	
		    	var marker_text = '<b>Current location</b><br/>'+address;
		    	if(Store_locator.streetview_display==1) marker_text += '<br/><a href="#" id="displayStreetViewBtn">Street View</a>';
		    	createMarker({"latlng":latlng, "lat":Store_locator.current_lat, "lng":Store_locator.current_lng, "html":marker_text, "icon":Store_locator.marker_icon_current});
		    	$('#sl_current_location').html('<div class="store_locator_current_location"><b>Your current location:</b> '+address+'</div>');
		    } 
		    else {
		    	//alert("No results found");
		    }
		  } 
		  else {
		    //alert("Geocoder failed due to: " + status);
		  }
		});
	}	
}

jQuery(document).on('click', ".sidebar_entry_btn", function(event) {
	event.preventDefault();
	var id = $(this).attr('data-id');
	var lat = $(this).attr('data-lat');
	var lng = $(this).attr('data-lng');
	var latlng = new google.maps.LatLng(
		parseFloat(lat),
		parseFloat(lng)
	);
	var bounds = new google.maps.LatLngBounds();
	bounds.extend(latlng);
	map.setCenter(bounds.getCenter());
	map.setZoom(15);
	google.maps.event.trigger(markers[id], 'click');
});

function display_locations_list() {
	$.ajax({
	  type: 'GET',
	  url: './views/display_stores_list.php?criteria='+JSON.stringify(Store_locator),
	  dataType: 'json',
	  success: function(msg) {
	  	$('#sl_pagination_loading').html('');
	  	$('#sl_sidebar').html(msg.sidebar);
	  	$('#sl_pagination').html(msg.pagination);
	  	if(msg.nb_stores==0) $('#sl_sidebar').hide();
	  	else $('#sl_sidebar').show();
	  }
	});
}

function display_locations() {
	$.ajax({
	  type: 'GET',
	  url: './views/display_stores.php?criteria='+JSON.stringify(Store_locator),
	  dataType: 'json',
	  success: function(msg) {
	  	
	  	var locations = msg.locations;
	  	var markersContent = msg.markersContent;
		var bounds = new google.maps.LatLngBounds();
		
		//Current location
		set_current_location_marker();
		
       	for (var i = 0; i < locations.length; i++) {
			var name = locations[i]['name'];
			var address = locations[i]['address'];
			var distance = parseFloat(locations[i]['distance']);
			var latlng = new google.maps.LatLng(
				parseFloat(locations[i]['lat']),
				parseFloat(locations[i]['lng'])
			);
			
			createMarker({"latlng":latlng, "lat":locations[i]['lat'], "lng":locations[i]['lng'], "html":markersContent[i], "id":locations[i]['id'], "icon":locations[i]['marker_icon']});
			bounds.extend(latlng);
       	}
       	
       	if(locations.length>1) {
       		map.fitBounds(bounds);
       	}
       	else {
			map.setCenter(bounds.getCenter());
			map.setZoom(15);
       	}
	  }
	});
}

function createMarker(obj) {
	var latlng = obj.latlng;
	var lat = obj.lat;
	var lng = obj.lng;
	var html = obj.html;
	var icon = obj.icon;
	var display_flag = obj.display_flag;
	var animation = obj.animation;
	var id = obj.id;
	
	if(latlng==undefined) latlng = '';
	if(lat==undefined) lat = '';
	if(lng==undefined) lng = '';
	if(html==undefined) html = '';
	if(icon==undefined) icon = '';
	if(display_flag==undefined) display_flag = '';
	if(animation==undefined) animation = '';
	if(id==undefined) id = '';
	
	//Default
	if(icon=='') icon = Store_locator.marker_icon;
	
	var marker = new google.maps.Marker({
		map: map,
		position: latlng,
		icon: icon,
		animation: google.maps.Animation.DROP
	});
		
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(html);
		infoWindow.open(map, marker);
		if(Store_locator.streetview_display==1) setStreetView(latlng);
	});
	
	if(display_flag==1) {
		infoWindow.setContent(html);
		infoWindow.open(map, marker);
	}
	
	markers[id] = marker;
	markersIds.push(id);
}

/*
function displayStreetView(lat,lng, dom) {
	var latlng = new google.maps.LatLng(lat,lng);
	
	var panoramaOptions = {
	  position: latlng,
	  pov: {
	    heading: 270,
	    pitch: 0,
	    zoom: 1
	  }
	};
	panorama = new google.maps.StreetViewPanorama(document.getElementById(dom),panoramaOptions);
	map.setStreetView(panorama);
}
*/

/*
function resizeMap(width,height) {
	$('#map').animate({width: width, height:height}, 
	function() { 
		google.maps.event.trigger(map, 'resize');
		map.setCenter(map.getCenter());
	});
}

function streetView(lat,lng) {
	var dom = 'streetview';
	panorama = new google.maps.StreetViewPanorama(document.getElementById(dom));
	displayStreetViewBtn(lat,lng, dom);
	if($('#map').height()==600) {
		resizeMap(850,300);
		$('#streetview').height(300);
	}
}
*/