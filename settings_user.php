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
	<?php $page = 'settings';include 'includes/navbar_user.php'; ?>
	</header>

	<!-- Start Settings Section -->
	<div id="settings" class="offset">

		<a href="settings_user.php" id="username_container">
			<?php
				$fullname_obj = new User($con, $userLoggedIn);
				echo $fullname_obj->getFirstAndLastName();
			?>
		</a>

		<div class="container pt-5">
			<div class="card card-default mt-5">
				<div class="card-header">
					<h3 class="center">Account Settings</h3>
					<p class="center">Note: Modify the value and click 'Update Details'</p>
				</div>

				<div class="card-body">
					<div class="row mb-1">

						<?php
						//Settings Handler
						include("includes/form_handlers/settings_handler.php");

						$user_data_query = mysqli_query($con, "SELECT first_name, last_name, user_name, user_email, user_gender, account FROM register_user WHERE user_name='$userLoggedIn'");
						$row = mysqli_fetch_array($user_data_query);

						$firstname = $row['first_name'];
						$lastname = $row['last_name'];
						$gender = $row['user_gender'];
						$email = $row['user_email'];
						$account = $row['account'];

						if($account == "google") {
							$disable = "disabled";
						}
						else {
							$disable = "";
						}

						?>

						<div class="col-md p-0 mx-1">
							<form class="" action="settings_user.php" method="POST">
								<strong><p>Basic Information</p></strong>

								<div class="form-row">
								    <div class="col-md py-0">
										<input class="form-control" type="text" name="first_name" placeholder="First Name" value="<?php echo $firstname; ?>" required>
								    </div>
									<div class="col-md py-0">
										<input class="form-control" type="text" name="last_name" placeholder="Last Name" value="<?php echo $lastname; ?>" required>
									</div>
								</div>

								<input class="form-control mt-1" type="email" name="user_email" placeholder="Email" value="<?php echo $email; ?>" required <?php echo $disable; ?>>

						        <select class="form-control mt-1" name="user_gender" id="user_gender" value="<?php echo $gender; ?>" required <?php echo $disable; ?>>
						      		<option value="Male" <?php if($gender == "Male")echo "selected"; ?>>Male</option>
						      		<option value="Female" <?php if($gender == "Female")echo "selected"; ?>>Female</option>
						        </select>

								<input class="btn btn-outline-light btn-lg bg-success mt-4" type="submit" name="update_details" value="Update Details"></input>
								<?php echo $message; ?>
							</form>
						</div>

						<div class="col-md p-0 mx-1">
							<form class="" action="settings_user.php" method="POST">
								<strong><p>Change Password</p></strong>
								<input class="form-control" type="password" name="old_password" placeholder="Current Password" required <?php echo $disable; ?>>
								<input class="form-control mt-1" type="password" name="new_password_1" placeholder="New Password" required <?php echo $disable; ?>>
								<input class="form-control mt-1" type="password" name="new_password_2" placeholder="Confirm New Password" required <?php echo $disable; ?>>
								<input class="btn btn-outline-light btn-lg bg-success mt-4" type="submit" name="update_password" value="Update Password" <?php echo $disable; ?>></input>
								<?php echo $password_message; ?>
							</form>
						</div>

					</div> <!-- End Row -->
				</div> <!-- End Card-Body -->

			</div> <!-- End Card -->

			<!-- Start Map Iframe -->
			<div class="card card-default mt-5">
				<div class="card-header center">
					<h3>Location</h3>
				</div>
				<div class="card-body">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61801.21332013339!2d121.38856623718988!3d14.509022598989775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ed7ababf3a55%3A0x88209f39595fc5f6!2sSanta%20Maria%2C%20Laguna!5e0!3m2!1sen!2sph!4v1636527272301!5m2!1sen!2sph" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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

</body>


</html>
