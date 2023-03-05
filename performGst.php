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

$billing_amt = 0;
$total_cgst = 0;
$total_sgst = 0;
$total_gst = 0;
$output = "";

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
	    
	date_default_timezone_set("asia/kolkata");
	$currentstartmonth = date("".$day1." 0:0:0");
	$currentendmonth = date("".$day2." 23:59:59");

    echo '<div style="color: #666" class="mb-3"><span class="h5">REPORT OF '.$day1.' BETWEEN '.$day2.'</span></div>';

		$output .= "<table class='table table-hover bg-white rounded mb-0 pr-5 pl-5 mt-3'>
                            <thead>
                                <tr>
                                    <th style='width: 150px'>Bill No</th>
                                    <th style='width: 150px'>Bill Date</th>
                                    <th style='width: 150px'>Billing Amount</th>
                                    <th style='width: 150px'>GST</th>
                                    <th style='width: 150px'>CGST</th>
                                    <th style='width: 150px'>SGST</th>
                                    <th style='width: 150px'>Total GST</th> 
                                </tr>
                            </thead>
                        <tbody>";
				
        $selltable = $_SESSION['username']."_sell";

        $sql = "select  bill_no, DATE_FORMAT(datetime,'%d-%m-%Y') as date, total, gst from $selltable where datetime between '$currentstartmonth' and '$currentendmonth'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= "<tr class=''>
                    <td>{$row['bill_no']}</td>
                    <td>{$row['date']}</td>
                    <td>{$row['total']} ₹</td>
                    <td>{$row['gst']}%</td>";

                    $cgst = ($row['gst']/2) * ($row['total']/100);
                    $sgst = ($row['gst']/2) * ($row['total']/100);
                    $sum_gst = $cgst + $sgst;
                          
                $output .= "<td>{$cgst} ₹</td>
                    <td>{$sgst} ₹</td>
                    <td>{$sum_gst} ₹</td>
                </tr>";

                $billing_amt = $billing_amt + $row['total'];
                $total_cgst = $total_cgst + $cgst;
                $total_sgst = $total_sgst + $sgst;
                $total_gst = $total_gst + $sum_gst;

            }

            $output .= "<tr>
                <td colspan='2'>Total</td>
                <td>{$billing_amt} ₹</td>
                <td>-</td>
                <td>{$total_cgst} ₹</td>
                <td>{$total_sgst} ₹</td>
                <td>{$total_gst} ₹</td>

            </tr>"; 

            $output .= "
                    </tbody>
                </table>
                ";

            echo $output;

        }
        else {
            echo "<b class='text-dark'>Records Not Found</b>";
        }                
?>
