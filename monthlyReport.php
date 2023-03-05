<?php

include 'conn.php';
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
	<title>Monthly Report</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><?php require("links.php"); ?>
</head>

<body class="text-white">
	<!-- The navbar code -->	
    <?php require "navbar.php"; ?>
    <br>
<script>
    //for changing the class name (# replacement for active class)
    var element = document.getElementById("report");
    element.classList.remove("text-light");
    element.classList.add("text-white");
    var elementt = document.getElementById("mreport");
    elementt.classList.remove("text-light");
    elementt.classList.add("text-white");
</script> 
	
<div class="centered form-div" style="margin-bottom:78vh;">
	<div class="mt-0 mb-2 " style="font-weight:bold; color: #666"><span class="h3">MONTHLY REPORT</span></div>
	<table class="mt-2" id="table" style="margin:0 auto;">
		<tr>
			<td id="header">
				<div id="search-bar">
					<select id="year">
						<option>Select Year</option>	
						<?php
                            $sql = "SELECT DISTINCT DATE_FORMAT(".$username."_products.datetime,'%Y') as date FROM ".$username."_products ORDER BY `".$username."_products`.`datetime` ASC";
                            $result = mysqli_query($conn, $sql);

                            while ($rows = mysqli_fetch_assoc($result)) {
                                ?>
								<option value="<?php echo $rows['date']; ?>">
                                        <?php echo $rows['date']; ?></option>
						<?php
                            }
                        ?>
					</select>
					<select id="month">
						<option >Select Month</option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>			
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					<button id="button"  style="padding:6px 1rem;">Ok</button>
					<hr>
				</div>			
			</td>
		</tr>
		<tr id="printOnly">
			<td id="table-data">
				<?php
                    $selltable = $_SESSION['username']."_sell";
                    $custtable = $_SESSION['username']."_customer";
                    $prodtable = $_SESSION['username']."_products";
                    $reporttable = $_SESSION['username']."_report";
                   
                    $productt = array();
                    $producttid = array();
                    $stkarr = array(0);
                    $stksoldarr = array(0);
                    $sellpricearr = array(0);
                    $prodprofitarr = array(0);
                    $totalprofit = 0;
                    date_default_timezone_set("asia/kolkata");
                    $currentstartmonth = date("y-m-01 0:0:0");
                    $currentendmonth = date("y-m-31 23:59:59");

                $sql = "select * from $prodtable where datetime between '$currentstartmonth' and '$currentendmonth'";
                $result = $conn->query($sql);
                $turnover = 0;
                $prodturnover = array();
                if ($result->num_rows > 0) {
                    $i=1;
                    while ($rows = $result->fetch_assoc()) {
                        $productt[$i] = $rows['product_name'];
                        $producttid[$i] = $rows['product_id'];
                        $producttprice[$i] = $rows['sell_price'];
                        $producttprice2[$i] = $rows['sell_price'];
                        $producttrate[$i] = $rows['rate'];
                        $producttgst[$i] = $rows['gst'];
                        $stkprc = "select * from $reporttable where product_name = '$productt[$i]' and
						  (datetime between '$currentstartmonth' and '$currentendmonth')";
                        $stkprcresult = $conn->query($stkprc);
                        if ($stkprcresult->num_rows > 0) {
                            $stkint = 0;
                            while ($stkrows = $stkprcresult->fetch_assoc()) {
                                $stkint += (double)$stkrows['qty'];
                            }
                            array_push($stkarr, $stkint);
                        }
                        $stksold = "select * from $selltable where product_id = '$producttid[$i]' and
						(datetime between '$currentstartmonth' and '$currentendmonth')";
                        $stksoldresult = $conn->query($stksold);
                        if ($stksoldresult->num_rows > 0) {
                            $soldint = 0;
                            while ($stksoldrows = $stksoldresult->fetch_assoc()) {
                                $producttprice[$i] = $stksoldrows['total'];
                                $soldint += (double) $stksoldrows['qty'];
                                $sellqty[$i] = $stksoldrows['qty'];
                            }
                            
                            array_push($stksoldarr, $soldint);
                        } else {
                            $sellqty[$i] = 0;
                            array_push($stksoldarr, 0);
                        }
                        $monthlysales = "select * from $selltable where product_id = '$producttid[$i]' and
							(datetime between '$currentstartmonth' and '$currentendmonth');";
                        $salesresult = $conn->query($monthlysales);
                        if($salesresult->num_rows > 0){
                        $salesprice = 0; $prodprofit = 0;
                        while($salerows = $salesresult->fetch_assoc()){
                            $salesprice += (double) $salerows['total']; 
                            $prodprofit += (double) $salerows['total'] - 
                            ((($salerows['rate'] +($salerows['rate'] / 100)
                             * $salerows['gst'])) * $salerows['qty']);
                            
                        }
                        array_push($sellpricearr, $salesprice);
                        $prodturnover[$i] = $salesprice;
                        $turnover += (double) $prodturnover[$i];
                        array_push($prodprofitarr, $prodprofit);
                        $totalprofit += (double) $prodprofit;
                        }
                        else {
                            $prodturnover[$i] = 0;
                            $sellpricearr[$i] = 0;
                            array_push($prodprofitarr, 0);
                            $totalprofit += (double) 0;
                        }
                         if ($conn->error) {
                            echo "error come back later";
                        }
                      
                        $i++;

                    }

                    echo '<div style="color: #666" class="mb-3"><span class="h5">MONTHLY REPORT OF CURRENT MONTH</span></div>';
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
                             //$sellpricearr[$i] = 0;
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
                else {
                    echo "<b class='text-dark'>no data</b>";
                }                
                ?>
			</td>
        </tr>
	</table>
    <button type="button" onclick="printOnly()"><i class="fa fa-print"></i> PRINT </button>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
		$("#button").on("click", function(){
			var year_selected = $("#year").val();
			var month_selected = $("#month").val();
				$.ajax({  
					url: "performMonthly.php",
					type: "POST",
					data: {year:year_selected,month:month_selected},
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