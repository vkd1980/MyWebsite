<?php
include'includes/header.php';
if(!isset($_SESSION['logged_in'])) {
header("Location: index.php");
	}
?>

<html>
  <head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
        function getvalues()
        {
             var selname = $("input[name='names']:text").val(); 
    
                $.ajax({ url: "includes/jsonphp.php",
                    data: {"selname":selname},
                    type: 'post',
                    dataType: "json",
                    success: function(output) {
					 var siteArray = output.array;
				if( !$.isArray(siteArray) ||  !siteArray.length ) {
				console.log(output);
				if (output[0]==0){
				window.alert(output[2]);
									$("#query").val("");
									$("#Emp_Code").val("");
                                    $("#Emp_Name").val("");
									$('#Emp_Role').val(0);
				}
				else
				{
									$("#Emp_Code").val(output[0]);
                                    $("#Emp_Name").val(output[1]);
									$('#Emp_Role').val(output[2]).attr("selected", "selected")
									
                           }        
					}
					
                    }
    
                });
        }
    </script>
    </script>
  </head>
  <body>
    <form method="post">
      <input type="text" name="names" id="query" onblur="getvalues()"/>
      <input type="text" name="Emp_Code" id="Emp_Code"/>
      <input type="text" name="Emp_Name" id="Emp_Name" />
	  <select name="Emp_Role" id="Emp_Role" class="gridder_add select"  >
	  <option value="0">Select </option>
                                                <?php $sql = "SELECT AccessID,AccessTitle FROM tblsecurityaccess 	";
		
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['AccessID'] . "'>" . $row['AccessTitle'] . "</option>";
}

?>
                        </select>
    </form>
  </body>
</html>