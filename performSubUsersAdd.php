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
$srNo = 1;
$sqll = "SELECT *  from ".$username."_report where  product_name = '{$product_name}' or datetime = '{$product_name}' or sell_price = '{$product_name}' or adder = '{$product_name}';";
$resultt = mysqli_query($conn, $sqll);
if($conn->error){
    echo "error";
}
$output = "";
$output .= '
<table class="table table-hover bg-white rounded mb-0 pr-5 pl-5 mt-3">
    <thead>
        <tr>
            <th class="text-nowrap" scope="col" width="60px">Sr no</th>
            <th class="text-nowrap" scope="col" width="120px">Product Name</th>
            <th class="text-nowrap" scope="col" width="60px">Rate</th>
            <th class="text-nowrap" scope="col" width="60px">Quantity</th>
            <th class="text-nowrap" scope="col" width="100px">GST</th>
            <th class="text-nowrap" scope="col" width="100px">Sell Price</th>
            <th class="text-nowrap" scope="col" width="100px">Date</th>
           
            <th class="text-nowrap" scope="col" width="100px">User</th>
        </tr> 
    </thead>
    <tbody>';
$i = 0;
if (mysqli_num_rows($resultt) > 0) {
    $i = 1;


		while ($rows1 = mysqli_fetch_assoc($resultt)) {
      
            
                 
                $output .= "
					<tr>
                        <td class='pl-5 pr-5 text-nowrap' >{$srNo}</td>
                        <td class='pl-5 pr-5 text-nowrap' >{$rows1["product_name"]}</td>
                        <td class='pr-5 pl-5 text-nowrap'>{$rows1["rate"]}</td>
                        <td class='pr-5 pl-5 text-nowrap'>{$rows1["qty"]}</td>
                        <td class='pr-5 pl-5 text-nowrap'>{$rows1["gst"]}</td>
                        <td class='pr-5 pl-5 text-nowrap'>{$rows1["sell_price"]}</td>
                        <td class='pr-5 pl-5 text-nowrap'>{$rows1["datetime"]}</td>
                        <td class='pr-5 pl-5 text-nowrap'>{$rows1["adder"]}</td>

                    <tr>";
                    $srNo++;
        }
            
        
		 
}
 

$sql = "SELECT * from ".$username."_report where  product_name like '%{$product_name}%' or datetime like '%{$product_name}%' or sell_price like '%{$product_name}%' or adder like '%{$product_name}%';";
$result = mysqli_query($conn, $sql);



if (mysqli_num_rows($result) > 0) {
	  

		while ($rows = mysqli_fetch_assoc($result)) {
                if($product_name == $rows["adder"]  || $product_name == $rows["product_name"] || $product_name == $rows["datetime"] || $product_name == $rows["sell_price"]){
                    continue;
                }
            
                 
                $output .= "
                    <tr>
                        <td class='pl-5 pr-5 text-nowrap'>{$srNo}</td>
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
else{
	echo "Records Not Found!";
}

?>
