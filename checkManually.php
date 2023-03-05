<?php

include 'conn.php';
session_start();
if (!isset($_SESSION['username'])) {
	header("location:login.php");
}

//recalling session variables
$username = $_SESSION['username'];
$shopname = $_SESSION['shopname'];
$shopaddress = $_SESSION['shopaddress'];

$security = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>

<head>
	<title>Manual Report</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"><?php require("links.php"); ?>
</head>
<style>
	.activee {
		background: #343a40 !important;
	}
</style>

<body class="text-white">

	<!-- The navbar code -->

	<?php require "navbar.php"; ?>
	<br>
	<script>
		//for changing the class name (# replacement for active class)
		document.getElementById("report").classList.add("active");
		document.getElementById("report1").classList.remove("text-light");
		document.getElementById("report1").classList.add("text-white");

		document.getElementById("cmreport").classList.add("activee");
	</script>

	<div class="centered form-div" style="margin-bottom:78vh;">
		<div class="mt-0 mb-2 " style="font-weight:bold; color: #666"><span class="h3">SEARCH MANUALLY</span></div>
		<div id="search-bar">
			<input type="date" name="date" id="date1">
			<b class="text-dark">To</b>
			<input type="date" name="date" id="date2" class="mt-2">
			<button id="button">Ok</button>
			<hr>
		</div>
		<div id="printOnly">
			<!-- #omi do your code below this comment.  (code for 2 lines of info as i told on whatsapp) -->
			<table class="mt-2" id="table" style="margin:0 auto;">
				<tr>
					<td id="table-data">
						<!-- data will be added heere and printed -->
					</td>
				</tr>
			</table>
		</div>
		<button type="button" onclick="printOnly()"><i class="fa fa-print"></i> PRINT </button>
	</div>

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#button").on("click", function() {
				var date1 = $("#date1").val();
				var date2 = $("#date2").val();
				$.ajax({
					url: "performManually.php",
					type: "POST",
					data: {
						date1: date1,
						date2: date2
					},
					success: function(data) {
						$("#table-data").fadeIn();
						$("#table-data").html(data);
					}
				});
			});
		});
	</script>
</body>

</html>