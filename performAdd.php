<?php
session_start();
$adder = $_SESSION['seller'];
require("conn.php");

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}
function isNullInput($value)
{
    if ($value == "") {
        return "0";
    } else {
        return $value;
    }
}

//recalling session variables
$username=$_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //for getting counted number of input rows
    $num_of_inputs = $_POST['countField'];

    //adding all the rows with while loop
    while ($num_of_inputs) {
        //storing field values in saperate variables
        if ((isNullInput($_POST["product_name$num_of_inputs"]) == "0") || (isNullInput($_POST["specification$num_of_inputs"]) == "0") || (isNullInput($_POST["product_rate$num_of_inputs"]) == "0") || (isNullInput($_POST["product_qty$num_of_inputs"]) == "0") || (isNullInput($_POST["qty_limit$num_of_inputs"]) == "0")) {
            //just do nothing boss!!
        } else {
            $result_error = 0;
            $product_name  =  $_POST["product_name$num_of_inputs"]." ".$_POST["specification$num_of_inputs"];
            $product_rate  =  $_POST["product_rate$num_of_inputs"];
            $product_qty   =  $_POST["product_qty$num_of_inputs"];
            $qty_limit = $_POST["qty_limit$num_of_inputs"];
            $limitArr = explode('%', $qty_limit);
            if (isset($limitArr[1])) {
                $Original_limit = $product_qty * $limitArr[0]/100 ;               
            }
            else
            {
                $Original_limit = $limitArr[0];              
            }
            
            $product_gst = 0; 

            if (isNullInput($_POST["product_gst$num_of_inputs"]) == '0') {
                $product_gst = 0;
            } else {
                $product_gst   =  $_POST["product_gst$num_of_inputs"];
            }
            if (isNullInput($_POST["sell_price$num_of_inputs"]) == '0') {
                $product_sell_price = $product_rate;
            } else {
                $product_sell_price =  $_POST["sell_price$num_of_inputs"];
            }
            $cgst = (double) (((double)$product_gst) / 2);
            $sgst = (double) (((double)$product_gst) / 2);

            $checkQuery = "SELECT * FROM ".$username."_products WHERE `product_name` = '$product_name'";
            $checkQueryResult = mysqli_query($conn, $checkQuery);

            $numOfRows = mysqli_num_rows($checkQueryResult);

            //if product alerady exists then updating (rate, gst, qty, discount, sellprice) else just insert
            if ($numOfRows > 0) {
                $tempData = mysqli_fetch_array($checkQueryResult);
                $product_rate = ((double) $product_rate);
                $product_gst = ((double) $product_gst);
                $cgst = ((double) $product_gst / 2);
                $sgst = ((double) $product_gst / 2);
                $product_qty = ((double) $product_qty) + ((double) $tempData['qty']);
                $product_sell_price = ((double) $product_sell_price);
                $product_id = $tempData['product_id'];

                $updateQuery = "
                    UPDATE ".$username."_products 
                    SET 
                    `rate` = '$product_rate', 
                    `fix_qty` = '$product_qty',
                    `qty` = '$product_qty', 
                    `gst` = '$product_gst',
                    `cgst` = '$cgst',
                    `sgst` = '$sgst', 
                    `datetime` = CURRENT_TIMESTAMP(),
                    `sell_price` = '$product_sell_price',
                    `lowlimit` = '$Original_limit' 
                    WHERE `product_id` = $product_id;
                ";

                $result_updateQuery = mysqli_query($conn, $updateQuery);

                //inserting into report
                $insertReportSql = "INSERT INTO ".$username."_report (
                    `product_name`, 
                    `rate`, 
                    `fix_qty`,
                    `qty`, 
                    `gst`,
                    `cgst`,
                    `sgst`, 
                    `sell_price`,
                    `lowlimit`,
                    `adder`
                ) 
    
                VALUES (
                    '$product_name', 
                    '$product_rate',
                    '$product_qty', 
                    '$product_qty', 
                    '$product_gst', 
                    '$cgst',
                    '$sgst',
                    '$product_sell_price',
                    '$Original_limit',
                    '$adder'
                );
                ";
                $insertReportResult = mysqli_query($conn, $insertReportSql);

                if (!$result_updateQuery) {
                    $result_error = 1;
                } else {
                    $result_error = 0;
                }
            } else {
                //query to add product
                $insertQuery = "
                    INSERT INTO ".$username."_products (
                        `product_name`, 
                        `rate`, 
                        `fix_qty`,
                        `qty`, 
                        `gst`,
                        `cgst`,
                        `sgst`, 
                        `sell_price`,
                        `lowlimit`
                    ) 
        
                    VALUES (
                        '$product_name', 
                        '$product_rate',
                        '$product_qty', 
                        '$product_qty', 
                        '$product_gst', 
                        '$cgst',
                        '$sgst',
                        '$product_sell_price',
                        '$Original_limit'
                    );
                ";
                //running the add product query
                $result_insertQuery = mysqli_query($conn, $insertQuery);

                //inserting into report
                $insertReportSql = "
                INSERT INTO ".$username."_report (
                    `product_name`, 
                    `rate`, 
                    `fix_qty`,
                    `qty`, 
                    `gst`,
                    `cgst`,
                    `sgst`, 
                    `sell_price`,
                    `lowlimit`,
                    `adder`
                ) 
    
                VALUES (
                    '$product_name', 
                    '$product_rate',
                    '$product_qty', 
                    '$product_qty', 
                    '$product_gst', 
                    '$cgst',
                    '$sgst',
                    '$product_sell_price',
                    '$Original_limit',
                    '$adder'
                );
                ";
                $insertReportResult = mysqli_query($conn, $insertReportSql);

                
                if (!$result_insertQuery) {
                    $result_error = 1;
                } else {
                    $result_error = 0;
                }
            }
            if ($result_error) {
                $_SESSION["errorKey"] = 1;
            } elseif (!$result_error) {
                $_SESSION["successKey"] = 1;
            }
        }

        $num_of_inputs--;
    }
    //showing result for above operation
    header("location:add.php");
}
