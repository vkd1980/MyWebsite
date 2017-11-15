<?php
include'includes/header.php';?>
<script type="text/javascript">
   $(document).ready(function() {
        var numberIncr = 1; // used to increment the name for the inputs

        function addInput() {
            $('#inputs').append($('<input class="comment" name="name'+numberIncr+'" />'));
            numberIncr++;
        }

        $('form.commentForm').on('submit', function(event) {

            // adding rules for inputs with class 'comment'
            $('input.comment').each(function() {
                $(this).rules("add", 
                    {
                        required: true
                    })
            });            

            // prevent default submit action         
           // event.preventDefault();

            // test if form is valid 
            /*if($('form.commentForm').validate().form()) {
                console.log("validates");
            } else {
                console.log("does not validate");
            }*/
        })

        // set handler for addInput button click
        $("#addInput").on('click', addInput);

        // initialize the validator
        $('form.commentForm').validate();

   });


</script>
<form class="commentForm" method="post" >
    <div>

        <p id="inputs">    
            <input class="comment" name="name0" />
        </p>

    <input class="submit" type="submit" value="Submit" />
    <input type="button" value="add" id="addInput" />

    </div>
</form>