<?php
include_once('include/webzone.php');

$redirectTo = (isset($_GET['redirectTo']) ? $_GET['redirectTo'] : '');

$u1 = new YgpUserSession();
if($u1->isConnected()) {
	if($redirectTo!='') {
		echo '<script>window.location = "'.$redirectTo.'";</script>'; exit();
	}
	else if($GLOBALS['redirect_after_login']!='') {
		echo '<script>window.location = "'.$GLOBALS['redirect_after_login'].'";</script>'; exit();
	}
	else {
		echo '<script>window.location = "../admin/";</script>'; exit();
	}
}

include_once('include/presentation/header.php');
?>

<div class="container">
	<div class="row">
		<div class="col-md-3">
			
		</div>
		<div class="col-md-6">
			
			<form class="form-signin" role="form" id="login_form" name="login_form">
				
				<div class="input-group" style="margin-bottom:10px;">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input type="text" id="login" name="login" class="form-control" placeholder="Username" autocomplete="off" autofocus tabindex="1">
				</div>
				
				<div class="input-group" style="margin-bottom:10px;">
					<span class="input-group-addon"><i class="fa fa-key"></i></span>
					<input type="password" id="password" name="password" class="form-control" placeholder="Password" autocomplete="off" tabindex="2">
				</div>
				
				<button class="btn btn-lg btn-primary btn-block" id="login_btn" type="submit" tabindex="4">Sign in</button>
				<div id="notification" style="margin-top:10px;">
				</div>
			</form>
			
		</div>
		<div class="col-md-3">
			
		</div>
	</div>
</div>

<?php
include_once('include/presentation/footer.php');
?>