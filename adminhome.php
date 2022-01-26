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
					<a href="adminhome.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_home') {
																							echo 'background-color: var(--nav-link); border-radius: 5px;';
																						} ?>">
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
					<a href="adminusers.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_users') {
																							echo 'background-color: var(--nav-link); border-radius: 5px;';
																						} ?>">
						<div class="row center">
							<div class="col-2 py-0">
								<div class="center" id="icon_wrapper"><i class="fas fa-user-friends" id="sidebar_icons"></i></fas>
								</div>
							</div>
							<div class="col-8 py-0">
								<div class="ml-2" id="sidebar_text_wrapper">Users</div>
							</div>
						</div>
					</a>
				</li>

				<li class="nav-item">
					<a href="adminrecords.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_records') {
																								echo 'background-color: var(--nav-link); border-radius: 5px;';
																							} ?>">
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
			<div class="row" id="dashboard_container">
				<div class="col-xl-4 col-lg-5">
					<?php
					$all_user_details_query = mysqli_query($con, "SELECT * FROM register_user");
					$all_users = mysqli_num_rows($all_user_details_query);

					$admin_details_query = mysqli_query($con, "SELECT * FROM register_user WHERE user_type='admin'");
					$admins = mysqli_num_rows($admin_details_query);

					$user_details_query = mysqli_query($con, "SELECT * FROM register_user WHERE user_type='user'");
					$users = mysqli_num_rows($user_details_query);

					$admin_output = "<span class='d-none' id='fetch_admin'>" . $admins . "</span>";
					$user_output = "<span class='d-none' id='fetch_user'>" . $users . "</span>";

					echo $admin_output;
					echo $user_output;
					?>
					<!-- Start Donut Chart -->
					<div class="card mb-4" id="dashboard_col_wrapper">
						<h6 class="ml-3 mt-2 font-weight-bold" id="setting_headings">All Users Statistics</h6>
						<hr>
						<div class="card-body">
							<div class="chart-pie">
								<canvas id="myPieChart"></canvas>
							</div>
							<small>Users Count: <?php echo $users; ?></small><br>
							<small>Admin Count: <?php echo $admins; ?></small><br>
							<small>Total User: <?php echo $all_users; ?></small>
						</div>
						<hr>
						<div class="ml-3">
							<h6 class="m-0 font-weight-bold" id="setting_headings">Legends:</h6>
							<small>
								<span id="user_legends">■</span>
								User</small>
							<small>
								<span id="admin_legends">■</span>
								Admin</small>
						</div>
					</div>
					<!-- End Donut Chart -->
				</div>

				<div class="col-xl-4 col-lg-5">
					<?php
					$all_user_details_query = mysqli_query($con, "SELECT * FROM register_user");
					$all_users = mysqli_num_rows($all_user_details_query);

					$admin_details_query = mysqli_query($con, "SELECT * FROM register_user WHERE user_type='admin'");
					$admins = mysqli_num_rows($admin_details_query);

					$user_details_query = mysqli_query($con, "SELECT * FROM register_user WHERE user_type='user'");
					$users = mysqli_num_rows($user_details_query);

					$admin_output = "<span class='d-none' id='fetch_admin'>" . $admins . "</span>";
					$user_output = "<span class='d-none' id='fetch_user'>" . $users . "</span>";

					echo $admin_output;
					echo $user_output;
					?>
					<!-- Start Donut Chart -->
					<div class="card mb-4" id="dashboard_col_wrapper">
						<h6 class="ml-3 mt-2 font-weight-bold" id="setting_headings">Documents Statistics</h6>
						<hr>
						<div class="card-body">

						</div>
						<hr>
						<div class="ml-3">

						</div>
					</div>
					<!-- End Donut Chart -->
				</div>
			</div>

			<?php include 'includes/footer.php'; ?>
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

	<script src="assets/js/Chart.min.js"></script> <!-- Pie Chart Plugins -->

	<script>
		// Set new default font family and font color to mimic Bootstrap's default styling
		Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
		Chart.defaults.global.defaultFontColor = '#858796';

		// Fetch Details																					
		var fetch_admin = document.getElementById("fetch_admin").textContent;
		var fetch_user = document.getElementById("fetch_user").textContent;

		// Pie Chart Example
		var ctx = document.getElementById("myPieChart");
		var myPieChart = new Chart(ctx, {
			type: 'doughnut',
			data: {
				labels: ["Admin Count", "Users Count", "Social"],
				datasets: [{
					data: [fetch_admin, fetch_user, 0],
					backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
					hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
					hoverBorderColor: "rgba(234, 236, 244, 1)",
				}],
			},
			options: {
				maintainAspectRatio: false,
				tooltips: {
					backgroundColor: "rgb(255,255,255)",
					bodyFontColor: "#858796",
					borderColor: '#dddfeb',
					borderWidth: 1,
					xPadding: 15,
					yPadding: 15,
					displayColors: false,
					caretPadding: 10,
				},
				legend: {
					display: false
				},
				cutoutPercentage: 80,
			},
		});
	</script>
</body>

</html>