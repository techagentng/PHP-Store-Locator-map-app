<?php

function getCurrentPageURL($criteria=array()) {
	$forceHttps = (isset($criteria['forceHttps']) ? $criteria['forceHttps'] : false);
	$noParam = (isset($criteria['noParam']) ? $criteria['noParam'] : false);
	$rootUrl = (isset($criteria['rootUrl']) ? $criteria['rootUrl'] : false);
	
	$pageURL = 'http://';
	if((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO']=='https') || $forceHttps===true) {
		$pageURL = 'https://';
	}
	
	if($rootUrl===true) {
		$pageURL .= $_SERVER['SERVER_NAME'];
		return $pageURL;
	}
	
	if ($_SERVER['SERVER_PORT'] != '80') {
		$pageURL .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
	}
	else {
		$pageURL .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}
	
	if($noParam===true) {
		$pos = strpos($pageURL, '?');
		if($pos!==FALSE) {
			$pageURL = substr($pageURL, 0, $pos);
		}
	}
	
	return $pageURL;
}

function getDataFromUrl($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

?>