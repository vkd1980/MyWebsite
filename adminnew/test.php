<?php include 'Includes/header.php';?>

<script type="text/javascript">
            var windowSizeArray = [ "width=200,height=200",
                                    "width=300,height=400,scrollbars=yes" ];
$(document).ready(function(){
                $('.newWindow').click(function (event){
  var tokken='';
                    window.open('cashbill.php?action=load&token=<?php echo $_SESSION['token'];?>&finyear=<?php echo$_SESSION['FinYearID']?>&id=12952', "popUp", 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=720,height=450');
 
                    event.preventDefault();
 
                });
            });
        </script>
		<body>
        <a href="#" rel="0" class="newWindow" >click me</a><br>
        <a href="#" rel="1" class="newWindow" >click me</a>
    </body>									
<?php include 'Includes/footer.php';?>