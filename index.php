<?php

session_start();
if (isset($_SESSION['username'])) {
    header("location:sell.php");
}
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}
 ?>