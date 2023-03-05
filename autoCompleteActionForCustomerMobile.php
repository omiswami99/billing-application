<?php
session_start();
require("conn.php");

if (!isset($_SESSION['username'])) {
    header("location:login.php");
}

$inputText = $_POST['query'];
$thisId = $_POST['thisId'];
$username = $_POST['username'];

$query = "SELECT * FROM ".$username."_customer WHERE customer_mobile LIKE '%$inputText%' ";
$result = mysqli_query($conn, $query);
$row = mysqli_num_rows($result);
if ($row > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $cname = $row['customer_name'];
        echo "<a href='#' onclick='setName(".'"'.$cname.'"'.")' id='".$thisId."'>".$row['customer_mobile']."</a>";
    }
} else {
    echo "<script>setName('')</script>";
}