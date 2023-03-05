<html>

<head>
    <title>Create Subuser</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    session_start();
    $security = $_SESSION['user'];
    require("links.php"); 
	?>
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

label {
    font-weight: bold;


}

input:focus {
    border-color: transparent !important;
}


.activee {
    background: #343a40 !important;
}
</style>

 <!-- validation -->
 <script type="text/javascript">
    function signup() {

        var phone = document.getElementById('mobile').value;

        var regxPh = /^0?[6-9]\d{9}$/;

        if (regxPh.test(phone) && confirmPass()) {

        } else if (regxPh.test(phone) == false) {
            document.getElementById("mobile").style.borderBottom = "solid 2px red";
            document.getElementById("numberError").innerHTML = "Enter valid Phone Number";
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
            document.getElementById("password").style.borderBottom = "1px solid black";
            passDiv.classList.add("animate-hide");
            document.getElementById('goUP').classList.add("go-up");
        } else {
            document.getElementById("password").style.borderBottom = "1px solid red";
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
                document.getElementById("password").style.borderBottom = "1px solid black";
                document.getElementById("cpassword").style.borderBottom = "1px solid black";
                document.getElementById("cpassError").innerHTML = "Passwords matched";
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
   
    function clear() {
        var cpasss = document.getElementById('cpassword');
        cpasss.value = "";
    }
    </script>

<body>
    <?php require "navbar.php"; ?>
    <?php
    //subuser created successfully
    
        if ($_SESSION["subusrcrt"] == 1) {
        $_SESSION["subusrcrt"] = 0; ?>
    <div class="alert animate-hide alert-success alert-dismissible fade show" role="alert">
        <strong> Subuser created succesfully...</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    </div>
    <?php

        }
    
?>
    <?php
    //username is present in system... please enter another user name
    
        if ($_SESSION["uniqUserNm"] == 1) {
        $_SESSION["uniqUserNm"] = 0; ?>
    <div class="alert animate-hide alert-warning alert-dismissible fade show" role="alert">
        <strong> Please enter another username...!!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    </div>
    <?php

        }
    
?>
    <script>
    //for changing the class name (# replacement for active class)
    document.getElementById("subUsers").classList.add("active");
    document.getElementById("subUsers").classList.remove("text-light");
    document.getElementById("subUsers").classList.add("text-white");

    document.getElementById("crtsubUsers").classList.add("activee");
    </script>
    <center class="form-div m-0 p-0" id="passDiv" style="display:none">
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
    <form onsubmit="return signup();" method="post" action="PerformSubUsers.php"
        class="container bg-white rounded mt-2 pb-3 pt-4 mt-5 z-depth-2" id="goUP">
        <div class="container-fluid view overlay pb-3">
            <p class="h2 text-nowrap text-center text-primary mb-4 pb-4 pt-2 border-bottom border-primary"><b>Create
                    SubUser</b></p>
            <p class="h4 text-nowrap text-center text-gray" style="font-family: 'Times New Roman', Times, serif;">
                SubUser Details</p>

            <div class="row">
                <div class='autoComplete col-xl-5 col-lg-4 col-md-4 col-sm-6 col-12 ml-auto'>
                    <div class="md-form">
                        <input class='form-control text-dark' type="text" autocomplete='off' name="fname" id="fName"
                            required>
                        <label for="fName">Full Name</label>
                    </div>
                </div>

                <div class="autoComplete col-xl-5 col-lg-4 col-md-4 col-sm-6 col-12 mr-auto">
                    <div class="md-form">
                        <input class='form-control text-dark' autocomplete='off' type='text' name="username"
                            id="username">
                        <label for="username">User Name</label>
                    </div>
                </div>
            </div>


            <div class='row'>
                <div class='col-xl-5 col-lg-4 col-md-4 col-sm-6 col-12 ml-auto'>
                    <div class='autoComplete md-form'>
                        <input class='form-control text-dark' autocomplete='off' type="password" name="password"
                            id="password" onkeyup="validatePassword();">
                        <label for="password">Password</label>

                    </div>
                </div>

                <div class='col-xl-5 col-lg-4 col-md-4 col-sm-6 col-12 mr-auto'>
                    <div class='autoComplete md-form'>
                        <input class='form-control text-dark text-number' autocomplete='off' type="password"
                            name="cpassword" id="cpassword" onkeyup="confirmPass();">
                        <label for="cpassword">Confirm Password</label>

                    </div>
                </div>

            </div>

            <div class="row d-flex justify-content-center">
                <small id="cpassError" style="color: red;visibility: hidden;"></small>
            </div>

            <div class='row'>
                <div class='col-xl-5 col-lg-4 col-md-4 col-sm-6 col-12 mx-auto'>
                    <div class="autocomplete md-form">
                        <input class='form-control text-dark text-number' autocomplete="off" type="number" name="mobile"
                            id="mobile">
                        <label for="mobile">Mobile Number</label>
                        <small id="numberError" style="color: red;visibility: hidden;"></small>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12 text-center">
                    <button name="crtacc" class="btn btn-primary"><b>Create</b></button>
                </div>
            </div>

        </div>
    </form>


</body>

</html>
<script>
//document.getElementsByTagName("input").style.borderBottom =  "solid 5px black";
k = document.getElementsByTagName("input");
k[0].style = "border-bottom: 1px solid black";
k[1].style = "border-bottom: 1px solid black";
k[2].style = "border-bottom: 1px solid black";
k[3].style = "border-bottom: 1px solid black";
k[4].style = "border-bottom: 1px solid black";
</script>