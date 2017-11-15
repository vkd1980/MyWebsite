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
	$("#title").focus();
        LoadGrid();
		$('#message').hide();
		 $("#gridder_addform")
            .validate({
                rules: {
				title:{
					required: true,
					minlength: 4
				},
                    code:{
					required: true,
					minlength: 3
				},
				symbol_left:{
					required: true
				},
				value:{
					required: true,
					number:true
				}
				
                },
                messages: {
				 title: {
                        required: "Please enter Currency Name",
                        minlength: "CUR Name must consist of at least 4 characters"
                    },
					code: {
                        required: "Please enter Currency Code",
                        minlength: "Code Name must consist of at least 3 characters"
                    },
					symbol_left: {
                        required: "Please enter Currency Symbol"
                    },
					value: {
                        required: "Please enter Currency Value",
						number:"Please Enter digits only"
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
                                  }
            });
				$('#title').focusout(function(){
				this.value = this.value.toUpperCase();
				});
				$('#code').focusout(function(){
				this.value = this.value.toUpperCase();
				});
				$('#value').focusout(function(){
				this.value =numeral(this.value).format('0.00');
				});
			  });
		 
function LoadGrid() {
    var gridder = $('#as_gridder');
    var UrlToPass = 'action=load';
    //gridder.html('loading..');
    $.ajax({
        url: 'includes/cur_master.php',
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
            url: "includes/cur_master.php",
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
                        clear() 
						
                    } else {
                        $("#action")
                            .val("update");
                        $("#title")
                            .val(output[0]);
                        $("#code")
                            .val(output[1]);
                        $('#symbol_left')
                            .val(output[2])			
						 $("#symbol_right")
						  	.val(output[3])
						 $("#value")
						  	.val(output[4])
						 $("#currencies_id")
						  	.val(output[5])
							$("#title")
                            .focus()
                    }
                }

            }

        });
    }
}
function clear(){
						$("#action")
                            .val("addnew")
                        $("#currencies_id")
                            .val("")
                        $("#title")
                            .val("")
						$('#code')
                            .val("")
                         $('#symbol_left')
                            .val("")			
						 $("#symbol_right")
						  	.val("")
						 $("#value")
						  	.val("") 
}
$('body')
    .delegate("#btncancel", 'click', function() {
        clear();
		LoadGrid();
        return false;
    });

</script>
<div class="container-fuild">
<div class="container">
<div class="row">
<div class="alert alert-success" id="message" align="center"></div>
<div class="alert alert-info" align="center" ><h4>Currency Master</h4></div>
<div class="alert well" align="center">
<form name="gridder_addform" id="gridder_addform">
<input type="hidden" name="action" id= "action" value="addnew" />
<input type="hidden"  name="currencies_id" id="currencies_id" class="gridder_add" />
<table class="table table-bordered table-striped "  >
<thead>
<tr>
<th  width="200">Title</th>
<th  width="128">Code</th>
<th  width="100">Symbol Left</th>
<th  width="100">Symbol Right</th>
<th  width="125">Value</th>
<th  width="160">Action</th>

</tr>
</thead>
<tr>
<td><input type="text"  name="title" id="title"  autocomplete="off" class="form-control" /></td>
<td><input type="text"  name="code" id="code"  autocomplete="off" class="form-control" /></td>
<td><input type="text"  name="symbol_left" id="symbol_left"  autocomplete="off" class="form-control" /></td>
<td><input type="text"  name="symbol_right" id="symbol_right"  autocomplete="off" class="form-control" /></td>
<td ><input type="text"  name="value" id="value"  autocomplete="off" class="form-control" style="text-align:right" /></td>

<td><input type="submit" value="Save" class="btn btn-info" id="btnsave" /> 
		  <input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
</tr>
</table>
</form>
</div>
</div>
</div>
<div class="container"> <div class="row" id="as_gridder"></div> </div><!-- GRID LOADER --><br class="clearBoth" />
</div>
<?php
include 'includes/footer.php';
?>
