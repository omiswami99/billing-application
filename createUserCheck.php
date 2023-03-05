<?php
session_start();

include "conn.php";
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

    //checking whether username is already taken
    $usernameSql    = "SELECT * from `login_table` where username = '$username'";
    $usernameResult = mysqli_query($conn, $usernameSql);
    $checkNoOfUsers = mysqli_num_rows($usernameResult);

    if ($checkNoOfUsers == 1) {
        $_SESSION['errorKey'] = 2;
        $_SESSION['successKey'] = 0;
        header("location:createUser.php");
    } else {
        //inserting  fname, lname, mobile no in user_table table
        $insertloginSql = "INSERT into `login_table` (`username`, `password`) values ('$username', '$password')";
        $insertloginResult = mysqli_query($conn, $insertloginSql);

        $getIdQuery = "SELECT login_id as id FROM  `login_table` WHERE username = '$username'";
        $result_getIdQuery = mysqli_query($conn, $getIdQuery);
        $dataId = mysqli_fetch_array($result_getIdQuery);
        $id = $dataId['id'];
        
        $insertUserSql  = "
        INSERT INTO `user_table` ( 
            `user_id`, 
            `fname`, 
            `lname`, 
            `mobile1`, 
            `mobile2`
            ) 
            VALUES ( 
                $id, 
                '$fname', 
                '$lname', 
                '$mobile1', 
                '$mobile2'
            )
            ;";
        $insertshopSql  = "INSERT INTO `shop_table` (`shop_id`, `shop_name`, `shop_gst_no`, `shop_address`) VALUES ($id, '$shopname', '$gstNumber', '$address')";
        
        //running query to insert data in tables
        $insertUserResult  = mysqli_query($conn, $insertUserSql);
        $insertshopResult  = mysqli_query($conn, $insertshopSql);
    
        //queries for creating tables
        $tableOneSql    = "CREATE TABLE ".$username."_products  ( 
            `product_id` INT(255) NOT NULL AUTO_INCREMENT , 
            `product_name` VARCHAR(255) NOT NULL , 
            `rate` VARCHAR(255) NOT NULL , 
            `fix_qty` VARCHAR(250) NOT NULL ,
            `qty` VARCHAR(250) NOT NULL , 
            `gst` VARCHAR(25) NOT NULL , 
            `cgst` VARCHAR(25) NOT NULL ,
            `sgst` VARCHAR(25) NOT NULL , 
            `sell_price` VARCHAR(255) NOT NULL , 
            `lowlimit` VARCHAR(255) NOT NULL , 
            `datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (`product_id`))
            ";
        $tableTwoSql    = "CREATE TABLE ".$username."_sell ( 
            `sr_no` INT(255) NOT NULL AUTO_INCREMENT , 
            `bill_no` INT(255) NOT NULL , 
            `product_id` INT(255) NOT NULL , 
            `qty` VARCHAR(250) NOT NULL ,
            `gst` VARCHAR(250) NOT NULL ,
            `rate` VARCHAR(250) NOT NULL , 
            `sellprice` VARCHAR(250) NOT NULL ,
            `total` VARCHAR(250) NOT NULL , 
            `discount` VARCHAR(250) NULL , 
            `seller` VARCHAR(250) NOT NULL ,
            `datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (`sr_no`))
            ";
        $tableThreeSql  = "CREATE TABLE ".$username."_customer ( 
            `customer_id` INT(255) NOT NULL AUTO_INCREMENT , 
            `customer_name` VARCHAR(255) NOT NULL , 
            `customer_mobile` VARCHAR(255) NOT NULL,
            `dateTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (`customer_id`)) ENGINE = InnoDB
            ";
        $tableFourSql   = "CREATE TABLE ".$username."_customerbill ( 
            `sr_no` INT(255) NOT NULL AUTO_INCREMENT ,
            `customer_id` INT(255) NOT NULL , 
            `bill_no` INT(255) NOT NULL , 
            `total_price` VARCHAR(255) NOT NULL , 
            `datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (`sr_no`))
            ";
        $tableFiveSql = "CREATE TABLE ".$username."_report ( 
            `Sr_no` INT(255) NOT NULL AUTO_INCREMENT , 
            `product_name` VARCHAR(255) NOT NULL , 
            `rate` VARCHAR(255) NOT NULL , 
            `fix_qty` VARCHAR(250) NOT NULL ,
            `qty` VARCHAR(250) NOT NULL , 
            `gst` VARCHAR(25) NOT NULL , 
            `cgst` VARCHAR(25) NOT NULL ,
            `sgst` VARCHAR(25) NOT NULL , 
            `sell_price` VARCHAR(255) NOT NULL , 
            `lowlimit` VARCHAR(255) NOT NULL , 
            `adder` VARCHAR(255) NOT NULL,  
            `datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
            PRIMARY KEY (`Sr_no`))
        ";
        $tableSixSql = "CREATE TABLE ".$username."_subusers (
            `sr_no` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `fname` VARCHAR(255) NOT NULL,
            `username` VARCHAR(255) NOT NULL,
            `spassword` VARCHAR(255) NOT NULL, 
            `mobile` VARCHAR(255) NOT NULL, 
            `status` VARCHAR(255) NOT NULL
        )";


        //running queries to create tables
        $tableTwoResult   = mysqli_query($conn, $tableTwoSql);
        $tableOneResult   = mysqli_query($conn, $tableOneSql);
        $tableThreeResult = mysqli_query($conn, $tableThreeSql);
        $tableFourResult  = mysqli_query($conn, $tableFourSql);
        $tableFiveResult  = mysqli_query($conn, $tableFiveSql);
        $tableSixResult  = mysqli_query($conn, $tableSixSql);

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
        if(!$tableSixResult) {
            $result_error += 1;
        } else {
            $result_error += 0;
        }
        
        if($result_error > 0 ) {    //error if there was problem to create tables
            $_SESSION['errorKey']   = 2;
            $_SESSION['successKey'] = 0;
            header("location:createUser.php");
        } else {                    //success if there was success to create all tables
            $_SESSION['errorKey']   = 0;
            $_SESSION['successKey'] = 2;
            $_SESSION["subusrcrt"] = 0;
            $_SESSION["uniqUserNm"] = 0;
            header("location:createUser.php");
        }
    }
} else {
    header("location:createUser.php");
}
