<?php

session_start();
$security = $_SESSION['user'];
if(!isset($_SESSION['username'])) {
     header("location:index.php");
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback</title>
    <?php
        require("links.php");
        ?>
    <style>
        fieldset {
            width: auto;
        }
         
        
    </style>


</head>
<style>
@media (min-width: 992px) {
  .container {
    max-width: 800px;
  }
}

@media (min-width: 1200px) {
  .container {
    max-width: 800px;
  }
}
    label{
        font-weight: bold;
    }
        
    input{
        border-color: black !important;
            
    }
    input:focus{
        border-color: transparent !important; 
    }
   
    textarea{
        border-color: black !important;    
    }
    textarea:focus{
        border-color: transparent !important;
        
         
         
    }
</style>
<body>
<?php require "navbar.php"; ?>
    <br>
<script>
    //for changing the class name (# replacement for active class)
    document.getElementById("feedback").classList.add("active");
    document.getElementById("feedback1").classList.remove("text-light");
    document.getElementById("feedback1").classList.add("text-white");

</script>      
    <form method="post" action="performUserFeedback.php" class="container bg-white mt-2 pb-3 pt-4 z-depth-2" style="margin-bottom: 50vh;">
    
        <input type="hidden" value="1" name="countField" id="hiddenField">
        <div class="container-fluid ">
            <p class="h2 text-nowrap text-center text-primary mb-4 pb-4 pt-2 border-bottom border-primary"><b>Contact Us</b></p>
             
                    <div class='row mb-0'>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 offset-xl-3 offset-lg-3 offset-md-3 offset-sm-2 mb-xl-0 md-form">
                                    <div class="md-form md-outline input-with-pre-icon">
                                        <i class="fas fa-envelope input-prefix"></i>
                                        <input type="text" name="emailID" id="emailID" class="form-control">
                                        <label for="emailID">E-mail address</label>
                                    </div>
                            </div>
                    </div>
                    <div class='row'>
                        <div class="col-xl-8 col-lg-8 col-md-8 offset-xl-2 offset-lg-2 offset-md-2 md-form">
    
                                <div class="md-form md-outline input-with-pre-icon">
                                    <i class="fas fa-pencil-alt input-prefix m-0 p-0" style="top: 1rem !important;"></i>
                                    <textarea name="feedback" id="feedback" class="md-textarea form-control" rows="3" style="padding: 0rem;"></textarea>
                                    <label for="feedback" class="adjst">  Write Your complaint/Problem </label>
                                </div>
                                 
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-12 text-center'>
                            <button name="sent" id='addd' class='mt-4 btn btn-primary'><b>Send</b></button>
                        </div>
                    </div>
     
            </div> 
        </div>
    </form>
</body>

</html>