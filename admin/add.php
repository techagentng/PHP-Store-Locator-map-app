<?php
include('./include/webzone.php');
include('./include/presentation/header.php');

//get categories
$list = get_categories_list(array('order'=>'id DESC'));
for($i=0; $i<count($list); $i++) {
	$list_tab[$list[$i]['id']] = $list[$i]['name'];
}
?>

<div id="geocode_section">
	<form>
	<p><label>Please type your full address:</label><input type="text" id="location2geocode" style="width:360px;" class="form-control"></p>
	<input id="geocode_address_btn" type="submit" value="Geocode and continue" class="btn btn-primary">
	</form>
</div>

<div id="address_thumbnail" style="margin-bottom:10px;"></div>

<?php

//form
$criteria['fields'][] = array('name'=>'name', 'title'=>'Name:');
$criteria['fields'][] = array('name'=>'category_id', 'title'=>'Category:', 'type'=>'select', 'select_values'=>$list_tab);
$criteria['fields'][] = array('name'=>'address', 'title'=>'Address:');
$criteria['fields'][] = array('name'=>'logo', 'title'=>'Logo url:');
$criteria['fields'][] = array('name'=>'url', 'title'=>'URL:');
$criteria['fields'][] = array('name'=>'description', 'title'=>'Description:', 'type'=>'textarea', 'rows'=>'5');
$criteria['fields'][] = array('name'=>'tel', 'title'=>'Tel:');
$criteria['fields'][] = array('name'=>'email', 'title'=>'Email:');
$criteria['fields'][] = array('name'=>'lat', 'title'=>'Latitude:');
$criteria['fields'][] = array('name'=>'lng', 'title'=>'Longitude:');
$criteria['submit'] = array('name'=>'add', 'id'=>'add_store_btn', 'value'=>'Add store');
$criteria['form'] = array('name'=>'add_store_form', 'id'=>'add_store_form');

echo '<div id="form_section" style="width:600px; display:none;">';
display_forms($criteria);
echo '</div>';

include('./include/presentation/footer.php');
?>