<?php
require("config/config.php");
$connect = new PDO("mysql:host=localhost;dbname=business", "root", "");

if (isset($_SESSION["user_id"])) {
    header("location:adminhome.php");
}

require("gconfig.php");

$login_button = '';

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

    <!-- Google Sign In Button -->
    <?php
    if(!isset($_SESSION['access_token'])) {
        //Create a URL to obtain user authorization
        $login_button = '
        <a href="' . $google_client->createAuthUrl() . '">
            <div class="g-sign-in-button">
                <div class="content-wrapper">
                    <div class="logo-wrapper center">
                        <img src="assets/images/icons/google.ico">
                    </div>
                <span class="text-container">
                    <span>Register with Google</span>
                </span>
                </div>
            </div>
        </a>';
    }
    ?>

	<!-- Start Register Section -->

    <!-- Start Background Image -->
    <div class="home-inner">
    </div>
    <!-- End Background Image -->

	<div class="container">
        <div class="card card-default animate__animated animate__backInLeft" id="login_card">
            <div class="center">
                <h1 id="login_headings" style="letter-spacing: 1.5px;"><strong>Create your Account</strong></h1>
                <!-- Google Button -->
                <?php
                if ($login_button == '') {
                    header('Location:adminhome.php');
                }
                else {
                    echo '<div align="center">' . $login_button . '</div>';
                }
                ?>

                <div class="row pt-2">
                    <div class="col-5 py-0 pr-0 pl-4">
                        <hr class="bg-dark">
                    </div>
                    <div class="col-2 py-1 px-0">
                        OR
                    </div>
                    <div class="col-5 py-0 pl-0 pr-4">
                        <hr class="bg-dark">
                    </div>
                </div>

            </div>


            <div class="card-body">
                <?php echo $message; ?>
				<form method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6 py-0">
                            <input type="text" name="first_name" class="form-control login-input" placeholder="First Name">
                            <?php echo $error_first_name; ?>
                        </div>
                        <div class="form-group col-md-6 py-0">
                            <input type="text" name="last_name" class="form-control login-input" placeholder="Last Name">
                            <?php echo $error_last_name; ?>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-8 py-0 my-0">
                            <div class="form-group">
                                <input type="text" name="user_email" class="form-control login-input" placeholder="Email Address">
                                <?php echo $error_user_email; ?>
                            </div>
                            <div class="form-group">
                                <input type="password" name="user_password" class="form-control login-input" placeholder="Password">
                                <?php echo $error_user_password; ?>
                            </div>
                        </div>

                        <div class="form-group col-md-4 pt-0">
                            <div class="form-group pt-2 pl-3" id="gender_wrapper">
                                <label for="user_gender" id="gender_label">Gender</label>
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
                            </div>
                        </div>
                    </div> <!-- End row -->

					<?php echo $error_user_gender; ?>

					<div class="form-group center">
						<input type="submit" name="register" id="next" class="btn btn-lg" value="Register">
					</div>
				</form>

                <div class="center">
                    Already a member?<a href="login.php" id="register_now"> Login</a>
                </div>

            </div> <!-- End Card-Body -->
        </div> <!-- End Card -->

	</div> <!-- End Register Section -->


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

