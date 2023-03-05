<?php


session_start();
if (!isset($_SESSION['username'])) {
	header("location:login.php");
}

require "conn.php";
require "links.php";

//recalling session variables
$username = $_SESSION['username'];
$shopname = $_SESSION['shopname'];
$shopaddress = $_SESSION['shopaddress'];
$srno = 1;
$product_name = $_POST['pname'];
$prd_id = "";
$qry = "Select * from ".$username."_products where product_name = '$product_name';";
$resulttqry = mysqli_query($conn, $qry);
while ($rows12 = mysqli_fetch_assoc($resulttqry)) {
    $prd_id = $rows12["product_id"];
} 
 
$sqll = "SELECT *  from ".$username."_sell where product_id = '{$prd_id}' or seller = '{$product_name}' or datetime = '{$product_name}' or sellprice = '{$product_name}';";
$resultt = mysqli_query($conn, $sqll);
if($conn->error){
    echo $conn->error;
}
$srNo = 1;
$output = "";
$output .= '
<table class="container-lg table table-hover text-center table-responsive-md bg-white">
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
$i = 0;
if($conn->error){
    echo $conn->error;
}
if (mysqli_num_rows($resultt) > 0) {
    $i = 1;


		while ($rows1 = mysqli_fetch_assoc($resultt)) {
            $id = $rows1['product_id'];
            $srchprod = "SELECT * FROM ".$username."_products WHERE product_id = '$id'";
            $sresult = mysqli_query($conn, $srchprod);
            while ($rowss = mysqli_fetch_assoc($sresult)) {
               
                $pname = $rowss['product_name'];

            }
            
                 
                $output .= "
                    <tr>
                    <td>{$srNo}</td>
                    <td>{$pname}</td>
                    <td>{$rows1["bill_no"]}</td>
                    <td>{$rows1["qty"]}</td>
                    <td>{$rows1["gst"]}</td>
                    <td>{$rows1["rate"]}</td>
                    <td>{$rows1["sellprice"]}</td>
                    <td>{$rows1["total"]}</td>
                    <td>{$rows1["seller"]}</td>
                    <td>{$rows1["datetime"]}</td>

                    <tr>";
                    $srNo++;
        }
            
        
		 
}
 
$qry = "Select * from ".$username."_products where product_name like '%$product_name%';";
$resulttqry = mysqli_query($conn, $qry);
while ($rows12 = mysqli_fetch_assoc($resulttqry)) {
    $prd_id = $rows12["product_id"];
} 
$sql = "SELECT * from ".$username."_sell where product_id like '%{$prd_id}%' or  seller like '%{$product_name}%' or datetime like '%{$product_name}%' or sellprice like '%{$product_name}%' or seller like '%{$product_name}%';";
$result = mysqli_query($conn, $sql);

if($conn->error){
    echo $conn->error;
}

if (mysqli_num_rows($result) > 0) {
	  $x = 0;

        while ($rows = mysqli_fetch_assoc($result)) { 
            $id = $rows['product_id'];
                $srchprod = "SELECT * FROM ".$username."_products WHERE product_id = '$id'";
                $sresult = mysqli_query($conn, $srchprod);
                while ($rowss = mysqli_fetch_assoc($sresult)) {
                    
                    $pname = $rowss['product_name'];

                }
                if($product_name == $rows["seller"]  || $product_name == $pname || $product_name == $rows["datetime"] || $product_name == $rows["sellprice"]){
                   $x = 1; 
                   continue;
                } 
                
                 
                $output .= "
                    <tr>
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
else{
	echo "Records Not Found!";
}

?>