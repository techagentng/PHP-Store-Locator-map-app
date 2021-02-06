<?php
include_once('include/webzone.php');

$displayType = '';
include_once('include/presentation/header.php');

$address = filter_input(INPUT_GET, 'address', FILTER_SANITIZE_STRING);
$category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_STRING);
$max_distance = filter_input(INPUT_GET, 'max_distance', FILTER_SANITIZE_STRING);
?>
	
<div class="container">
<form method="GET" class="form-inline">
	<div style="border:1px solid #dcdcdc; margin-bottom:10px; padding:10px;">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<p>Type any city name, address or zip code to find the closest location:</p>
			</div>
		</div>
		<div class="row">
			<?php
			display_search(array('address'=>$address, 'category_id'=>$category_id, 'max_distance'=>$max_distance));
			?>
		</div>
	</div>
</form>
</div>

<div class="container">
	<div style="padding:10px; width:100%; border:1px solid #dcdcdc;">
	
		<div id="sl_current_location"></div>
		
		<div class="row">
			<div class="col-xs-4">
				<div id="sl_sidebar" class="store_locator_sidebar">Loading...</div>
				<div id="sl_pagination" class="store_locator_pagination"></div>
				<span id="sl_pagination_loading"></span>
			</div>
			
			<div class="col-xs-8">
			    <div id="sl_map" style="width:100%; height:460px"></div>
			</div>
		</div>
	
	</div>
</div>

<?php
include_once('include/presentation/footer.php');
?>