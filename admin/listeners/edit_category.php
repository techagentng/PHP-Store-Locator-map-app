<?php
include('../../include/webzone.php');

if($GLOBALS['demo_mode']==1) {
	echo 'Action not allowed in Demo mode'; exit();
}

$category_id = $_POST['category_id'];
$name = $_POST['name'];
$marker_icon = $_POST['marker_icon'];

if($category_id!='' && $name!='') {
	$s1 = new MySqlTable();
	$sql = 'UPDATE '.$GLOBALS['db_table_name_category'].' 
	SET name="'.$s1->escape($name).'", marker_icon="'.$s1->escape($marker_icon).'"
	WHERE id="'.$s1->escape($category_id).'"';
	$s1->executeQuery($sql);	
}

?>