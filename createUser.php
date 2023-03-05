<?php

 require('links.php'); 

session_start();

if (!isset($_SESSION['admin'])) {
    session_unset();
    session_destroy();
    header("location:admin.php");
}

else {

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Title icon -->
    <link rel="icon" href="files/mannually/icon.png" sizes="4x4">
    <!-- ///////////////////md-bootstrap links////////////////// -->

    <!-- online -->
    <!-- css -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <!-- javascript -->
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js">
    </script>


    <!-- offline -->
    <!-- css -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="files/css/bootstrap.min.css">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="files/css/mdb.min.css">


    <!-- validation -->
    <script type="text/javascript">
    function signup() {

        var phone = document.getElementById('mobile').value;

        var regxPh = /^0?[6-9]\d{9}$/;

        if (regxPh.test(phone) && confirmPass() && confirmGst()) {

        } else if (regxPh.test(phone) == -1) {
            document.getElementById("mobile").style.borderBottom = "solid 2px red";
            document.getElementById("numberError").innerHTML = "Enter valid Phone";
            document.getElementById("numberError").style.visibility = "Visible";
            document.getElementById("numberError").style.color = "red";
            return false;

        } else {
            return false;
        }
    }


    function validatePassword() {
        var pass = document.getElementById('password').value;
        var passDiv = document.getElementById('passDiv');
        passDiv.style.display = "block";
        clear();
        if (pass == "") {
            passDiv.style.display = "none";
            document.getElementById("passNumber").style.color = "red";
            document.getElementById("passLetter").style.color = "red";
            document.getElementById("passSpecial").style.color = "red";
            document.getElementById("passLength").style.color = "red";
        }
        test1(pass);
        test2(pass);
        test3(pass);
        test4(pass);

        if (test1(pass) && test2(pass) && test3(pass) && test4(pass)) {
            document.getElementById("cpassError").innerHTML = "Password is Strong";
            document.getElementById("cpassError").style.color = "limegreen";
            document.getElementById("cpassError").style.visibility = "Visible";
            document.getElementById("password").style.borderColor = "2.3px solid #26f";
            passDiv.classList.add("animate-hide");
            document.getElementById('goUP').classList.add("go-up");
        } else {
            document.getElementById("cpassError").innerHTML = "Password is Week";
            document.getElementById("cpassError").style.color = "red";
            document.getElementById("cpassError").style.visibility = "Visible";
            passDiv.classList.remove("animate-hide");
            document.getElementById('goUP').classList.remove("go-up");
        }
    }

    function test1(pass) {

        if (pass.search(/[0-9]/) == -1) {
            document.getElementById("password").style = "border-color: red !important";
            document.getElementById("passNumber").style.color = "red";
            return false;
        } else {
            document.getElementById("passNumber").style.color = "limegreen";
            document.getElementById("password").style = "border-color: solid black !important";
            return true;
        }
    }

    function test2(pass) {

        if (pass.search(/[A-Z]/) == -1) {
            document.getElementById("password").style = "border-color: red !important";
            document.getElementById("passLetter").style.color = "red";
            return false;
        } else {
            document.getElementById("passLetter").style.color = "limegreen";
            document.getElementById("password").style = "border-color: solid black !important";
            return true;
        }
    }

    function test3(pass) {

        if (pass.search(/[!@#%^&(_+,;:]/) == -1) {
            document.getElementById("password").style = "border-color: red !important";
            document.getElementById("passSpecial").style.color = "red";
            return false;
        } else {
            document.getElementById("passSpecial").style.color = "limegreen";
            document.getElementById("password").style = "border-color: solid black !important";
            return true;
        }
    }

    function test4(pass) {

        if (pass.length < 8) {
            document.getElementById("password").style = "border-color: red !important";
            document.getElementById("passLength").style.color = "red";
            return false;
        } else {
            document.getElementById("passLength").style.color = "limegreen";
            document.getElementById("password").style = "border-color: solid black !important";
            return true;
        }
    }

    function confirmPass() {
        var pass = document.getElementById('password').value;
        var cpass = document.getElementById('cpassword').value;

        if (cpass == "") {
            document.getElementById("cpassError").style.color = "red";
            document.getElementById("cpassError").innerHTML = "Passwords are not matching";
            return false;
        }

        if (pass === cpass) {
            if (test1(cpass) && test2(cpass) && test3(cpass) && test4(cpass)) {
                document.getElementById("password").style.borderBottom = "2.3px solid #26f";
                document.getElementById("cpassword").style = "border-color: solid black !important";
                document.getElementById("cpassError").innerHTML = "Passwords are matched";
                document.getElementById("cpassError").style.visibility = "Visible";
                document.getElementById("cpassError").style.color = "limegreen";
                return true;
            } else {
                document.getElementById("cpassError").innerHTML =
                    "Password is too Week, follow above instructions to create your password strong";
                document.getElementById("cpassError").style.visibility = "Visible";
                document.getElementById("cpassError").style.color = "red";
                return false;
            }
        } else {
            document.getElementById("cpassword").style.borderBottomColor = "red";
            document.getElementById("cpassError").innerHTML = "Passwords are not matching";
            document.getElementById("cpassError").style.visibility = "Visible";
            document.getElementById("cpassError").style.color = "red";

            return false;
        }

    }


    function confirmGst() {
        var gst = document.getElementById('gstNumber').value.toUpperCase();

        var regxGst = /^[0-9]{2}([0-9A-Z]){10}[0-9]Z[0-9]$/;

        if (regxGst.test(gst)) {
            document.getElementById("gstNumber").style.borderBottom = "2.3px solid #26f";
            document.getElementById("gstError").innerHTML = "";
            return true;
        } else {
            document.getElementById("gstNumber").style.borderBottom = "solid 2px red";
            document.getElementById("gstError").innerHTML = "Enter complete GSTIN number";
            document.getElementById("gstError").style.visibility = "Visible";
            document.getElementById("gstError").style.color = "red";
            return false;
        }
    }

    function uppercase() {
        GSTInNumber = document.getElementById('gstNumber');
        GSTInNumber.value = GSTInNumber.value.toUpperCase();
    }

    function clear() {
        var cpasss = document.getElementById('cpassword');
        cpasss.value = "";
    }
    </script>
    <!-- jQuery -->
    <script type="text/javascript" src="files/js/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="files/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="files/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="files/js/mdb.min.js"></script>


    <!-- ///////////////////important css files(which should not be overwitten)////////////////////// -->


    <link rel="stylesheet" href="files/mannually/table.css">

    <link rel="stylesheet" href="files/mannually/animate.css">

    <link rel="stylesheet" href="files/mannually/dropanimate.css">

    <link rel="stylesheet" href="files/mannually/formStyle.css">

    <link rel="stylesheet" href="files/mannually/basic.css">
    <!-- script for print only specified div which has id "printOnly" -->

</head>
<style>
fieldset {
    width: auto;
}
</style>


<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="createUser.php">Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mr-auto" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" href="createUser.php">Create User</a>
                <a class="nav-link" href="userList.php">Users List</a>
                <a class="nav-link" href="userFeedbacks.php">User Feedbacks</a>
            </div>
            <div class="navbar-nav ml-auto">
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <?php
        if (isset($_SESSION["errorKey"])) {
            //checking passed errors from signupCheck.php page
            if ($_SESSION["errorKey"] == 2) {
                $_SESSION["errorKey"] = 0; ?>
    <div class="alert animate-hide alert-warning alert-dismissible fade show" role="alert">
        <strong>Username Alerardy Exists </strong> Please enter another username
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
            }
            
            if ($_SESSION["errorKey"] == 1) {
                $_SESSION["errorKey"] = 0; ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Problem while updating user information</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
            }
        }
        if (isset($_SESSION["successKey"])) {
            //checking passed sucfcess from signupCheck.php page //success if user is created successfully
            if ($_SESSION["successKey"] == 2) {
                $_SESSION["successKey"] = 0; ?>
    <div class="alert animate-hide alert-success alert-dismissible fade show" role="alert">
        User Account Created Successfully..
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
            }
        }
        ?>

    <center class="form-div m-0 p-0" id="passDiv" style="display:none;">
        <fieldset class="m-0 p-2 mt-3" style="width:95%">
            <ul style="width: fit-content; margin:0 auto;">

                <li>
                    <div style="text-align: left;" id="passNumber">Password should contain at-least 1 number</div>
                </li>
                <li>
                    <div style="text-align: left;" id="passLetter">Password should contain at-least one uppercase letter
                    </div>
                </li>
                <li>
                    <div style="text-align: left;" id="passSpecial">Password should contain at-least 1 special character
                    </div>
                </li>
                <li>
                    <div style="text-align: left;" id="passLength">Length of password should be minimum 8 characters
                    </div>
                </li>

            </ul>
        </fieldset>
    </center>
    <div class="form-div centered" id="goUP">
        <fieldset style="margin-top: 0;">
            <legend>Create User</legend>
            <form onsubmit="return signup();" action="createUserCheck.php" method="POST">
                <div class="border-top"></div>
                <p class="title">User Details</p>
                <input required autocomplete="off" type="text" name="fname" id="fName" placeholder="First Name">
                <input required autocomplete="off" type="text" name="lname" id="lName" placeholder="Last Name">
                <div class="left">
                    <input required autocomplete="off" type="text" name="username" id="username" placeholder="Username">
                </div>
                <input required autocomplete="off" type="password" name="password" id="password" placeholder="Password"
                    onkeyup="validatePassword();">
                <input required autocomplete="off" type="password" name="cpassword" id="cpassword"
                    placeholder="Confirm Password" onkeyup="confirmPass(); "><br>
                <small id="cpassError" style="color: red;visibility: hidden;"></small>
                <div class="border-top"></div>

                <p class="title">Shop Details</p>
                <input required autocomplete="off" type="text" name="shopname" id="shopname" placeholder="Shop Name">
                <input required autocomplete="off" type="search" name="gstNumber" id="gstNumber"
                    placeholder="GST Number" onkeyup="confirmGst(); uppercase();">
                <br>
                <small id="gstError" style="color: red;visibility: hidden;"></small>
                <textarea name="address" id="address" rows="2" placeholder="Shop Address"></textarea>
                <br>
                <label id="l1" style="color:red; visibility: hidden;">Invalid</label><br>
                <input required autocomplete="off" type="text" name="mobile1" id="mobile" placeholder="mobile number 1">
                <input autocomplete="off" type="text" name="mobile2" id="mobile2" placeholder="mobile number 2">
                <br>
                <small id="numberError" style="color: red;visibility: hidden;"></small>
                <small id="numberError2" style="color: red;visibility: hidden;"></small>
                <br>
                <button>Create Account</button>
            </form>
        </fieldset>
    </div>
</body>

</html>
<?php   
} 
?>