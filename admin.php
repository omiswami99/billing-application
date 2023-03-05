<?php 

session_start();
if (isset($_SESSION['admin'])) {
    header("location:createUser.php");
} else {
    header("location:adminLogin.php");
}


?>