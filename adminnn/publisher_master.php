<?php
include'includes/header.php';
if(!isset($_SESSION['logged_in'])) {
header("Location: login.php");
	}
?>
<script type="text/javascript">
$()
    .ready(function() {
	$('.filter').multifilter();
	$('#message').hide();
	$("#manufacturers_name").focus();
        LoadGrid();
				$("#gridder_addform")
            .validate({
                rules: {
                    manufacturers_name: {
                        minlength: 2,
                        required: true
                    }

                },
                messages: {
                    manufacturers_name: {
                        required: "Please enter Publisher Name",
                        minlength: "Publisher Name must consist of at least 2 characters"
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
$('#manufacturers_name').focusout(function(){
this.value = this.value.toUpperCase();
});


		  });
function LoadGrid() {
    var gridder = $('#as_gridder');
       $.ajax({
        url: 'includes/publisher_master.php',
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
		gridder.html(+output[1]);
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
            url: "includes/publisher_master.php",
            data: {
				action:'search',
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
                        $("#manufacturers_id")
                            .val("");
                        $("#manufacturers_name")
                            .val("");
											
                    } else {
                        $("#action")
                            .val("update");
                        $("#manufacturers_id")
                            .val(output[0]);
                        $("#manufacturers_name")
                            .val(output[1]);
                        $("#manufacturers_name").focus();

                    }
                }

            }

        });
    }
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
        $("#manufacturers_id")
            .val("");
        $("#manufacturers_name")
            .val("");
	}
function savedata() {
    var data = $('#gridder_addform')
        .serialize();
    $.ajax({
        url: 'includes/publisher_master.php',
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
			<input type="hidden"  name="manufacturers_id" id="manufacturers_id" class="gridder_add" />
<div class="alert alert-info" align="center" ><h4>Publisher Master</h4></div>
<div class="alert well" align="center" >
<table class="table table-bordered table-striped "  >
<thead>
<tr>
<th>Publisher Name</th>
<th>Action</th>
</tr>
</thead>
<tr>
<td><input type="text"  name="manufacturers_name" id="manufacturers_name"  autocomplete="off" class="form-control" /></td>
<td align="center"><input type="submit" value="Save" class="btn btn-info" id="btnsave" /> 
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
