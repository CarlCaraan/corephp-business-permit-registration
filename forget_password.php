<?php
$connect = new PDO("mysql:host=localhost;dbname=business", "root", "");

$message = '';


if(isset($_SESSION["user_id"]))
{
	header("location:userhome.php");
}

if(isset($_POST["submit"]))
{
	if(empty($_POST["user_email"]))
	{
		$message = '<div class="alert alert-danger">Email Address is required</div>';
	}
	else
	{
		$data = array(
			':user_email'	=>	trim($_POST["user_email"])
		);

		$query = "
		SELECT * FROM register_user
		WHERE user_email = :user_email
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			$result = $statement->fetchAll();

			foreach($result as $row)
			{
				if($row["user_email_status"] == 'not verified')
				{
					$message = '<div class="alert alert-info">Your Email Address is not verify, so first verify your email address by click on this <a href="resend_email_otp.php">link</a></div>';
				}
				else
				{
					$user_otp = rand(100000, 999999);

					$sub_query = "
					UPDATE register_user
					SET user_otp = '".$user_otp."'
					WHERE register_user_id = '".$row["register_user_id"]."'
					";

					$connect->query($sub_query);

					require 'includes/classes/class.phpmailer.php';

					$mail = new PHPMailer;

					$mail->IsSMTP();

					$mail->Host = 'smtp.gmail.com';

					$mail->Port = '587';

					$mail->SMTPAuth = true;

					$mail->Username = 'bannedefused3@gmail.com';

					$mail->Password = '0639854227101msdcfredsw';

					$mail->SMTPSecure = 'tls';

					$mail->From = 'bannedefused3@gmail.com';

					$mail->FromName = 'banne';

					$mail->AddAddress($row["user_email"]);

					$mail->IsHTML(true);

					$mail->Subject = 'Password reset request for your account';

					$message_body = '
					<p>For reset your password, you have to enter this verification code when prompted: <b>'.$user_otp.'</b>.</p>
					<p>Sincerely,</p>
					';

					$mail->Body = $message_body;

					if($mail->Send())
					{
						echo '<script>alert("Please Check Your Email for password reset code")</script>';

						echo '<script>window.location.replace("forget_password.php?step2=1&code=' . $row["user_activation_code"] . '")</script>';
					}
				}
			}
		}
		else
		{
			$message = '<div class="alert alert-danger">Email Address not found in our record</div>';
		}
	}
}

if(isset($_POST["check_otp"]))
{
	if(empty($_POST["user_otp"]))
	{
		$message = '<div class="alert alert-danger">Enter OTP Number</div>';
	}
	else
	{
		$data = array(
			':user_activation_code'		=>	$_POST["user_code"],
			':user_otp'					=>	$_POST["user_otp"]
		);

		$query = "
		SELECT * FROM register_user
		WHERE user_activation_code = :user_activation_code
		AND user_otp = :user_otp
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			echo '<script>window.location.replace("forget_password.php?step3=1&code=' . $_POST["user_code"] . '")</script>';
		}
		else
		{
			$message = '<div class="alert alert-danger">Wrong verification code</div>';
		}
	}
}

if(isset($_POST["change_password"]))
{
	$new_password = $_POST["user_password"];
	$confirm_password = $_POST["confirm_password"];

	if($new_password == $confirm_password)
	{
		$query = "
		UPDATE register_user
		SET user_password = '".password_hash($new_password, PASSWORD_DEFAULT)."'
		WHERE user_activation_code = '".$_POST["user_code"]."'
		";

		$connect->query($query);

		echo '<script>window.location.replace("login.php?reset_password=success")</script>';
	}
	else
	{
		$message = '<div class="alert alert-danger">Confirm Password is not match</div>';
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Reset Password | Business Permit Registration</title>
	<?php include 'includes/head.php'; ?>
</head>
<body>

	<!-- Navigation -->
	<header>
	<?php $page = 'login';include 'includes/navbar_landingpage.php'; ?>
	</header>

	<!-- Start Forget Password Section -->
	<div class="container p-5">
		<div class="card card-default mt-5">
			<div class="card-header center">
				<h3>Reset Password</h3>
				<p>Request a password reset below.</p>
			</div>
			<div class="card-body">
				<?php
				echo $message;

				if(isset($_GET["step1"]))
				{
				?>
				<form method="post">
					<div class="form-group">
						<strong><label for="user_email">Enter Your Email</label></strong>
						<input type="text" name="user_email" class="form-control" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-info btn-lg" value="Reset Password">
					</div>
				</form>
				<?php
				}
				if(isset($_GET["step2"], $_GET["code"]))
				{
				?>
				<form method="POST">
					<div class="form-group">
						<strong><label>Enter your verification code</label></strong>
						<input type="text" name="user_otp" class="form-control" placeholder="code">
					</div>
					<div class="form-group">
						<input type="hidden" name="user_code" value="<?php echo $_GET["code"]; ?>">
						<input type="submit" name="check_otp" class="btn btn-info btn-lg" value="Submit">
					</div>
				</form>
				<?php
				}

				if(isset($_GET["step3"], $_GET["code"]))
				{
				?>
				<form method="post">
					<div class="form-group">
						<strong><label for="user_password">New Password</label></strong>
						<input type="password" name="user_password" class="form-control">
					</div>
					<div class="form-group">
						<strong><label for="confirm_password">Confirm Password</label></strong>
						<input type="password" name="confirm_password" class="form-control">
					</div>
					<div class="form-group">
						<input type="hidden" name="user_code" value="<?php echo $_GET["code"]; ?>">
						<input type="submit" name="change_password" class="btn btn-info btn-lg" value="Change Password">
					</div>
				</form>
				<?php
				}
				?>

			</div> <!-- End Card-Body -->
		</div> <!-- End Card -->

	</div> <!-- End Container -->
	<!-- End Forget Password Section -->


<?php include 'includes/scripts.php'; ?>

</body>
</html>
