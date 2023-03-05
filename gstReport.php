<?php

include 'conn.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}

//recalling session variables
$username = $_SESSION['username'];
$shopname = $_SESSION['shopname'];
$shopaddress = $_SESSION['shopaddress'];

$security = $_SESSION['user'];

$billing_amt = 0;
$total_cgst = 0;
$total_sgst = 0;
$total_gst = 0;
$output = "";
?>

<!DOCTYPE html>
<html>

<head>
    <title>GST Report</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><?php require("links.php"); ?>
</head>

<body class="text-white">
    <!-- The navbar code -->
    <?php require "navbar.php"; ?>
    <br>
    <script>
        //for changing the class name (# replacement for active class)
        var element = document.getElementById("report");
        element.classList.remove("text-light");
        element.classList.add("text-white");
        var elementt = document.getElementById("gstreport");
        elementt.classList.remove("text-light");
        elementt.classList.add("text-white");
    </script>

    <div class="centered form-div" style="margin-bottom:78vh;">
        <div class="mt-0 mb-2 " style="font-weight:bold; color: #666"><span class="h3">GST REPORT</span></div>
        <table class="mt-2" id="table" style="margin:0 auto;">
            <tr>
                <td id="header">
                    <div id="search-bar">
                        <input type="date" name="date" id="date1">
                        <b class="text-dark">To</b>
                        <input type="date" name="date" id="date2">
                        <button id="button">Ok</button>
                        <hr>
                    </div>
                </td>
            </tr>
            <tr id="printOnly">
                <td id="table-data">
                    <?php
                    echo '<div id="printOnly"><div style="color: #666" class="mb-3"><span class="h5">OVERALL GST REPORT</span></div>';
                    $output .= "<table class='table table-hover bg-white rounded mb-0 pr-5 pl-5 mt-3'>
                            <thead>
                                <tr>
                                    <th style='width: 150px'>Bill No</th>
                                    <th style='width: 150px'>Bill Date</th>
                                    <th style='width: 150px'>Billing Amount</th>
                                    <th style='width: 150px'>GST</th>
                                    <th style='width: 150px'>CGST</th>
                                    <th style='width: 150px'>SGST</th>
                                    <th style='width: 150px'>Total GST</th> 
                                </tr>
                            </thead>
                        <tbody>";

                    $selltable = $_SESSION['username'] . "_sell";

                    $sql = "select  bill_no, DATE_FORMAT(datetime,'%d-%m-%Y') as date, total, rate, gst from $selltable";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            $output .= "<tr class=''>
                          <td>{$row['bill_no']}</td>
                          <td>{$row['date']}</td>
                          <td>{$row['total']} ₹</td>
                          <td>{$row['gst']}%</td>";

                            $cgst = ($row['gst'] / 2) * ($row['total'] / 100);
                            $sgst = ($row['gst'] / 2) * ($row['total'] / 100);
                            $sum_gst = $cgst + $sgst;

                            $output .= "<td>{$cgst} ₹</td>
                                <td>{$sgst} ₹</td>
                                <td>{$sum_gst} ₹</td>
                            </tr>";

                            $billing_amt = $billing_amt + $row['total'];
                            $total_cgst = $total_cgst + $cgst;
                            $total_sgst = $total_sgst + $sgst;
                            $total_gst = $total_gst + $sum_gst;
                        }

                        $output .= "<tr>
                        <td colspan='2'>Total</td>
                        <td>{$billing_amt}  ₹</td>
                        <td>-</td>
                        <td>{$total_cgst}  ₹</td>
                        <td>{$total_sgst}  ₹</td>
                        <td>{$total_gst} ₹</td>

                    </tr>";

                        $output .= "
                        </tbody>
                        </table>
                    ";

                        echo $output;
                    } else {
                        echo "<b class='text-dark'>Nothing is done right now please sell the products I will show you the GST report of it</b>";
                    }
                    ?>
                </td>
            </tr>
        </table>
            <button type="button" onclick="printOnly()"><i class="fa fa-print"></i> PRINT </button>
    </div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#button").on("click", function() {
                var date1 = $("#date1").val();
                var date2 = $("#date2").val();
                $.ajax({
                    url: "performGst.php",
                    type: "POST",
                    data: {
                        date1: date1,
                        date2: date2
                    },
                    success: function(data) {
                        $("#table-data").fadeIn();
                        $("#table-data").html(data);
                    }
                });
            });
        });
    </script>
</body>
</html>