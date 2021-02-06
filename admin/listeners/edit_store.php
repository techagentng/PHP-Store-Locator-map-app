<?php
include('../../include/webzone.php');

if($GLOBALS['demo_mode']==1) {
	echo 'Action not allowed in Demo mode'; exit();
}

$id = $_POST['id'];
$category_id = $_POST['category_id'];
$name = $_POST['name'];
$address = $_POST['address'];
$logo = $_POST['logo'];
$url = $_POST['url'];
$description = $_POST['description'];
$tel = $_POST['tel'];
$email = $_POST['email'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

if($name=='' || $address=='' || $lat=='' || $lng=='') {
	echo 'Name and address (including lat and lng) are required';
}
else {
	$s1 = new MySqlTable();
	$sql = 'UPDATE '.$GLOBALS['db_table_name'].' SET category_id="'.$s1->escape($category_id).'", 
	name="'.$s1->escape($name).'", address="'.$s1->escape($address).'", logo="'.$s1->escape($logo).'", 
	url="'.$s1->escape($url).'", description="'.$s1->escape($description).'", tel="'.$s1->escape($tel).'",
	email="'.$s1->escape($email).'", lat="'.$s1->escape($lat).'", lng="'.$s1->escape($lng).'"
	WHERE id="'.$s1->escape($id).'"';
	$s1->executeQuery($sql);	
}

?>