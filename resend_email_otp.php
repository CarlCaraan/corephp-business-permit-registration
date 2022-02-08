<?php
$connect = new PDO("mysql:host=localhost;dbname=business", "root", "");

$message = '';


if(isset($_SESSION["user_id"]))
{
	header("location:userhome.php");
}

if(isset($_POST["resend"]))
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
				if($row["user_email_status"] == 'verified')
				{
					$message = '<div class="alert alert-info">Email Address already verified, you can login into system</div>';
				}
				else
				{
					require 'includes/classes/class.phpmailer.php';
					$mail = new PHPMailer;
					$mail->IsSMTP();
					$mail->Host = 'smtp.gmail.com';
					$mail->Port = '587';
					$mail->SMTPAuth = true;
					$mail->Username = 'wetutwetut@gmail.com';
					$mail->Password = 'wetwet666';
					$mail->SMTPSecure = 'tls';
					$mail->From = 'wetutwetut@gmail.com';
					$mail->FromName = 'BPR-SantaMariaLaguna';
					$mail->AddAddress($row["user_email"]);
					$mail->WordWrap = 50;
					$mail->IsHTML(true);
					$mail->Subject = 'Verification code for Verify Your Email Address';
					$message_body = '
					<p>For verify your email address, enter this verification code when prompted: <b>'.$row["user_otp"].'</b>.</p>
					<p>Sincerely,</p>
					';
					$mail->Body = $message_body;

					if($mail->Send())
					{
						echo '<script>alert("Please Check Your Email for Verification Code")</script>';
						echo '<script>window.location.replace("email_verify.php?code='.$row["user_activation_code"].'");</script>';
					}
					else
					{

					}
				}
			}
		}
		else
		{
			$message = '<div class="alert alert-danger">Email Address doesn\'t exist</div>';
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Resend Email Verification</title>
	<?php include 'includes/head.php'; ?>
</head>
<body>

    <!-- Navigation -->
    <header>
        <?php $page = 'register';include 'includes/navbar_landingpage.php'; ?>
    </header>

	<!-- Start Resend Email OTP Section -->

    <!-- Start Background Image -->
    <div class="home-inner">
    </div>
    <!-- End Background Image -->

	<div class="container">
		<div class="card card-default" id="login_card">
			<div class="center">
				<h2 class="font-weight-bold" id="login_headings">Resend Email Verification</h2>
			</div>
			<div class="card-body">
				<div class="alert alert-info alert-dismissible fade show" role="alert">
					Please check your <strong>inbox</strong> after sending <strong>request</strong>.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php echo $message; ?>
				<form method="post">
					<div class="form-group">
						<strong><label for="user_email">Enter Your Email</label></strong>
						<input type="email" name="user_email" class="form-control login-input" placeholder="Email">
					</div>
					<div class="form-group center">
						<input type="submit" name="resend" class="btn btn-lg" id="next" value="Submit">
					</div>
				</form>
			</div> <!-- End Card-Body -->
		</div> <!-- End Card -->

	</div> <!-- End Container -->
	<!-- End Resend Email OTP Section -->


<?php include 'includes/scripts.php'; ?>

</body>
</html>
