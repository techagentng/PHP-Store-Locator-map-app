<?php

class YgpUserSession {
		
	function getSession() {
		//print_r($_SESSION);
		return $_SESSION[$GLOBALS['session_key']];
	}
		
	function isConnected() {
		if($_SESSION[$GLOBALS['session_key']]['user_id']!='') return true;
		else return false;
	}
	
	/*
	@param Array (user_id, login)
	*/
	function startSession($criteria=array()) {
		$_SESSION[$GLOBALS['session_key']] = $criteria;
	}
	
	function killSession() {
		$_SESSION[$GLOBALS['session_key']] = array();
		unset($_SESSION);
	}	
}

?>