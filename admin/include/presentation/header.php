<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Stores Locator Admin</title>

<link rel="stylesheet" href="./include/bootstrap-3.3.5/css/bootstrap.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="./include/js/script.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=<?php echo $GLOBALS['google_api_key']; ?>"></script>

<script>
var Store_locator = {googleAPIKey:"<?php echo $GLOBALS['google_api_key']; ?>"};
$(document).ready(function() {
	<?php echo $jsOnReady; ?>
})
</script>

</head>

<body>

<div class="container">
	<h1>Store Locator Admin</h1>
	
	<div>
		
		<a href="./list.php">Stores list</a> 
		- <a href="./add.php">Add store</a> 
		- <a href="./categories.php">Categories</a>
		
		<span class="pull-right">
			<a href="../">Front End</a> - 
			<a href="../login/listeners/kill_session.php">Logout</a>
		</span>
		
	</div>
	
	<hr>
</div>

<div class="container">