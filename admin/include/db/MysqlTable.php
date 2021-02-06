<?php

//Last update: 18 Jan 2020

class MySqlTable {
	
	var $link;
	var $db_name;
	var $verbose; //when set to 1 echo the SQL queries
	var $sqlErrorsTableName = 'sqlErrorsLog';
	var $sqlErrorsLogging = true; //true or false
	
	function __construct($options=array()) {
		$this->verbose = (isset($options['verbose']) ? $options['verbose'] : '');
		
		//Establish the DB Connection
		$c1 = Db_connection::getInstance();
		$db_connection = $c1->getDbConnection();
		$this->link = $db_connection['link'];
		$this->db_name = $db_connection['db_name'];
	}
	
	//Escapes the variable to protect against SQL injections
	public function escape($value) {
		$value = mysqli_real_escape_string($this->link, $value);
		return $value;
	}
	
	public function getSingleRow($table_name='', $where='') {
		
		$data = array();
		if($where=='' || !is_array($where)) return array();
		
		$tmp = '';
		$whereCondition = array();
		foreach($where as $ind=>$value) {
			$whereCondition[] = $ind . "='" . $this->escape($value) . "'";
		}
		$whereCondition = ' WHERE '.implode(' AND ', $whereCondition);
		
		$sql = "
		SELECT *
		FROM {$table_name}
		{$whereCondition}
		LIMIT 1;
		";
		$result = $this->customQuery($sql);
		if(count($result)>0) {
			$data = $result[0];
		}
		
		return $data;
	}

	public function getNameValueAssociation($table_name='', $where='', $options=array()) {
		$index = (isset($options['index']) ? $options['index'] : '');
		$value = (isset($options['value']) ? $options['value'] : '');
		
		$data = array();
		if($where=='' || !is_array($where)) return array();
		if($index=='' || $value=='') return array();
		
		$tmp = '';
		$whereCondition = array();
		foreach($where as $ind=>$val) {
			$whereCondition[] = $ind . "='" . $this->escape($val) . "'";
		}
		$whereCondition = ' WHERE '.implode(' AND ', $whereCondition);
		
		$sql = "
		SELECT *
		FROM {$table_name}
		{$whereCondition};
		";
		$result = $this->customQuery($sql);
		if(count($result)>0) {
			foreach($result as $row) {
				$data[$row[$index]] = $row[$value];
			}
		}
		
		return $data;
	}
	
	public function getNameValuesAssociation($table_name='', $where='', $options=array()) {
		$index = (isset($options['index']) ? $options['index'] : '');
		$values = (isset($options['values']) ? $options['values'] : array());
		
		if(!is_array($values) && $values!='') $values = array($values);
		else if(!is_array($values)) $values = array();
		
		$data = array();
		if($where=='' || !is_array($where)) return array();
		if($index=='' || (is_array($values) && count($values)==0)) return array();
		
		$tmp = '';
		$whereCondition = array();
		foreach($where as $ind=>$val) {
			$whereCondition[] = $ind . "='" . $this->escape($val) . "'";
		}
		$whereCondition = ' WHERE '.implode(' AND ', $whereCondition);
		
		$sql = "
		SELECT *
		FROM {$table_name}
		{$whereCondition};
		";
		$result = $this->customQuery($sql);
		if(count($result)>0) {
			foreach($result as $row) {
				foreach($values as $value) {
					$data[$value][$row[$index]] = $row[$value];
				}
			}
		}
		
		return $data;
	}
	
	//Returns the inserted id, or FALSE if it fails
	public function insert($table_name='', $data=array(), $options=array()) {
		$onDuplicateUpdate = $options['onDuplicateKeyUpdate'];
		
		if($table_name!='' && count($data)>0) {
			
			//Construct the query
			$query = "INSERT IGNORE INTO " . $table_name . " (";
			$s = "";
			foreach($data as $key => $value) {
				if($value || is_numeric($value)) {
					$query.= $s.$key;
					$s = ", ";
				}
			}
			$query .= ") VALUES (";
			$s = "";
			foreach($data as $value) {
				if($value || is_numeric($value)) {
					$query.= $s."'".$this->escape($value)."'";
					$s = ", ";
				}
			}
			$query .= ")";
			
			if(is_array($onDuplicateUpdate) && count($onDuplicateUpdate)>0) {
				$i=0;
				foreach($onDuplicateUpdate as $value) {
					$onDuplicateUpdate[$i] = $value.'=VALUES('.$value.')';
					$i++;
				}
				$query .= ' ON DUPLICATE KEY UPDATE ';
				$query .= implode(', ', $onDuplicateUpdate);
			}
			
			if($this->verbose) echo $query.'<br>';
			
			//Execute the query
			$result = $this->executeQuery($query);
			if($result) $result = mysqli_insert_id($this->link);
		}
		else {
			$result = false;
		}
				
		return $result;
	}
	
	public function getLastInserted() {
		$id = mysqli_insert_id($this->link);
		return $id;
	}
	
	//Update rows by condition - Return values: number of affected rows or false (error)
	public function update($table_name='', $data=array(), $where=array()) {
		
		if($table_name!='' && count($data)>0 && count($where)>0) {
			
			//Construct the query
			$query = "UPDATE " . $table_name . " SET ";
			$s = "";
			foreach($data as $ind=>$value) {
				$query .= $s . $ind . " = '" . $this->escape($value) . "'";
				$s = ", ";
			}
			$tmp = '';
			$query .= ' WHERE ';
			foreach($where as $ind=>$value) {
				$query .= $tmp . $ind . '="' . $this->escape($value) . '"';
				$tmp = ' AND ';
			}
			
			if($this->verbose) echo $query.'<br>';
			
			//Execute the query
			$result = $this->executeQuery($query);
			if($result) {
				$nb_rows = mysqli_affected_rows($this->link);
				if($nb_rows>0) {
					$result = $nb_rows;
				}
				else {
					$result = 0;
				}
			}
		}
		else {
			$result = false;
		}
		
		return $result;
	}
	
	//Delete rows by conditions - Return values: number of affected rows or false (error)
	public function delete($table_name='', $where=array()) {
		
		if($table_name!='' && count($where)>0) {
			
			//Construct the query
			$query = "DELETE FROM " . $table_name . " WHERE ";
			$tmp = '';
			foreach($where as $ind=>$value) {
				$query .= $tmp.$ind.'="'.$this->escape($value).'"';
				$tmp = ' AND ';
			}
			
			if($this->verbose) echo $query.'<br>';
			
			//Execute the query
			$result = $this->executeQuery($query);
			if($result) {
				$nb_rows = mysqli_affected_rows($this->link);
				if($nb_rows>0) {
					$result = $nb_rows;
				}
				else {
					$result = 0;
				}
			}
		}
		else {
			$result = false;
		}
		
		return $result;
	}
	
	public function executeQuery($query) {
		mysqli_select_db($this->link, $this->db_name);
		
		//mysqli_next_result($this->link);
		
		$oneQuery = false;
		
		if(strpos($query, ';')!==false) {
			$queriesList = explode(';', $query);
			$queriesList2 = array();
			if(count($queriesList)>0) {
				foreach($queriesList as $tmpQuery) {
					if(trim($tmpQuery)!='') $queriesList2[] = $tmpQuery;
				}
			}
			if(count($queriesList2)>1) {
				$query = implode(';', $queriesList2);
			}
			else {
				$query = $queriesList2[0];
				$oneQuery = true;
			}
		}
		else {
			//No semi-colon found, can only be one query
			$oneQuery = true;
		}
		
		if($oneQuery===true) {
			$result = mysqli_query($this->link, $query); //or die(mysqli_error($this->link))
			
			/*
			if($result===false){
				echo 'Why false?<br>';
				echo "query: {$query}<br><br>";
			}
			*/
			
			if( strtoupper(substr(trim($query), 0, 6)) == 'INSERT' ) {
				$returnResult = mysqli_insert_id($this->link);
			}
			else if( strtoupper(substr(trim($query), 0, 6)) == 'SELECT' ) {
				$returnResult = $this->getResultsFromQuery($result);
			}
			else {
				$returnResult = $result;
			}
		}
		else {
			$result = mysqli_multi_query($this->link, $query);
			$returnResult = $result;
		}
		
		//To avoid the 'Commands out of sync; you can't run this command now'
		//https://www.php.net/manual/en/mysqli.query.php#102904
		//while to take care of mysqli_multi_query => https://www.php.net/manual/en/mysqli.multi-query.php
		while(mysqli_more_results($this->link)===true) {
			mysqli_next_result($this->link);
		}
		
		if($result instanceof MySQLi) {
			mysqli_free_result($result);
		}
		
		if($result===false) {
			
			if($this->sqlErrorsLogging) {
				$errorMessage = mysqli_error($this->link);
				
				$debugTrace = debug_backtrace();
				//print_r($query); echo '<br>';
				
				if(is_array($debugTrace) && count($debugTrace)>0) {
					$nb = count($debugTrace);
					$file = $debugTrace[($nb-1)]['file'];
					$file = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
					if($file!='') $errorMessage .= " - File: {$file}";
				}
				
				$this->addErrorLog($errorMessage, $query);
			}
		}
		
		return $returnResult;
	}
	
	//Deprecated: please use executeQuery
	public function customQuery($query) {
		return $this->executeQuery($query);
	}
	
	private function isTableExists($tableName) {
		$isTableExists = false;
		
		$sql = "
		SELECT * 
		FROM information_schema.tables
		WHERE table_schema = '{$this->db_name}' 
		AND table_name = '{$this->escape($tableName)}'
		LIMIT 1;
		";
		$result = $this->executeQuery($sql, 1);
		if(count($result)>0) {
			$isTableExists = true;
		}
		
		return $isTableExists;
	}
	
	private function addErrorLog($errorMessage, $query) {
		
		$sqlErrorsFullTableName = $this->db_name.'.'.$this->sqlErrorsTableName;
		//echo "table: {$this->sqlErrorsTableName}";
		
		$logTableExists = $this->isTableExists($this->sqlErrorsTableName);
		
		if($logTableExists===false) {
			$sql = "
			CREATE TABLE IF NOT EXISTS {$sqlErrorsFullTableName} (
				id int(11) PRIMARY KEY AUTO_INCREMENT,
				errorMessage char(255) NOT NULL DEFAULT '',
				query text,
				created datetime
			);
			";
			$this->executeQuery($sql);
		}
		
		$dataToInsert = array(
			'errorMessage'=>$errorMessage,
			'query'=>$query,
			'created'=>date('Y-m-d H:i:s')
		);
		$this->insert($sqlErrorsFullTableName, $dataToInsert);
	}
	
	//Execute the query and return the results in an array
	private function getResultsFromQuery($result) {
		$return = array();
		
		if(!is_bool($result)) {
			while ($rows = mysqli_fetch_assoc($result)) {
				$return[] = $rows;
			}
		}
		return $return;
	}
}

?>
