// JavaScript Document
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function isNumberKeydecimal(evnt) {
    var charCode = (evnt.which) ? evnt.which : evnt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function isEmpty(obj) {
    for (var key in obj) {
        if (obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

function Calculateamount(myid) {
    var slid = $("#" + myid)
        .closest("tr")
        .find("input[name^='slno']")
        .attr("id");
    //console.log(slid);
    var amount = ($("#Qty_" + slid)
        .val() * $("#rate_" + slid)
        .val() * $("#price_" + slid)
        .val()) * (1 - $("#disc_" + slid)
        .val() / 100);
    amount = numeral(amount)
        .format('0.00');
    $("#Amount_" + slid)
        .val(amount);
    calculatetotal();
}

function calculatetotal() {
    var add = 0;
    $(".amt")
        .each(function() {
            add += Number($(this)
                .val());
        });
    add = numeral(add)
        .format('0.00');
    $("#subtotal")
        .val(add);
    var amount = parseFloat($('#Add')
        .val(), 10) + parseFloat($('#subtotal')
        .val(), 10) - parseFloat($('#Less')
        .val(), 10);
    amount = numeral(amount)
        .format('0.00');
    //console.log("Amount :"+amount);
    $("#Amount")
        .val(amount);

}

function calculatepercentamt() {
    var less = parseFloat($("#subtotal")
        .val(), 10) * parseFloat($("#Discount")
        .val(), 10) / 100;
    less = numeral(less)
        .format('0.00');
    $("#Less")
        .val(less);
    calculatetotal();
}

function calcpercent() {
    $("#Discount")
        .val($("#Less")
            .val() / $("#subtotal")
            .val() * 100);
    calculatetotal();
}