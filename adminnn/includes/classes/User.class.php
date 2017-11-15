<?php
//User.class.php
 
require_once (__DIR__.'/DB.class.php');
 
 
class User {
 
    public $Emp_ID;
	public $Emp_Code;
    public $Emp_Name;
    public $Emp_Pass;
	public $Emp_Address;
	public $Emp_State;
	public $Emp_Country;
	public $Emp_Phone;
	public $Emp_Email;
	public $Emp_Role;
    public $Timestamp;
 
    //Constructor is called whenever a new object is created.
    //Takes an associative array with the DB row as an argument.
    function __construct($data) {
        $this->Emp_ID = (isset($data['Emp_ID'])) ? $data['Emp_ID'] : "";
		$this->Emp_Code = (isset($data['Emp_Code'])) ? $data['Emp_Code'] : "";
        $this->Emp_Name = (isset($data['Emp_Name'])) ? $data['Emp_Name'] : "";
        $this->Emp_Pass = (isset($data['Emp_Pass'])) ? $data['Emp_Pass'] : "";
		$this->Emp_Address = (isset($data['Emp_Address'])) ? $data['Emp_Address'] : "";
		$this->Emp_State = (isset($data['Emp_State'])) ? $data['Emp_State'] : "";
		$this->Emp_Country = (isset($data['Emp_Country'])) ? $data['Emp_Country'] : "";
		$this->Emp_Phone = (isset($data['Emp_Phone'])) ? $data['Emp_Phone'] : "";
		$this->Emp_Email = (isset($data['Emp_Email'])) ? $data['Emp_Email'] : "";
		$this->Emp_Role = (isset($data['Emp_Role'])) ? $data['Emp_Role'] : "";
        $this->Timestamp = (isset($data['Timestamp'])) ? $data['Timestamp'] : "";
    }
 
    public function save($isNewUser = false) {
        //create a new database object.
        $db = new DB();
        
        //if the user is already registered and we're
        //just updating their info.
        if(!$isNewUser) {
            //set the data array
            $data = array(
                "Emp_Name" => "'$this->Emp_Name'",
				"Emp_Pass" => "'$this->Emp_Pass'",
				"Emp_Address" => "'$this->Emp_Address'",
				"Emp_State" => "'$this->Emp_State'",
				"Emp_Country" => "'$this->Emp_Country'",
				"Emp_Phone" => "'$this->Emp_Phone'",
				"Emp_Email" => "'$this->Emp_Email'",
				"Emp_Role" => "'$this->Emp_Role'"
				
            );
            
            //update the row in the database
            $db->update($data, 'tbl_emp_master', 'Emp_ID = '.$this->Emp_ID);
        }else {
        //if the user is being registered for the first time.
            $data = array(
                "Emp_Name" => "'$this->Emp_Name'",
				"Emp_Code" => "'$this->Emp_Code'",
				"Emp_Pass" => "'$this->hashedEmp_Pass'",
				"Emp_Address" => "'$this->Emp_Address'",
				"Emp_State" => "'$this->Emp_State'",
				"Emp_Country" => "'$this->Emp_Country'",
				"Emp_Phone" => "'$this->Emp_Phone'",
				"Emp_Email" => "'$this->Emp_Email'",
				"Emp_Role" => "'$this->Emp_Role'",
                "Timestamp" => "'".date("Y-m-d H:i:s",time())."'"
            );
            
            $this->Emp_ID = $db->insert($data, 'tbl_emp_master');
            $this->joinDate = time();
        }
        return true;
    }
    
}
 
?>