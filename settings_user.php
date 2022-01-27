<?php
require("config/config.php");
include("includes/classes/User.php");
?>

<html>

<head>
	<?php include 'includes/head.php'; ?>
	<title>Account | Settings</title>
</head>

<body>

	<!-- Navigation -->
	<header>
		<?php $page = 'settings';
		include 'includes/navbar_user.php'; ?>
	</header>

	<!-- Start Settings Section -->
	<div id="settings" class="offset">

		<div class="container pt-4">
			<div class="card card-default" id="setting_container">
				<h1 id="setting_headings" class="center">Account Settings</h1>
				<div class="card-body py-1">
					<?php
					if (isset($_SESSION['password_message'])) {
						echo $_SESSION['password_message'];
						unset($_SESSION['password_message']);
					}
					?>
					<?php
					if (isset($_SESSION['message'])) {
						echo $_SESSION['message'];
						unset($_SESSION['message']);
					}
					?>
					<div class="row mb-1">
						<?php
						$user_data_query = mysqli_query($con, "SELECT first_name, last_name, user_name, user_email, user_gender, user_password FROM register_user WHERE user_name='$userLoggedIn'");
						$row = mysqli_fetch_array($user_data_query);

						$firstname = $row['first_name'];
						$lastname = $row['last_name'];
						$gender = $row['user_gender'];
						$check_password = $row['user_password'];

						if (empty($check_password)) {
							$disable = "d-none";
							$create = "<h5 id='setting_headings' class='my-0 py-0'>Set a new password</h5>";
							$alert_setpassword = "<div class='alert alert-info alert-dismissible fade show' id='alert_setpassword'>
														Set a password to<strong> Login</strong> via portal.
													</div>";
							$notice = '<strong><label class="mt-2" for="alert">Notice</label></strong>';
						} else {
							$disable = "";
							$create = "<h5 id='setting_headings' class='my-0 py-0'>Change Password</h5>";
							$alert_setpassword = "";
							$notice = '<strong><label class="mt-2" for="alert">Current Password</label></strong>';
						}

						?>

						<div class="col-lg p-0 mx-1">
							<form class="" action="includes/form_handlers/settings_handler.php" method="POST">
								<h5 id='setting_headings' class='my-0 py-0'>Basic Information</h5>

								<div class="form-group">
									<strong><label class="mt-2" for="first_name">First Name</label></strong>
									<input class="form-control login-input" type="text" name="first_name" placeholder="First Name" value="<?php echo $firstname; ?>" required>

									<strong><label class="mt-2" for="last_name">Last Name</label></strong>
									<input class="form-control login-input" type="text" name="last_name" placeholder="Last Name" value="<?php echo $lastname; ?>" required>

									<strong><label class="mt-2" for="user_gender">Sex</label></strong>
									<select class="form-control gender-input" name="user_gender" id="user_gender" value="<?php echo $gender; ?>" required>
										<option disabled selected>Select Gender (optional)</option>
										<option value="Male" <?php if ($gender == "Male") echo "selected"; ?>>Male</option>
										<option value="Female" <?php if ($gender == "Female") echo "selected"; ?>>Female</option>
									</select>
								</div>

								<div class="center">
									<input class="btn btn-lg mt-1" id="next" type="submit" name="update_details" value="Update Details"></input>
								</div>
							</form>
						</div>

						<hr>

						<div class="col-lg p-0 mx-1">
							<form class="" action="includes/form_handlers/settings_handler.php" method="POST">
								<?php echo $create; ?>
								<?php echo $notice; ?>
								<?php echo $alert_setpassword; ?>
								<input class="form-control login-input <?php echo $disable; ?>" type="password" name="old_password" placeholder="Current Password">

								<strong><label class="mt-2" for="new_password_1">New Password</label></strong>
								<input class="form-control login-input" type="password" name="new_password_1" placeholder="New Password" required>

								<strong><label class="mt-2" for="new_password_2">Confirm New Password</label></strong>
								<input class="form-control login-input" type="password" name="new_password_2" placeholder="Confirm New Password" required>

								<div class="center">
									<input class="btn btn-lg mt-4" id="next" type="submit" name="update_password" value="Update Password"></input>
								</div>
							</form>
						</div>

					</div> <!-- End Row -->
				</div> <!-- End Card-Body -->

			</div> <!-- End Card -->

			<!-- Start Map Iframe -->
			<div class="card card-default mt-3" id="setting_container">
				<div class="center">
					<h5 id='setting_headings' class='my-0 py-0'>Location</h5>
				</div>
				<div class="card-body">
					<iframe class="rounded" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61801.21332013339!2d121.38856623718988!3d14.509022598989775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ed7ababf3a55%3A0x88209f39595fc5f6!2sSanta%20Maria%2C%20Laguna!5e0!3m2!1sen!2sph!4v1636527272301!5m2!1sen!2sph" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				</div>

			</div>
			<!-- End Map Iframe -->


		</div> <!-- End Container -->

	</div>
	<!-- End Settings Section -->


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