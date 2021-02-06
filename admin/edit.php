<?php
include('./include/webzone.php');

$id = $_GET['id'];

if($id!='') $store = get_stores_list(array('id'=>$id));

if($store[0]['lat']!='' && $store[0]['lng']!='') $jsOnReady = "load_thumbnail_map('".$store[0]['lat']."', '".$store[0]['lng']."')";

include('./include/presentation/header.php');

if(count($store)>0) {
	//get categories
	$list = get_categories_list(array('order'=>'id DESC'));
	for($i=0; $i<count($list); $i++) {
		$list_tab[$list[$i]['id']] = $list[$i]['name'];
	}
	
	?>
	
	<div id="geocode_section" style="display:none;">
		<form>
		<p><label>Please type your full address:</label><input type="text" id="location2geocode" style="width:360px;" class="form-control"></p>
		<input id="geocode_address_btn" type="submit" value="Geocode and continue" class="btn btn-primary">
		</form>
	</div>
	
	<div id="address_thumbnail" style="margin-bottom:10px;"></div>
	
	<?php
	
	//form
	$criteria['fields'][] = array('name'=>'id', 'type'=>'hidden', 'value'=>$id);
	$criteria['fields'][] = array('name'=>'name', 'title'=>'Name:', 'value'=>$store[0]['name']);
	$criteria['fields'][] = array('name'=>'category_id', 'title'=>'Category:', 'type'=>'select', 'select_values'=>$list_tab, 'value'=>$store[0]['category_id']);
	$criteria['fields'][] = array('name'=>'address', 'title'=>'Address:', 'value'=>$store[0]['address']);
	$criteria['fields'][] = array('name'=>'logo', 'title'=>'Logo url:', 'value'=>$store[0]['logo']);
	$criteria['fields'][] = array('name'=>'url', 'title'=>'URL:', 'value'=>$store[0]['url']);
	$criteria['fields'][] = array('name'=>'description', 'title'=>'Description:', 'type'=>'textarea', 'rows'=>'5', 'value'=>$store[0]['description']);
	$criteria['fields'][] = array('name'=>'tel', 'title'=>'Tel:', 'value'=>$store[0]['tel']);
	$criteria['fields'][] = array('name'=>'email', 'title'=>'Email:', 'value'=>$store[0]['email']);
	$criteria['fields'][] = array('name'=>'lat', 'title'=>'Latitude:', 'value'=>$store[0]['lat']);
	$criteria['fields'][] = array('name'=>'lng', 'title'=>'Longitude:', 'value'=>$store[0]['lng']);
	$criteria['submit'] = array('name'=>'edit', 'id'=>'edit_store_btn', 'value'=>'Edit store');
	$criteria['form'] = array('name'=>'edit_store_form', 'id'=>'edit_store_form');
	
	echo '<div id="form_section" style="width:600px;">';
	display_forms($criteria);
	echo '</div>';	
}
else {
	echo 'No store found';
}

include('./include/presentation/footer.php');
?>