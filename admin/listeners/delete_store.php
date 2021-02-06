<?php
include('../../include/webzone.php');

if($GLOBALS['demo_mode']==1) {
	echo 'Action not allowed in Demo mode'; exit();
}

$store_id = $_POST['id'];

$s1 = new MySqlTable();
$sql = 'DELETE FROM '.$GLOBALS['db_table_name'].' WHERE id="'.$s1->escape($store_id).'"';
$s1->executeQuery($sql);

?>