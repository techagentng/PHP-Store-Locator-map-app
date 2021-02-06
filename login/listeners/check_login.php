<?php
include('../include/webzone.php');

$login = $_POST['login'];
$password = $_POST['password'];

if($login=='' || $password=='') {
	$display .= '<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	$display .= 'Missing login and/or password';
	$display .= '</div>';
	$d['display'] = $display;
	$d['code'] = 1;
	echo json_encode($d);
}
else {
	
	if($login==$GLOBALS['admin_username'] && $password==$GLOBALS['admin_password']) {
		
		$u1 = new YgpUserSession();
		$u1->startSession(array('user_id'=>1, 'login'=>$login));
		
		$d['code'] = 2; //success
		echo json_encode($d);
	}
	else {
		$display .= '<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
		$display .= 'Incorrect username and/or password';
		$display .= '</div>';
		$d['display'] = $display;
		$d['code'] = 1;
		echo json_encode($d);
	}
}

?>