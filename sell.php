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
    <title>Sell Products</title>
    <?php require "links.php"; ?>
</head>
<style>
label {
    font-weight: bold;
}

input {
    border-bottom: 1.5px solid black !important;
}

input:focus {
    border-bottom: none !important;
}

::placeholder {
    font-weight: bold;
}

@media (max-width: 576px) {
    .mbb-3 {
        border-top: 1px dotted black !important;
    }
}

.amb {
    font-size: 12px;
}
</style>
<script>
var count = 1;
</script>

<body>
    <?php require "navbar.php"; ?>
    <script>
    //for changing the class name (# replacement for active class)
    document.getElementById("sellprod").classList.add("active");
    document.getElementById("sellprod1").classList.remove("text-light");
    document.getElementById("sellprod1").classList.add("text-white");
    </script>
    <br>
    <?php

    if (isset($_SESSION['errorKey'])) {
        if ($_SESSION["errorKey"] == 5) {
        $_SESSION["errorKey"] = 0; ?>
    <div class="alert animate-hide animate alert-success alert-dismissible fade show" role="alert"
        style="margin-top:-15px;">
        <strong>Login Successfull</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
        }
    }

    //checking passed success from login.php page
    if (isset($_SESSION['successKey'])) {
            if ($_SESSION["successKey"] == 1) {
            $_SESSION["successKey"] = 0; ?>
    <div class="alert animate-hide animate alert-success alert-dismissible fade show" role="alert"
        style="margin-top:-25px;">
        <strong>Login Successfull</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
            }
            if ($_SESSION["successKey"] == 2) {//alert for successfull selling of products
            $_SESSION["successKey"] = 0; ?>
    <div class="alert animate-hide alert-success alert-dismissible fade show" role="alert" style="margin-top:-25px;">
        <strong>Products Sold Successfull..</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
            }
            if ($_SESSION["successKey"] == 5) {//alert for successfull feedback
            $_SESSION["successKey"] = 0; ?>
    <div class="alert animate-hide alert-success alert-dismissible fade show" role="alert" style="margin-top:-25px;">
        <strong>Feedback Sent Successfully.. </strong> Thanks for the feedback
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
            }
    }
    ?>

    <?php 
    if(isset($_GET['edit'])) {
        $customerName = $_GET['customerName'];
        $customerMobile = $_GET['customerMobile'];
        echo "
        <form method='post' action='confirmSell.php' class='container bg-white rounded mt-2 pb-3 pt-4 mt-5 z-depth-2' style='margin-bottom:50vh'>
            <input type='hidden' value='1' name='countField' id='hiddenField'>
            <div class='container-fluid view overlay pb-3 ' style='overflow: visible !important;'>
            <p class='h2 text-nowrap text-center text-primary mb-4 pb-4 pt-2 border-bottom border-primary'><b>SELL PRODUCTS</b></p>
            <p class='h4 text-nowrap text-center text-gray' style='font-family: 'Times New Roman', Times, serif;'>Customer Details</p>
                <div class='row mx-auto mt-4 mb-3'>
                    <div class='autoComplete col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3 mb-sm-0 ml-auto'>
                        <div class='md-form'>
                            <input value='$customerMobile' class='form-control text-dark' type='number' autocomplete='off' name='customerMobile' id='customerMobile'>
                            <label for='customerMobile'>Mobile Number</label>
                            <div id='show-list0' class='show-list'></div>
                        </div>
                    </div>
                    <div class='autoComplete col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3 mb-sm-0 mr-auto'>
                        <div class='md-form'>
                            <input value='$customerName' class='form-control text-dark' autocomplete='off' id='searchCustomer' type='search' name='customerName' value=''>
                            <label for='searchCustomer'>Customer Name</label>
                            <div id='show-list' class='show-list'></div>
                        </div>
                    </div>
                </div>
                <p class='h4 text-nowrap text-center text-dark mt-5' style='font-family: 'Times New Roman', Times, serif;'>Selling Products List</p>
                <div id='addNewDivArea'>
        ";

        
        $i = $_GET['length'];
        ?>
    <script>
    count = (int)
    "<?php echo $i ?>";
    </script>
    <?php
        while ($i) {
            $product = $_GET["product$i"];
            $qty = $_GET["qty$i"];
            $discount = $_GET["discount$i"];
            $qtyError = "qtyError$i";
            echo "
                <div class='row mx-2 pt-1 pb-1'>

                    <div class='col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0 ml-auto'>
                        <div class='autoComplete md-form'>
                            <input value='$product' class='form-control text-dark' autocomplete='off' onfocus='runAJAX($i)' type='search' name='product$i' id='search$i'>
                            <label for='search$i'>Product Name</label>
                            <div id='show-list$i' class='show-list'></div>
                        </div>
                    </div>

                    <div class='col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0 '>
                        <div class='autoComplete md-form'>
                            <input value='$qty' class='form-control text-dark text-number' autocomplete='off' type='search' onkeyup='validateQty($i, this.value)' onfocus='checkQty($i)' name='qty$i' id='qty$i'>
                            <label for='qty$i'>Qty</label>
                            <p class='text-danger d-none' id='$qtyError'></p>
                        </div>
                    </div>

                    <div class='col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-3 mr-auto'>
                        <div class='autocomplete md-form'>
                            <input value='$discount' class='form-control text-dark text-number' onkeyup='absDiscount($i)' type='search' name='discount$i' autocomplete='off' id='discount$i'>
                            <label for='discount$i'>Discount (If any)</label>
                        </div>
                    </div>

                </div>
            ";

            $i--; 
            
            ?>

    <?php
        }

        echo "
        </div>

        </div>
        <div class='container-fluid mx-auto text-center'>
                <div class='mt-1 row'>
                    <div class='col-4'>
                        <button type='button' onclick='addNewDiv()' id='add' class='mt-4 btn btn-primary'><b>+</b></button>
                    </div>
                    <div class='col-4 pt-3' id='dispCount1'></div>
                    <div class='col-4'>
                        <button name='submit' class='mt-4 btn btn-primary'><b>Sell</b></button>
                    </div>
                </div>
                <div class=' row center'>
                    <p class='col-12 m-2 font-weight-bold' style='font-size:0.8rem; color:#aaa'>-If you put any row blank then It will not be saved</p>
                </div>
            </div>
    </form>
        ";
    } else {


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////


    ?>

    <form method="post" action="confirmSell.php" class="container bg-white rounded pb-3 pt-4 mt-4 z-depth-2"
        style="margin-bottom:50vh;">
        <input type="hidden" value="1" name="countField" id="hiddenField">

        <div class="container-fluid view overlay pb-3 " style="overflow: visible !important;">
            <p class="h2 text-nowrap text-center text-primary mb-4 pb-4 pt-2 border-bottom border-primary"><b>SELL
                    PRODUCTS</b></p>
            <p class="h4 text-nowrap text-center text-gray" style="font-family: 'Times New Roman', Times, serif;">
                Customer Details</p>

            <div class="row mx-auto mt-4 mb-3">
                <div class='autoComplete col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3 mb-sm-0 ml-auto'>
                    <div class="md-form">
                        <input class='form-control text-dark' type="number" autocomplete='off' name="customerMobile"
                            id="customerMobile">
                        <label for="customerMobile">Mobile Number</label>
                        <div id='show-list0' class='show-list'></div>
                    </div>
                </div>
                <div class="autoComplete col-xl-3 col-lg-4 col-md-4 col-sm-5 col-12 mb-3 mb-sm-0 mr-auto">
                    <div class="md-form">
                        <input class='form-control text-dark' autocomplete='off' id="searchCustomer" type='search'
                            name='customerName' value="">
                        <label for="searchCustomer">Customer Name</label>
                        <div id='show-list' class='show-list'></div>
                    </div>
                </div>
            </div>
            <p class="h4 text-nowrap text-center text-dark mt-5" style="font-family: 'Times New Roman', Times, serif;">
                Selling Products List</p>

            <div id="addNewDivArea">
                <div class='row mx-2  pt-1 pb-1'>

                    <div class='col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0 ml-auto'>
                        <div class='autoComplete md-form'>
                            <div class="md-form">
                                <input value="" class='form-control text-dark' autocomplete='off' onfocus='runAJAX(1)'
                                    type='search' name='product1' id='search1'>
                                <label for="search1">Product Name</label>
                                <div id='show-list1' class='show-list'></div>
                            </div>
                        </div>
                    </div>

                    <div class='col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0 '>
                        <div class='autoComplete md-form'>
                            <input value="" class='form-control text-dark text-number' autocomplete='off' type='search'
                                onkeyup='validateQty(1, this.value)' onfocus='checkQty(1)' name='qty1' id='qty1'>
                            <label for="qty1">Qty</label>
                            <p class="text-danger d-none" id="qtyError1"></p>
                        </div>
                    </div>

                    <div
                        class='col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-3 mr-auto'>
                        <div class="autocomplete md-form">
                            <input value="" class='form-control text-dark text-number' onkeyup='absDiscount(1)'
                                type='search' name='discount1' autocomplete='off' id='discount1'>
                            <label for="discount1">Discount (If any)</label>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="container-fluid text-center mx-auto">
            <div class="mt-1 row">
                <div class="col-4">
                    <button type="button" onclick="addNewDiv()" id="add" class="mt-4 btn btn-primary"><b>+</b></button>
                </div>
                <div class='col-4' id='dispCount1'></div>
                <div class="col-4">
                    <button name="submit" class="mt-4 btn btn-primary"><b>Sell</b></button>
                </div>
            </div>
            <div class=" row center">
                <p class="col-12 m-2 font-weight-bold" style="font-size:0.8rem; color:#aaa">-If you put any row blank
                    then It will not be saved</p>
            </div>
        </div>
    </form>
    <?php 
    }
    ?>
    <p id="showme"></p>
</body>

</html>
<script>
/*     //for product   
    document.getElementById("customerMobile").addEventListener("focusin", myFunction);
    document.getElementById("searchCustomer").addEventListener("focusin", myFunction);
    document.getElementById("qty1").addEventListener("focusin", myFunction);
    document.getElementById("discount1").addEventListener("focusin", myFunction);

    function myFunction() {
        document.getElementById("show-list1").style.display = "none";
    }

    document.getElementById("search1").addEventListener("focusin", myFunction1);

    function myFunction1() {
        document.getElementById("show-list1").style.display = "block";
    }

    //for mobile no.
    document.getElementById("search1").addEventListener("focusin", myFunction3);
    document.getElementById("searchCustomer").addEventListener("focusin", myFunction3);
    document.getElementById("qty1").addEventListener("focusin", myFunction3);
    document.getElementById("discount1").addEventListener("focusin", myFunction3);

    function myFunction3() {
        document.getElementById("show-list0").style.display = "none";
    }

    document.getElementById("customerMobile").addEventListener("focusin", myFunction4);

    function myFunction4() {
        document.getElementById("show-list0").style.display = "block";
    }

    //for cust name
    document.getElementById("search1").addEventListener("focusin", myFunction5);
    document.getElementById("customerMobile").addEventListener("focusin", myFunction5);
    document.getElementById("qty1").addEventListener("focusin", myFunction5);
    document.getElementById("discount1").addEventListener("focusin", myFunction5);

    function myFunction5() {
        document.getElementById("show-list").style.display = "none";
    }


    document.getElementById("searchCustomer").addEventListener("focusin", myFunction6);

    function myFunction6() {
        document.getElementById("show-list").style.display = "block";
    } */
</script>
<script>
function save() {
    for (i = 1; i <= count; i++) {
        product = document.getElementById('search' + i);
        qty = document.getElementById('qty' + i);
        discount = document.getElementById('discount' + i);
        product.value = product.value;
    }
}

function addNewDiv() {
    save();
    count += 1;
    //creating div
    newDiv = "<div class='row mx-2 pt-1 pb-1 mbb-3'>";
    newDiv += "<div class='col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0 ml-auto'>";
    newDiv += "<div class='autoComplete md-form'>";
    newDiv += "<input value='' class='form-control' autocomplete='off' onfocus='runAJAX(" + count +
        ")' type='search' name='product" + count + "' placeholder='Product Name'";
    newDiv += "id='search" + count + "'>";
    newDiv += "<div id='show-list" + count + "' class='show-list'></div>";
    newDiv += "</div>";
    newDiv += "</div>";
    newDiv += "<div class='col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0 '>";
    newDiv += "<div class='autoComplete md-form'>";
    newDiv += "<input value='' autocomplete='off' class='form-control' type='search' onkeyup='validateQty(" + count +
        ", this.value)' onfocus='checkQty(" + count + ")' class='text-number' name='qty" + count +
        "' placeholder='Qty' id='qty" + count + "'>";
    newDiv += "<p class='text-danger d-none' id='qtyError" + count + "'></p>";
    newDiv += "</div>";
    newDiv += "</div>";
    newDiv +=
        "<div class='col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 mb-3 mb-md-0 offset-xl-0 offset-lg-0 offset-md-0 offset-sm-3 mr-auto md-form'>";
    newDiv += "<input value='' class='form-control' onkeyup='absDiscount(" + count +
        ")' type='search' class='text-number' name='discount" + count +
        "' placeholder='Discount (If any)' id='discount" + count + "' autocomplete='off'>";
    newDiv += "</div>";
    newDiv += "</div>";
    newDiv += "";

    //creating new tag
    var newDivTag = document.createElement("div");
    newDivTag.innerHTML = newDiv;
    //adding div to form
    document.getElementById('addNewDivArea').appendChild(newDivTag);

    //updating count into hiddinField
    document.getElementById('hiddenField').value = count;

    //changing innerHTML of id="addd" button after clicking + button
    document.getElementById('addd').innerHTML = "<b>Sell All</b>";
}


function setMobile(number) {
    document.getElementById('customerMobile').value = number;
}

function setName(name) {
    document.getElementById('searchCustomer').value = name;
}


//for autocomplete customer mobile number
$('#customerMobile').keyup(function() {
    var searchText = $(this).val();
    if (searchText != '') {
        $.ajax({
            url: 'autoCompleteActionForCustomerMobile.php',
            method: 'post',
            data: {
                query: searchText,
                username: '<?php echo $username ?>',
                thisId: 'user0'
            },
            success: function(response) {
                $('#show-list0').html(response);
            }
        });
    } else {
        $('#show-list0').html('');
    }
});
$(document).on('click', '#user0', function() {
    $('#customerMobile').val($(this).text());
    $('#show-list0').html('');
    document.getElementById("searchCustomer").focus();
});

//for autocomplete customername
$('#searchCustomer').keyup(function() {
    var searchText = $(this).val();
    if (searchText != '') {
        $.ajax({
            url: 'autoCompleteActionForCustomer.php',
            method: 'post',
            data: {
                query: searchText,
                username: '<?php echo $username ?>',
                thisId: 'user'
            },
            success: function(response) {
                $('#show-list').html(response);
            }
        });
    } else {
        $('#show-list').html('');
    }
});
$(document).on('click', '#user', function() {
    $('#searchCustomer').val($(this).text());
    $('#show-list').html('');
});


var productName;
var productQty;
var productNameP

function checkQty(i) {
    productName = $('#search' + i).val();
    $.ajax({
        url: 'checkQtyProducts.php',
        method: 'post',
        data: {
            productName: productName,
            username: '<?php echo $username ?>'
        },
        success: function(qty) {
            let str = qty.toString().split(";");
            productQty = str[0];
            productNameP = str[1];
        }
    });

}

function runAJAX(i) {
    $('#search' + i).keyup(function() {
        var searchText1 = $(this).val();
        if (searchText1 != '') {
            qtyInputField = $('#search' + i);
            qtyInputField.removeClass('border-danger');
            qtyInputField.addClass('border-primary');
            $.ajax({
                url: 'autoCompleteActionForProducts.php',
                method: 'post',
                data: {
                    query: searchText1,
                    username: '<?php echo $username ?>',
                    thisId: i
                },
                success: function(response1) {
                    $('#show-list' + i).html(response1);
                }
            });
        } else {
            $('#show-list' + i).html('');
            qtyInputField = $('#search' + i);
            qtyInputField.removeClass('border-primary');
            qtyInputField.addClass('border-danger');
        }
    });
    $(document).on('click', '#' + i, function() {
        $('#search' + i).val($(this).text());
        $('#show-list' + i).html('');
    });
}

let validateQty = (i, value) => {
        if(isNaN(value)) {
            $('#qty' + i).val("");
        }
        if (value == "") {
            $('#qtyError' + i).removeClass('d-block');
        }
        value = Number.parseInt(value);
        if (value <= productQty) {
            $('#qtyError' + i).removeClass('d-block');
        }
        if (value > productQty) {
            $('#qtyError' + i).html('<p class="amb">There are only <b>' + productQty + '</b> <i>' + productName + '</i> available</p>');
            $('#qtyError' + i).addClass('d-block');
            $('#qty' + i).val(productQty);
        }
    }


    function absDiscount(number) {
        var id = "discount" + number;
        if (isNaN(parseFloat(document.getElementById(id).value))) {
            document.getElementById(id).value = "";
            document.getElementById(id).placeholder = "enter number only";
        } else {
            if (document.getElementById(id).value != "" && document.getElementById(id).value != "-") {
                var value = parseFloat(document.getElementById(id).value);
                value = Math.abs(value);
                document.getElementById(id).value = value;
            } else {
                document.getElementById(id).value = "";
            }
        }
    }
</script>