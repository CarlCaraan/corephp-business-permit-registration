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
		<?php include 'includes/admin_sidebar.php' ?>
		<!-- End Vertical navbar -->

		<!-- Start Page Content holder -->
		<div class="page-content" id="admin_content">

			<!-- Toggle button -->
			<button id="sidebarCollapse" type="button" class="btn border-0">
				<i class="fas fa-bars mt-1" id="sidebar_icons"></i>
			</button>
			<div class="row">
				<div class="col-xl-6">
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
					<div class="card" id="dashboard_col_wrapper">
						<h6 class="ml-3 mt-2 font-weight-bold" id="setting_headings">All Users Statistics</h6>
						<hr>
						<div class="card-body">
							<div class="chart-pie">
								<canvas id="myPieChart"></canvas>
							</div>
							<small>Users Count:
								<span class="counter"><?php echo $users; ?></span>
							</small><br>
							<small>Admin Count:
								<span class="counter"><?php echo $admins; ?></span>
							</small><br>
							<small>Total User:
								<span class="counter"><?php echo $all_users; ?></span>
							</small>
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

				<div class="col-xl-6">
					<?php
					$all_record_details_query = mysqli_query($con, "SELECT * FROM posts");
					$all_records = mysqli_num_rows($all_record_details_query);
					$all_records_percentage = mysqli_num_rows($all_record_details_query);

					$all_pending_details_query = mysqli_query($con, "SELECT * FROM posts WHERE status='for verification'");
					$all_pendings = mysqli_num_rows($all_pending_details_query);

					$all_approved_details_query = mysqli_query($con, "SELECT * FROM posts WHERE status='Verified'");
					$all_approveds = mysqli_num_rows($all_approved_details_query);

					// Get percentage
					$percentage_pending = substr(($all_pendings / $all_records) * 100, 0, 5);
					$percentage_approved = substr(($all_approveds / $all_records) * 100, 0, 5);

					$results_percentage = substr(($all_pendings + $all_approveds) / $all_records * 100, 0, 5);
					?>
					<!-- Start Progress Chart -->
					<div class="card" id="dashboard_col_wrapper">
						<h6 class="ml-3 mt-2 font-weight-bold" id="setting_headings">Documents Statistics</h6>
						<hr>
						<div class="card-body pt-4 pb-4">
							<h4 class="small font-weight-bold">For Verification
								<span class="float-right">%</span>
								<span class="float-right counter"><?php echo $percentage_pending; ?></span>
							</h4>
							<div class="progress mb-4">
								<div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage_pending; ?>%" aria-valuenow="<?php echo $all_pendings; ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_records; ?>"></div>
							</div>

							<h4 class="small font-weight-bold">Verified
								<span class="float-right">%</span>
								<span class="float-right counter"><?php echo $percentage_approved; ?></span>
							</h4>
							<div class="progress mb-4">
								<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentage_approved; ?>%" aria-valuenow="<?php echo $all_approveds; ?>" aria-valuemin="0" aria-valuemax="<?php echo $all_records; ?>"></div>
							</div>

							<h4 class="small font-weight-bold">Total Documents
								<span class="float-right">%</span>
								<span class="float-right counter"><?php echo $results_percentage; ?></span>
							</h4>
							<div class="progress mb-4">
								<div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<?php
							$date_today = date("Y-m-d");
							$total_document_query = mysqli_query($con, "SELECT * FROM posts WHERE date_added='$date_today'");
							$total_documents = mysqli_num_rows($total_document_query);
							?>
							<small>Documents Uploaded Today:
								<span class="counter"><?php echo $total_documents; ?></span>
							</small>
						</div>
						<hr>
						<div class="ml-3">
							<h6 class="m-0 font-weight-bold" id="setting_headings">Legends:</h6>
							<small><span id="pending_legends">■</span>
								Pending Documents:
								<span class="counter"><?php echo $all_pendings; ?></span>
							</small>
							<small><span id="approved_legends">■</span>
								Approved Documents:
								<span class="counter"><?php echo $all_approveds; ?></span>
							</small>
						</div>
					</div>
					<!-- End Progress Chart -->
				</div>
			</div>

			<?php include 'includes/admin_footer.php'; ?>
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

	<!-- ========= ALL Javascript ========= -->
	<!-- Font Awesome CDN -->
	<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>

	<!-- Bootstrap JS CDN -->
	<script src="bootstrap-4.6.0-dist/js/bootstrap.min.js"></script>

	<!-- Main Custom JS -->
	<script src="assets/js/custom.js"></script>
	
	<!-- Dark Mode JS -->
	<script src="assets/js/darkmode.js"></script> 

	<!-- Start Pie Chart Plugins -->
	<script src="assets/js/Chart.min.js"></script>
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
	<!-- End Pie Chart Plugins -->

	<!-- Start Counter Up JS -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
	<script src="assets/js/jquery.counterup.min.js"></script>
	<script>
		jQuery(document).ready(function($) {
			$('.counter').counterUp({
				delay: 10,
				time: 1000
			});
		});
	</script>
	<!-- End Counter Up JS -->

</body>

</html>