<?php
include('../../include/webzone.php');

if($GLOBALS['demo_mode']==1) {
	echo 'Action not allowed in Demo mode'; exit();
}

$category_id = $_POST['id'];

if($category_id!='') $stores = get_stores_list(array('category_id'=>$category_id));

if(count($stores)>0) {
	echo 'You cannot delete this category because it\'s still containing some stores';
}
else {
	$s1 = new MySqlTable();
	$sql = 'DELETE FROM '.$GLOBALS['db_table_name_category'].' WHERE id="'.$s1->escape($category_id).'"';
	$s1->executeQuery($sql);
}

?>