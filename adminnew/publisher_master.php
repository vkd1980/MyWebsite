<?php
include 'Includes/header.php';?>
<script type="text/javascript">
$()
    .ready(function() {
        $('.filter').multifilter({
            'target': $('#filtertable')
        })
        $('#message').hide();

        $("#manufacturers_name").focus();
        //LoadGrid();
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
                    savedata('#gridder_addform','Includes/publisher_master.php','<?php echo $token; ?>');

                }

            });
        $('#manufacturers_name').focusout(function() {
            this.value = this.value.toUpperCase();
        });


    });

function getvalues(catid) {
    //var empcode = $("input[name='Emp_Code']:text").val(); 
    if (catid == null || catid == undefined || catid == '') {

    } else {
        $.ajax({
            url: "Includes/publisher_master.php",
            data: {
                action: 'search',
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
                        $('#addnew span').text('Edit');
                        $('#myModal').modal('show');
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


function clear() {
    $("#action")
        .val("addnew");
    $("#manufacturers_id")
        .val("");
    $("#manufacturers_name")
        .val("");
    $("#filter")
        .val("");
    $('#addnew span').text('Addnew');

}

</script>
<div class="container-fuild">
    <div class="container">
        <div class="row">
            <div class="alert alert-info" align="center">
                <h4>Publisher Master</h4>
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
            <input autocomplete='off' id='filter' class='filter form-control ' name="Publisherfilter" placeholder="Enter Publisher Name to Filter" data-col="Publisher" />
            <br>
            <?php
$query 	= $db->select("SELECT * FROM manufacturers ORDER BY manufacturers_name");
	$count  = mysql_num_rows($query);
		if($count > 0) {
			while($fetch = mysql_fetch_array($query)) {
				$record[] = $fetch;
			}
		}
		
		 $responsetext="<div class='table-responsive'>
    <table class='table table-condensed table-striped table-hover' id='filtertable'>
        <thead>
            <tr class='alert alert-info'>
                <th>Sno</th>
                <th>Publisher</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>";
               
            if($count <= 0) {
            
            $responsetext .="<tr>
    <td colspan='3' align='right'>
        <input type='button' id='btnaddnew' value='Add New' title='Add New' class='btn btn-success' data-toggle='modal' data-target='#myModal' />
    </td>
</tr>";
             } else {
            $i = 0;
            foreach($record as $records) {
            $i = $i + 1;
            
           $responsetext .="<tr>
    <td style='border: none;'>" . $i."</td>
    <td style='border: none;'>" . $records['manufacturers_name']."</td>
    <td style='border: none;'><a href='javascript:getvalues(".$records['manufacturers_id'].")' <button type='submit' name='submit-login' id='gridder_addnew' class='btn btn-info'>Edit</button></a>
    </td>
</tr>";
           
                }
            }
           
             $responsetext .="</tbody>
</table>
</div>";
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
                <br /><div class="alert alert-info" align="center">
    <h4>Publisher Master</h4>
</div>

<div class="alert alert-warning" id="addnew" align="center">
    <h4><span>Add new</span></h4> </div>
                
            </div>
            <div class="modal-body">

                <div class="alert alert-success" id="message" align="center"></div>
                <form name="gridder_addform" id="gridder_addform">
                    <input type="hidden" name="action" id="action" value="addnew" />
                    <input type="hidden" name="manufacturers_id" id="manufacturers_id" class="gridder_add" />
                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <td>Publisher Name</th>
                                    <td>Action</th>
                            </tr>
                        </thead>
                        <tr>
                            <td>
                                <input type="text" name="manufacturers_name" id="manufacturers_name" autocomplete="off" class="form-control" />
                            </td>
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