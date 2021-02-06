<?php
include('../../include/webzone.php');

if($GLOBALS['demo_mode']==1) {
	echo 'Action not allowed in Demo mode'; exit();
}

$name = $_POST['name'];
$marker_icon = $_POST['marker_icon'];

$s1 = new MySqlTable();
$sql = 'INSERT INTO '.$GLOBALS['db_table_name_category'].' (name, marker_icon) 
VALUES ("'.$s1->escape($name).'", "'.$s1->escape($marker_icon).'")';
$s1->executeQuery($sql);

?>