<script>
function addRow() {
   var tbl = document.getElementById('tbl');
   var Row = parseInt(document.getElementById('hsb').value);
   var temprow=Row+1;
   
   var mainRow = tbl.insertRow(temprow);
   var trId ="tr"+temprow;
   mainRow.id=trId;
   
   var td =  document.createElement("td");
   td.colSpan='6';
   var table =  document.createElement("table");
   table.border="0";
   table.cellPadding="0";
   table.cellSpacing="1";
   table.width="100%"
   var newRow = table.insertRow(0);
   
   var sec = "'risk'";
     var newCell = newRow.insertCell(0);
   newCell.width="50%"
   newCell.innerHTML = '<input type="text" class="input" name="ata[]" id="ata'+temprow+'" value="" size="80" maxlength="100 ">'
  var newCell = newRow.insertCell(1);
   newCell.width="17%"
   newCell.innerHTML = '<input type="text" class="input" name="ca[]" id="ca'+temprow+'" value="" size="25" maxlength="100">';   
   
   var newCell = newRow.insertCell(2);
   newCell.width="10%"
   newCell.innerHTML = '<select name="atc[]" class="input" id="atc'+temprow+'" ><option value="Sooner" >Sooner</option><option value="Later" >Later</option></select>';   
   
   var newCell = newRow.insertCell(3);
   newCell.width="10%"
   newCell.innerHTML = '<select name="aca[]" class="input" id="aca'+temprow+'" ><option value="Certain" >Certain</option><option value="Uncertain" >Uncertain</option></select>';   
  
 td.appendChild(table);
   mainRow.appendChild(td);
   
     
   document.getElementById('hsb').value=temprow;
   
 
}
$('#add').click(function(){AddRow({});
    });
    var AddRow=function(){
        $('#tbl:first').clone().hide().insertBefore('#tbl:first').slideDown(function(){
            //setting all elements value as blank
            //We can do this by a single line code  $('input',this).val(''); but this raises some cross browser issue
            for(i=0; i<element.length; i++) 
             {
              $.each($(this).find(element[i]), function(){      
               switch($(this).attr('type')) {
                case 'text':
                case 'select-one':
                case 'textarea':
                case 'hidden':
                case 'password':
                $(this).val('');
                break;
                case 'checkbox':
                case 'radio':
                 $(this).attr('checked',false); //or make it true if you want 
                break;
               }
          });
         }
        });
    }
</script>
<table width="100%" id="tbl">
         <thead>
            <tr>
             <td class="tdclass" width="50%" align="left">
              Antecedents/Triggers
             </td>
             <td class="tdclass" width="17%" align="left">
              Consequences
             </td>
             <td class="tdclass" width="10%" align="left">
              Timing 
             </td>
             <td class="tdclass" width="10%" align="left">
                Consistency
             </td>
             <td class="tdclass" width="2%" align="right">
               <img src="images/plus16.gif" onClick="addRow();" style="cursor:pointer " title="Add" id="add">
             </td>
            </tr>
         </thead>
    <tbody>
     <input type="hidden" value="1" id="hsb">
       <tr id="tr1">
          <td colspan="5">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                 <td width="50%">
                   <input type="text" class="input" name="ata[]" id="ata1" value="" size="80" maxlength="100"/>
                  </td>
                  <td width="17%">
                   <input type="text" class="input" name="ca[]" id="ca1" value="" size="25" maxlength="100"/>
                   </td>
                   <td width="10%">
                     <select name="atc[]" class="input" id="atc1" >
                      <option value="Sooner" >Sooner</option>
                      <option value="Later" >Later</option>
                     </select>
                    </td>
                    <td width="10%">
                     <select name="aca[]" class="input" id="aca1" >
                      <option value="Certain" >Certain</option>
                      <option value="Uncertain" >Uncertain</option>
                     </select>
                    </td>
                   </tr>
                 </table>
                </td>
              </tr>
            </tbody>
</table>
