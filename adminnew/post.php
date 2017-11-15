<?php
print_r($_REQUEST);
//or
/*foreach ($_REQUEST as $key => $value)
    echo $key.'='.$value.'<br />';*/
	?>
	<?php include 'Includes/header.php';?>
	<table>
<?php 


   /*foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
		echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
	$authors = $_POST['Product_ID'];
		foreach($authors as $author) :
   echo $author.'<br>';
endforeach;*/


?>
</table>
<?php

/*if(!empty($_POST["slno"])) {
   //$conn = mysql_connect("localhost","root","");
  // mysql_select_db("phppot_examples",$conn);
   $itemCount = count($_POST["slno"]);
   $itemValues=0;
   $query = "INSERT INTO item (item_name,item_price) VALUES ";
   $queryValue = "";
   for($i=0;$i<$itemCount;$i++) {
      if(!empty($_POST["slno"][$i]) || !empty($_POST["Product_ID"][$i])) {
         $itemValues++;
	 if($queryValue!="") $queryValue .= ",";
	 
  	 $queryValue .= "('" .mysql_real_escape_string( $_POST["slno"][$i] ). "', '" . mysql_real_escape_string($_POST["Product_ID"][$i] ). "')";
      }
   }
   	$sql = $query.$queryValue;
  		 if($itemValues!=0) {
      //$result = mysql_query($sql);
	  echo $sql;
      if(!empty($result)) $message = "Added Successfully.";
   }
}*/
 

function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 100000);  /* lakhs (giga) */ 
    $number -= $Gn * 100000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Lakh"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 


$cheque_amt = 8747484.21 ; 
try
    {
    echo convert_number($cheque_amt);
    }
catch(Exception $e)
    {
    echo $e->getMessage();
    }
?>

