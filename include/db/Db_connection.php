<?php

class Db_connection 
{
    private static $_instance;
 	private $link;
 	private $db_host;
 	private $db_name;
 	private $db_user;
 	private $db_password;
 	private $db_port;
 	private $db_charset;
 	
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
	
    final private function __construct() {
    	$this->db_host = $GLOBALS['db_host'];
    	$this->db_name = $GLOBALS['db_name'];
    	$this->db_user = $GLOBALS['db_user'];
    	$this->db_password = $GLOBALS['db_password'];
    	$this->db_port = $GLOBALS['db_port'];
    	$this->db_charset = $GLOBALS['db_charset'];
    	
    	if($this->db_charset=='') $this->db_charset = 'utf8';
    	if($this->db_port=='') $this->db_port = 3306;
    	
    	$this->openConnection();
    }
    
    public function __destruct() {
    	$this->closeConnection();
    }
    
    final private function __clone() { }
	
	private function openConnection() {
		$this->link = @mysqli_connect($this->db_host, $this->db_user, $this->db_password, '', $this->db_port);
		if (!$this->link) {
		    echo "Error: Unable to connect to MySQL." . PHP_EOL.'<br>';
		    echo mysqli_connect_errno().' - '.mysqli_connect_error();
		    exit;
		}
		mysqli_set_charset($this->link, $this->db_charset);
	}
	
	private function closeConnection() {
		if($this->link) mysqli_close($this->link);
	}
	
	public function getDbConnection() {
		$db['link'] = $this->link;
		$db['db_name'] = $this->db_name;
		return $db;
	}
}

?>