<?php
include('./include/webzone.php');
include('./include/presentation/header.php');

$category_id = $_GET['id'];

if($category_id!='') $result = get_categories_list(array('id'=>$category_id));

echo '<h2 style="margin-top:0px;">Edit a category</h2>';

if(count($result)>0) {
	echo '<form style="width:400px;">';
	echo '<input type="hidden" id="category_id" value="'.$category_id.'">';
	echo '<label>Name</label>';
	echo '<p><input type="text" id="name" class="form-control" value="'.$result[0]['name'].'"></p>';
	echo '<label>Marker icon</label>';
	echo '<p><input type="text" id="marker_icon" name="marker_icon" value="'.$result[0]['marker_icon'].'" class="form-control"></p>';
	echo '<p><input type="submit" id="edit_category_btn" value="Save changes" class="btn btn-primary edit_category_btn"></p>';
	echo '</form>';
}
else {
	echo 'Category not found';
}

include('./include/presentation/footer.php');
?>