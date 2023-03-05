<?php

include "conn.php";

session_start();

if (isset($_SESSION['username'])) {
    header("location:index.php");
}

if (isset($_SESSION['errorKey'])) {
    //checking passed errors from performAdd.php page
    if ($_SESSION["errorKey"] == 2) {
        $_SESSION["errorKey"] = 0; 
        ?>
		<div class="alert animate-hide alert-warning alert-dismissible fade show" role="alert">
            <strong>Incorrect Username Or Password </strong> Please enter correct username and password
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
	<?php
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //checking the username is present in login_table or not
    $sql = "SELECT * from `login_table` where username = '$username'";
    $result = mysqli_query($conn, $sql);
    $password1 = mysqli_fetch_array($result)['password'];
    
    if (password_verify($password, $password1)) {
        //Running this query for creating the sessions of shop_name and shop_address
        $joinSql = "SELECT shop_table.*, user_table.* FROM shop_table JOIN login_table ON shop_table.shop_id = login_table.login_id  JOIN user_table ON shop_table.shop_id = user_table.user_id where login_table.username = '$username';";
        $joinResult = mysqli_query($conn, $joinSql);

        $data = mysqli_fetch_array($joinResult);
        $shopname = $data['shop_name'];
        $shopaddress = $data['shop_address'];
        $shopgstin = $data['shop_gst_no'];
        $mobile1 = $data['mobile1'];
        $mobile2 = $data['mobile2'];
        $userID = $data['user_id'];

        $_SESSION['username'] = $username;
        $_SESSION['shopname'] = $shopname;
        $_SESSION['shopaddress'] = $shopaddress;
        $_SESSION['shopgstin'] = $shopgstin;
        $_SESSION['mobile1'] = $mobile1;
        $_SESSION['mobile2'] = $mobile2;
        $_SESSION['userID'] = $userID;
        $_SESSION['user'] = "adminUser";
        $_SESSION['seller'] = "adminUser";

        $_SESSION['successKey'] = 1;
        $_SESSION['errorKey'] = 0;
        $_SESSION["subusrcrt"] = 0;
        $_SESSION["uniqUserNm"] = 0;
        
        header("location:sell.php");
    } else {
        $_SESSION['successKey'] = 0;
        $_SESSION['errorKey'] = 2;
        header("location:login.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php
    require("links.php");
    ?>
    <style>
        body {
            height: 100vh;
        }
    </style>
</head>

<body>
    <center>
    <div class="form-div centered">
        <fieldset style="width:auto">
            <legend>Login</legend>
            <form action="" method="post">
                <input required type="text" name="username" id="username" placeholder="Username" style="margin-top:30px" autocomplete="off">
                <br>
                <input required type="password" name="password" id="password" placeholder="Password" >
                <br>
                <button>Login</button>
                <br>
            </form>
            <div class="left mt-4"><a href="subUserLogin.php" class="text-primary" style="font-weight:bold;">SubUser Login</a</div>
            
    
        </fieldset>
        
    </div>
    </center>
</body>

</html>