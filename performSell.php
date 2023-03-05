<!DOCTYPE html>
<head>
    <title>Print</title>
    <?php
        require("links.php");
    ?>
    <style>
        body{
            background:#fff;
             
        }
        table, th, td {
            border: 0.1px solid #777;
        }

         tr, td, th{
            text-align: center;
        }
        td,th.rright{
            text-align:right;
        }
        td, th.lleft{
            text-align:left;
        }
        td, th,span.lleft{
            text-align:left;
        }
        tr.msize{
            font-size: 15px;
        }
        .thisDiv {
            width:fit-content;
            border:0.1px solid #777;
        }
</style>

</head>
<body>


<?php
    include 'conn.php';

    session_start();
    $sellingPerson = $_SESSION['seller'];
    $shopname = $_SESSION['shopname'] ;
    $shopaddress = $_SESSION['shopaddress'];
    $shopgstin = $_SESSION['shopgstin'];
    $mobile1 = $_SESSION['mobile1'];
    
    $username  = $_SESSION['username'];

    $selltable = $username."_sell";
    $custtable = $username."_customer";
    $custbilltable = $username."_customerbill";
    $prodtable = $username."_products";
    date_default_timezone_set("asia/kolkata");
    $insdate = date("d-M-Y");
    $instime = date("h-i a");
    $xcounter = 1;
    $totaldiscount = 0;
    //if (!empty($_POST["totalBill"] && !empty($_POST["totalSaved"])) {
        
        if (isset($_POST['confirmed'])) {
            $customerName   = $_POST['customerName'];
            $customerMobile = $_POST['userMobile'];
            $billTotal      = $_POST['totalBill'];
            $savedTotal     = $_POST['totalSaved'];
            if ($_POST['customerName'] == "undefined") {
                $customerName = " ";
            }
            if ($_POST['userMobile'] == "undefined") {
                $customerMobile = " ";
            }
            $newbillno  = getNewBillno();//returns a new billnumber
            
            $counter    = $_POST["length"];

             
            echo '<div id="printOnly1">
            <table class="container mt-5 bg-transperent thisDiv" style="width: 200px; text-align: center; font-size: 12px;>

            <tr class="container">
                 <th colspan="7" style="font-size:1.018rem; overflow: hidden;" class="container">
                    <center>'.$shopname.'</center>
                </th>             
            </tr>
            <tr>
                <center><td colspan="7"  class="container">
                    <center>
                        Address: '.$shopaddress." <br> 
                        GSTIN: <span class='ontainer'>".$shopgstin." <br>
                        Mobileno: ".$mobile1.' 
                     </center>
                </td></center>
            </tr>
            <tr>
                 
                <td colspan="5" rowspan="2" class="lleft" >
                   
                    <center>CUSTOMER DETAILS</center><br>
                    <span class="lleft">
                     &nbsp Name: '.$customerName.'<br>  
                     &nbsp Mobile no: '.$customerMobile.'</span>
                </td>
                <td colspan="2" style="padding-left: px;">
                    &nbsp  Date & time: <br>
                    &nbsp '.$insdate.'<br>
                    &nbsp '.$instime.'
                </td>
            </tr>
            <tr>
                <th colspan="3" style="padding-left: px;">
                    <center>Bill No: '.$newbillno.'</center>
                    </th>
            </tr>
            </tr>
             ';

            echo '<tr>
                <td><center>Sr.no</center></td>
                <td><center>Product</center></td>
                <td><center>MRP</center></td>
                <td><center>Qty</center></td>
                <td><center>GST(%)</center></td>
                <td><center>discount</center></td>
                <td><center>Total</center></td>
                
            </tr> ';
            
            for ($i = $counter; $i >= 1; $i--) {
                //gettomg inputs from confirmSell.php
                
                $product_id = $_POST["productId$i"];
                $qty        = (double)$_POST["qty$i"];
                $discount   = $_POST["discount$i"];
                $total      = $_POST["total$i"];
                if (empty($product_id) || $qty == '0' || $total == '0') {
                    continue;
                }
                $totaldiscount += $discount;
                $selProdDet = "SELECT * from $prodtable where product_id = $product_id;";
                $resselProdDet = $conn->query($selProdDet);
                if ($resselProdDet->num_rows == 1) {
                    while ($roks = $resselProdDet->fetch_assoc()) {
                        $tbprodname = $roks['product_name'];
                        $tbprodrate = $roks['rate'];
                        $tbprodsp = $roks['sell_price'];
                        $tbprodgst = $roks['gst'];
                    }
                }
                echo '
                <tr >
                    <td><center>'.$xcounter.'</center></td>
                    <td><center>'.$tbprodname.'</center></td>
                    <td><center>₹'.$tbprodsp.'</center></td>
                    <td><center>'.$qty.'</center></td>
                    <td><center>'.$tbprodgst.'%</center></td>
                    <td><center>₹'.$discount.'</center></td>
                    <td><center>₹'.$total.'</center></td>
                     
                </tr>';
                
                //echo $product_id." ".$qty." ".$discount." ".$total."<br>";
                if (($product_id == "0") || $qty <= (DOUBLE)'0') {
                    //do nothing when product is 0
                } else {
                    //getting product qty from product table     
                    $getQtyQuery        = "SELECT qty from $prodtable where product_id = $product_id;";
                    $result_getQtyQuery = $conn->query($getQtyQuery);
                        
                    $qtyData = mysqli_fetch_array($result_getQtyQuery);
                    $productQty = $qtyData['qty'];

                    $newqty             = (double)$productQty - (double)$qty;
                    //updating qty of product
                    $updateQtyQuery = "UPDATE $prodtable set qty = '$newqty' WHERE product_id = '$product_id';";
                    $conn->query($updateQtyQuery);
                    //echo $sellingPerson;

                    //inserting all the columns in sales table;
                    $insertIntoSellQuery = "
                    insert into $selltable (
                        bill_no, 
                        product_id, 
                        qty, 
                        gst,
                        rate,
                        sellprice,
                        total,
                        discount,
                        seller
                        
                        
                    )
                    values (
                        '$newbillno', 
                        '$product_id', 
                        '$qty',
                        '$tbprodgst', 
                        '$tbprodrate',
                        '$tbprodsp',
                        '$total',
                        '$discount',
                        '$sellingPerson'
                       
                        
                    );
                    ";
                    $updateResult = $conn->query($insertIntoSellQuery);
                    if($conn->error){
                        echo $conn->error;
                    }
                    //echo $sellingPerson;
                    //inserting customer informations in customer table
                    $selectCustomerQuery = "SELECT * FROM $custtable WHERE customer_name = '$customerName' AND customer_mobile = '$customerMobile'";
                    $result_selectCustomerQuery = $conn->query($selectCustomerQuery);
                    if ($result_selectCustomerQuery->num_rows > 0) { //if customer is repeated
                        //getting customer id
                        $getCustomerId  = "SELECT customer_id FROM $custtable WHERE customer_name = '$customerName' AND customer_mobile = '$customerMobile'";
                        $customerId     = $conn->query($getCustomerId)->fetch_array()['customer_id'];
                        //to add customer bill
                        $addCustomerBillQuery = "
                        INSERT INTO $custbilltable (
                            customer_id,
                            bill_no,
                            total_price
                        )
                        VALUES (
                            '$customerId',
                            '$newbillno',
                            '$billTotal'
                        )
                        ";
                        $conn->query($addCustomerBillQuery);
                        if($conn->error){
                            echo $conn->error;
                        }
                    } else { //if customer is new
                        $addCustomerQuery = "
                        INSERT INTO $custtable (
                            customer_name,
                            customer_mobile
                        )
                        VALUES (
                            '$customerName',
                            '$customerMobile'
                        )
                        ";
                        $conn->query($addCustomerQuery);

                        //getting customer id of added customer
                        $getCustomerId = "SELECT customer_id FROM $custtable WHERE customer_name = '$customerName' AND customer_mobile = '$customerMobile'";
                        $customerId = $conn->query($getCustomerId)->fetch_array()['customer_id'];
                        //to add customer bill
                        $addCustomerBillQuery = "
                        INSERT INTO $custbilltable (
                            customer_id,
                            bill_no,
                            total_price
                        )
                        VALUES (
                            '$customerId',
                            '$newbillno',
                            '$billTotal'
                        )
                        ";
                        $conn->query($addCustomerBillQuery);
                    }
                }
                $xcounter++;
            }
            
            echo '
            <tr>
                 
                <th colspan="5" style="font-weight: bold;font-size: 12px;" class="rright">Ruppees Saved:</th>
                <th colspan="2"><center>₹'.$totaldiscount.'</center></th>
            </tr>
            <tr>
                <th class="rright" colspan="5" 
                style="font-weight: bold; font-size:12px";>Total:</th>
                <th  colspan="2"><center>₹'.$billTotal.'</center></th>
            </tr>
            </table>
            </div>
            ';
            $_SESSION['successKey'] = 2; //selling successfull
            echo '';
        }
    
        function getNewBillno()
        {
            global $selltable, $conn;
            $getBillnoQuery = "SELECT COUNT(DISTINCT bill_no) AS bill_no FROM $selltable";
            $result_getBillnoQuery = mysqli_query($conn, $getBillnoQuery);
            $data = mysqli_fetch_array($result_getBillnoQuery);
            $old_billno = $data['bill_no'];
            $newbillno = ((int) $old_billno) + 1;
            return $newbillno;
        }
    

?>

 
 
<script>   

window.print();
window.onafterprint = function(){
    window.open("Sell.php","_self")
}
</script>
</body>
</html>