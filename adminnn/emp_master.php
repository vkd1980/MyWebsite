<?php
include'includes/header.php';
if(!isset($_SESSION['logged_in'])) {
header("Location: index.php");
	}
?>
<script type="text/javascript">
$()
    .ready(function() {
        LoadGrid();
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
                    savedata();
                }
            });
    });

function savedata() {
    var datav = $('#gridder_addform')
        .serialize();
		$.ajax({
        url: 'includes/emp_master.php',
        type: 'POST',
        data: "token=<?php echo $token; ?>&" + datav,
		dataType: "json",
		beforeSend: function() {
		$("#message").removeClass('alert-success');
		$("#message").addClass('alert-danger');
        $('#message').text('Please Wait.....'); 
            },
        success: function(output) {
		if (output[0]== 'OK'){
		$("#message").removeClass('alert-danger');
		$("#message").addClass('alert-success');
		$("#message").fadeIn();
		$('#message').text(output[1]);
		$('#message').delay(10000).fadeOut();
			clear()
        LoadGrid();}
		else{
		$("#message").fadeIn();
		$("#message").removeClass('alert-success');
		$("#message").addClass('alert-danger');
		$('#message').text(output[1]);
		$('#message').delay(10000).fadeOut();
			clear()
		}
        }
    });
}

function getvalues(empcode) {
    //var empcode = $("input[name='Emp_Code']:text").val(); 
    if (empcode == null || empcode == undefined || empcode == '') {

    } else {
        $.ajax({
            url: "includes/emp_master.php",
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

                    }
                }

            }

        });
    }
}

function LoadGrid() {
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
}
$('body')
    .delegate("#btncancel", 'click', function() {
       	clear()
        LoadGrid()
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
}

	 </script>
<div class="container-fuild">
<div class="container">
<div class="row">
<div class="alert alert-success" id="message" align="center"></div>
			<form name="gridder_addform" id="gridder_addform">
			<input type="hidden" name="action" id= "action" value="addnew" />
			<input type="hidden"  name="Emp_ID" id="Emp_ID" class="gridder_add" />
			<div class="alert alert-info" align="center" ><h4>Employee Master</h4></div>
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
					$result = mysql_query($sql);
					while ($row = mysql_fetch_array($result)) 
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
		<td><input type="submit" value="Save" class="btn btn-info" id="btnsave" /> 
		  <input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
      </tr>     
          </tbody>
  </table>
  </form>
</div>
</div>
<div class="container"> <div class="row" id="as_gridder"></div> </div><!-- GRID LOADER --><br class="clearBoth" />
</div>