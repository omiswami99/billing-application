<?php

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
	<title>Search(Bill/Date/Customer)</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><?php require("links.php"); ?>
</head>
 
<body onload="document.getElementById('search').focus()">
	
	<!-- The navbar code -->
	
	<?php require "navbar.php"; ?>
	<br>
<script>
    //for changing the class name (# replacement for active class)
    document.getElementById("searchh").classList.add("active");
	document.getElementById("searchh1").classList.remove("text-light");
	document.getElementById("searchh1").classList.add("text-white");
</script> 

<div class="centered form-div">
<div class="mt-0 mb-2 " style="font-weight:bold; color: black;"><span class="h3">SEARCH</span></div>
<input type="text" id="search" placeholder="Customer Name/Bill No/Date" autocomplete="off">
</div>

<div class="table centered form-div" style="margin-bottom:78vh;">
	<div id="table-data"></div>
</div>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
		//live search
		$("#search").on("keyup", function(){
			var searched_term = $(this).val();
			if(searched_term != '')
			{
				$.ajax({  
					url: "searchFix.php",
					type: "POST",
					data: {search:searched_term},
					success: function(data)
					{
						$("#table-data").fadeIn();
						$("#table-data").html(data);
					}
				});
			}
			else{
				$("#table-data").fadeOut();
				$("#table-data").html("");
			}	
		});
	});

</script>
</body>
</html>