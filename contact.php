<?php
$error = '';
$name = '';
$email = '';
$subject = '';
$message = '';
date_default_timezone_set('Asia/Manila');

function clean_text($string)
{
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

if (isset($_POST["submit"])) {
    if (empty($_POST["name"])) {
        $error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
    } else {
        $name = clean_text($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
        }
    }
    if (empty($_POST["email"])) {
        $error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
    } else {
        $email = clean_text($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= '<p><label class="text-danger">Invalid email format</label></p>';
        }
    }
    if (empty($_POST["subject"])) {
        $error .= '<p><label class="text-danger">Subject is required</label></p>';
    } else {
        $subject = clean_text($_POST["subject"]);
    }
    if (empty($_POST["message"])) {
        $error .= '<p><label class="text-danger">Message is required</label></p>';
    } else {
        $message = clean_text($_POST["message"]);
    }
    if ($error == '') {
        require 'phpmailer/class/class.phpmailer.php';
        $mail = new PHPMailer;
        $mail->IsSMTP();                                //Sets Mailer to send message using SMTP
        $mail->Host = 'smtp.gmail.com';        //Sets the SMTP hosts of your Email hosting, this for Godaddy
        $mail->Port = '587';                                //Sets the default SMTP server port
        $mail->SMTPAuth = true;                            //Sets SMTP authentication. Utilizes the Username and Password variables
        $mail->Username = 'bannedefused3@gmail.com';                    //Sets SMTP username
        $mail->Password = '0639854227101msdcfredsw';                    //Sets SMTP password
        $mail->SMTPSecure = 'tls';                            //Sets connection prefix. Options are "", "ssl" or "tls"
        $mail->From = $_POST["email"];                    //Sets the From email address for the message
        $mail->FromName = $_POST["name"];                //Sets the From name of the message
        $mail->AddAddress('bannedefused3@gmail.com', 'banne');        //Adds a "To" address
        $mail->AddCC($_POST["email"], $_POST["name"]);    //Adds a "Cc" address
        $mail->WordWrap = 50;                            //Sets word wrapping on the body of the message to a given number of characters
        $mail->IsHTML(true);                            //Sets message type to HTML				
        $mail->Subject = $_POST["subject"];                //Sets the Subject of the message
        $mail->Body = "									
            <html>
			<body>
                <p>
                    Greetings <strong> " . $name . " </strong>,
                </p>
				<p>
                    Your inquiry has been sent as of " . date('F j, Y g:i:a  ') . "<br><br><br>
                    Visit Us At: <a href='#' style='text-decoration: underline;'>santa.maria.laguna.bpr.ph</a><br><br><br>
                    Message:</br>
                    " . $_POST["message"] . "
                    <br><br>
                    <strong>If you experience any problems, please send a screenshot and a description to our <a href='https://www.facebook.com/MayorCindySML' style='text-decoration: none;' target='_blank'>Facebook Account.</a><br>
                    For concerns, you may also reach us by sending an e-mail at: <a href='mailto:santamarialaguna@gmail.com' style='text-decoration: none;'>santamarialaguna@gmail.com</a><br>
                    <h3>---------- THIS IS A SYSTEM GENERATED MESSAGE. DO NOT REPLY ----------</h3></strong><br>
				</p>
			</body>
		</html>"; // Customize Html Template

        if ($mail->Send()) //Send an Email. Return true on success or false on error
        {
            $error = '<label class="text-success">Thank you for contacting us</label>';
        } else {
            $error = '<label class="text-danger">There is an Error</label>';
        }
        $name = '';
        $email = '';
        $subject = '';
        $message = '';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Business Registration</title>
    <?php include 'includes/head.php'; ?>

    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&amp;display=swap" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/contact.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation -->
    <header>
        <?php $page = 'contact';
        include 'includes/navbar_landingpage.php'; ?>
    </header>

    <!-- Start Content -->
    <video class="bg-video" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
        <source src="assets/videos/bg.mp4" type="video/mp4" />
    </video>

    <!-- Masthead-->
    <div class="masthead">
        <div class="masthead-content text-white">
            <div class="container-fluid px-4 px-lg-0">
                <h1 class="lh-1 mb-4 text-white" id="contact_heading">Contact Form</h1>
                <p class="mb-5 text-white" id="paragraph_heading">We're working hard to finish the development of this site. Fill up below to receive updates and to be notified when we launch!</p>

                <?php echo $error; ?>
                <form method="post">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" placeholder="Full Name" class="form-control" value="<?php echo $name; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Subject" value="<?php echo $subject; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" class="form-control" placeholder="Message"><?php echo $message; ?></textarea>
                    </div>
                    <div class="form-group" align="left">
                        <input type="submit" name="submit" value="Submit" class="btn btn-lg" id="next" />
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Social Icons-->
    <!-- For more icon options, visit https://fontawesome.com/icons?d=gallery&p=2&s=brands-->
    <div class="social-icons">
        <div class="d-flex flex-row flex-lg-column justify-content-center align-items-center h-100 mt-3 mt-lg-0">
            <a class="btn btn-dark m-3" href="https://www.facebook.com/MayorCindySML" target="_blank"><i class="fab fa-twitter" id="icon_twitter"></i></a>
            <a class="btn btn-dark m-3" href="https://www.facebook.com/MayorCindySML" target="_blank"><i class="fab fa-facebook-f" id="icon_facebook"></i></a>
            <a class="btn btn-dark m-3" href="https://www.facebook.com/MayorCindySML" target="_blank"><i class="fab fa-instagram" id="icon_instagram"></i></a>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script> <!-- empty js file -->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <!-- End Content -->

    <!-- All JavaScript -->
    <?php include 'includes/scripts.php'; ?>
</body>

</html>