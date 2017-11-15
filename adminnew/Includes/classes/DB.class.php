<?php
//DB.class.php

class DB {

	protected $db_name = 'bookstorenew';
	protected $db_user = 'Terminals';
	protected $db_pass = 'prabhus1';
	protected $db_host = 'localhost:3307';
	
	//open a connection to the database. Make sure this is called
	//on every page that needs to use the database.
	public function connect() {
			$connection = @mysql_connect($this->db_host , $this->db_user, $this->db_pass)or die('Could not connect: ' . mysql_error());
			
		  mysql_select_db($this->db_name) ;

		return true;
	}

	//takes a mysql row set and returns an associative array, where the keys
	//in the array are the column names in the row set. If singleRow is set to
	//true, then it will return a single row instead of an array of rows.
	public function processRowSet($rowSet, $singleRow=false)
	{
		$resultArray = array();
		while($row = mysql_fetch_assoc($rowSet))
		{
			array_push($resultArray, $row);
		}

		if($singleRow === true)
			return $resultArray[0];

		return $resultArray;
	}

	//Select rows from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function select($sql) {
		//$sql = "SELECT * FROM $table ";
		$result = mysql_query($sql);
		return $result;
	}
	
	//Select rows from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function selectwhere($table, $where) {
		$sql = "SELECT * FROM $table WHERE $where";
		$result = mysql_query($sql);
		/*if(mysql_num_rows($result) == 1)
			return $this->processRowSet($result, true);

		return $this->processRowSet($result);*/
		return $result;
	}

	//Updates a current row in the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table and $where is the sql where clause.
	public function update($data, $table, $where) {
		foreach ($data as $column => $value) {
			$sql = "UPDATE $table SET $column = $value WHERE $where";
			mysql_query($sql) or die(mysql_error());
		}
		return true;
	}
	//Updates a current row in the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table and $where is the sql where clause.
	public function updatedb($sql) {
	
	mysql_query($sql) or die(mysql_error());
	if(mysql_affected_rows() > 0){
	$response=array("OK", " Edited Successfully");
	
	}else{
	$response=array("ERROR","No Action Taken");
	}
		return $response;
	}
	//Inserts a new row into the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table.
	public function insertdb($sql) {
	
	mysql_query($sql) or die(mysql_error());
	if(mysql_affected_rows() > 0){
	$response=array("OK", " Inserted Successfully",mysql_insert_id());
	
	}else{
	$response=array("ERROR","No Action Taken");
	}
		return $response;
	}


	//Inserts a new row into the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table.
	public function insert($data, $table) {

		$columns = "";
		$values = "";

		foreach ($data as $column => $value) {
			$columns .= ($columns == "") ? "" : ", ";
			$columns .= $column;
			$values .= ($values == "") ? "" : ", ";
			$values .= $value;
		}

		$sql = "insert into $table ($columns) values ($values)";

		mysql_query($sql) or die(mysql_error());

		//return the ID of the user in the database.
		return mysql_insert_id();

	}
	//Select Max from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function selectmax($field, $table, $where) {
		$sql = "SELECT max($field) as value FROM $table WHERE $where";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result)) 
					{
		return $row['value'];
		}

			}

}

?>