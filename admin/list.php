<?php
include('./include/webzone.php');
include('./include/presentation/header.php');

$category_id = $_GET['category_id'];

//prepare categories for select list
$list = get_categories_list(array('order'=>'id DESC'));
for($i=0; $i<count($list); $i++) {
	$list_tab[$list[$i]['id']] = $list[$i]['name'];
}

$s1 = new MySqlTable();
$sql = 'SELECT s.*, c.name category_name 
FROM '.$GLOBALS['db_table_name'].' s
LEFT JOIN '.$GLOBALS['db_table_name_category'].' c
on s.category_id=c.id
WHERE 1';
if($category_id!='') $sql .= ' AND s.category_id="'.$s1->escape($category_id).'"';
$sql .= ' ORDER BY s.id DESC';
$list = $s1->customQuery($sql);

//categories filter
if(count($list_tab)>0) {
	echo '<form name="form" method="get" class="form-inline">';
		echo '<p style="text-align:right;">';
		echo 'Filter by category: ';
		echo '<select name="category_id" onchange="form.submit();" class="form-control" style="width:200px;">';
		echo '<option value=""></option>';
		foreach($list_tab as $ind=>$value) {
			if($ind==$category_id) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
			else echo '<option value="'.$ind.'">'.$value.'</option>';
		}
		echo '</select></p>';
	echo '</form>';
}

for($i=0; $i<count($list); $i++) {
	$lat = $list[$i]['lat'];
	$lng = $list[$i]['lng'];
	$address = $list[$i]['address'];
	$category_name = $list[$i]['category_name'];
	
	echo '<div>';
	echo '<b>'.$list[$i]['name'].'</b>';
	if($category_name!='') echo ' (<font color="#b71414">'.$category_name.'</font>)';
	if($address!='') echo '<br>Address: '.$address.' <font color="blue">(Lat: '.$lat.', Lng: '.$lng.')</font>';
	echo '<p style="float:right;">';
	echo '<a href="./edit.php?id='.$list[$i]['id'].'">Edit</a> - ';
	echo '<a href="#" class="delete_store_btn" id="'.$list[$i]['id'].'">Delete</a></p>';
	echo '</div>';
	echo '<hr>';
}

if(count($list)==0) echo 'No stores have been found.';

include('./include/presentation/footer.php');
?>