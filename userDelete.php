<?php
session_start();
if(!isset($_POST['delsuree'])){
    header("location: index.php");
}
if (!isset($_SESSION['admin'])) {
    session_unset();
    session_destroy();
    header("location:admin.php");
}

require "conn.php";

$user_id = $_POST["userID"];
$username = $_POST["username"];

//MAKING EMPTY ALL THE USER TABLE
$truncate1 = "TRUNCATE ".$username."_customer";
$truncate2 = "TRUNCATE ".$username."_products'";
$truncate3 = "TRUNCATE ".$username."_customerbill";
$truncate4 = "TRUNCATE ".$username."_report";
$truncate5 = "TRUNCATE ".$username."_sell";

$TRUNCATE1Result = mysqli_query($conn, $truncate1);
$TRUNCATE2Result = mysqli_query($conn, $truncate2);
$TRUNCATE3Result = mysqli_query($conn, $truncate3);
$TRUNCATE4Result = mysqli_query($conn, $truncate4);
$TRUNCATE5Result = mysqli_query($conn, $truncate5);

//DROPPING ALL THE USER TABLES
$dropQuery1 = "DROP TABLE ".$username."_customer";
$dropQuery2 = "DROP TABLE ".$username."_products";
$dropQuery3 = "DROP TABLE ".$username."_customerbill";
$dropQuery4 = "DROP TABLE ".$username."_report";
$dropQuery5 = "DROP TABLE ".$username."_sell";

$dropQuery1Result = mysqli_query($conn, $dropQuery1);
$dropQuery2Result = mysqli_query($conn, $dropQuery2);
$dropQuery3Result = mysqli_query($conn, $dropQuery3);
$dropQuery4Result = mysqli_query($conn, $dropQuery4);
$dropQuery5Result = mysqli_query($conn, $dropQuery5);

//REMOVING USER FROM USER_TABLE, LOGIN_TABLE AND SHOP_TABLE
$remove1 = "DELETE FROM user_table WHERE user_id = $user_id;";
$remove2 = "DELETE FROM shop_table WHERE shop_id = $user_id;";
$remove3 = "DELETE FROM login_table WHERE login_id = $user_id;";

$remove1Result = mysqli_query($conn, $remove1);
$remove2Result = mysqli_query($conn, $remove2);
$remove3Result = mysqli_query($conn, $remove3);

$_SESSION['successKey'] = 4;

header("location:userList.php");
?>