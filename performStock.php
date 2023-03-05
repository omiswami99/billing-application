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
$srno = 1;
$product_name = $_POST['pname'];


$sql = "SELECT * from ".$username."_products where  product_name like '%{$product_name}%' or datetime like '%{$product_name}%' or sell_price like '%{$product_name}%';";
$result = mysqli_query($conn, $sql);

$output = "";

if (mysqli_num_rows($result) > 0) {
	$output = '
			<table class="table table-hover bg-white rounded mb-0 mt-3">
				<thead>
					<tr>
						<th class="text-nowrap" scope="col" width="50px">Sr no</th>
						<th class="text-nowrap" scope="col" width="120px">Product Name</th>
						<th class="text-nowrap" scope="col" width="60px">Rate</th>
						<th class="text-nowrap" scope="col" width="60px">Quantity</th>
						<th class="text-nowrap" scope="col" width="100px">GST</th>
						<th class="text-nowrap" scope="col" width="100px">Sell Price</th>
						<th class="text-nowrap" scope="col" width="100px">Status</th>
					</tr> 
				</thead>
				<tbody>';

		while ($rows = mysqli_fetch_assoc($result)) {
            if($rows['qty'] < $rows['lowlimit'])
            {
                $status = "Less than ".$rows['lowlimit']." Remaining";
                $output .= "
					<tr>
						<td class='text-nowrap'>{$srno}</td>
						<td class='text-nowrap' scope='row'>{$rows["product_name"]}</td>
						<td class='text-nowrap'>{$rows["rate"]}</td>
						<td class='text-nowrap text-danger font-weight-bold' >{$rows["qty"]}</td>
						<td class='text-nowrap'>{$rows["gst"]}</td>
						<td class='text-nowrap'>{$rows["sell_price"]}</td>
						<td class='text-nowrap'>{$status}</td>

					<tr>";
            }
            else if($rows['qty'] >= $rows['lowlimit'] && $rows['qty'] < ((double)$rows['fix_qty'] * (80/100)))
           	{
             	$status = "Moderate Stock Remaining";
             	$output .= "
					<tr class=''>
						<td class='text-nowrap'>{$srno}</td>
						<td class='text-nowrap' scope='row'>{$rows["product_name"]}</td>
						<td class='text-nowrap'>{$rows["rate"]}</td>
						<td class='text-nowrap text-warning font-weight-bold'>{$rows["qty"]}</td>
						<td class='text-nowrap'>{$rows["gst"]}</td>
						<td class='text-nowrap'>{$rows["sell_price"]}</td>
						<td class='text-nowrap'>{$status}</td>
					<tr>";
            }
            else if($rows['qty'] >= ((double)$rows['fix_qty'] * (80/100)) && $rows['qty'] <= $rows['fix_qty'])
            {
                $status = "Maximum Stock Remaining";
                $output .= "
					<tr class=''>
						<td class='text-nowrap'>{$srno}</td>
						<td class='text-nowrap' scope='row'>{$rows["product_name"]}</td>
						<td class='text-nowrap'>{$rows["rate"]}</td>
						<td class='text-nowrap text-success font-weight-bold'>{$rows["qty"]}</td>
						<td class='text-nowrap'>{$rows["gst"]}</td>
						<td class='text-nowrap'>{$rows["sell_price"]}</td>
						<td class='text-nowrap'>{$status}</td>
					<tr>";
			}
			$srno++;
        }
        
		$output .= "
					</tbody>
				</table>
				";

		echo $output;
}
else{
	echo "Records Not Found!";
}

?>
