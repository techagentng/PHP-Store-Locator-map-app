<?php
include('./include/webzone.php');
include('./include/presentation/header.php');

echo '<form style="width:400px;">';
echo '<label>Category</label>';
echo '<p><input type="text" id="name" name="name" class="form-control"></p>';
echo '<label>Marker icon</label>';
echo '<p><input type="text" id="marker_icon" name="marker_icon" class="form-control"></p>';
echo '<p><input type="submit" id="add_category_btn" value="Add category" class="btn btn-primary"></p>';
echo '</form>';

//Get number of stores per category
$s1 = new MySqlTable();
$sql = 'SELECT category_id, count(*) nb FROM '.$GLOBALS['db_table_name'].' GROUP BY category_id';
$result = $s1->customQuery($sql);
for($i=0; $i<count($result); $i++) {
	$nb_stores_by_cat[$result[$i]['category_id']] = $result[$i]['nb'];
}

$list = get_categories_list(array('order'=>'id DESC'));

echo '<h2>List</h2>';

for($i=0; $i<count($list); $i++) {
	echo '<div>';
		echo ''.$list[$i]['name'].'';
		if($nb_stores_by_cat[$list[$i]['id']]=='') echo ' (0)';
		else echo ' ('.$nb_stores_by_cat[$list[$i]['id']].')';
		
		echo '<span class="pull-right"><a href="edit_category.php?id='.$list[$i]['id'].'">Edit</a> - <a href="#" id="'.$list[$i]['id'].'" class="delete_category_btn">Delete</a></span>';
	echo '</div>';
	echo '<hr style="margin-top:10px; margin-bottom:10px;">';
}

if(count($list)==0) echo 'No categories has been added yet.';


include('./include/presentation/footer.php');
?>