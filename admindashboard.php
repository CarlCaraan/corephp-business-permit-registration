<?php
require("config/config.php");
require("gconfig.php");
include("includes/classes/User.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'includes/head.php'; ?>
	<title>Dashboard | Admin</title>
</head>

<body>
    	<!-- Start Admin Section -->
	<div class="home">

		<!-- Navigation -->
		<header>
		<?php
		$page = 'admin';
		$side = 'admin_dashboard';
		include 'includes/navbar_admin.php';
		?>
		</header>

		<!-- Start Vertical navbar -->
		<div class="vertical-nav" id="sidebar">

			<!-- Dashboard -->
		    <p class="font-weight-bold text-uppercase px-3 mt-5">Admin Panel</p>

		    <ul class="nav flex-column mb-0">
		        <li class="nav-item">
		            <a href="admindashboard.php" class="nav-link" id="admin_navlink" style="<?php if($side=='admin_dashboard'){echo 'background-color: #E9ECEF;';}?>">
		                <i class="fas fa-tachometer-alt mr-3 text-success"></i>Dashboard
		            </a>
		        </li>

		        <li class="nav-item">
		            <a href="adminhome.php" class="nav-link" id="admin_navlink" style="<?php if($side=='admin_users'){echo 'background-color: #E9ECEF;';}?>">
		                <i class="fas fa-users mr-3 text-success"></i>Users
		            </a>
		        </li>

		        <li class="nav-item">
		            <a href="adminrecords.php" class="nav-link" id="admin_navlink" style="<?php if($side=='admin_records'){echo 'background-color: #E9ECEF;';}?>">
		                <i class="fas fa-book-open mr-3 text-success"></i>Records
		            </a>
		        </li>
		    </ul>

		</div>
		<!-- End Vertical navbar -->

		<!-- Start Page Content holder -->
		<div class="page-content" id="admin_content">

		    <!-- Toggle button -->
		    <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded shadow-sm">
		        <i class="fas fa-bars text-success"></i>
		    </button>



		</div>
		<!-- End Page Content holder -->

    </div>
    <!-- End Admin Section -->
    
<!-- Start Internet Notification Popup Message -->
<div class="connections">
	<div class="connection offline">
		<i class="material-icons wifi-off">wifi_off</i>
		<p>you are currently offline</p>
		<a href="#" class="refreshBtn">Refresh</a>
		<i class="material-icons close">close</i>
	</div>
	<div class="connection online">
		<i class="material-icons wifi">wifi</i>
		<p>your Internet connection was restored</p>
		<i class="material-icons close">close</i>
	</div>
</div>
<!-- End Internet Notification Popup Message -->

<!-- Javascript -->
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
<script src="bootstrap-4.6.0-dist/js/bootstrap.min.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/darkmode.js"></script> <!-- Dark Mode JS -->

</body>
</html>