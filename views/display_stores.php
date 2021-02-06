<?php
include_once('../include/webzone.php');

$criteria = stripslashes($_GET['criteria']);
$criteria = json_decode($criteria, true);

$lat = $criteria['lat'];
$lng = $criteria['lng'];
$category_id = $criteria['category_id'];
$page_number = $criteria['page_number'];
$nb_display = $criteria['nb_display'];
$max_distance = $criteria['max_distance'];
$display_type = $criteria['display_type'];

$distance_unit = $GLOBALS['distance_unit'];

if($GLOBALS['map_all_stores']==1) {
	$page_number = '';
	$nb_display = '';
}

$locations = get_stores_list(array('lat'=>$lat, 'lng'=>$lng, 'category_id'=>$category_id, 'page_number'=>$page_number, 'nb_display'=>$nb_display, 'max_distance'=>$max_distance, 'distance_unit'=>$distance_unit));

$data['locations'] = $locations;
$data['markersContent'] = displayMarkersContent($locations);

$data = json_encode($data);
echo $data;

?>