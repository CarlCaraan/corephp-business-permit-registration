<?php
require("config/config.php");
require("gconfig.php");
include("includes/classes/User.php");
?>

<html>

<head>
	<?php include 'includes/head.php'; ?>
	<title>Registration | Business Permission</title>
</head>

<body>

	<!-- Start Home Section -->
	<div id="home" class="offset">

		<!-- Navigation -->
		<header>
			<?php $page = 'user';
			include 'includes/navbar_user.php'; ?>
		</header>

		<!--========= Start Main Content Section =========-->
		<div class="container-fluid pt-5" id="registration_main_content">
			<div class="row mt-5">
				<div class="col-md-3">
					<div class="mt-0" id="setting_container">
						<img class="mb-3 mt-4 img-fluid" src="assets/images/registration_primary.svg" id="image1" alt="">
						<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
							<a class="nav-link active" id="v-pills-personal-tab" data-toggle="pill" href="#v-pills-personal" role="tab" aria-controls="v-pills-personal" aria-selected="true">
								PERSONAL INFORMATION
							</a>
							<a class="nav-link" id="v-pills-business-tab" data-toggle="pill" href="#v-pills-business" role="tab" aria-controls="v-pills-business" aria-selected="false">
								BUSINESS INFORMATION
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<header class="mb-3 mt-0" id="setting_container">
						<h3 class="center mb-0 text-uppercase" id="registration_headings">Step 1</h3>
						<h3 class="center text-uppercase" id="setting_headings">Business Permit Registration</h3>
						<p class="center mx-2" id="registration_text">
							Please fill and complete the form with the necessary information.<br>
							Click "<strong>Create PDF</strong>" below upon completetion. A PDF file will be downloaded.
						</p>
					</header>

					<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade show active" id="v-pills-personal" role="tabpanel" aria-labelledby="v-pills-personal-tab">
							<div class="card card-default mt-0" id="setting_container">

								<div class="card-body">
									<form action="makepdf.php" method="POST">
										<div class="narrow">
											<h5 class="font-weight-bold mb-3" id="registration_text2">PERSONAL INFORMATION</h5>
											<div class="form-row mb-2">
												<div class="col-xl">
													<label class="font-weight-bold" for="first_name">First Name</label>
													<input class="form-control registration-input" type="text" name="first_name" placeholder="First Name" required>
												</div>
												<div class="col-xl">
													<label class="font-weight-bold" for="last_name">Last Name</label>
													<input class="form-control registration-input" type="text" name="last_name" placeholder="Last Name" required>
												</div>
												<div class="col-xl">
													<label class="font-weight-bold" for="middle_name">Middle Initial</label>
													<input class="form-control registration-input" type="text" name="middle_name" placeholder="Middle Initial" required>
												</div>
												<div class="col-xl">
													<label class="font-weight-bold" for="middle_name">Name Suffix (ex. Sr.Jr.III,etc.)</label>
													<input class="form-control registration-input" type="text" name="suffix_name" placeholder="Name Suffix (optional)">
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-xl">
													<label class="font-weight-bold" for="email">Email Address</label>
													<input class="form-control registration-input" type="email" name="email" placeholder="Email Address" required>
												</div>
												<div class="col-xl">
													<label class="font-weight-bold" for="phone">Contact Number</label>
													<input class="form-control registration-input" type="tel" name="phone" placeholder="Mobile/Telephone" required>
												</div>
											</div>
											<div class="w-100 center">
												<button class="btn btn-lg mt-2" type="submit" name="" id="registration_button">Generate PDF</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						<div class="tab-pane fade" id="v-pills-business" role="tabpanel" aria-labelledby="v-pills-business-tab">
							<div class="card card-default mt-0" id="setting_container">
								<div class="card-body">
									<form action="makepdf.php" method="POST">
										<div class="narrow">
											<h5 class="font-weight-bold mb-3" id="registration_text2">BUSINESS INFORMATION</h5>
											<div class="form-row mb-2">
												<div class="col-xl">
													<label class="font-weight-bold" for="first_name">Business Name</label>
													<input class="form-control registration-input" type="text" name="" placeholder="Business Name" required><br>

													<label class="font-weight-bold" for="last_name">Address (House/Block/Lot No./Street/Subdivision/Village)</label>
													<input class="form-control registration-input" type="text" name="last_name" placeholder="Business Address" required>
												</div>
											</div>
											<div class="w-100 center">
												<button class="btn btn-lg mt-2" type="submit" name="" id="registration_button">Generate PDF</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- End Row -->

		</div> <!-- End Container -->
		<!--========= End Main Content Section =========-->

		<!--========= Start Footer Section =========-->
		<?php include 'includes/user_footer.php'; ?>
		<!--========= End Footer Section =========-->
	</div>
	<!-- End Home Section -->


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


	<?php include 'includes/scripts.php'; ?>
	<script src="assets/js/darkmode.js"></script> <!-- Dark Mode JS -->

</body>


</html>