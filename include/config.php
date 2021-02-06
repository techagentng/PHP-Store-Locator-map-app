<?php

//Get a key from this URL And here for ore info
//Make sure the Google Maps geocoding and static Maps are enabled from the "Enabled API" section
//https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend&keyType=CLIENT_SIDE&reusekey=true&pli=1
//https://developers.google.com/maps/documentation/javascript/get-api-key
$GLOBALS['google_api_key'] = '';

//database access
$GLOBALS['db_host'] = '';
$GLOBALS['db_name'] = '';
$GLOBALS['db_user'] = '';
$GLOBALS['db_password'] = '';

//Pagination - Number of stores to display per page
$GLOBALS['nb_display'] = 10;

//Define if all the stores are loaded on the Map or not - Possible values: 0 or 1
$GLOBALS['map_all_stores'] = 0;

//Distance unit. Possible values: miles, km
$GLOBALS['distance_unit'] = 'miles';

//Activate or no the categories filters. Possible values: 0 or 1
$GLOBALS['categories_filter'] = 1;

//Display or no the max distance select bow filter. Possible values: 0 or 1
$GLOBALS['max_distance_filter'] = 1;

//Custom icon to use as a marker - Leave empty to use the default Google Maps icon
$GLOBALS['marker_icon'] = '';

//Custom marker for the current user location
$GLOBALS['marker_icon_current'] = './include/graph/icons/marker-current.png';

//Autodetect user location or no. Possible values: 0 or 1
$GLOBALS['autodetect_location'] = 1;

//activate the streetview display or no. Possible values: 0 or 1.
$GLOBALS['streetview_display'] = 1;

//activate the get directions links in the markers infowindow. Possible values: 0 or 1.
$GLOBALS['get_directions_display'] = 1;

//Demo mode for the Admin
$GLOBALS['demo_mode'] = 0; //Possible values: 0 or 1

/*
System Variables
*/
//database table name
$GLOBALS['db_table_name'] = 'store_locator';
$GLOBALS['db_table_name_category'] = 'store_locator_category';

?>