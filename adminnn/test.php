<?php
include'includes/header.php';
if(!isset($_SESSION['logged_in'])) {
header("Location: index.php");
	}
?>
<script type='text/javascript'>
    
      $(document).ready(function() {
        $('.filter').multifilter()
      })
   
  </script>
<body>

</div>
<div class='container' style="margin-top:150px;">
<div class='hero'>
<h2> Multifilter is a jQuery plugin to let you filter a table based on multiple inputs. <br />
Check it out below. It's pretty sweet. </h2>
<div class='actions'> <a href='http://github.com/tommyp/multifilter/'>Download from Github</a> </div>
</div>
</div>
<div class='container'>
<div class='filters'>
<div class='filter-container'>
<input autocomplete='off' class='filter' name="Publisher" placeholder="Publisher" data-col="Publisher" />
</div>
<div class='clearfix'></div>
</div>
</div>
<div class='container'>
<table class="table">
<thead>
<th>Name</th>
<th>Publisher</th>
<th>Pizza</th>
<th>Movie</th>
</thead>
<tbody>
<tr>
<td> Homer </td>
<td> Squishie </td>
<td> Magheritta </td>
<td> The Avengers </td>
</tr>
<tr>
<td> Marge </td>
<td> Squishie </td>
<td> Magheritta </td>
<td>&nbsp;</td>
</tr>
<tr>
<td> Bart </td>
<td> Squishie </td>
<td> Pepperoni </td>
<td> Black Dynamite </td>
</tr>
<tr>
<td> Lisa </td>
<td> Buzz Cola </td>
<td> Pepperoni </td>
<td> Iron Man </td>
</tr>
<tr>
<td> Maggie </td>
<td> Duff Beer </td>
<td> Magheritta </td>
<td> The Avengers </td>
</tr>
<tr>
<td> Kent </td>
<td> Duff Beer </td>
<td> Hawaiian </td>
<td> The Avengers </td>
</tr>
<tr>
<td> Patty </td>
<td> Duff Beer </td>
<td> Hawaiian </td>
<td> District 9 </td>
</tr>
<tr>
<td> Selma </td>
<td> Duff Beer </td>
<td> Pepperoni </td>
<td> The Avengers </td>
</tr>
<tr>
<td> Otto </td>
<td> Duff Beer </td>
<td> Magheritta </td>
<td> Star Trek </td>
</tr>
<tr>
<td> Carl </td>
<td> Duff Beer </td>
<td> Pepperoni </td>
<td> Star Trek </td>
</tr>
<tr>
<td> Lenny </td>
<td> Duff Beer </td>
<td> Magheritta </td>
<td> Pacific Rim </td>
</tr>
<tr>
<td> Stu </td>
<td> Squishie </td>
<td> Hawaiian </td>
<td> Black Dynamite </td>
</tr>
<tr>
<td> Eddie </td>
<td> Duff Beer </td>
<td> Magheritta </td>
<td> Star Trek </td>
</tr>
<tr>
<td> Lou </td>
<td> Duff Beer </td>
<td> Pepperoni </td>
<td> Pacific Rim </td>
</tr>
<tr>
<td> Ned </td>
<td> Duff Beer </td>
<td> Pepperoni </td>
<td> District 9 </td>
</tr>
<tr>
<td> Barney </td>
<td> Squishie </td>
<td> Pepperoni </td>
<td> Pacific Rim </td>
</tr>
<tr>
<td> Moe </td>
<td> Buzz Cola </td>

<td> Hawaiian </td>
<td> Star Trek </td>
</tr>
<tr>
<td> Julius </td>
<td> Squishie </td>
<td> Pepperoni </td>
<td> Pacific Rim </td>
</tr>
<tr>
<td> Jimbo </td>
<td> Squishie </td>
<td> Pepperoni </td>
<td> Star Trek </td>
</tr>
<tr>
<td> Rod </td>
<td> Duff Beer </td>
<td> Magheritta </td>
<td> Star Trek </td>
</tr>
<tr>
<td> Todd </td>
<td> Squishie </td>
<td> Hawaiian </td>
<td> The Avengers </td>
</tr>
</tbody>
</table>

</div>
</body>
</html>