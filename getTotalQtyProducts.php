<?php
session_start();
require("conn.php");


if (!isset($_SESSION['username'])) {
    header("location:login.php");
}

$qtyInput = (double)$_POST['qtyInput'];
$productName = $_POST['productName'];
$username = $_POST['username'];

$query = "SELECT qty FROM ".$username."_products WHERE product_name LIKE '%$productName%' ";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_array($result);

if(  ( (double) $data['qty'] )  >=  ( (double) ($qtyInput) )  ) { //when  product is available
    echo $qtyInput;
} else {    //when product is unavilable at given price
    echo $data['qty'];
}
