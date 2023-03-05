<?php

session_start();

if (!isset($_SESSION['username'])) {
	header("location:login.php");
}

require "conn.php";
require "links.php";
//recalling session variables
$username=$_SESSION['username'];
$shopname=$_SESSION['shopname'];
$shopaddress=$_SESSION['shopaddress'];

$selltable = $username."_sell";
$prodtable = $username."_products";

$search_value = $_POST['search'];
$billarr = array(0);
$sql = "SELECT DISTINCT ".$username."_customer.customer_name,  ".$username."_customer.customer_mobile, ".$username."_customerbill.bill_no, ".$username."_customerbill.total_price, DATE_FORMAT(".$username."_customerbill.datetime,'%d-%m-%Y') as date, time(".$username."_customerbill.datetime) as time  from ".$username."_customer JOIN ".$username."_customerbill on ".$username."_customer.customer_id = ".$username."_customerbill.customer_id WHERE ".$username."_customer.customer_name like '%{$search_value}%' OR ".$username."_customerbill.bill_no like '{$search_value}' OR  DATE_FORMAT(".$username."_customerbill.datetime,'%d-%m-%Y') like '{$search_value}'";
$result = mysqli_query($conn, $sql);

$srno = 1;
$output = "";
$output2 = "";
if(mysqli_num_rows($result) > 0){?>
	<div class="mt-3 mb-2" style="color: black;">
		<span class="h4">
			COSTUMER DETAILS
		</span>
	</div>

	<strong></strong>
	<?php

	$output = '
		<div class="table-responsive">
		<table class="table container table-hover bg-white rounded  mb-0 mt-3 z-depth-2">
			<thead>
				<tr>
					<th class="text-nowrap" scope="col" width="50px">Sr no</th>
					<th class="text-nowrap" scope="col" width="120px">Customer Name</th>
					<th class="text-nowrap" scope="col" width="120px">Mobile Number</th>
					<th class="text-nowrap" scope="col" width="60px">Bill No</th>
					<th class="text-nowrap" scope="col" width="60px">Total Bill</th>
					<th class="text-nowrap" scope="col" width="100px">Time</th>
					<th class="text-nowrap" scope="col" width="100px">Date</th>
				</tr> 
			</thead>
			<tbody>';

			while($rows = mysqli_fetch_assoc($result)){
				array_push($billarr, $rows["bill_no"]);
				$output .= "
				<tr class=''>
					<td class='pr-5 pl-5 text-nowrap'>{$srno}</td>
					<td class='pl-5 pr-5 text-nowrap' scope='row'>{$rows["customer_name"]}</td>
					<td class='pl-5 pr-5 text-nowrap' scope='row'>{$rows["customer_mobile"]}</td>
					<td class='pr-5 pl-5 text-nowrap'>{$rows["bill_no"]}</td>
					<td class='pr-5 pl-5 text-nowrap'>{$rows["total_price"]}</td>
					<td class='pr-5 pl-5 text-nowrap'>{$rows["time"]}</td>
					<td class='pr-5 pl-5 text-nowrap'>{$rows["date"]}</td>
				<tr>";
				$srno++;
			}
	$output .= "
			</tbody>
		</table>
		</div>
	";

	echo $output;
}
else
{
	echo "Record Not Found!";	
}
$selprod = "";
$selsell = ""; 
if (count($billarr) > 1) {
	$output2 .= '
		<div class="mt-4 mb-2 container" style="color: black;">
			<span class="h4">
				PRODUCT DETAILS
			</span>
		</div>
		<div class="table-responsive">
		<table class="table container table-hover bg-white rounded mb-0 mt-3 z-depth-2">
			<thead>
				<tr>
					<th class="text-nowrap" scope="col" width="50px">Sr no</th>
					<th class="text-nowrap" scope="col" width="60px">Bill No</th>
					<th class="text-nowrap ml-2" scope="col" width="100px">Product Name</th>
					<th class="text-nowrap" scope="col" width="=60px">Quantity</th>
					<th class="text-nowrap" scope="col" width="=60px">Total</th>
					<th class="text-nowrap" scope="col" width="=10px">Time</th>
					<th class="text-nowrap" scope="col" width="=10px">Date</th>
				</tr> 
			</thead>
			<tbody>'; 
}
for ($i=1; $i < count($billarr); $i++) { 	
	$selsell = "SELECT `sr_no`, `bill_no`, `product_id`, `qty`, `gst`, `rate`, `total`, `discount`, DATE_FORMAT(`datetime`,'%d-%m-%Y') as date,  time(`datetime`) as time from ".$username."_sell WHERE bill_no = '$billarr[$i]'";
	$ressel = $conn->query($selsell);
	if($ressel->num_rows > 0){?>
		
		<?php
		$srno = 1;
		while($rows = mysqli_fetch_assoc($ressel)){
			$id = $rows['product_id'];
			
			$selprod = "SELECT * FROM $prodtable WHERE product_id = '$id'";
			$resprod = $conn->query($selprod);
			if($resprod->num_rows > 0){
				
				while($rowss = mysqli_fetch_assoc($resprod)){
					$output2 .= "
				<tr class=''>				
					<td class='pr-5 pl-5 text-nowrap'>{$srno}</td>	 
					<td class='pr-5 pl-5 text-nowrap'>{$rows["bill_no"]}</td>
					<td class='pr-5 pl-5 text-nowrap'>{$rowss["product_name"]}</td>
					<td class='pr-5 pl-5 text-nowrap'>{$rows["qty"]}</td>
					<td class='pr-5 pl-5 text-nowrap'>{$rows["total"]}</td>
					<td class='pr-5 pl-5 text-nowrap'>{$rows["time"]}</td>
					<td class='pr-5 pl-5 text-nowrap'>{$rows["date"]}</td>
				<tr>";
				$srno++;
				}

			}
		}
		
	}
}
if (count($billarr) > 1) {
	$output2 .= "
				</tbody>
			</table>
			</div>
		";
		echo $output2;
}
?>