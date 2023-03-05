<?php

include "conn.php";

session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}

//recalling session variables
$username=$_SESSION['username'];
$shopname=$_SESSION['shopname'];
$shopaddress=$_SESSION['shopaddress'];

$security = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>

<head>
	<title>Subusers Sold</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    require("links.php"); 
    ?>
</head>
<style>
    .activee{
        background: #343a40 !important;
    }   

</style>
<body class="text-white">
 
	<!-- The navbar code -->
	<?php require "navbar.php"; ?>
	<br>
<script>
    //for changing the class name (# replacement for active class)
    document.getElementById("subUsers").classList.add("active");
    document.getElementById("subUsers").classList.remove("text-light");
    document.getElementById("subUsers").classList.add("text-white");
   
    document.getElementById("soldsubUsers").classList.add("activee");
</script>

	<div class="centered form-div" style="margin-bottom:78vh;">
	<div class="mt-0 mb-2 " style="font-weight:bold; color: #666"><span class="h3">SUB-USER SOLD PRODUCTS INFO</span></div>
		
			 
					<input type="search" id="search" placeholder="Enter subuser" autocomplete="off" title="enter subuser or date or product name or sell price">
					<button id="button" style="padding:6px 1rem">Search</button>
					<hr>
            <table class="mt-2" id="table" style="margin:0 auto;">
			<tr>
				<td id="table-data">
					<?php
                        $sql = "SELECT * from ".$username."_sell;";
                        $result = mysqli_query($conn, $sql);

                        $output = "";
                        $srNo = 1; 
                        

                        if (mysqli_num_rows($result) > 0) {
                            $output = '
								<table class="table table-hover bg-white rounded mb-0 pr-5 pl-5 mt-3">
									<thead>
                                        <tr>
                                        <th>Sr no</th>
                                        <th>Product Name</th>
                                        <th>Rate</th>
                                        <th>Quantity</th>
                                        <th>GST</th>
                                        <th>Rate</th>
                                        <th>Sell Price</th>
                                        <th>Total</th>
                                        <th>User</th>
                                        <th>Datetime</th>
										</tr> 
									</thead>
									<tbody>';

                             while ($rows = mysqli_fetch_assoc($result)) {
                                $id = $rows['product_id'];
                                $srchprod = "SELECT * FROM ".$username."_products WHERE product_id = '$id'";
                                $sresult = mysqli_query($conn, $srchprod);
                                while ($rowss = mysqli_fetch_assoc($sresult)) {
                                    $pname = $rowss['product_name'];

                                }
                            		
                            		$output .= "
                                        <tr >
                                            <td>{$srNo}</td>
											<td>{$pname}</td>
											<td>{$rows["bill_no"]}</td>
											<td>{$rows["qty"]}</td>
											<td>{$rows["gst"]}</td>
                                            <td>{$rows["rate"]}</td>
                                            <td>{$rows["sellprice"]}</td>
											<td>{$rows["total"]}</td>
                                            <td>{$rows["seller"]}</td>
                                            <td>{$rows["datetime"]}</td>

                                        <tr>";
                                        $srNo++;
                            	
                            }


                            $output .= "
									</tbody>
								</table>
							";

                            echo $output;
                        }  
                        else {
                            echo "Records Not Found!";
                        } 

                    ?>
				</td>
			</tr>
		</table>
</div>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
		$("#button").on("click", function(){
			var product_name = $("#search").val();
				$.ajax({  
					url: "performSubUsersSold.php",
					type: "POST",
					data: {pname: product_name},
					success: function(data)
					{
						$("#table-data").fadeIn();
						$("#table-data").html(data);
					}
				});
		});
	});

</script>
</body>
</html>