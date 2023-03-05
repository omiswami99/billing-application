<?php 
session_start();
$subuserid = $_SESSION['user'];
require "conn.php";

$userID     = $_SESSION['userID'];
$emailID    = $_POST['emailID'];
$feedback   = $_POST['feedback'];

if(isset($_POST['sent'])) {
    $feedbackSql = "SELECT * FROM `customer_feedback`";
    $result_feedbackSql = mysqli_query($conn, $feedbackSql);
    if(!$result_feedbackSql) {//creates a customer_feedback table if it not exists
        $createFeedbackTable = "CREATE TABLE customer_feedback ( 
                `sr_no`  INT(255) NOT NULL AUTO_INCREMENT , 
                `user_id`  VARCHAR(255) NOT NULL , 
                `subUser_uName`  VARCHAR(255) NOT NULL ,
                `email_id` VARCHAR(255) NOT NULL , 
                `feedback` VARCHAR(255) NOT NULL , 
                `datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
                PRIMARY KEY (`sr_no`)
            );
        ";
        $result_createFeedbackTable = mysqli_query($conn, $createFeedbackTable);
    }
    //adding data to table
    $insertQuery = "INSERT INTO `customer_feedback`(
            `user_id`, 
            `subUser_uName`,
            `email_id`, 
            `feedback`
        ) 
        VALUES (
            '$userID',
            '$subuserid',
            '$emailID',
            '$feedback'
        );
    ";
    $result_insertQuery = mysqli_query($conn, $insertQuery);
    if($result_insertQuery) {
        $_SESSION['errorKey']   = 0;
        $_SESSION['successKey'] = 5;
        header("location:index.php");
    } else {
        $_SESSION['errorKey']   = 5;
        $_SESSION['successKey'] = 0;
        header("location:index.php");
    }
}
else {
    header("location:index.php");
}
?>