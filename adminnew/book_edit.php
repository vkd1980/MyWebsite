<?php
include 'Includes/header.php';?>
<script type="text/javascript">
$()
    .ready(function() {
        $('.filter').multifilter({
            'target': $('#filtertable')
        })
        $('#message').hide();

       // $("#manufacturers_name").focus();
        //LoadGrid();
        $("#gridder_addform")
            .validate({
                rules: {
                    products_quantity: {
                        minlength: 1,
                        required: true,
						number: true
                    }

                },
                messages: {
                    products_quantity: {
                        required: "Please enter product Quantity",
                        minlength: "quantity should be atleast 0 or 1",
						number: "Enter in Digits"
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
                    savedata('#gridder_addform','Includes/book_edit.php','<?php echo $token; ?>');

                }

            });
       

    });

function getvalues(catid) {
    //var empcode = $("input[name='Emp_Code']:text").val(); 
    if (catid == null || catid == undefined || catid == '') {

    } else {
        $.ajax({
            url: "Includes/book_edit.php",
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
                        $("#products_id")
                            .val("");
                        $("#products_name")
                            .val("");

                    } else {
                        $("#action")
                            .val("update");
                        $("#products_id")
                            .val(output[0]);
						$("#products_model")
                            .text(output[1]);
						$("#products_author")
                            .text(output[2]);
                        $("#products_name")
                            .text(output[3]);
						$("#products_quantity")
                            .val(output[4]);
						$("#products_rate")
                            .text(output[5]);
						$('#addnew span').text('Edit');
                        $('#myModal').modal('show');
                        $("#products_quantity").focus();

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
    $("#products_id")
        .val("");
    $("#products_quantity")
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
                <h4>Book Stock Edit</h4>
            </div>
			<form method="post">
			<table class="table table-bordered table-striped ">
<td width="90%" c><?php		$sql = "SELECT categories.*,categories_description.*
FROM categories
LEFT JOIN categories_description ON categories.categories_id = categories_description.categories_id";
		
$result = mysql_query($sql);

echo "<select name='catid' class='form-control'>";
?><option value='%'>All Subject</option><?php
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['categories_id'] . "'>" . $row['categories_name'] . "</option>";
}
echo "</select>";
?></td>
<td><input type="submit" value="View" class="btn btn-info " /></td>
</table>
			
            
			</form>
            <br>
            <input autocomplete='off' id='filter' class='filter form-control ' name="Publisherfilter" placeholder="Enter Publisher Name to Filter" data-col="Title" />
            <br>
            <?php
			if (isset($_REQUEST['catid']) && $_REQUEST['catid'] != "") {
			$catid = isset($_REQUEST['catid']) ? mysql_real_escape_string($_REQUEST['catid']) : '';
$query 	= $db->select("SELECT products.products_id, products.products_model,
 products_description.products_author, products_description.products_name,products.products_rate,
 products.products_quantity,products.master_categories_id
FROM products
LEFT JOIN products_description ON products.products_id = products_description.products_id
WHERE products.master_categories_id=$catid
ORDER BY products.products_id;");
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
                <th>ISBN</th>
				<th>Author</th>
				<th>Title</th>
				<th>Qty</th>
				<th>Price</th>
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
    <td style='border: none;'>" . $records['products_model']."</td>
	<td style='border: none;'>" . $records['products_author']."</td>
	<td style='border: none;'>" . $records['products_name']."</td>
	<td style='border: none;'>" . $records['products_quantity']."</td>
	<td style='border: none;'>" . $records['products_rate']."</td>
    <td style='border: none;'><a href='javascript:getvalues(".$records['products_id'].")' <button type='submit' name='submit-login' id='gridder_addnew' class='btn btn-info'>Edit</button></a>
    </td>
</tr>";
           
                }
            }
           
             $responsetext .="</tbody>
</table>
</div>";
			 echo $responsetext;
			 }
			 else{
			 echo " Select Subject to View Books";
			 }
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
    <h4>Book Stock Edit</h4>
</div>

<div class="alert alert-warning" id="addnew" align="center">
    <h4><span>Add new</span></h4> </div>
                
            </div>
            <div class="modal-body">

                <div class="alert alert-success" id="message" align="center"></div>
                <form name="gridder_addform" id="gridder_addform">
                    <input type="hidden" name="action" id="action" value="addnew" />
                    <input type="hidden" name="products_id" id="products_id" class="gridder_add" />
                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
								<th>ISBN</th>
								<th>Author</th>
								<th>Title</th>
								<th>Qty</th>
								<th>Price</th>
								<th>Actions</th>
                                                            </tr>
                        </thead>
                        <tr>
                            
                                <td style='border: none;' id="products_model"></td>
								<td style='border: none;' id="products_author"></td>
								<td style='border: none;' id="products_name"></td>
																
								<td>
                                <input type="text" name="products_quantity" id="products_quantity" autocomplete="off" class="form-control" size="10" />
                            </td>
								<td style='border: none;' id="products_rate"></td>
                           						
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