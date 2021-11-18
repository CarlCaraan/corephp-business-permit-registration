<?php
require("config/config.php");
$connect = new PDO("mysql:host=localhost;dbname=business", "root", "");

if (isset($_SESSION["user_id"])) {
    header("location:userhome.php");
}


$message = '';
$error_first_name = '';
$error_last_name = '';
$error_user_email = '';
$error_user_password = '';
$error_user_gender = '';
$first_name = '';
$last_name = '';
$user_email = '';
$user_password = '';
$user_gender = '';


if (isset($_POST["register"])) {
    if (empty($_POST['user_gender'])) {
        $error_user_gender = "<label class='text-danger'>Choose your Gender</label>";
    } else {
        //gender
        $user_gender = strip_tags($_POST['user_gender']); //Remove html tags
        $user_gender = ucfirst(strtolower($user_gender)); //Uppercase first letter
    }

    if (empty($_POST["first_name"])) {
        $error_first_name = "<label class='text-danger'>Enter First Name</label>";
    } else {
        $first_name = strip_tags($_POST['first_name']); //Remove html tags
        $first_name = str_replace(' ', '', $first_name); //remove spaces
        $first_name = ucfirst(strtolower($first_name)); //Uppercase first letter
    }

    if (empty($_POST["last_name"])) {
        $error_last_name = "<label class='text-danger'>Enter Last Name</label>";
    } else {
        $last_name = strip_tags($_POST['last_name']); //Remove html tags
        $last_name = str_replace(' ', '', $last_name); //remove spaces
        $last_name = ucfirst(strtolower($last_name)); //Uppercase first letter
    }

    if (empty($_POST["user_email"])) {
        $error_user_email = '<label class="text-danger">Enter Email Address</label>';
    } else {
        $user_email = trim($_POST["user_email"]);
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $error_user_email = '<label class="text-danger">Enter Valid Email Address</label>';
        }
    }

    if (empty($_POST["user_password"])) {
        $error_user_password = '<label class="text-danger">Enter Password</label>';
    } else {
        $user_password = trim($_POST["user_password"]);
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
    }


    if (empty($error_first_name && $error_last_name && $error_user_email && $error_user_password)) {
        //Generate username by concatinating first name and last name
        $user_name = strtolower($first_name . "_" . $last_name);
        $check_username_query = mysqli_query($con, "SELECT user_name FROM register_user WHERE user_name='$user_name'");

        //if username exist add number to username
        $i = 0;
        while (mysqli_num_rows($check_username_query) !=0) {
            $i++; //Add 1 to i
            $user_name = $user_name . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT user_name FROM register_user WHERE user_name='$user_name'");
        }
    }


    if ($error_first_name == '' && $error_last_name == '' && $error_user_email == '' && $error_user_password == '') {
        $user_activation_code = md5(rand());

        $user_otp = rand(100000, 999999);

        $data = array(
            ':first_name'		=>	$first_name,
            ':last_name'		=>	$last_name,
            ':user_name'		=>	$user_name,
            ':user_email'		=>	$user_email,
            ':user_password'	=>	$user_password,
            ':user_activation_code' => $user_activation_code,
            ':user_email_status'=>	'not verified',
            ':user_otp'			=>	$user_otp,
            ':user_gender'		=>	$user_gender
        );

        $query = "
		INSERT INTO register_user
		(first_name, last_name, user_name, user_email, user_password, user_activation_code, user_email_status, user_otp, user_gender)
		SELECT * FROM (SELECT :first_name, :last_name, :user_name, :user_email, :user_password, :user_activation_code, :user_email_status, :user_otp, :user_gender) AS tmp
		WHERE NOT EXISTS (
		    SELECT user_email FROM register_user WHERE user_email = :user_email
		) LIMIT 1
		";


        $statement = $connect->prepare($query);

        $statement->execute($data);

        if ($connect->lastInsertId() == 0) {
            $message = '<label class="text-danger">Email Already Register</label>';
        } else {
            $statement = $connect->prepare($query);

            $statement->execute();


            require 'includes/classes/class.phpmailer.php';
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '587';
            $mail->SMTPAuth = true;
            $mail->Username = 'bannedefused3@gmail.com';
            $mail->Password = '0639854227101msdcfredsw';
            $mail->SMTPSecure = 'tls';
            $mail->From = 'bannedefused3@gmail.com';
            $mail->FromName = 'banne';
            $mail->AddAddress($user_email);
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->Subject = 'Verification code for Verify Your Email Address';

            $message_body = '
			<p>For verify your email address, enter this verification code when prompted: <b>'.$user_otp.'</b>.</p>
			<p>Sincerely,</p>
			';
            $mail->Body = $message_body;

            if ($mail->Send()) {
                echo '<script>alert("Please Check Your Email for Verification Code")</script>';

                header('location:email_verify.php?code='.$user_activation_code);
            } else {
                $message = $mail->ErrorInfo;
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Account | Business Permit Registration</title>
	<?php include 'includes/head.php'; ?>
</head>
<body>

	<!-- Navigation -->
	<header>
	<?php $page = 'register';include 'includes/navbar_landingpage.php'; ?>
	</header>


	<!-- Start Container -->
	<div class="container pt-5">
        <div class="card card-default mt-5 animate__animated animate__rotateInUpLeft">
            <div class="card-header center">
                <div id="signup_typing"></div><br>
                <a href="login.php">Already have an account? Sign in here</a>
            </div>

            <div class="card-body">
                <?php echo $message; ?>
				<form method="post">
					<div class="form-group">
						<strong><label for="first_name">First Name</label></strong>
						<input type="text" name="first_name" class="form-control" placeholder="First Name">
						<?php echo $error_first_name; ?>
					</div>
					<div class="form-group">
						<strong><label for="last_name">Last Name</label></strong>
						<input type="text" name="last_name" class="form-control" placeholder="Last Name">
						<?php echo $error_last_name; ?>
					</div>
					<div class="form-group">
						<strong><label for="user_email">Email</label></strong>
						<input type="text" name="user_email" class="form-control" placeholder="Email">
						<?php echo $error_user_email; ?>
					</div>
					<div class="form-group">
						<strong><label for="user_password">Enter Your Password</label></strong>
						<input type="password" name="user_password" class="form-control" placeholder="Password">
						<?php echo $error_user_password; ?>
					</div>

					<strong><label for="user_gender">Gender</label></strong>
					<div class="form-check">
					    <label class="form-check-label">
					        <input type="radio" class="form-check-input" name="user_gender" value="male">Male
				    	</label>
					</div>
					<div class="form-check">
					    <label class="form-check-label">
					        <input type="radio" class="form-check-input" name="user_gender" value="female">Female
					    </label>
					</div>
					<?php echo $error_user_gender; ?>

					<div class="form-group center">
						<input type="submit" name="register" class="btn btn-info btn-lg" value="Sign Up">
					</div>
				</form>
            </div> <!-- End Card-Body -->
        </div> <!-- End Card -->

	</div> <!-- End Container -->


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

<script>

/*========== TYPING ANIMATION ==========*/
$(document).ready(function() {
	 $("#signup_typing").typed({
	    strings:["<h3>Create your Account</h3>"],
	    typespeed:0,
	    loop:true
	 });
});

</script>
