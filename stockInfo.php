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
    <title>Stock Info</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
	require("links.php"); 
	
	?>
    
</head>

<body onload="document.getElementById('search').focus()">

    <!-- The navbar code -->
    <?php require("navbar.php"); ?>
    <script>
        //for changing the class name (# replacement for active class)
        document.getElementById("stockinfo").classList.add("active");
        document.getElementById("stockinfo11").classList.remove("text-light");
        document.getElementById("stockinfo11").classList.add("text-white");
        
    </script>
    <br>

    <div class="container-fluid mb-5">
        <div class="d-flex justify-content-center" style="font-weight:bold; color: black">
            <span class="h3">STOCK INFO</span>
        </div>

        <div id="header" class="d-flex justify-content-center form text-center form-div">
            <input type="search" id="search" placeholder="Product Name For Search" class="rounded" autocomplete="off">
            <button type="button" id="button">Search</button>
 
        </div>
    </div>
    <div class="d-flex justify-content-center" style="margin-bottom: 70vh;">
        <?php
                        $sql = "SELECT * from ".$username."_products";
                        $result = mysqli_query($conn, $sql);

                        $output = "";
                        $status = "";
                        $srNo = 1;

                        if (mysqli_num_rows($result) > 0) {
                            $output .= '
								<table id="table-data" class="container-lg table table-hover text-center table-responsive-md bg-white z-depth-2">
									<thead>
										<tr>
											<th>Sr no</th>
											<th>Product Name</th>
											<th>Rate</th>
											<th>Quantity</th>
											<th>GST</th>
											<th>Sell Price</th>
											<th>Status</th>
										</tr> 
									</thead>
									<tbody>';

                             while ($rows = mysqli_fetch_assoc($result)) {
                            	if($rows['qty'] < $rows['lowlimit'])
                            	{
                            		$status = "Less than ".$rows['lowlimit']." Remaining";
                            		$output .= "
										<tr >
											<td>{$srNo}</td>
											<td class='text-left'>{$rows["product_name"]}</td>
											<td>{$rows["rate"]}</td>
											<td class='text-danger font-weight-bold' >{$rows["qty"]}</td>
											<td>{$rows["gst"]}</td>
											<td>{$rows["sell_price"]}</td>
											<td>{$status}</td>

										</tr>";
										$srNo++;
								}
								 
                            }

                            $sql = "SELECT * from ".$username."_products";
                        	$result = mysqli_query($conn, $sql);
                            while ($rows = mysqli_fetch_assoc($result)) {                            	
                            	if($rows['qty'] >= $rows['lowlimit'] && $rows['qty'] < ((double)$rows['fix_qty'] * (80/100)))
                            	{
                            		$status = "Moderate Stock Remaining";
									$output .= "
										 
										<tr class=''>
											<td>{$srNo}</td>
											<td class='text-left'>{$rows["product_name"]}</td>
											<td>{$rows["rate"]}</td>
											<td class='text-warning font-weight-bold'>{$rows["qty"]}</td>
											<td>{$rows["gst"]}</td>
											<td>{$rows["sell_price"]}</td>
											<td>{$status}</td>
										</tr>";
										$srNo++;
								} 
								 
                            }

                            $sql = "SELECT * from ".$username."_products";
                        	$result = mysqli_query($conn, $sql);
                            while ($rows = mysqli_fetch_assoc($result)) {	
                            	if($rows['qty'] >= ((double)$rows['fix_qty'] * (80/100)) && $rows['qty'] <= $rows['fix_qty'])
                            	{
                            		$status = "Maximum Stock Remaining";
                            		$output .= "
										<tr>
											<td>{$srNo}</td>
											<td class='text-xl-left text-md-center'>{$rows["product_name"]}</td>
											<td>{$rows["rate"]}</td>
											<td class='text-success font-weight-bold'>{$rows["qty"]}</td>
											<td>{$rows["gst"]}</td>
											<td>{$rows["sell_price"]}</td>
											<td>{$status}</td>
										</tr>";
										$srNo++;
                            	}     
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

    </div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#button").on("click", function() {
            var product_name = $("#search").val();
            $.ajax({
                url: "performStock.php",
                type: "POST",
                data: {
                    pname: product_name
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