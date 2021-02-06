<?php
include('../../include/webzone.php');

if($GLOBALS['demo_mode']==1) {
	echo 'Action not allowed in Demo mode'; exit();
}

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
	$sql = 'INSERT INTO '.$GLOBALS['db_table_name'].' (category_id, name, address, logo, url, description, tel, email, lat, lng, created) 
	VALUES ("'.$s1->escape($category_id).'", "'.$s1->escape($name).'", "'.$s1->escape($address).'", "'.$s1->escape($logo).'",
	"'.$s1->escape($url).'", "'.$s1->escape($description).'", "'.$s1->escape($tel).'", "'.$s1->escape($email).'", 
	"'.$s1->escape($lat).'", "'.$s1->escape($lng).'", "'.date('Y-m-d H:i:s').'")';
	$s1->executeQuery($sql);	
}

?>