<?php
include 'Includes/header.php';
?>
<script type="text/javascript">
$()
    .ready(function() {
	$("#title").focus();
       $('.filter').multifilter({
            'target': $('#filtertable')
        })
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
				savedata('#gridder_addform','Includes/cur_master.php','<?php echo $token; ?>');
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
		 

function getvalues(catid) {
    //var empcode = $("input[name='Emp_Code']:text").val(); 
    if (catid == null || catid == undefined || catid == '') {

    } else {
        $.ajax({
            url: "Includes/cur_master.php",
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
							$('#addnew span').text('Edit');
                        $('#myModal').modal('show');
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
						$('#addnew span')
							.text('Addnew');
}
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
	
</script>
<div class="container-fuild">
    <div class="container">
        <div class="row">
            <div class="alert alert-info" align="center">
                <h4>Currency Master</h4>
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
            <input autocomplete='off' id='filter' class='filter form-control ' name="Publisherfilter" placeholder="Enter Currency Title to Filter" data-col="Title" />
            <br>
            <?php
			mysql_query('SET CHARACTER SET utf8');
			$query 	= $db->select('SELECT * FROM `currencies`  ORDER BY title');
	$count  = mysql_num_rows($query);
	if($count > 0) {
			while($fetch = mysql_fetch_array($query)) {
				$record[] = $fetch;
			}
		}
		$responsetext="<div class='table-responsive'>
            		<table class='table table-condensed table-striped table-hover' id='filtertable' >
					<thead>
					<tr class='alert alert-info'>
					<th >Sno</div></th>
              	<th >Title</th>
				<th >Code</th>
				<th >Symbol Left</th>
				<th>Symbol Right</th>
				<th style='text-align:right'>Value</th>
				<th style='text-align:right'>Action</th>
            		</tr>
					</thead>
			<tbody>";
		if($count <= 0) {
		echo "<tr id='norecords'>
                <td colspan='12' align='center'>No records found <a href='addnew' id='gridder_insert' class='gridder_insert'><img src='includes/images/insert.png' alt='Add New' title='Add New' /></a></td>
            </tr>";
				 } 
				 else {
            $i = 0;
			foreach($record as $records) {
            $i = $i + 1;
			 $responsetext .= "<tr><td>". $i." </td>
			 		<td>". $records['title']."</td>			
					 <td>" . $records['code']  . "</td>
					 <td>" . $records['symbol_left']  . "</td>
					 <td>" . $records['symbol_right']  . "</td>
					 <td align='right'>" . $records['value']  . "</td>
					 				 				<td align='right'><a href='javascript:getvalues(" . $records['currencies_id'] . ")' <button type='submit'  name='submit-login' id='gridder_addnew'class='btn btn-info'>Edit</button></a>
				</td>
            </tr>";
			
			}
			}
			 $responsetext .="</tbody></table></div>";
			 echo $responsetext ;
			?>

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
    <h4>Currency Master</h4>
</div>

<div class="alert alert-warning" id="addnew" align="center">
    <h4><span>Add new</span></h4> </div>
                
            </div>
            <div class="modal-body">

                <div class="alert alert-success" id="message" align="center"></div>
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