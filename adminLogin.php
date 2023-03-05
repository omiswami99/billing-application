<?php  

session_start();
if (isset($_SESSION['admin'])) {
    header("location:adminHome.php");
}
else {

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
        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $password1  = "$2y$10$3deIWtSI0hv/p2C7ufUZ4OAcSxBW3X2fYHFNHiPmoGnDkM6U3Z/KS";

        if ( ( $username == "admin" ) && ( password_verify($password, $password1) ) ) {
            $_SESSION['successKey'] = 2;
            $_SESSION['errorKey']   = 0;
            $_SESSION['admin']      = "true";
            header("location:createUser.php");
        } else {
            $_SESSION['successKey'] = 0;
            $_SESSION['errorKey']   = 2;
            header("location:adminLogin.php");
        }
    }
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php   
            require "links.php";
        ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
    body {
        height: 100vh;
        overflow: hidden;
    }
    </style>
</head>

<body>
    <center>
        <div class="form-div centered">
            <fieldset style="width:auto">
                <legend>Login</legend>
                <form action="" method="post">
                    <input required type="text" name="username" id="username" placeholder="Admin Username"
                        style="margin-top:30px" autocomplete="off">
                    <br>
                    <input required type="password" name="password" id="password" placeholder="Admin Password">
                    <br>
                    <button class="mt-4">Login</button>
                    <br>
                </form>
            </fieldset>
        </div>
    </center>
</body>

</html>

<?php 

}

?>