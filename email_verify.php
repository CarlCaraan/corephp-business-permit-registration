<?php
$connect = new PDO("mysql:host=localhost;dbname=business", "root", "");

$error_user_otp = '';
$user_activation_code = '';
$message = '';

if(isset($_GET["code"]))
{
	$user_activation_code = $_GET["code"];

	if(isset($_POST["submit"]))
	{
		if(empty($_POST["user_otp"]))
		{
			$error_user_otp = '<label class="text-danger">Enter verification code</label>';
		}
		else
		{
			$query = "
			SELECT * FROM register_user
			WHERE user_activation_code = '".$user_activation_code."'
			AND user_otp = '".trim($_POST["user_otp"])."'
			";

			$statement = $connect->prepare($query);

			$statement->execute();

			$total_row = $statement->rowCount();

			if($total_row > 0)
			{
				$query = "
				UPDATE register_user
				SET user_email_status = 'verified'
				WHERE user_activation_code = '".$user_activation_code."'
				";

				$statement = $connect->prepare($query);

				if($statement->execute())
				{
					header('location:login.php?register=success');
				}
			}
			else
			{
				$message = '<label class="text-danger">Invalid verification code</label>';
			}
		}
	}
}
else
{
	$message = '<label class="text-danger">Invalid Url</label>';
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Verify Email | Business Permit Registration</title>
	<?php include 'includes/head.php'; ?>
</head>

<body>

	<!-- Navigation -->
	<header>
	<?php $page = 'login';include 'includes/navbar_landingpage.php'; ?>
	</header>

	<!-- Start Email Verify Section  -->

    <!-- Start Background Image -->
    <div class="home-inner">
    </div>
    <!-- End Background Image -->

	<div class="container">
		<div class="card card-default" id="login_card">
			<div class="center">
				<h2 class="font-weight-bold" id="login_headings">Verify Your Email Address</h2>
			</div>
			<div class="card-body">
				<div class="alert alert-info alert-dismissible fade show" role="alert">
					An <strong>email</strong> has been sent. Please check your <strong>inbox</strong>.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST">
					<div class="form-group">
						<strong><label for="user_otp">Enter your verification code</label></strong>
						<input type="text" name="user_otp" class="form-control login-input" placeholder="6-digit code">
						<?php echo $message; ?>
						<?php echo $error_user_otp; ?>
					</div>
					<div class="form-group center">
						<input type="submit" name="submit" class="btn btn-lg px-5" id="next" value="Submit">
						<a href="resend_email_otp.php" class="btn btn-secondary btn-lg px-4 font-weight-bold">Resend Code</a>
					</div>
				</form>
			</div> <!-- End Card-Body -->
		</div> <!-- End Card -->

	</div> <!-- End Container -->
	<!-- End Email Verify Section  -->


<?php include 'includes/scripts.php'; ?>

</body>
</html>
