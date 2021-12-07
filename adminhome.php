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
		$side = 'admin_home';
		include 'includes/navbar_admin.php';
		?>
		</header>

		<!-- Start Vertical navbar -->
		<div class="vertical-nav" id="sidebar">

			<!-- Dashboard -->
		    <p class="text-uppercase center text-white p-2 my-0" id="sidebar_headings">Admin Panel</p>

		    <ul class="nav flex-column">
		        <li class="nav-item">
		            <a href="adminhome.php" class="nav-link" id="admin_navlink"
					style="<?php if($side=='admin_home'){echo 'background-color: var(--nav-link); border-radius: 5px;';}?>">
						<div class="row center">
							<div class="col-2 py-0">
								<div class="center" id="icon_wrapper"><i class="fas fa-chart-bar" id="sidebar_icons"></i></div>
							</div>
							<div class="col-8 py-0">
								<div class="ml-2" id="sidebar_text_wrapper">Dashboard</div>
							</div>
						</div>
		            </a>
		        </li>

		        <li class="nav-item">
		            <a href="adminusers.php" class="nav-link" id="admin_navlink"
					style="<?php if($side=='admin_users'){echo 'background-color: var(--nav-link); border-radius: 5px;';}?>">
						<div class="row center">
							<div class="col-2 py-0">
								<div class="center" id="icon_wrapper"><i class="fas fa-user-friends" id="sidebar_icons"></i></fas></div>
							</div>
							<div class="col-8 py-0">
								<div class="ml-2" id="sidebar_text_wrapper">Users</div>
							</div>
						</div>
		            </a>
		        </li>

		        <li class="nav-item">
		            <a href="adminrecords.php" class="nav-link" id="admin_navlink"
					style="<?php if($side=='admin_records'){echo 'background-color: var(--nav-link); border-radius: 5px;';}?>">
						<div class="row center">
							<div class="col-2 py-0">
								<div class="center" id="icon_wrapper"><i class="fas fa-book" mr-3" id="sidebar_icons"></div></i>
							</div>
							<div class="col-8 py-0">
								<div class="ml-2" id="sidebar_text_wrapper">Records</div>
							</div>
						</div>
		            </a>
		        </li>
		    </ul>

		</div>
		<!-- End Vertical navbar -->

		<!-- Start Page Content holder -->
		<div class="page-content" id="admin_content">

		    <!-- Toggle button -->
		    <button id="sidebarCollapse" type="button" class="btn border-0">
		        <i class="fas fa-bars mt-1" id="sidebar_icons"></i>
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