<?php
//DB.class.php

class DB {

	protected $db_name = 'prabhuszendb';
	protected $db_user = 'root';
	protected $db_pass = '';
	protected $db_host = 'localhost:3308';//prod
	//protected $db_host = 'localhost:3307';//dev
	//open a connection to the database. Make sure this is called
	//on every page that needs to use the database.
	public function connect() {
			return new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
	}

	//takes a mysql row set and returns an associative array, where the keys
	//in the array are the column names in the row set. If singleRow is set to
	//true, then it will return a single row instead of an array of rows.
	public function processRowSet($rowSet, $singleRow=false)
	{
	$dbcon = $this->connect();
		$resultArray = array();
		while($row = mysqli_fetch_assoc($rowSet))
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
	$dbcon = $this->connect();
		//$sql = "SELECT * FROM $table ";
		mysqli_query($dbcon,"SET NAMES utf8");
		$result = mysqli_query($dbcon,$sql);
		mysqli_close($dbcon);
		return $result;
	}

	//Select rows from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function selectwhere($table, $where) {
	$dbcon = $this->connect();
	mysqli_query($dbcon,"SET NAMES utf8");
		$sql = "SELECT * FROM $table WHERE $where";
		$result = mysqli_query($dbcon,$sql);
		/*if(mysql_num_rows($result) == 1)
			return $this->processRowSet($result, true);

		return $this->processRowSet($result);*/
		mysqli_close($dbcon);
		return $result;
	}

	//Updates a current row in the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table and $where is the sql where clause.
	public function update($data, $table, $where) {
	$dbcon = $this->connect();
		foreach ($data as $column => $value) {
			$sql = "UPDATE $table SET $column = $value WHERE $where";
				
			mysqli_query($dbcon,$sql) or die(mysql_error());
		}
		mysqli_close($dbcon);
		return true;
	}
	//Updates a current row in the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table and $where is the sql where clause.
	public function updatedb($sql) {
	$dbcon = $this->connect();
	mysqli_query($dbcon,'SET CHARACTER SET utf8');
	mysqli_query($dbcon,$sql) or die(mysqli_error($dbcon));
	if(mysqli_affected_rows($dbcon) > 0){
	$response=array("OK", " Edited Successfully");
//return true;
	}else{
		//return false;
	$response=array("ERROR","No Action Taken");
	}
	mysqli_close($dbcon);
return $response;
	}
	//Inserts a new row into the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table.
	public function insertdb($sql) {
	$dbcon = $this->connect();
		mysqli_query($dbcon,'SET CHARACTER SET utf8');
	mysqli_query($dbcon,$sql) or die(mysqli_error($dbcon));
	if(mysqli_affected_rows($dbcon) > 0){
	$response=array("OK", " Inserted Successfully",mysqli_insert_id($dbcon));

	}else{
	$response=array("ERROR","No Action Taken");
	}
	mysqli_close($dbcon);
		return $response;
	}
	public function insertID($sql) {
	$dbcon = $this->connect();
	mysqli_query($dbcon,$sql) or die(mysqli_error($dbcon));
	if(mysqli_affected_rows($dbcon) > 0){
	return mysqli_insert_id($dbcon);
	mysqli_close($dbcon);
	}
	}

	//Inserts a new row into the database.
	//return the response
		public function InsertDBphp($sql){
		$dbcon = $this->connect();
		$response=mysqli_query($dbcon,$sql);
		mysqli_close($dbcon);
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
	$dbcon = $this->connect();
		mysqli_query($dbcon,$sql) or die(mysql_error($dbcon));
		//return the ID of the user in the database.
		return mysqli_insert_id($dbcon);
mysqli_close($dbcon);
	}
	//Inserts a new row into the database.
	//takes an array of data, where the keys in the array are the column names
	//and the values are the data that will be inserted into those columns.
	//$table is the name of the table.
	public function Mulltinsert($data, $table) {
	$fields = implode(', ', array_shift($data));
	array_shift($data);
	$values = array();
	foreach ($data as $rowValues) {
		foreach ($rowValues as $key => $rowValue) {
			 $rowValues[$key] = $rowValues[$key];
		}

		$values[] = "(" . implode(', ', $rowValues) . ")";
	}

	$sql = "INSERT INTO $table ($fields) VALUES " . implode (', ', $values);
	$dbcon = $this->connect();
		mysqli_query($dbcon,$sql) or die(mysql_error($dbcon));
mysqli_close($dbcon);
		//return the ID of the user in the database.
		return true;

	}

	//Select Max from the database.
	//returns a full row or rows from $table using $where as the where clause.
	//return value is an associative array with column names as keys.
	public function selectmax($field, $table, $where) {
		$sql = "SELECT max($field) as value FROM $table WHERE $where";
		$dbcon = $this->connect();
		$result = mysqli_query($dbcon,$sql);
		while ($row = mysqli_fetch_array($result))
					{
		return $row['value'];
		mysqli_close($dbcon);
		}

			}

}

?>
