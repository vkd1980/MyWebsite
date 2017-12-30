<?php
//User.class.php
 
require_once (__DIR__.'/DB.class.php');
 
 
class User {
 
    public $customers_id;
	public $customers_gender;
    public $customers_firstname;
    public $customers_lastname;
	public $customers_dob;
	public $customers_email_address;
	public $customers_telephone;
	public $customers_password;
	public $customers_newsletter;
    public $customers_authorization;
 
    //Constructor is called whenever a new object is created.
    //Takes an associative array with the DB row as an argument.
	 function __construct($data) {
        $this->customers_id = (isset($data['customers_id'])) ? $data['customers_id'] : "";
		$this->customers_gender = (isset($data['customers_gender'])) ? $data['customers_gender'] : "";
        $this->customers_firstname = (isset($data['customers_firstname'])) ? $data['customers_firstname'] : "";
        $this->customers_lastname = (isset($data['customers_lastname'])) ? $data['customers_lastname'] : "";
		$this->customers_dob = (isset($data['customers_dob'])) ? $data['customers_dob'] : "";
		$this->customers_email_address = (isset($data['customers_email_address'])) ? $data['customers_email_address'] : "";
		$this->customers_telephone = (isset($data['customers_telephone'])) ? $data['customers_telephone'] : "";
		$this->customers_password = (isset($data['customers_password'])) ? $data['customers_password'] : "";
		$this->customers_newsletter = (isset($data['customers_newsletter'])) ? $data['customers_newsletter'] : "";
		$this->customers_authorization = (isset($data['customers_authorization'])) ? $data['customers_authorization'] : "";
		
            }
 
 public function InsertCust(){
  $db = new DB();
  $data= array(
  "customers_gender" => "'$this->customers_gender'",
  "customers_firstname" => "'$this->customers_firstname'",
  "customers_lastname" => "'$this->customers_lastname'",
  "customers_dob" => "'$this->customers_dob'",
  "customers_email_address" => "'$this->customers_email_address'",
  "customers_telephone" => "'$this->customers_telephone'",
  "customers_password" => "'$this->customers_password'",
  "customers_newsletter" => "'$this->customers_newsletter'",
  "customers_authorization" => "'$this->customers_authorization'"
  );
  $lastid=$db->insert($data, 'customers');
  return $lastid;
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