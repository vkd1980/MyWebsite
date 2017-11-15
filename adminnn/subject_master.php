<?php
include'includes/header.php';
$now=time();
if(!isset($_SESSION['logged_in'])) {
header("Location: index.php");
	}
?>
<script type="text/javascript">
$()
    .ready(function() {
	$("#categories_name").focus();
        LoadGrid();
		$('#message').hide();
		 $.validator.addMethod("selectcat", function(value, element, arg) {
            return arg != value;
        }, "Select Parent Category.");
		$("#gridder_addform")
            .validate({
                rules: {
                    categories_name: {
                        minlength: 4,
                        required: true
                    },
					parent_id: {
                        selectcat: "-1",
                        required: true
                    }

                },
                messages: {
                    categories_name: {
                        required: "Please enter Category Name",
                        minlength: "Category Name must consist of at least 5 characters"
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
$('#categories_name').focusout(function(){
this.value = this.value.toUpperCase();
});
   
		  });
function LoadGrid() {
    var gridder = $('#as_gridder');
    var UrlToPass = 'action=load';
    //gridder.html('loading..');
    $.ajax({
        url: 'includes/subject_master.php',
        type: 'POST',
        data: {
		action:'load',
		token:'<?php echo $token; ?>'
		},
		dataType: "json",
        beforeSend: function() {
		gridder.html("<div class='alert alert-info' align='center'> <img src='includes/images/loading.gif' /> Loading .......</div>");
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
function getvalues(catid) {
    //var empcode = $("input[name='Emp_Code']:text").val(); 
    if (catid == null || catid == undefined || catid == '') {

    } else {
        $.ajax({
            url: "includes/subject_master.php",
            	data: {
				action:"search",
                catid: catid,
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
                        $("#categories_id")
                            .val("");
                        $("#categories_name")
                            .val("");
						$('#parent_id')
                            .val(-1)
                            .attr("selected", "selected");
						
                    } else {
                        $("#action")
                            .val("update");
                        $("#categories_id")
                            .val(output[0]);
                        $("#categories_name")
                            .val(output[2]);
                        $('#parent_id')
                            .val(output[1])
                            .attr("selected", "selected")
							$("#categories_name").focus();

                    }
                }

            }

        });
    }
}
$('body')
    .delegate("#btncancel", 'click', function() {
        clear();
		LoadGrid();
        return false;
    });
	function clear(){
	 $("#action")
            .val("addnew");
        $("#categories_id")
            .val("");
        $("#categories_name")
            .val("");
		$('#parent_id')
            .val(-1)
            .attr("selected", "selected")
	}
function savedata() {
    var data = $('#gridder_addform')
        .serialize();
    $.ajax({
        url: 'includes/subject_master.php',
        type: 'POST',
		data: "token=<?php echo $token; ?>&" + data,
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
		LoadGrid();
		clear();
        }
		else{
		$("#message").fadeIn();
		$("#message").removeClass('alert-success');
		$("#message").addClass('alert-danger');
		$('#message').text(output[1]);
		$('#message').delay(10000).fadeOut();
		}
        }
    });
}
</script>
<div class="container-fuild">
<div class="container">
<div class="row">
<div class="alert alert-success" id="message" align="center"></div>
<form name="gridder_addform" id="gridder_addform">
<input type="hidden" name="action" id= "action" value="addnew" />
<input type="hidden"  name="categories_id" id="categories_id" class="gridder_add" />
<div class="alert alert-info" align="center" ><h4>Subject Master</h4></div>
<div class="alert well" align="center" >
<table class="table table-bordered table-striped "  >
<thead>
<tr>
<td>Category Name</td>
<td>Parent Category</td>
<td>Action</td>
</tr>
</thead>
<tr>
<td><input type="text"  name="categories_name" id="categories_name"  autocomplete="off" class="form-control" /></td>
<td><select name="parent_id" id="parent_id"  class="form-control"  >
			 <option value="-1">Select </option>
			  <option value="0">Parent Category </option>
               <?php $sql = "SELECT categories_id,categories_name FROM categories WHERE parent_id='0' ORDER BY categories_name";		
					$result = mysql_query($sql);
					while ($row = mysql_fetch_array($result)) 
					{
					echo "<option value='" . $row['categories_id'] . "'>" . $row['categories_name'] . "</option>";
					}
					?>
                        </select></td>
<td><input type="submit" value="Save" class="btn btn-info" id="btnsave" /> 
		  <input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
</tr>

</table>	
</div>
</form>

</div>
</div>
<div class="container"> <div class="row" id="as_gridder"></div> </div><!-- GRID LOADER --><br class="clearBoth" />
</div>
<?php
include 'includes/footer.php';
?>
