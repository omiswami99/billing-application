<?php
session_start();
require("conn.php");

if (!isset($_SESSION['username'])) {
    header("location:login.php");
}

$inputText = $_POST['query'];
$thisId = $_POST['thisId'];
$username = $_POST['username'];

$query = "SELECT * FROM ".$username."_products WHERE product_name LIKE '%$inputText%' ";
$result = mysqli_query($conn, $query);
$row = mysqli_num_rows($result);
if ($row > 0) {
    while ($row = mysqli_fetch_array($result)) {
        echo "<a href='#' id='".$thisId."'>".$row['product_name']."</a>";
    }
}
else {
    echo "<script>
        document.getElementById('search".$thisId."').value = '';
        document.getElementById('search".$thisId."').placeholder = 'Select Available Product';
    </script>";
}
