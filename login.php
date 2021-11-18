<?php
$connect = new PDO("mysql:host=localhost;dbname=business", "root", "");

if (isset($_SESSION["user_id"])) {
    header("location:adminhome.php");
}
require("gconfig.php");

$login_button = '';

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login | Business Permit Registration</title>
    <?php include 'includes/head.php'; ?>
</head>

<body>

    <!-- Navigation -->
    <header>
        <?php $page = 'login';include 'includes/navbar_landingpage.php'; ?>
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
                    <span>Sign in with Google</span>
                </span>
                </div>
            </div>
        </a>';
    }
    ?>

    <!-- Start Login Section -->
    <div class="container pt-5">
        <div class="card card-default mt-5 animate__animated animate__rotateInDownRight">
            <div class="card-header center">
                <div id="signin_typing"></div><br>
                <a href="register.php" class="center">Need an account? Register here</a>
            </div>

            <div class="card-body">
                <?php
                if (isset($_GET["register"])) {
                    if ($_GET["register"] == 'success') {
                        echo '<div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Email successfully verified!</strong> Now you can login with your account.
                              </div>';
                    }
                }

                if (isset($_GET["reset_password"])) {
                    if ($_GET["reset_password"] == 'success') {
                        echo '<div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Password save successfully!</strong> Now you can login with your new password.
                              </div>';
                    }
                }
                ?>
                <form method="POST" id="login_form">
                    <div class="form-group" id="email_area">
                        <strong><label for="user_email">Email</label></strong>
                        <input type="text" name="user_email" id="user_email" class="form-control" placeholder="Email">
                        <span id="user_email_error" class="text-danger"></span>
                    </div>
                    <div class="form-group" id="password_area" style="display:none;">
                        <strong><label for="user_password">Password</label></strong>
                        <input type="password" name="user_password" id="user_password" class="form-control" placeholder="password">
                        <span id="user_password_error" class="text-danger"></span>
                    </div>
                    <div class="form-group" id="otp_area" style="display:none;">
                        <strong><label for="user_otp">Enter Login Verification Code</label></strong>
                        <input type="text" name="user_otp" id="user_otp" class="form-control">
                        <span id="user_otp_error" class="text-danger"></span>
                    </div>
                    <div class="form-group" align="left">
                        <input type="hidden" name="action" id="action" value="email">
                        <input type="submit" name="next" id="next" class="btn btn-info btn-lg" value="Next">
                    </div>
                </form>

                <div class="center">
                    <strong><a href="forget_password.php?step1=1">Forgot Password</a></strong>
                    <?php
                    if ($login_button == '') {
                        header('Location:adminhome.php');
                    }
                    else {
                       echo '<div align="center">' . $login_button . '</div>';
                    }
                    ?>
                </div>
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
$(document).ready(function() {
    $('#login_form').on('submit', function(event) {
        event.preventDefault();
        var action = $('#action').val();
        $.ajax({
            url: "includes/handlers/ajax_login_verify.php",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#next').attr('disabled', 'disabled');
            },
            success: function(data) {
                $('#next').attr('disabled', false);
                if (action == 'email') {
                    if (data.error != '') {
                        $('#user_email_error').text(data.error);
                    } else {
                        $('#user_email_error').text('');
                        $('#email_area').css('display', 'none');
                        $('#password_area').css('display', 'block');
                    }
                } else if (action == 'password') {
                    if (data.error != '') {
                        $('#user_password_error').text(data.error);
                    } else {
                        $('#user_password_error').text('');
                        $('#password_area').css('display', 'none');
                        $('#otp_area').css('display', 'block');
                    }
                } else {
                    if (data.error != '') {
                        $('#user_otp_error').text(data.error);
                    } else {
                        window.location.replace("adminhome.php");
                    }
                }

                $('#action').val(data.next_action);
            }
        })
    });
});
</script>

<script>

/*========== TYPING ANIMATION ==========*/
$(document).ready(function() {
	 $("#signin_typing").typed({
	    strings:["<h3>Sign In</h3>", "<h3>Register using Google Account</h3>"],
	    typespeed:0,
	    loop:true
	 });
});

</script>
