<?php

$authors = $_POST['Author'];
foreach($authors as $author) :
echo $author.'<br>';
endforeach;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<script>
var counter3 = 0;
function addAuthor() {
    // Get the main Div in which all the other divs will be added
    var mainContainer = document.getElementById('Author');

    // Create a new div for holding text and button input elements
    var newDiv = document.createElement('div');

    // Create a new text input
    var newText = document.createElement('input');
    newText.type = "text";
    //var i = 1;
    newText.name = "Author[]";
    newText.value = counter3 + 2 + ". ";

    //Counter starts from 2 since we already have one item
    //newText.class = "input.text";
    // Create a new button input
    var newDelButton = document.createElement('input');
    newDelButton.type = "button";
    newDelButton.value = "-";

    // Append new text input to the newDiv
    newDiv.appendChild(newText);
    // Append new button input to the newDiv
    newDiv.appendChild(newDelButton);
    // Append newDiv input to the mainContainer div
    mainContainer.appendChild(newDiv);
    counter3++;
    //i++;

    // Add a handler to button for deleting the newDiv from the mainContainer
    newDelButton.onclick = function() {
        mainContainer.removeChild(newDiv);
        counter3--;
    }
}
</script>
<body>
<form method="post">
<div id="Author">
    <LI>Author</LI> 
	
    <input type = "text" name="Author[]" value = "1. "/>
    <input type="button" value="+" id="Authorbutton" onclick="addAuthor()" />
	
</div>
<input type="submit" />
	</form>
</body>
</html>

