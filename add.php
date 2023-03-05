<?php

session_start();
//recalling session variables
$username=$_SESSION['username'];
$shopname=$_SESSION['shopname'];
$shopaddress=$_SESSION['shopaddress'];

$security = $_SESSION['user'];
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <?php require "links.php"; ?>
    
</head>
<style>
     
    select{
        border-top: 1px solid transparent !important;
        border-right: 1px solid transparent !important;
        border-left: 1px solid transparent !important;
        border-bottom: 1px solid #ced4da !important;
        border-radius: 0px;
         
         
    }
    select:focus{
        box-shadow: none !important;
    }
    label{
        font-weight: bold;
        margin-left: 1rem;
    }
    select,input{
        border-bottom: 1.5px solid black !important;
        
    }
    select{
        -webkit-transition: border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out;
    }
    input:focus{
        border-bottom: none !important; 
    }
    select:focus{
        border-bottom: .1rem solid #4285f4 !important;
    }
    ::placeholder{
        font-weight: bold;
    }
    @media (max-width: 576px){
        .mbb-3 {
            border-top: 1px dotted black !important;
        }
    }

</style>

<body>
<?php require "navbar.php"; ?>
<script>
    //for changing the class name (# replacement for active class)
    document.getElementById("addprod").classList.add("active");
    document.getElementById("addprod1").classList.remove("text-light");
    document.getElementById("addprod1").classList.add("text-white");
</script>
    <?php
			
	if (isset($_SESSION["errorKey"])) {
		//checking passed errors from performAdd.php page //if tables are
		if ($_SESSION["errorKey"] == 1) {
			$_SESSION["errorKey"] = 0; 
			?>
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<strong>Error: </strong> Products not added succesfully due to some technical issue, Please <strong><a href="userFeedback.php">Contact Us</a></strong> or <strong>Come Later</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php
		}
	}

	if (isset($_SESSION['successKey'])) {
		//checking passed success from performAdd.php page
		if ($_SESSION["successKey"] == 1) {
			$_SESSION["successKey"] = 0; ?>
			<div class="alert animate-hide alert-success alert-dismissible fade show" role="alert">
				<strong>Success: </strong> Products are added succesfully...
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php
		}
	}
    ?>

    <form method="post" action="performAdd.php" class="container bg-white rounded mt-2 pb-3 pt-4 mt-5 z-depth-2" style="margin-bottom:50vh;">
        <input type="hidden" value="1" name="countField" id="hiddenField">
        <div class="container-fluid ">
            <p class="h2 text-nowrap text-center text-primary mb-4 pb-4 pt-2 border-bottom border-primary"><b>ADD PRODUCTS</b></p>
            <p class="h4 text-nowrap text-center text-gray" style="font-family: 'Times New Roman', Times, serif;">STOCK Details</p>

            <div id="addNewDivArea">
                <div class="row ml-2 mr-2  p-2 pt-3 pb-3 mt-3">
                    <div class="col-xl-2 col-sm-6 mb-2 mb-xl-0 col-12 md-form">
                        <input name='product_name1' type="search" class="form-control" id='product_name1'>
                        <label for="product_name1">Product Name</label>
                    </div>
                    <div class='col-xl-2 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>
                        <input name='specification1' type='search' class='form-control' id="spec">
                        <label for="spec">Specification</label>
                    </div>
                    <div class='col-xl-1 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>
                        <input name='product_rate1' type='number' class='form-control' id="rate">
                        <label for="rate">Rate</label>
                    </div>
                    <div class='col-xl-1 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>
                        <input name='product_qty1' type='number' class='form-control' id="qty">
                        <label for="qty">Qty</label>
                    </div>
                    <div class='col-xl-2 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>
                        <select name='product_gst1' class='custom-select' style="font-weight: bold;">
                        <label for="gst">Gst</label>
                            <option selected value = '0' style='background-color: #ddd; font-weight: bold;'> GST% </option>
                            
                                <option value = '0'>0%</option>
                                <option value = '0.25'>0.25%</option>
                                <option value = '5'>5%</option>
                                <option value = '12'>12%</option>
                                <option value = '18'>18%</option>
                                <option value = '28'>28%</option>
                            
                        </select>
                    </div>
                    <div class='col-xl-2 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>
                        <input name='sell_price1' type='number' class='form-control' id="sellpricee">
                        <label for="sellpricee">Sell Price</label>
                    </div>
                    <div class='col-xl-2 col-sm-6 mb-2 mb-xl-0 col-12 ml-auto mr-auto md-form'>
                        <input name='qty_limit1' type='text' class='form-control' id="lLimit">
                        <label for="lLimit">Low Limit</label>
					</div>
                </div>
				<!-- <div class='mt-2 mb-2' style='border-top: 5px double #aaa'></div> -->
            </div>
        </div>
        <div class='container-fluid'>
            <div class='mt-1 row'>
                <div class='col-4 offset-1 text-left'>
                    <button type='button' onclick='addNewDiv()' id='add' class='mt-4 btn btn-primary'><b>+</b></button>
                </div>
                <div class='col-6 text-right'>
                    <button name='submit' id='addd' class='mt-4 btn btn-primary'><b>Add</b></button>
                </div>
            </div>
            <div class='center'>
                <p class='m-2 font-weight-bold' style='font-size:0.8rem; color:#aaa'>-If you put any row blank then It will not saved</p>
            </div>
        </div>
    </form>
</div>
</body>
</html>
<script>
    var count = 1;
    function addNewDiv() {
        count  += 1;
        //creating div
        newDiv  = "<div class='row ml-2 mr-2  p-2 pt-3 pb-3 mt-3 mbb-3'>";
        newDiv +=     "<div class='col-xl-2 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>";
        newDiv +=         "<input name='product_name"+count+"' type='search' class='form-control' id='productName2'>";
        newDiv +=           "<label for='productName2'>Product Name</label>";
        newDiv +=     "</div>";
        newDiv +=     "<div class='col-xl-2 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>";
        newDiv +=         "<input name='specification"+count+"' type='search' class='form-control' id='spec"+count+"'>";
        newDiv +=           "<label for='spec"+count+"'>Specification</label>";
        newDiv +=     "</div>";
        newDiv +=     "<div class='col-xl-1 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>";
        newDiv +=         "<input name='product_rate"+count+"' type='number' class='form-control' id='rate"+count+"'>";
        newDiv +=           "<label for='rate"+count+"'>Rate</label>";
        newDiv +=     "</div>";
        newDiv +=     "<div class='col-xl-1 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>";
        newDiv +=         "<input name='product_qty"+count+"' type='number' class='form-control' id='Qty"+count+"'>";
        newDiv +=           "<label for='Qty"+count+"'>Qty</label>";
        newDiv +=     "</div>";
        newDiv +=     "<div class='col-xl-2 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>";
        newDiv +=         "<select name='product_gst"+count+"' class='custom-select' style='font-weight: bold;'>";
        newDiv +=             "<option selected value = '0' style='background-color: #ddd; font-weight: bold;'> GST% </option>";
        newDiv +=             "<option value = '0'>0%</option>";
        newDiv +=             "<option value = '0.25'>0.25%</option>";
        newDiv +=             "<option value = '5'>5%</option>";
        newDiv +=             "<option value = '12'>12%</option>";
        newDiv +=             "<option value = '18'>18%</option>";
        newDiv +=             "<option value = '28'>28%</option>";
        newDiv +=         "</select>";
        newDiv +=     "</div>";
        newDiv +=     "<div class='col-xl-2 col-sm-6 mb-2 mb-xl-0 col-12 md-form'>";
        newDiv +=         "<input name='sell_price"+count+"' type='number' class='form-control' id='sellprice"+count+"'>";
        newDiv +=           "<label for='sellprice"+count+"'>Sell Price</label>";
        newDiv +=     "</div>";
        newDiv +=     "<div class='col-xl-2 col-sm-6 mb-2 mb-xl-0 col-12 ml-auto mr-auto md-form'>";
        newDiv +=         "<input name='qty_limit"+count+"' type='text' class='form-control' id='lLimit"+count+"'>";
        newDiv +=           "<label for='lLimit"+count+"'>Low Limit</label>";
        newDiv +=     "</div>";
        newDiv += "</div>";
		

         //creating new tag
         var newDivTag = document.createElement("div");
        newDivTag.innerHTML = newDiv;
        //adding div to form
        document.getElementById('addNewDivArea').appendChild(newDivTag);

        //updating count into hiddinField
        document.getElementById('hiddenField').value = count;
        
        //changing innerHTML of id="addd" button after clicking + button
        document.getElementById('addd').innerHTML = "<b>Add All</b>";
    }
</script>