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

$stores = get_stores_list(array('lat'=>$lat, 'lng'=>$lng, 'page_number'=>$page_number, 'nb_display'=>$nb_display, 'category_id'=>$category_id, 'max_distance'=>$max_distance, 'distance_unit'=>$distance_unit));

$all_stores = get_stores_list(array('lat'=>$lat, 'lng'=>$lng, 'category_id'=>$category_id, 'max_distance'=>$max_distance, 'distance_unit'=>$distance_unit));
$nb_stores = count($all_stores);

$sql = get_stores_list2(array('lat'=>$lat, 'lng'=>$lng, 'category_id'=>$category_id, 'max_distance'=>$max_distance, 'distance_unit'=>$distance_unit));

$pagination = display_pagination(array('page_number'=>$page_number, 'nb_display'=>$nb_display, 'nb_stores'=>$nb_stores));

if($display_type=='') {
	$data['sidebar'] = get_sidebar_display_1(array('locations'=>$stores, 'lat'=>$lat, 'lng'=>$lng));
	$data['pagination'] = $pagination;
	$data['nb_stores'] = $nb_stores;
}
else if($display_type==2) {
	$data['sidebar'] = get_sidebar_display_2(array('locations'=>$stores, 'lat'=>$lat, 'lng'=>$lng));
	$data['pagination'] = $pagination;
	$data['nb_stores'] = $nb_stores;
}

$data = json_encode($data);
echo $data;

?>