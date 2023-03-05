<?php
session_start();
require "conn.php";
if (!isset($_SESSION['admin'])) {
    session_unset();
    session_destroy();
    header("location:admin.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //getting data from form
    $fname     = $_POST['fname'];
    $lname     = $_POST['lname'];
    $mobile1   = $_POST['mobile1'];
    $mobile2   = $_POST['mobile2'];
    $username  = $_POST['username'];
    $password  = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $shopname  = $_POST['shopname'];
    $gstNumber = $_POST['gstNumber'];
    $address   = $_POST['address'];
    $user_id   = $_GET['userID'];
    $oldUsername = $_GET['oldUsername'];
    //inserting  fname, lname, mobile no in user_table table
    echo $username;
    $updateLoginSql = "UPDATE `login_table` 
        SET 
        `username`      = '$username' , 
        `password`      = '$password' 
        WHERE `login_id`= $user_id;
    ";

    $updateUserSql      = "UPDATE `user_table` 
        SET 
        `fname`         = '$fname', 
        `lname`         = '$lname', 
        `mobile1`       = '$mobile1', 
        `mobile2`       = '$mobile2' 
        WHERE `user_id` = $user_id;
    ";

    $updateShopSql      = "UPDATE `shop_table` 
        SET 
        `shop_name`     = '$shopname', 
        `shop_gst_no`   = '$gstNumber', 
        `shop_address`  = '$address' 
        WHERE `shop_id` = $user_id;
        ;";
    
    //running query to insert data in tables
    $updateLoginSqlResult = mysqli_query($conn, $updateLoginSql);
    $updateUserSqlResult  = mysqli_query($conn, $updateUserSql);
    $updateShopSqlResult  = mysqli_query($conn, $updateShopSql);

    //queries for creating tables
    $tableOneSql    = "ALTER TABLE ".$oldUsername."_products 
        RENAME TO ".$username."_products ";
    $tableTwoSql    = "ALTER TABLE ".$oldUsername."_sell 
        RENAME TO ".$username."_sell ";
    $tableThreeSql  = "ALTER TABLE ".$oldUsername."_customer 
        RENAME TO ".$username."_customer ";
    $tableFourSql   = "ALTER TABLE ".$oldUsername."_customerbill
        RENAME TO ".$username."_customerbill ";
    $tableFiveSql   = "ALTER TABLE ".$oldUsername."_report 
        RENAME TO ".$username."_report ";
    //ALTER TABLE table_name RENAME TO new_table_name;
    
    
    //running queries to create tables
    $tableTwoResult   = mysqli_query($conn, $tableTwoSql);
    $tableOneResult   = mysqli_query($conn, $tableOneSql);
    $tableThreeResult = mysqli_query($conn, $tableThreeSql);
    $tableFourResult  = mysqli_query($conn, $tableFourSql);
    $tableFiveResult  = mysqli_query($conn, $tableFiveSql);

    $result_error = 0;

    if(!$tableTwoResult) {
        $result_error += 1;
    } else {
        $result_error += 0;
    }
    if(!$tableOneResult) {
        $result_error += 1;
    } else {
        $result_error += 0;
    }
    if(!$tableThreeResult) {
        $result_error += 1;
    } else {
        $result_error += 0;
    }
    if(!$tableFourResult) {
        $result_error += 1;
    } else {
        $result_error += 0;
    }
    if(!$tableFiveResult) {
        $result_error += 1;
    } else {
        $result_error += 0;
    }
    
    if($result_error > 0 ) {    //error if there was problem to rename table name
        $_SESSION['errorKey']   = 2;
        $_SESSION['successKey'] = 0;
        header("location:userList.php");
    } else {                    //success if there was success to rename table name
        $_SESSION['errorKey']   = 0;
        $_SESSION['successKey'] = 2;
        header("location:userList.php");
    }
} else {
    header("location:index.php");
}
