<?php
include'includes/header.php';
$now=time();
if(!isset($_SESSION['logged_in'])) {
header("Location: index.php");
	}
	
?>
<script type="text/javascript">
$().ready( function() {
        $("#Account_Code").focus();
        $("#Bill_Date").val($.datepicker.formatDate("dd/mm/yy", new Date()));
        $("#Name").val("CASH");
        $.validator.addMethod("checkforzero", function(value, element, arg) {
            return arg != value;
        }, "Value Cannot Be Zero.");
        validatee()
    });
	$(function() {
    // GET ID OF last row and increment it by one
    var $lastChar = 1,
        $newRow;
    $get_lastID = function() {
        var $id = $('#invoice_details_table tr:last-child td:first-child input').attr("id");
        $lastChar = parseInt($id, 10);
        //console.log('GET id: ' + $lastChar + ' | $id :'+$id);
        $lastChar = $lastChar + 1;
        //console.log('Last Char :'+$lastChar);
        $newRow = "<tr> \
					<td width='5%' align='centre'><input type='text' readonly='true' disabled='disabled' name='slno_[]'   id='" + $lastChar + "' value='" + $lastChar + "' class='slnumber form-control'   /></td>\
					<input type='hidden' name='Product_ID[]' id='Product_ID_" + $lastChar + "' value='' class='Product_ID'/>\
					<input type='hidden' name='Cur_ID[]' id='Cur_ID_" + $lastChar + "'value='' class='Cur_ID form-control'/>\
					<td width='13%' align='centre'><input type='text' name='isbn[]'  onblur='getbookvalues(this.value,this.id)'id='isbn_" + $lastChar + "' class='isbn form-control' /></td>\
<td width='30%' align='centre'><input type='text' readonly='true' name='title[]'id='title_" + $lastChar + "' disabled='disabled'  class='title form-control' /></td>\
					  <td width='5%' align='centre'><input type='text' name='Qty[]' id='Qty_" + $lastChar + "' onblur='Calculateamount(this.id)' onKeyPress='return isNumberKey(event)' class='Qty form-control' /></td>\
<td width='5%' align='centre'><input type='text' readonly='true' disabled='disabled' name='Cur[]'id='Cur_" + $lastChar + "'  class='Cur form-control' /></td>\
<td width='5%' align='centre'><input type='text' readonly='true' tabindex = '-1' name='rate[]' id='rate_" + $lastChar + "'style='text-align:right;' onKeyPress='return isNumberKeydecimal(event)' class='rate form-control' /></td>\
<td width='12%' align='centre'><input type='text' readonly='true' name='price[]'id='price_" + $lastChar + "' tabindex = '-1' style='text-align:right;' class='price form-control' /></td>\
<td width='5%' align='centre'><input type='text' name='disc[]' id='disc_" + $lastChar + "'  onblur='Calculateamount(this.id)' onKeyPress='return isNumberKeydecimal(event)' class='disc form-control'/></td>\
<td width='11%' align='centre'><input type='text' readonly='true' name='Amount[]'id='Amount_" + $lastChar + "'tabindex = '-1' class='amt form-control' style='text-align:right;' /></td>\
<td width='5%'><input type='button' value='-' class='del_ExpenseRow btn btn-primary' /></td>\
				</tr>"
        return $newRow;
    }

    $('#add_ExpenseRow')
        .on("click", function() {
            $get_lastID();
            $('#invoice_details_table tbody')
                .append($newRow);
            $('#invoice_details_table tr:last-child input[name^=isbn]')
                .focus();
            //console.log(id);
        });


    $("#invoice_details_table")
        .on('click', '.del_ExpenseRow', function(e) {
            var whichtr = $(this)
                .closest("tr");
            whichtr.remove();
            //console.log('Last char now;'+$lastChar);
            $(".slnumber")
                .each(function(index) {
                    $(this).attr("id", index + 1);
                    $(this).val(index + 1);
                });
            $(".isbn").each(function(index) {
                    var isbnid = index + 1
                    $(this)
                        .attr("id", 'isbn_' + isbnid);
                });
            $(".Product_ID")
                .each(function(index) {
                    var prodid = index + 1
                    $(this)
                        .attr("id", 'Product_ID_' + prodid);
                });
            $(".Cur_ID")
                .each(function(index) {
                    var curid = index + 1
                    $(this)
                        .attr("id", 'Cur_ID_' + curid);
                });
            $(".title")
                .each(function(index) {
                    var titid = index + 1
                    $(this)
                        .attr("id", 'title_' + titid);
                });
            $(".Qty")
                .each(function(index) {
                    var qtyid = index + 1
                    $(this)
                        .attr("id", 'Qty_' + qtyid);
                });
            $(".Cur")
                .each(function(index) {
                    var cid = index + 1
                    $(this)
                        .attr("id", 'Cur_' + cid);
                });
            $(".rate")
                .each(function(index) {
                    var rid = index + 1
                    $(this)
                        .attr("id", 'rate_' + rid);
                });
            $(".price")
                .each(function(index) {
                    var pid = index + 1
                    $(this)
                        .attr("id", 'price_' + pid);
                });
            $(".disc")
                .each(function(index) {
                    var did = index + 1
                    $(this)
                        .attr("id", 'disc_' + did);
                });
            $(".amt")
                .each(function(index) {
                    var aid = index + 1
                    $(this)
                        .attr("id", 'Amount_' + aid);
                });
            $lastChar = $lastChar - 1;
        });
});
$("body")
    .delegate(".form-control.datepiker", "focusin", function() {
        var ThisElement = $(this);
        $(this)
            .datepicker({
                dateFormat: 'dd/mm/yy'
            });
    });

function getbookvalues(isbn, isbnid) {
    isbnid = parseInt(isbnid.replace(/[^\d.]/g, ''), 10);

    //var empcode = $("input[name='Emp_Code']:text").val(); 
    if (isbn == null || isbn == undefined || isbn == '') {

    } else {
        $.ajax({
            url: "includes/books_master.php?action=search",
            data: {
                "isbn": isbn
            },
            type: 'post',
            dataType: "json",
            success: function(output) {
                var siteArray = output.array;
                if (!$.isArray(siteArray) || !siteArray.length) {
                    //console.log(output);
                    if (output[0] == 0) {
                        window.alert(output[2]);
                        $("#isbn_" + isbnid)
                            .val("");
                        $("#isbn_" + isbnid)
                            .focus();
                    } else {
                        $("#Product_ID_" + isbnid)
                            .val(output[0]);
                        $("#_" + isbnid)
                            .val(output[0]);
                        $("#isbn_" + isbnid)
                            .val(output[1]);
                        $("#Cur_ID_" + isbnid)
                            .val(output[4]);
                        $("#title_" + isbnid)
                            .val(output[2] + " : " + output[3]);
                        $("#Qty_" + isbnid)
                            .val(1);
                        $("#Cur_" + isbnid)
                            .val(output[5]);
                        $("#rate_" + isbnid)
                            .val(numeral(output[6])
                                .format('0.00'));
                        $("#price_" + isbnid)
                            .val(numeral(output[7])
                                .format('0.00'));
                        $("#disc_" + isbnid)
                            .val(numeral(0)
                                .format('0.00'));
                        $("#Amount_" + isbnid)
                            .val(numeral(output[6] * output[7] * 1)
                                .format('0.00'));


                    }
                }

            }

        });
    }
}
function validatee(){

$("#frmcashbillmaster").validate({
                rules: {
                    'isbn[]': {
                        required: true
                    },
                    'Qty[]': {
                        required: true,
                        checkforzero: "0"
                    },
                    'disc[]': {
                        required: true
                    },
                    Amount: {
                        checkforzero: "0.00"
                    },
                    Account_Code: {
                        required: true,
                        checkforzero: "0"
                    }
                },
                messages: {
                    'isbn[]': {
                        required: "Please Enter Product Code or Delete the Row"
                    },
                    'Qty[]': {
                        required: "Qty Cannot be Blank"
                    },
                    'disc[]': {
                        required: "Disc Cannot be Blank"
                    },
                    Account_Code: {
                        required: "Select Pay Mode"
                    }
                },
                showErrors: function(errorMap, errorList) {
                    $.each(this.successList, function(index, value) {
                        return $(value).popover("hide");
                    });
                    return $.each(errorList, function(index, value) {
                        var _popover;
                        //console.log(value.message);
                        _popover = $(value.element).popover({
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
                    //alert("Submitted");
                }
            });
			}
</script>
<div class="panel panel-primary well">
<div class="panel-heading"><h2 align="center">Cash Bill</h2></div>
<form name="frmcashbillmaster" id="frmcashbillmaster" action="post.php" >
<table class="table table-condensed">
  <thead>
    <tr>
      <th class="col-md-1">No</th>
      <th class="col-md-2">Date</th>
      <th class="col-md-3">Paymode</th>
      <th class="col-md-2">Name</th>
	  <th class="col-md-2">Address</th>
	  <th class="col-md-2">Mob Number</th>
	   <th >&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="text" name="Cashbill_No" value="#"  class="form-control"></td>
      <td><input type="text" id="Bill_Date" name="Bill_Date"  class="form-control datepiker" autocomplete="off" /></td>
	  <input type="hidden" name="Finyear_ID" value="<?php echo $_SESSION["FinYearID"]; ?>" >
			<input type="hidden" name="Emp_ID" value="<?php $user = unserialize($_SESSION['user']);$Emp_ID = $user->Emp_ID; echo $Emp_ID ;?>" >
      <td><select name="Account_Code" id="AccountCode" class="form-control"  >
				<option value="0">Select</option>
				<?php $sql = "SELECT Account_ID,Account_Name FROM tbl_account_master WHERE cashorbank=1 AND Accounts_Group_ID=3 ORDER BY Account_Name ";		
					$result = mysql_query($sql);
					while ($row = mysql_fetch_array($result)) 
					{
					echo "<option value='" . $row['Account_ID'] . "'>" . $row['Account_Name'] . "</option>";
					}
					?>
				</select></td>
      <td><input  type="text" id="Name" name="Name"  class="form-control" autocomplete="off"></td>
	  <td><input type="text" id="Address" name="Address"  class="form-control" autocomplete="off" /></td>
	  <td><input type="text" id="Mob_No" name="Mob_No" onkeypress=" return isNumberKey(event)" class="form-control" autocomplete="off" /></td>
	  <td>&nbsp;</td>
    </tr>
      </tbody>
</table>
<table class="table table-condensed" id="invoice_details_table" cellpadding="1" cellspacing="1">
<thead>	
<tr>
<th width="7%">Sl No</th>
<th width="13%">ISBN/Code</th>
<th width="25%">Title</th>
<th width="7%" >Qty</th>
<th width="7%">Cur</th>
<th width="7%">Rate</th>
<th width="10%">Price</th>
<th width="7%">Disc</th>
<th width="12%">Amount</th>
<th width="5%" >&nbsp;</th>
</tr>
</thead>
<tbody>	
<tr>
<td><input type="text" readonly="true" disabled="disabled" name="slno_[]"   id="1" value="1" class="slnumber form-control"   /></td>
<input type="hidden" name="Product_ID[]" id="Product_ID_1" value="" class="Product_ID form-control"/>
					<input type="hidden" name="Cur_ID[]" id="Cur_ID_1"value="" class="Cur_ID form-control" />	
<td><input type="text" name="isbn[]"  onblur="getbookvalues(this.value,this.id)"id="isbn_1" class="isbn form-control"  autocomplete="off" /></td>
<td><input type="text" readonly="true" name="title[]"id="title_1" disabled="disabled" class="title form-control"/></td>
<td><input type="text" name="Qty[]" id="Qty_1" onblur="Calculateamount(this.id)" onKeyPress="return isNumberKey(event)" onkeyup="Calculateamount(this.id)"class="Qty form-control" autocomplete="off" /></td>
<td><input type="text" readonly="true" disabled="disabled" name="Cur[]"id="Cur_1"  class="Cur form-control" autocomplete="off"/></td>
<td><input type="text" readonly="true" tabindex = "-1" name="rate[]" id="rate_1"style="text-align:right;" onKeyPress="return isNumberKeydecimal(event)" class="rate form-control" /></td>
<td><input type="text" readonly="true" name="price[]"id="price_1" tabindex = "-1" style="text-align:right;" class="price form-control" autocomplete="off" /></td>
<td><input type="text" name="disc[]" id="disc_1" onblur="Calculateamount(this.id)" onKeyPress="return isNumberKeydecimal(event)" onkeyup="Calculateamount(this.id)" class="disc form-control" autocomplete="off"/></td>
<td><input type="text" readonly="true" name="Amount[]" id="Amount_1" tabindex = "-1" class="amt form-control" style="text-align:right;" autocomplete="off" /></td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>
<table  class="table table-condensed"  width="100%">
<thead>
<tr>
<th class="col-md-3"></th>
<th class="col-md-2"></th>
<th class="col-md-3"></th>
<th class="col-md-1"></th>
<th class="col-md-1"></th>
<th class="col-md-2"></th>
<th class="col-md-0"></th>
</tr>
</thead>
<tbody>
<tr>
<td><input name="button" type="button" id="add_ExpenseRow" value="+"  class="btn btn-primary"  /></td>
<td align="right">Remark</td>
<td><input type="text"  name="Remark" id="Remark"  class="form-control" autocomplete="off"/></td>
<td>Sub Total</td>
<td></td>
<td><input type="text" readonly="true" name="subtotal" disabled="disabled" id="subtotal" tabindex = "-1"style="text-align:right;" class="form-control" /></td>
<td>&nbsp;</td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td>Add</td>
<td></td>
<td><input type="text" name="Add" id="Add" style="text-align:right;" value="0.00" onkeyup="calculatetotal()" onkeypress="isNumberKeydecimal(event)" class="form-control" autocomplete="off"/></td>
<td>&nbsp;</td>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td>Less %</td>
<td><input type="text" name="Discount" id="Discount" style="text-align:right;" onkeyup="calculatepercentamt()"  onkeypress="isNumberKeydecimal(event)" value="0.00" class="form-control" autocomplete="off" /></td>
<td><input type="text"  tabindex = "-1" readonly="true" name="Less" id="Less" style="text-align:right;" value="0" class="form-control" autocomplete="off" /></td>
<td>&nbsp;</td>
</tr>

<tr>
<td></td>
<td></td>
<td><input type="submit" value="Save" class="btn btn-primary" id="btnsave" />&nbsp;</td>
<td>Total</td>
<td></td>
<td><input type="text" readonly="true" tabindex = "-1" name="Amount" id="Amount" style="text-align:right;" value="0.00" class="form-control" /></td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>
</form>
</div>
<?php
include 'includes/footer.php';
?>