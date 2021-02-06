<?php

function get_stores_list2($criteria=array()) {
	$id = $criteria['id'];
	$lat = $criteria['lat'];
	$lng = $criteria['lng'];
	$page_number = $criteria['page_number'];
	$nb_display = $criteria['nb_display'];
	$distance_unit = $criteria['distance_unit'];
	$max_distance = $criteria['max_distance'];
	$category_id = $criteria['category_id'];
	
	$table_name = $GLOBALS['db_table_name'];
	$start = ($page_number*$nb_display)-$nb_display;
	
	$s1 = new MySqlTable();
	
	if($distance_unit=='miles') $distance_unit='3959'; //miles
	else $distance_unit='6371'; //km
	
	$sql = "SELECT *, 
	( $distance_unit * acos( cos( radians('".$s1->escape($lat)."') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('".$s1->escape($lng)."') ) + sin( radians('".$s1->escape($lat)."') ) * sin( radians( lat ) ) ) ) AS distance 
	FROM ".$table_name." 
	WHERE 1";
	
	if($id!='') $sql .= " AND id='".$s1->escape($id)."'";
	if($category_id!='') $sql .= " AND category_id='".$s1->escape($category_id)."'";
	if($max_distance!='') $sql .= " HAVING distance<='".$s1->escape($max_distance)."'";
	
	if($lat!='' && $lng!='') $sql .= " ORDER BY distance";
	else $sql .= " ORDER BY name";
	
	if($nb_display>0) $sql .= " LIMIT $start, $nb_display";
	
	//echo $sql.'<br>';
	
	$locations = $s1->customQuery($sql);
	
	return $sql;
}


function get_stores_list($criteria=array()) {
	$id = $criteria['id'];
	$lat = $criteria['lat'];
	$lng = $criteria['lng'];
	$page_number = $criteria['page_number'];
	$nb_display = $criteria['nb_display'];
	$distance_unit = $criteria['distance_unit'];
	$max_distance = $criteria['max_distance'];
	$category_id = $criteria['category_id'];
	
	$table_name = $GLOBALS['db_table_name'];
	$start = ($page_number*$nb_display)-$nb_display;
	
	$s1 = new MySqlTable();
	
	if($distance_unit=='miles') $distance_unit='3959'; //miles
	else $distance_unit='6371'; //km
	
	$sql = "SELECT s.*, 
	( $distance_unit * acos( cos( radians('".$s1->escape($lat)."') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('".$s1->escape($lng)."') ) + sin( radians('".$s1->escape($lat)."') ) * sin( radians( lat ) ) ) ) AS distance,
	c.marker_icon
	FROM ".$table_name." s LEFT JOIN {$GLOBALS['db_table_name_category']} c ON s.category_id=c.id
	WHERE 1";
	
	if($id!='') $sql .= " AND s.id='".$s1->escape($id)."'";
	if($category_id!='') $sql .= " AND s.category_id='".$s1->escape($category_id)."'";
	if($max_distance!='') $sql .= " HAVING distance<='".$s1->escape($max_distance)."'";
	
	if($lat!='' && $lng!='') $sql .= " ORDER BY distance";
	else $sql .= " ORDER BY s.name";
	
	if($nb_display>0) $sql .= " LIMIT $start, $nb_display";
	
	//echo $sql.'<br>';
	
	$locations = $s1->customQuery($sql);
	
	return $locations;
}

function get_store($id) {
	$table_name = $GLOBALS['db_table_name'];
	$s1 = new MySqlTable();
	$sql = "SELECT s.*, c.name category_name FROM ".$table_name." s 
	LEFT JOIN ".$GLOBALS['db_table_name_category']." c
	ON s.category_id=c.id
	WHERE s.id='".$s1->escape($id)."'";
	$store = $s1->customQuery($sql);
	if($store[0]['category_name']==null) $store[0]['category_name']='';
	return $store;
}

function get_categories_list($criteria=array()) {
	$id = $criteria['id'];
	$order = $criteria['order'];
	
	$m1 = new MySqlTable();
	$sql = 'SELECT * FROM '.$GLOBALS['db_table_name_category'].' WHERE 1';
	if($id!='') $sql .= " AND id='".$m1->escape($id)."'";
	
	if($order!='') $sql .= ' ORDER BY '.$m1->escape($order);
	
	$result = $m1->customQuery($sql);
	return $result;
}

?>