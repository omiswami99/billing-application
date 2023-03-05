<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}
include('conn.php');
$username = $_SESSION['username'];
$shopname = $_SESSION['shopname'];
$shopaddress = $_SESSION['shopaddress'];

if (!isset($_POST['submit'])) {
    header("location:sell.php");
} else {
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    require('links.php'); 
    ?>
</head>
<?php
    function isNullInput($value) {
        if($value == "") {
            return "0";
        } else {
            return $value;
        }
    }
    function isUndefined($value) {
        if($value == "") {
            return "undefined";
        }
        else {
            return $value;
        }
    }
?>
<?php
        function getNewBillno()
        {
            global $username, $conn;
            $selltable = $username."_sell";
            $getBillnoQuery = "SELECT COUNT(DISTINCT bill_no) AS bill_no FROM $selltable";
            $result_getBillnoQuery = mysqli_query($conn, $getBillnoQuery);
            $data = mysqli_fetch_array($result_getBillnoQuery);
            $old_billno = $data['bill_no'];
            $newbillno = ((int) $old_billno) + 1;
            return $newbillno;
        }

        
        ?>
<body>
    <div class="container-md bg-white rounded mt-2 pb-3 pt-4 mt-5 z-depth-2" style="margin-bottom:50vh;">
            <input type="hidden" value="1" name="countField" id="hiddenField">

            <div class="container-fluid view overlay pb-3">
                <p class="h2 text-nowrap text-center text-primary mb-4 pb-4 pt-2 border-bottom border-primary"><b>CONFIRM BILL</b></p>
                <div class="border-bottom border-dark w-75 mx-auto">
                    <div class="col-12 h4 center"><?php echo $shopname ?></div>
                    <div class="col-12 h5 center"><?php echo $shopaddress ?></div>
                </div>
                <div class="d-flex justify-content-center border-bottom border-dark mx-auto mt-3 pb-3" style="width: 60%;">
                    <form action="sell.php" method="get">
                        <?php
                            //getting all inputs from sell.php forrm
                            $length = $_POST['countField'];
                            $customerName = $_POST['customerName'];
                            $customerMobile = $_POST['customerMobile'];

                            //declaring arrays
                            $product=array();
                            $qty = array();
                            $discount = array();

                            //for calculating total bill price, and total discount
                            $billTotal = 0;
                            $totalDiscount = 0;
                            $i = 1;
                            echo "
                            <td><input hidden name='customerName' type='text' value='$customerName' /></td>
                            <td><input hidden name='customerMobile' type='text' value='$customerMobile' /></td>
                            <td><input hidden name='length' type='text' value='$length' /></td>";
                            while ($i <= $length) { //while loop for performing operations on each product and displaying total details
                                //inserting values into array
                                $product[$i] = isNullInput($_POST["product$i"]);
                                $qty[$i] = isNullInput($_POST["qty$i"]);
                                $discount[$i] = isNullInput($_POST["discount$i"]);

                                //adding a row with data into table to display
                                echo "
                                    <tr>
                                        <td><input hidden name='product$i' type='text' value='$product[$i]' /></td>
                                        <td><input hidden name='qty$i' type='text' value='$qty[$i]' /></td>
                                        <td><input hidden name='discount$i' type='text' value='$discount[$i]' /></td>
                                    </tr>
                                ";
                                $i++;
                            }
                        ?>
                        <button name="edit" onclick="setProducts();" class="btn btn-danger text-white">Edit</button>
                    </form>
                        
                    <form action="performSell.php" method="post">
                        <?php
                        //getting all inputs from sell.php forrm
                        $length = $_POST['countField'];
                        $customerName = isUndefined($_POST['customerName']);
                        $customerMobile = isUndefined($_POST['customerMobile']);

                        //declaring arrays
                        $product=array();
                        $productId=array();
                        $qty = array();
                        $discount = array();
                        $price = array();
                        $gst = array();
                        $total = array();

                        //for calculating total bill price, and total discount
                        $billTotal = 0;
                        $totalDiscount = 0;
                        $i = $length;
                        $srno = 1;

                        echo "
                        <input hidden name='customerName' type='text' value='$customerName' />
                        <input hidden name='userMobile' type='text' value='$customerMobile' />
                        <input hidden name='length' type='text' value='$length' />";

                        while ($i) { //while loop for performing operations on each product and displaying total details
                            //inserting values into array
                            $product[$i]    = isNullInput($_POST["product$i"]);
                            $qty[$i]        = isNullInput($_POST["qty$i"]);
                            $discount[$i]   = isNullInput($_POST["discount$i"]);

                            //select query to get sell_price,gst,product_id of perticular product
                            $selectProductQuery = "
                                            SELECT `sell_price` AS price , 
                                            `gst` , 
                                            `product_id` 
                                            FROM ".$username."_products
                                            WHERE `product_name` = '$product[$i]';
                                            ";
                            //executing above query
                            $resultSelectProductQuery = mysqli_query($conn, $selectProductQuery);
                                            
                            //fetching data from result of query
                            $data = mysqli_fetch_array($resultSelectProductQuery);
                                            
                            //adding fetched data into perticular variables
                            if ($data) {
                                $price[$i] =(double) $data['price'];
                                $gst[$i] =(int) $data['gst'];
                                $productId[$i] =(double) $data['product_id'];
                            } else {
                                $price[$i] = 0;
                                $gst[$i] = 0;
                                $productId[$i] = 0;
                            }

                            //calculating total of perticular product bill
                            $total[$i] = (((double)$price[$i]) * ((double)$qty[$i])) - ((double) $discount[$i]);

                            //adding a row with data into table to display
                            echo "
                                    <tr>
                                        <td><input hidden name='productId$i' type='text' value='$productId[$i]' /></td>
                                        <td><input hidden name='qty$i' type='text' value='$qty[$i]' /></td>
                                        <td><input hidden name='discount$i' type='text' value='$discount[$i]' /></td>
                                        <td><input hidden name='total$i' type='text' value='$total[$i]' /></td>
                                    </tr>
                                ";

                                $billTotal += (double) $total[$i];
                                $totalDiscount += (double) $discount[$i];

                                $i--;

                                $srno++;
                            }

                            echo "
                            
                            <td><input hidden name='totalBill' type='text' value='$billTotal' /></td>
                            <td><input hidden name='totalSaved' type='text' value='$totalDiscount' /></td>
                            
                            ";
                        ?>
                        <button name="confirmed" class="btn bg-primary text-white ml-4">Confirm</button>
                    </form>
                   
                </div>

                <div class="row w-100 mt-3 mb-0 mx-auto">
                    <div style="font-size: 1.2rem;" class=" col-lg-6 col-md-6 col-12 center text-dark">Customer Name: <span
                            class="font-weight-bold"><?php echo $_POST['customerName'] ?></span></div>
                    <div style="font-size: 1.2rem;" class=" col-lg-6 col-md-6 col-12 center text-dark">Mobile : <span
                            class="font-weight-bold"><?php echo $_POST['customerMobile'] ?></span></div>
                </div>
                <div class="row w-100 mt-3 mb-0 mx-auto">
                    <div style="font-size: 1.2rem;" class="col-12 center text-dark">Bill no: <span
                            class="font-weight-bold"><?php echo getNewBillno() ?></span></div>
            
                </div>                 

            </div>

            <div class="d-flex justify-content-center">
                <table class="table table-striped table-responsive-md w-75">
                    <thead>
                        <tr>
                            <th>SrNo</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>GST</th>
                            <th>Discount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //getting all inputs from sell.php forrm
                            $length = $_POST['countField'];
                            $customerName = $_POST['customerName'];
                            $customerMobile = isNullInput($_POST['customerMobile']);

                            //declaring arrays
                            $product=array();
                            $qty = array();
                            $discount = array();
                            $price = array();
                            $gst = array();
                            $total = array();

                            //for calculating total bill price, and total discount
                            $billTotal = 0;
                            $totalDiscount = 0;
                            $i = $length;
                            $srno = 1;
                            while ($i) { //while loop for performing operations on each product and displaying total details
                                //inserting values into array
                                $product[$i] = isNullInput($_POST["product$i"]);
                                $qty[$i] = isNullInput($_POST["qty$i"]);
                                $discount[$i] = isNullInput($_POST["discount$i"]);

                                //select query to get sell_price,gst,product_id of perticular product
                                $selectProductQuery = "
                                                SELECT `sell_price` AS price , 
                                                `gst` , 
                                                `product_id` 
                                                FROM ".$username."_products
                                                WHERE `product_name` = '$product[$i]';
                                                ";
                                //executing above query
                                $resultSelectProductQuery = mysqli_query($conn, $selectProductQuery);
                                                
                                //fetching data from result of query
                                $data = mysqli_fetch_array($resultSelectProductQuery);
                                                
                                //adding fetched data into perticular variables
                                if ($data) {
                                    $price[$i] =(double) $data['price'];
                                    $gst[$i] =(int) $data['gst'];
                                    $productId[$i] =(double) $data['product_id'];
                                } else {
                                    $price[$i] = 0;
                                    $gst[$i] = 0;
                                    $productId[$i] = 0;
                                }

                                //calculating total of perticular product bill
                                $total[$i] = (((double)$price[$i]) * ((double)$qty[$i])) - ((double) $discount[$i]);

                                //adding a row with data into table to display
                                if($productId[$i] == 0 || $qty == '0') {

                                } else {
                                    echo "
                                    <tr>
                                        <td>$srno</td>
                                        <td>$product[$i]</td>
                                        <td>$price[$i]</td>
                                        <td>$qty[$i]</td>
                                        <td>$gst[$i]</td>
                                        <td>$discount[$i]</td>
                                        <td>$total[$i]</td>
                                    </tr>
                                ";
                                }

                                $billTotal +=(double) $total[$i];
                                $totalDiscount +=(double) $discount[$i];

                                $i--;

                                $srno++;
                            }
                            
                            ?>
                    </tbody>
                </table>
            </div>
            <div class="row w-100 mb-5 border-top pt-4 mx-auto">
                <div class="col-6 center text-dark">Saved(₹): <?php echo $totalDiscount ?></div>
                <div class="col-6 center text-dark">Total Bill Price(₹): <?php echo $billTotal ?></div>
            </div>
          
    </div>
</body>

</html>

<?php
}
?>