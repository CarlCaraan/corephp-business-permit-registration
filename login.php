<?php
require("config/config.php");
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
    <title>Login | Business Registration</title>
    <?php include 'includes/head.php'; ?>
</head>

<body>

    <!-- Navigation -->
    <header>
        <?php $page = 'login';
        include 'includes/navbar_landingpage.php'; ?>
    </header>

    <!-- Google Sign In Button -->
    <?php
    if (!isset($_SESSION['access_token'])) {
        //Create a URL to obtain user authorization
        $login_button = '
        <a href="' . $google_client->createAuthUrl() . '">
            <div class="g-sign-in-button">
                <div class="content-wrapper">
                    <div class="logo-wrapper center">
                        <img src="assets/images/icons/google.ico">
                    </div>
                <span class="text-container">
                    <span>Log in with Google</span>
                </span>
                </div>
            </div>
        </a>';
    }
    ?>

    <!-- Start Login Section -->

    <!-- Start Background Image -->
    <div class="home-inner">
    </div>
    <!-- End Background Image -->

    <div class="container">
        <div class="card card-default" id="login_card">
            <div class="center">
                <h1 id="login_headings"><strong>Log in to your account</strong></h1>
                <!-- Google Button -->
                <?php
                if ($login_button == '') {
                    header('Location:adminhome.php');
                } else {
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
                                <strong>Password saved successfully!</strong> You can now log in with your new password.
                              </div>';
                    }
                }
                ?>
                <form method="POST" id="login_form">
                    <div class="form-group" id="email_area">
                        <input type="text" name="user_email" id="user_email" class="form-control login-input" placeholder="Email Address">
                        <span id="user_email_error" style="font-size: 0.8rem" class="text-danger px-2"></span>
                        <a class="float-right my-1" id="forgot_password" href="forget_password.php?step1=1">Forgot Password</a>
                        <!-- <span class="float-right my-1" id="forgot_password" style="cursor: pointer;" data-toggle="modal" data-target="#exampleModal">Forgot Password</span> -->
                    </div>
                    <div class="form-group" id="password_area" style="display:none;">
                        <input type="password" name="user_password" id="user_password" class="form-control login-input" placeholder="password">
                        <span id="user_password_error" style="font-size: 0.8rem" class="text-danger px-2"></span>
                    </div>
                    <div class="form-group" id="otp_area" style="display:none;">
                        <input type="text" name="user_otp" id="user_otp" class="form-control login-input" placeholder="6-digit code">
                        <span id="user_otp_error" style="font-size: 0.8rem" class="text-danger px-2"></span>
                    </div>
                    <div class="form-group center" id="next_btn_container">
                        <input type="hidden" name="action" id="action" value="email">
                        <input type="submit" name="next" id="next" class="btn btn-lg" value="Next">
                    </div>
                </form>

                <div class="center">
                    Not a member?<a href="register.php" id="register_now"> Register now</a>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body center">
                    <img class="w-25 rounded-circle img-thumbnail" src="assets/images/lonely.png" alt=""><br><br>
                    <h4>Try to relax and remember your password</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
                        }
                        else {
                            $('#user_email_error').text('');
                            $('#email_area').css('display', 'none');
                            $('#password_area').css('display', 'block');
                        }
                    }
                    else if (action == 'password') {
                        if (data.error != '') {
                            $('#user_password_error').text(data.error);
                        }
                        else {
                            $('#user_password_error').text('');
                            $('#password_area').css('display', 'none');
                            $('#otp_area').css('display', 'block');
                        }
                    }
                    else {
                        if (data.error != '') {
                            $('#user_otp_error').text(data.error);
                        }
                        else {
                            window.location.replace("adminhome.php");
                        }
                    }

                    $('#action').val(data.next_action);
                }
            })
        });
    });
</script>