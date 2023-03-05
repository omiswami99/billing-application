<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "billing_application";


$conn = mysqli_connect($servername, $username, $password);
$queryCreateDB = "CREATE DATABASE $database";
$rQueryCreateDB = mysqli_query($conn, $queryCreateDB);
if ($rQueryCreateDB) {
    $conn = mysqli_connect($servername, $username, $password, $database);

    $queryCreate_login_table = "CREATE TABLE `login_table` (
        `login_id` INT(255) NOT NULL AUTO_INCREMENT ,
        `username` VARCHAR(255) NOT NULL ,
        `password` VARCHAR(255) NOT NULL ,
        PRIMARY KEY  (`login_id`)) ENGINE = InnoDB;
    ";

    $queryCreate_shop_table = "CREATE TABLE `shop_table` ( 
        `shop_id` INT(255) NOT NULL AUTO_INCREMENT ,  
        `shop_name` VARCHAR(255) NOT NULL ,  
        `shop_gst_no` VARCHAR(200) NOT NULL ,  
        `shop_address` VARCHAR(255) NOT NULL ,    
        PRIMARY KEY  (`shop_id`)) ENGINE = InnoDB;
    ";

    $queryCreate_user_table = "CREATE TABLE `user_table` ( 
        `user_id` INT(225) NOT NULL AUTO_INCREMENT ,  
        `fname` VARCHAR(225) NOT NULL ,  
        `lname` VARCHAR(225) NOT NULL ,  
        `mobile1` VARCHAR(225)  NOT NULL ,  
        `mobile2` VARCHAR(225)  NULL ,    
        `dateTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (`user_id`)) ENGINE = InnoDB;
    ";

    $resultQueryCreate_login_table = mysqli_query($conn, $queryCreate_login_table);
    $resultQueryCreate_shop_table =  mysqli_query($conn, $queryCreate_shop_table);
    $resultQueryCreate_user_table = mysqli_query($conn, $queryCreate_user_table);

    if((!$resultQueryCreate_login_table) && (!$resultQueryCreate_shop_table) && (!$resultQueryCreate_user_table)) {
        echo "problem to create database tables";
    }

}

$conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn) {
    ?>
        <script>
            alert("Problem to connect with server, Please come later");
        </script>
    <?php
}

?>