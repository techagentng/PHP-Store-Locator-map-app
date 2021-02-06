<?php
include('../include/webzone.php');

$u1 = new YgpUserSession();
$u1->killSession();

header('Location: ../');

?>