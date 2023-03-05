 
<html>
<head>
<title>Update Subusers Account</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
    
    session_start();
    $security = $_SESSION['user'];
    $sub_username = $_SESSION['username'];
     require("links.php"); 
     if(!$_SERVER['REQUEST_METHOD'] == "POST") {
         header('location:index.php');
     } else {
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
label{
    font-weight: bold;
}
input:focus{
    border-color: transparent !important;
}
.activee{
    background: #343a40 !important;
}   


</style>
<body>
    <?php require "navbar.php"; ?>
    <script>
        //for changing the class name (# replacement for active class)
        document.getElementById("subUsers").classList.add("active");
        document.getElementById("subUsers").classList.remove("text-light");
        document.getElementById("subUsers").classList.add("text-white");
    </script>
            <center class="form-div m-0 p-0" id="passDiv" style="display:none">
            <fieldset class="m-0 p-2 mt-3" style="width:95%">
                <ul style="width: fit-content; margin:0 auto;">

                    <li>
                        <div style="text-align: left;" id="passNumber">Password should contain at-least 1 number</div>
                    </li>
                    <li>
                        <div style="text-align: left;" id="passLetter">Password should contain at-least one uppercase letter</div>
                    </li>
                    <li>
                        <div style="text-align: left;" id="passSpecial">Password should contain at-least 1 special character</div>
                    </li>
                    <li>
                        <div style="text-align: left;" id="passLength">Length of password should be minimum 8 characters</div>
                    </li>

                </ul>
            </fieldset>
        </center> 
        <div id="goUp">
        <div class="container bg-white rounded mt-2 pb-3 pt-4 mt-5 z-depth-2" >
             
            <div class='container-fluid view overlay pb-3'>
                <p class='h2 text-nowrap text-center text-primary mb-4 pb-4 pt-2 border-bottom border-primary'><b>Update SubUser</b></p>
                <p class='h4 text-nowrap text-center text-gray pb-3' style='font-family: "Times New Roman", Times, serif;'>SubUser Details</p>

             
                    <?php 
                    
                    include 'conn.php';
                    $subusertable = $sub_username."_subusers";
                    if(isset($_POST['editsure'])){
                        $uname = $_POST['editUname'];

                    }else{
                        $uname = "";
                    }
                     
                    $chkuname = "select * from $subusertable where username = '$uname';";
                    $result = $conn->query($chkuname);
                    if($result->num_rows == 1){ 
                        while($rows = $result->fetch_assoc()){
                            
                            $fname = $rows['fname'];
                            $username = $rows['username'];
                            $passwod = $rows['spassword'];
                            $mobile = $rows['mobile'];
                        }
                    }
                    echo"
                    <div class='row'>
                        <div class='autoComplete col-xl-5 col-lg-4 col-md-4 col-sm-6 col-12 ml-auto'>
                            <div class='md-form'>
                                <input class='form-control text-dark' type='text' autocomplete='off' name='fname' id='fName' value='$fname'>
                                <label for='fName'>Full Name</label>
                            </div>
                            <div style='display: none;'>
                                <input required autocomplete='off' type='text' name='unameOld' id='unameOld' placeholder='First Name' value='$uname'>
                            </div>
                        </div>

                        <div class='autoComplete col-xl-5 col-lg-4 col-md-4 col-sm-6 col-12 mr-auto'>
                            <div class='md-form'>
                                <input class='form-control text-dark' autocomplete='off' type='text' name='username' id='username' value='$username'> 
                                <label for='username' >User Name</label>
                            </div>
                        </div>
                    </div>
            
                 
                    <div class='row'>
                        <div class='col-xl-5 col-lg-4 col-md-4 col-sm-6 col-12 ml-auto'>
                            <div class='autoComplete md-form'>
                                <input class='form-control text-dark' autocomplete='off' type='password' name='password' id='password' value='$passwod'  onkeyup='validatePassword();'>
                                <label for='password'>Password</label>

                            </div>
                        </div>
                    
                        <div class='col-xl-5 col-lg-4 col-md-4 col-sm-6 col-12 mr-auto'>
                            <div class='autoComplete md-form'>
                                <input class='form-control text-dark text-number' autocomplete='off' type='password' name='cpassword' id='cpassword' value='$passwod' onkeyup='confirmPass();'>
                                <label for='cpassword' >Confirm Password</label>
                            </div>
                        </div>
                    </div>
                    <div class='row d-flex justify-content-center'>
                        <small id='cpassError' style='color: red;visibility: hidden;'></small>
                    </div>
                    
                    <div class='row'>        
                        <div class='col-xl-5 col-lg-4 col-md-4 col-sm-6 col-12 mx-auto'>
                            <div class='autocomplete md-form'>
                                <input class='form-control text-dark text-number' autocomplete='off' type='number'  name='mobile' id='mobile' value='$mobile'>
                                <label for='mobile'>Mobile Number</label>
                            </div>
                        </div>
                    </div>
         
        
                    ";?>
                    <br>
                    <div class="row"> 
                        <div class="col-12 text-center">
                            <button data-toggle="modal" data-target="#modalPush" onclick='allinfo();' class="btn btn-primary"><b>Update Account</b></button>
                        </div>
                    </div>
                    
        </div>
    </div>
    </div>
    <!-- Modal 1 -->
<div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content animate text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center bg-primary">
        <p class="heading">Recheck details once!!</p>
      </div>

      <!--Body-->
      <form method="post" action="performSubUsers.php">
                <div class="modal-body">
                <i class="far fa-bell fa-4x mb-3 animated rotateIn"></i><br><br>
                    Full Name: <span id="fNamepp" class="ml-3"></span><br>
                    Username: <span id="usernamepp" class="ml-3"></span><br>
                    Password: <span id="passwordpp" class="ml-3"></span><br>
                    Mobile: <span id="mobilepp" style="margin-left: 2.4rem !important;"></span><br>

                    <div style="visibility: hidden;">
                        <input id="fNamep" name="fname">
                        <input id="unamep" name="uname">
                        <input id="usernamep" name="username">
                        <input id="passwordp" name="password">
                        <input id="mobilep" name="mobile">
                    </div> 
                    <script>
                        function allinfo(){
                            var fname = document.getElementById("fName").value;
                            var unameOld = document.getElementById("unameOld").value;
                            var uname = document.getElementById("username").value;
                            var pass = document.getElementById("password").value;
                            var mobile = document.getElementById("mobile").value;
                            document.getElementById("fNamep").value = fname;
                            document.getElementById("unamep").value = unameOld;
                            document.getElementById("usernamep").value = uname;
                            document.getElementById("passwordp").value = pass;
                            document.getElementById("mobilep").value = mobile;

                            document.getElementById("fNamepp").innerHTML = fname;
                            document.getElementById("usernamepp").innerHTML = uname;
                            document.getElementById("passwordpp").innerHTML = pass;
                            document.getElementById("mobilepp").innerHTML = mobile;
                             
                        }
                    </script>
                </div>
                <div class="modal-footer">
                            
                    <button type="button" class="btn btn-md btn-dark" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-md btn-success" name="updateacc">Sure</button>
                     
                        
                </div>
            </form> 
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalPush-->
</body>
</html>
<?php } ?>
<script>

//document.getElementsByTagName("input").style.borderBottom =  "solid 5px black";
k = document.getElementsByTagName("input");
k[0].style = "border-bottom: 1px solid black";
k[1].style = "border-bottom: 1px solid black";
k[2].style = "border-bottom: 1px solid black";
k[3].style = "border-bottom: 1px solid black";
k[4].style = "border-bottom: 1px solid black";
k[5].style = "border-bottom: 1px solid black";

 
</script>