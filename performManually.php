<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}
$username = $_SESSION['username'];

//checking passed success from login.php page
if (isset($_SESSION['successKey'])) {
    if ($_SESSION["successKey"] == 1) {
        $_SESSION["successKey"] = 0; ?>
<script style="display:none">
    alert("Logged In Successfullt");
</script>
<?php
    }
}
?>


<?php
require "conn.php";


    $selltable = $_SESSION['username']."_sell";
    $custtable = $_SESSION['username']."_customer";
    $prodtable = $_SESSION['username']."_products";
    $reporttable = $_SESSION['username']."_report";
   
   //Fetching The Year and Month From monthlyreport.php
    $day1 = $_POST['date1'];
    $day2 = $_POST['date2'];
	$output = "";
	    
	$productt = array();
	$producttid = array();
	$stkarr = array(0);
    $stksoldarr = array(0);
    $sellpricearr = array(0);
    $prodprofitarr = array(0);
    $totalprofit = 0;
	date_default_timezone_set("asia/kolkata");
	$currentstartmonth = date("".$day1." 0:0:0");
	$currentendmonth = date("".$day2." 23:59:59");

$sql = "select * from $prodtable where datetime between '$currentstartmonth' and '$currentendmonth'";
$result = $conn->query($sql);$turnover = 0;$prodturnover = array("0");
if($result->num_rows > 0){
	$i=1;
	while($rows = $result->fetch_assoc()){
		 $productt[$i] = $rows['product_name'];
		 $producttid[$i] = $rows['product_id'];
		 $producttprice[$i] = $rows['sell_price'];
		 $producttprice2[$i] = $rows['sell_price'];
		 $producttrate[$i] = $rows['rate'];
		 $producttgst[$i] = $rows['gst'];
		 $stkprc = "select * from $reporttable where product_name = '$productt[$i]' and
		  (datetime between '$currentstartmonth' and '$currentendmonth')";
		 $stkprcresult = $conn->query($stkprc);
		 if($stkprcresult->num_rows > 0){
		 	$stkint = 0;
		 	while($stkrows = $stkprcresult->fetch_assoc()){
		 		$stkint +=(double) $stkrows['qty']; 
		 	}
		 	array_push($stkarr, $stkint);
		 }
		 $stksold = "select * from $selltable where product_id = '$producttid[$i]' and
		 (datetime between '$currentstartmonth' and '$currentendmonth')";
		 $stksoldresult = $conn->query($stksold);
		 if($stksoldresult->num_rows > 0){
		 	$soldint = 0;
		 	while ($stksoldrows = $stksoldresult->fetch_assoc()) {
		 		$producttprice[$i] = $stksoldrows['total'];
		 		$soldint += $stksoldrows['qty'];
		 		$sellqty[$i] = $stksoldrows['qty'];
		 		
		 	}
		 	
		 	array_push($stksoldarr, $soldint);
		 }else{
		 	$sellqty[$i] = 0;
		 	array_push($stksoldarr, 0);
		 }
		 $monthlysales = "select * from $selltable where product_id = '$producttid[$i]' and
			(datetime between '$currentstartmonth' and '$currentendmonth');"; 
		$salesresult = $conn->query($monthlysales);
		if($salesresult->num_rows > 0){
			$salesqty = 0;$salesprice = 0; $prodprofit = 0;
			while($salerows = $salesresult->fetch_assoc()){
				$salesprice += $salerows['total'];
				$prodprofit +=  (int) $salerows['total'] - 
                  ((($salerows['rate'] +($salerows['rate'] / 100)
                  * $salerows['gst'])) * $salerows['qty']);
			}
			array_push($sellpricearr, $salesprice);
            $prodturnover[$i] = $salesprice;
            $turnover += $prodturnover[$i];
            array_push($prodprofitarr, $prodprofit);
            $totalprofit += $prodprofit;
		}
		else {
			$prodturnover[$i] = 0;
			$sellpricearr[$i] = 0;
			array_push($prodprofitarr, 0);
            $totalprofit += 0;
		}
		 if ($conn->error) {
		 	echo "error";
		 }
		  
		$i++;

	}

	echo '<div style="color: #666" class="mb-3"><span class="h5">REPORT OF '.$day1.' BETWEEN '.$day2.'</span></div>';
	$output = 
		'<table class="table table-hover bg-white rounded mb-0 pr-5 pl-5 mt-3">
			<thead>
				<tr>
					<th>Srno</th>
					<th>Product name</th>
					<th>Stock Purchased</th>
					<th>Stock Sold</th>
					<th>Stock Balance</th>
					<th>Turnover</th>
					<th>Profit</th>	
				</tr>
			</thead>
		<tbody>';
	echo '<div style="color: #666"><span id="turnover" class="h5" style="float: left;text-decoration: underline;"></span></div>';
    echo '<div style="color: #666"><span id="totalProfit" class="h5" style="float: right;text-decoration: underline;"></span></div>';
    echo '</br>';

                    
    for ($i = 1; $i <= count($productt) ; $i++) {
        if (empty($stksoldarr[$i])) {
            $stksoldarr[$i] = 0;
             $sellpricearr[$i] = 0;
        }
        if (empty($prodprofitarr[$i])) {
            $prodprofitarr[$i] = 0;
                             
        }
                        
        //Calculating the Stock Balance
        $stkbalance = $stkarr[$i]-$stksoldarr[$i];

        $output .=
              	"<tr class=''>
					<td>{$i}</td>
					<td>{$productt[$i]}</td>
					<td>{$stkarr[$i]}</td>
					<td>{$stksoldarr[$i]}</td>
					<td>{$stkbalance}</td>
					<td>{$prodturnover[$i]}</td>
					<td>{$prodprofitarr[$i]}</td>
				</tr>";
    }

        $output .= '
				</tbody>	
				</table>';
         echo $output;
?>
 	<script>
     	document.getElementById('turnover').innerHTML = "Total Turnover = <?php echo $turnover; ?> ₹";
     	document.getElementById('totalProfit').innerHTML = "Total Profit = <?php echo $totalprofit ?> ₹";
 	</script>
<?php
}
else
{
	echo "Records Not Found";
}

?>
