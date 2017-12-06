<?php
include 'Includes/header.php';
?>
<script type="text/javascript">
$()
    .ready(function() {
        $("#categories_name").focus();
        $('.filter').multifilter({
            'target': $('#filtertable')
        })
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
                   savedata('#gridder_addform','Includes/subject_master.php','<?php echo $token; ?>');
                }
            });
        $('#categories_name').focusout(function() {
            this.value = this.value.toUpperCase();
        });

    });

function getvalues(catid) {
    //var empcode = $("input[name='Emp_Code']:text").val();
    if (catid == null || catid == undefined || catid == '') {

    } else {
        $.ajax({
            url: "Includes/subject_master.php",
            data: {
                action: "search",
                catid: catid,
                token: '<?php echo $token; ?>'
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
                        $('#addnew span').text('Edit');
                        $('#myModal').modal('show');
                        $("#categories_name").focus();

                    }
                }

            }

        });
    }
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
        }, 2000);
        $('#myModal').modal('toggle')

        return false;
    });

function clear() {
    $("#action")
        .val("addnew");
    $("#categories_id")
        .val("");
    $("#categories_name")
        .val("");
    $('#parent_id')
        .val(-1)
        .attr("selected", "selected")
    $('#addnew span').text('Addnew');

}
</script>
<div class="container-fuild">
    <div class="container">
        <div class="row">
            <div class="alert alert-info" align="center">
                <h4>Subject Master</h4>
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
            <input autocomplete='off' id='filter' class='filter form-control ' name="subjectfilter" placeholder="Enter Subject to Filter" data-col="Category" />
            <br>

			<?php
			$query 	= $db->select('SELECT *
FROM categories
ORDER BY categories_name') ;
$count  = mysqli_num_rows($query);
if($count > 0) {
			while($fetch = mysqli_fetch_array($query)) {
				$record[] = $fetch;
			}
		}
		$responsetext="<div class='table-responsive'>
            		<table class='table table-condensed table-striped table-hover' id='filtertable'>
					<thead>
					<tr class='alert alert-info'>
              	<th >Sno</div></th>
               	<th >Category</div></th>
              	<th >Parent Category</div></th>
               	<th >Actions</div></th>
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
			 $responsetext .= "<tr><td>". $i." </td><td>". $records['categories_name']."</td>";
			if ($records['parent_id']=="0")
				{
				 $responsetext .= "<td> - </td>";

					}
					else{

					 $responsetext .="<td>" . $records['parent_id']  . "</td>";
						}
						$responsetext .="<td>
				<a href='javascript:getvalues(" . $records['categories_id'] . ")' <button type='submit'  name='submit-login' id='gridder_addnew'class='btn btn-info'>Edit</button></a></td>
            </tr>
			 ";

			}
			}
			 $responsetext .="</tbody></table></div>";
			 echo $responsetext;
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
                <br /><div class="alert alert-info " align="center">
    <h4>Subject Master</h4>
</div>

<div class="alert alert-warning" id="addnew" align="center">
    <h4><span>Add new</span></h4> </div>

            </div>
            <div class="modal-body">
			<div class="alert alert-success" id="message" align="center"></div>
			<!-- form-->
			<form name="gridder_addform" id="gridder_addform">
<input type="hidden" name="action" id= "action" value="addnew" />
<input type="hidden"  name="categories_id" id="categories_id" class="gridder_add" />
<table class="table table-bordered table-striped ">
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
                            <td align="center">
                                <input type="submit" value="Save" class="btn btn-info" id="btnsave" />
                                <input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" />
                            </td>
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
