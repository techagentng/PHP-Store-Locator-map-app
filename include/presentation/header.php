<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

    <title>Advanced Store Locator - Yougapi Technology</title>
    <meta name="description" content="The Best Selling Store Locator PHP App - Get your store locator based on Google Maps on your website. Allow visitors to search for the closest store to a given address or current location">
    <meta name="keywords" content="Store Locator, PHP store locator, locate a store, locate business, php google maps, address geocoding, stores search, Address search">
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
	<link rel="stylesheet" href="./include/bootstrap-3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="./include/css/style.css" />
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?key=<?php echo $GLOBALS['google_api_key']; ?>" type="text/javascript"></script>
    <script src="./include/js/script.js" type="text/javascript"></script>
	<script>
	"use strict";
	var Store_locator = {
		ajaxurl:"", lat:"", lng:"", current_lat:"", current_lng:"", category_id:"", max_distance:"",
		page_number:1, nb_display: <?php echo $GLOBALS['nb_display']; ?>, map_all_stores: "<?php echo $GLOBALS['map_all_stores']; ?>",
		marker_icon:"<?php echo $GLOBALS['marker_icon']; ?>", marker_icon_current:"<?php echo $GLOBALS['marker_icon_current']; ?>", 
		autodetect_location:"<?php echo $GLOBALS['autodetect_location']; ?>",
		streetview_display:<?php echo $GLOBALS['streetview_display']; ?>,
		display_type:"<?php echo $displayType; ?>"
	};
	</script>
	
</head>

<body>

<div class="container">
	<br>
	<a href="http://codecanyon.net/item/advanced-php-store-locator/244349?ref=yougapi"><img src="./include/graph/advanced-store-locator-mini.png" align="left" style="margin-right:30px;"></a>
	<h1 style="margin-top:0px;">Advanced Store Locator</h1>
	Enrich your website with a Google Maps powered Store Locator. <a href="http://codecanyon.net/item/advanced-php-store-locator/244349?ref=yougapi">Get this app here</a><br>
</div><br>

<div class="container">
	<a href="./index.php" class="">Style 1</a> - 
	<a href="./demo_2.php" class="">Style 2</a> - 
	<a href="./admin/" class="">Admin Demo</a> (Username: admin - Password: admin)
</div><br>