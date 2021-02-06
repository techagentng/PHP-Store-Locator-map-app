<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set("display_errors", 1);

include_once(__DIR__.'/../../include/config.php');

include_once(__DIR__.'/functions/functions.php');
include_once(__DIR__.'/functions/display_functions.php');
include_once(__DIR__.'/functions/db_functions.php');
include_once(__DIR__.'/functions/Forms.php');

$redirectTo = getCurrentPageURL();
include(__DIR__.'/../../login/include/webzone.php');
$u1 = new YgpUserSession();
if(!$u1->isConnected()) header('Location: ../login/?redirectTo='.urlencode($redirectTo));

include_once(__DIR__.'/db/db_class.php');

?>