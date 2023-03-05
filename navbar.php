<style>
	.dropdown-menu .dropdown-item:hover {
		color: #fff !important;
		background: #343a40 !important;
	}
 
</style>
 
	<nav  class="navbar sticky-top navbar-expand-lg navbar-dark elegant-color">
		<a href='#' class='navbar-brand'><b>Billing Application</b></a>
		<button class='navbar-toggler ' type='button' data-toggle='collapse' data-target='#navbaraid'>
			<span class='navbar-toggler-icon'></span>
		</button>
		<div class='collapse navbar-collapse' id='navbaraid'>
			<ul class='navbar-nav text-center mr-auto'>
				<li class='nav-item' id='sellprod'>
					<a href='sell.php' class='nav-link text-nowrap text-light' id='sellprod1'>Sell Products</a>
				</li>
				<li class='nav-item' id='addprod'>
					<a href='add.php' class='nav-link text-nowrap text-light' id='addprod1'>Add Products</a>
				</li>
				<li class='nav-item' id='stockinfo'>
					<a href='stockInfo.php' class='nav-link text-nowrap text-light' id='stockinfo11'>Stock Info</a>
				</li>
				<li class='nav-item dropdown' id='report'>
					<a class='nav-link dropdown-toggle text-light' href='#' data-toggle='dropdown' id='report1'>
						View Report
					</a>
					<div class='dropdown-menu elegant-color animatee slideIn'>
						<a class='dropdown-item text-light' href='monthlyReport.php' id='mreport'>Monthly Report</a>
						<a class='dropdown-item text-light' href='annualReport.php' id='areport'>Annual Report</a>
						<a class='dropdown-item text-light' href='checkManually.php' id='cmreport'>Check Manually</a>
						<a class='dropdown-item text-light' href='gstReport.php' id='gstreport'>GST Report</a>
					</div>

				</li>
				<li class='nav-item' id='searchh'>
					<a href='search.php' class='nav-link text-nowrap text-light' id='searchh1'>Search</a>
				</li>
				<?php if($security == 'adminUser'){ ?>
				<li class='nav-item dropdown' id='subUsers'>
					<a class='nav-link dropdown-toggle text-light' href='#' data-toggle='dropdown'>
						Sub-Users
					</a>
					<div class="justify-content-center mx-auto">
					<div class='dropdown-menu elegant-color animatee slideIn text-light'>
						<a class='dropdown-item text-light' href='subUsersCreate.php' id='crtsubUsers'>Create</a>
						<a class='dropdown-item text-light' href='subUsersEdit.php' id='editsubUsers'>Edit</a>
						<a class='dropdown-item text-light' href='subUsersAdd.php' id='addsubUsers'>Added Products</a>
						<a class='dropdown-item text-light' href='subUsersSold.php' id='soldsubUsers'>Sold Products</a>
						<a class='dropdown-item text-light' href='subUsersLeft.php' id='leftsubUsers'>Left</a>
					</div>
					</div>
				</li>
				<?php } ?>
			</ul>
			<ul class='navbar-nav text-center ml-auto'>

				<li class='nav-item' id='feedback'>
					<a href='userFeedback.php' class='nav-link text-nowrap text-light' id='feedback1'>Feedback</a>
				</li>

				<li class='nav-item'>
					<a href='logout.php' class='nav-link text-nowrap text-light'>Logout</a>
				</li>
			</ul>
		</div>
	</nav>
 