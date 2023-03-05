<?php

$servername = "sql305.epizy.com";
$username = "epiz_27507086";
$password = "HbKb184ChB";
$database = "epiz_27507086_billing";

$conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn) {
    ?>
        <script>
            alert("Problem to connect with server, Please come later");
        </script>
    <?php
}

?>

