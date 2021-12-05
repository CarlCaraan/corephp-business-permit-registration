<?php
require("config/config.php");
require("gconfig.php");
include("includes/classes/User.php");
?>

<html>
<head>
	<?php include 'includes/head.php'; ?>
	<title>Registration | Welcome</title>
</head>

<body>

	<!-- Start Home Section -->
	<div id="home" class="offset">

		<!-- Navigation -->
		<header>
		<?php $page = 'user';include 'includes/navbar_user.php'; ?>
		</header>

		<div class="container pt-5">
			<div class="card card-default mt-5">
				<div class="card-header">
					<h3 class="center">Step 1 - Business Permit Registration</h3>
					<p class="center">Fill up the details below and download the pdf</p>
				</div>

				<div class="card-body">
					<form class="center" action="makepdf.php" method="POST">

						<div class="narrow">

							<div class="row mb-1">
							    <div class="col-md p-0 mx-1">
									<input class="form-control" type="text" name="fname" placeholder="First Name" required>
							    </div>
							    <div class="col-md p-0 mx-1">
									<input class="form-control" type="text" name="lname" placeholder="Last Name" required>
								</div>
							</div>

							<div class="mx-1 mb-1">
								<input class="form-control" type="email" name="email" placeholder="Email" required>
							</div>

							<div class="mx-1 mb-1">
								<input class="form-control" type="tel" name="phone" placeholder="Cellphone Number" required>
							</div>

							<button class="btn btn-outline-light btn-lg bg-success" type="submit" name="">Create PDF</button>

						</div>

					</form>
				</div>
			</div>



		</div>



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
