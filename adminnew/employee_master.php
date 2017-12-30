<?php
include 'Includes/header.php';
?>
<script type="text/javascript">
$()
    .ready(function() {
	$('.filter').multifilter({
            'target': $('#filtertable')
        })
        $.validator.addMethod("selectemprole", function(value, element, arg) {
            return arg != value;
        }, "Select Employee Role.");
        $("#Emp_Code")
            .focus();
			$('#message').hide();
        $("#gridder_addform")
            .validate({
                rules: {
                    Emp_Code: {
                        minlength: 4,
                        required: true,
                        number: true
                    },
                    Emp_Name: {
                        minlength: 5,
                        required: true
                    },
                    Emp_Pass: {
                        minlength: 5,
                        required: true
                    },
                    Emp_Role: {
                        selectemprole: "0",
                        required: true
                    },
                    Emp_Address: {
                        minlength: 5,
                        required: true
                    },
                    Emp_State: {
                        minlength: 3,
                        required: true
                    },
                    Emp_Country: {
                        minlength: 5,
                        required: true
                    },
                    Emp_Phone: {
                        minlength: 10,
                        required: true,
                        number: true
                    },
                    Emp_Email: {
                        email: true,
                        required: true
                    }

                },
                messages: {
                    Emp_Name: {
                        required: "Please enter your Name",
                        minlength: "Your Name must consist of at least 5 characters"
                    },
                    Emp_Code: {
                        required: "Please enter Employee Code",
                        minlength: "Your Employee Code must consist of at least 5 characters",
                        number: "Enter Numbers Only"
                    },
                    Emp_Pass: {
                        required: "Please enter your Password",
                        minlength: "Your Password must consist of at least 5 characters"
                    },
                    Emp_Address: {
                        required: "Please enter Address",
                        minlength: "Your Address must consist of at least 5 characters"
                    },
                    Emp_State: {
                        required: "Please enter State",
                        minlength: "Your State must consist of at least 3 characters"
                    },
                    Emp_Country: {
                        required: "Please enter Country",
                        minlength: "Your Country must consist of at least 5 characters"
                    },
                    Emp_Phone: {
                        required: "Please enter Phone",
                        minlength: "Your Phone must consist of at least 10 ",
                        number: "Enter Numbers Only"
                    },
                    Emp_Email: {
                        required: "Please enter your Email",
                        email: "Please enter a valid email address",
                    }
                },
                showErrors: function(errorMap, errorList) {
                    $.each(this.successList, function(index, value) {
                        return $(value)
                            .popover("hide");
                    });
                    return $.each(errorList, function(index, value) {
                        var _popover;
                        //console.log(value.message);
                        _popover = $(value.element)
                            .popover({
                                trigger: "manual",
                                placement: "top",
                                content: value.message,
                                template: "<div class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"><p></p></div></div></div>"
                            });
                        _popover.data("popover")
                            .options.content = value.message;
                        return $(value.element)
                            .popover("show");
                    });
                },

                submitHandler: function() {
                    savedata('#gridder_addform','Includes/emp_master.php','<?php echo $token; ?>');
                }
            });
    });

function getvalues(empcode) {
    //var empcode = $("input[name='Emp_Code']:text").val(); 
    if (empcode == null || empcode == undefined || empcode == '') {

    } else {
        $.ajax({
            url: "Includes/emp_master.php",
            data: {
				action:"search",
                empcode: empcode,
				token:'<?php echo $token; ?>'
            },
            type: 'post',
            dataType: "json",
            success: function(output) {
                var siteArray = output.array;
                if (!$.isArray(siteArray) || !siteArray.length) {

                    if (output[0] == 0) {
                        window.alert(output[2]);
                        $("#action")
                            .val("addnew");
                        $("#Emp_ID")
                            .val("");
                        $("#Emp_Name")
                            .val("");
						$("#Emp_Pass")
                            .val("")	
                        $("#Emp_Address")
                            .val("");
                        $("#Emp_State")
                            .val("");
                        $("#Emp_Country")
                            .val("");
                        $("#Emp_Phone")
                            .val("");
                        $("#Emp_Email")
                            .val("");
                        $('#Emp_Role')
                            .val(0)
                            .attr("selected", "selected")
                    } else {
                        $("#action")
                            .val("update");
                        $("#Emp_ID")
                            .val(output[0]);
                        $("#Emp_Code")
                            .val(output[1]);
                        $("#Emp_Name")
                            .val(output[2]);
                        $("#Emp_Address")
                            .val(output[4]);
                        $("#Emp_State")
                            .val(output[5]);
                        $("#Emp_Country")
                            .val(output[6]);
                        $("#Emp_Phone")
                            .val(output[7]);
                        $("#Emp_Email")
                            .val(output[8]);
                        $('#Emp_Role')
                            .val(output[9])
                            .attr("selected", "selected")
						$('#addnew span').text('Edit');
                        $('#myModal').modal('show');

                    }
                }

            }

        });
    }
}

/*function LoadGrid() {
    var gridder = $('#as_gridder');
    gridder.html('loading..');
    $.ajax({
        url: 'includes/emp_master.php',
        type: 'POST',
        data: {
		action:'load',
		token:'<?php echo $token; ?>'
		},
		dataType: "json",
        beforeSend: function() {
		gridder.html("<div class='alert alert-info'>Loading .......</div>");
            },
        success: function(output) {
		if (output[0]== 'ERROR'){
		gridder.html(output[1]);
        }
		else{
		gridder.html(output[1]);
		}
        }
    });
}*/
$('body')
    .delegate("#btncancel", 'click', function() {
        clear()
        return false;
    });
$('body')
    .delegate("#btnrf", 'click', function() {
        clear()
        location.reload(true)
        return false;
    });
$('body')
    .delegate("#btnmodalclose", 'click', function() {
        clear()
        setTimeout(function() {
            location.reload();
        }, 1000);
        $('#myModal').modal('toggle')
        return false;
    });

function clear(){
 $("#action")
            .val("addnew");
        $("#Emp_ID")
            .val("");
        $("#Emp_Code")
            .val("");

        $("#Emp_Name")
            .val("");
        $("#Emp_Pass")
            .val("");
        $("#Emp_Address")
            .val("");
        $("#Emp_State")
            .val("");
        $("#Emp_Country")
            .val("");
        $("#Emp_Phone")
            .val("");
        $("#Emp_Email")
            .val("");
        $('#Emp_Role')
            .val(0)
            .attr("selected", "selected")
			$("#Emp_Code")
            .focus()
		 $('#addnew span').text('Addnew');
}

	 </script>
<div class="container-fuild">
    <div class="container">
        <div class="row">
            <div class="alert alert-info" align="center">
                <h4>Employee Master</h4>
            </div>
            <table width="100%" border="0">
                <tr>
                    <td colspan="3" align="right">
                        <input type="button" id="btnaddnew" value="Add New" title="Add New" class="btn btn-success" data-toggle="modal" data-target="#myModal" />&nbsp;
                        <input type="button" id="btnrf" value="Refresh" title="Refresh" class="btn btn-warning" />
                    </td>
                </tr>
            </table>
            <br>
            <input autocomplete='off' id='filter' class='filter form-control ' name="employeefilter" placeholder="Enter Employee Name to Filter" data-col="Name" />
            <br>
            <?php
			$query 	= $db->select("SELECT tbl_emp_master.*, tblsecurityaccess.AccessTitle FROM tblsecurityaccess RIGHT JOIN tbl_emp_master ON tblsecurityaccess.AccessID = tbl_emp_master.Emp_Role Order by Emp_Code Asc");
		$count  = mysqli_num_rows($query);
if($count > 0) {
			while($fetch = mysqli_fetch_array($query)) {
				$record[] = $fetch;
			}
		}
		$responsetext = "<div class='table-responsive'>
    <table class='table table-condensed table-striped table-hover' id='filtertable'>
        <thead>
            <tr class='alert alert-info'>
                <th>Sno</th>
                <th>Code</th>
                <th>Name</th>
                <th>Role</th>
                <th>Address</th>
                <th>State</th>
                <th>Country</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>";
			if($count <= 0) {
			echo "<tr>
    <td  colspan='10'align='right'>
        <input type='button' id='btnaddnew' value='Add New' title='Add New' class='btn btn-success' data-toggle='modal' data-target='#myModal' />
    </td>
</tr>";
			 } 
			 else {
            $i = 0;
			foreach($record as $records) {
            $i = $i + 1;
			 $responsetext .= "<tr><td>" . $i . "</th><td>" . $records['Emp_Code'] . "</td><td>" . $records['Emp_Name'] . "</td>
				 
				 <td>" . $records['AccessTitle'] . "</td><td>" . $records['Emp_Address'] . "</td><td>" . $records['Emp_State'] . "</td>
				<td>" . $records['Emp_Country'] . "</td><td>" . $records['Emp_Phone'] . "</td><td>" . $records['Emp_Email'] . "</td><td><a href='javascript:getvalues(". $records['Emp_Code'] . ")' <button type='submit'  name='submit-login' id='gridder_addnew' class='btn btn-info'>Edit</button></a></td>
            </tr>";
			
			}
			}
			 $responsetext .="</tbody></table></div>";
			 echo $responsetext;
			?>
			
</div>
</div>
</div>
</div>
<!-- BOF Modal DEL -->
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <br /><div class="alert alert-info" align="center">
    <h4>Employee Master</h4>
</div>

<div class="alert alert-warning" id="addnew" align="center">
    <h4><span>Add new</span></h4> </div>
                
            </div>
            <div class="modal-body">

                <div class="alert alert-success" id="message" align="center"></div>
                <form name="gridder_addform" id="gridder_addform">
			<input type="hidden" name="action" id= "action" value="addnew" />
			<input type="hidden"  name="Emp_ID" id="Emp_ID" class="gridder_add" />
                    <table class="table table-bordered table-striped ">
                       <thead>
      <tr>
        <th >Code</th>
        <th>Name</th>
        <th>Password</th>
        <th>Role</th>	
		<th>Address</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><input type="text"  name="Emp_Code" id="Emp_Code"  onKeyPress="return isNumberKey(event)" onBlur="getvalues(this.value)" autocomplete="off" class="form-control" /></td>
        <td><input type="text"   name="Emp_Name" id="Emp_Name" autocomplete="off" class="form-control" /></td>
        <td><input type="password"    name="Emp_Pass" id="Emp_Pass" autocomplete="off" class="form-control" /></td>
        <td><select name="Emp_Role" id="Emp_Role"  class="form-control"  >
			  <option value="0">Select </option>
               <?php $sql = "SELECT AccessID,AccessTitle FROM tblsecurityaccess";		
					$result = mysqli_query($sql);
					while ($row = mysqli_fetch_array($result)) 
					{
					echo "<option value='" . $row['AccessID'] . "'>" . $row['AccessTitle'] . "</option>";
					}
					?>
                        </select></td>
		<td><input type="text"   name="Emp_Address" id="Emp_Address" autocomplete="off" class="form-control" /></td>
      </tr>     
          </tbody>
		  <thead>
      <tr>
        <th>State</th>
        <th>Country</th>
        <th>Phone</th>
        <th>Email</th>	
		<th>Actions</th>
      </tr>
    </thead>
	<tbody>
      <tr>
        <td><input type="text"   name="Emp_State" id="Emp_State" autocomplete="off" class="form-control" /></td>
        <td><input type="text"    name="Emp_Country" id="Emp_Country" autocomplete="off" class="form-control" /></td>
        <td><input type="text"   name="Emp_Phone" id="Emp_Phone" onKeyPress="return isNumberKey(event)" autocomplete="off" class="form-control" /></td>
        <td><input type="text"   name="Emp_Email" id="Emp_Email" autocomplete="off" class="form-control" /></td>
		<td align="center">
                                <input type="submit" value="Save" class="btn btn-info" id="btnsave" />
                                <input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" />
                            </td>
      </tr>     
          </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id='btnmodalclose'>Close</button>
            </div>
        </div>
    </div>
</div>
<!-- EOF Modal DEL -->
<?php
include 'Includes/footer.php';
?>