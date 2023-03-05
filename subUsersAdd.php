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
	<title>Subusers Stock</title>
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
   
    document.getElementById("addsubUsers").classList.add("activee");
</script>

	<div class="centered form-div" style="margin-bottom:78vh;">
	<div class="mt-0 mb-2 " style="font-weight:bold; color: #666"><span class="h3">SUB-USER ADDED PRODUCTS INFO</span></div>
		
			 
					<input type="search" id="search" placeholder="Enter subuser" autocomplete="off" title="enter subuser or date or product name or sell price">
					<button id="button" style="padding:6px 1rem">Search</button>
					<hr>
		<table class="mt-2" id="table" style="margin:0 auto;"> 
			<tr>
				<td id="table-data">
					<?php
                        $sql = "SELECT * from ".$username."_report;";
                        $result = mysqli_query($conn, $sql);

                        $output = "";
						$srNo = 1;
                        

                        if (mysqli_num_rows($result) > 0) {
                            $output = '
								<table class="table table-hover bg-white rounded mb-0 pr-5 pl-5 mt-3">
									<thead>
										<tr>
										<th class="text-nowrap" scope="col" width="50px">Sr no</th>
											<th class="text-nowrap" scope="col" width="120px">Product Name</th>
											<th class="text-nowrap" scope="col" width="60px">Rate</th>
											<th class="text-nowrap" scope="col" width="60px">Quantity</th>
											<th class="text-nowrap" scope="col" width="100px">GST</th>
											<th class="text-nowrap" scope="col" width="100px">Sell Price</th>
											<th class="text-nowrap" scope="col" width="100px">Datetime</th>
											<th class="text-nowrap" scope="col" width="100px">User</th>
										</tr> 
									</thead>
									<tbody>';

                             while ($rows = mysqli_fetch_assoc($result)) {
                            	 
                            	
                            		
                            		$output .= "
										<tr>
										    <td class='pr-5 pl-5 text-nowrap'>{$srNo}</td>
											<td class='pl-5 pr-5 text-nowrap'>{$rows["product_name"]}</td>
											<td class='pr-5 pl-5 text-nowrap'>{$rows["rate"]}</td>
											<td class='pr-5 pl-5 text-nowrap'>{$rows["qty"]}</td>
											<td class='pr-5 pl-5 text-nowrap'>{$rows["gst"]}</td>
											<td class='pr-5 pl-5 text-nowrap'>{$rows["sell_price"]}</td>
											<td class='pr-5 pl-5 text-nowrap'>{$rows["datetime"]}</td>
											<td class='pr-5 pl-5 text-nowrap'>{$rows["adder"]}</td>

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
					url: "performSubUsersAdd.php",
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