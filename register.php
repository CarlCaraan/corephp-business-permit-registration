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
        $error_user_gender = "<span class='text-danger' id='error_messages'>Select Gender</span>";
    } else {
        //gender
        $user_gender = strip_tags($_POST['user_gender']); //Remove html tags
        $user_gender = ucfirst(strtolower($user_gender)); //Uppercase first letter
    }

    if (empty($_POST["first_name"])) {
        $error_first_name = "<span class='text-danger px-2' id='error_messages'>Enter First Name</span>";
    } else {
        $first_name = strip_tags($_POST['first_name']); //Remove html tags
        $first_name = str_replace(' ', '', $first_name); //remove spaces
        $first_name = ucfirst(strtolower($first_name)); //Uppercase first letter
    }

    if (empty($_POST["last_name"])) {
        $error_last_name = "<span class='text-danger px-2' id='error_messages'>Enter Last Name</span>";
    } else {
        $last_name = strip_tags($_POST['last_name']); //Remove html tags
        $last_name = str_replace(' ', '', $last_name); //remove spaces
        $last_name = ucfirst(strtolower($last_name)); //Uppercase first letter
    }

    if (empty($_POST["user_email"])) {
        $error_user_email = '<span class="text-danger px-2" id="error_messages">Enter Email Address</span>';
    } else {
        $user_email = trim($_POST["user_email"]);
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $error_user_email = '<span class="text-danger px-2" id="error_messages">Enter Valid Email Address</span>';
        }
    }

    if (empty($_POST["user_password"])) {
        $error_user_password = '<span class="text-danger px-2" id="error_messages">Enter Password</span>';
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
        <div class="card card-default" id="register_card">
            <div class="center">
                <h1 id="login_headings" style="letter-spacing: 1.5px;"><strong>Create your account</strong></h1>
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
                            <div class="form-group pt-2 pl-3 rounded" id="gender_wrapper">
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
                                <?php echo $error_user_gender; ?>
                            </div>
                        </div>
                    </div> <!-- End row -->

                    <!-- Start Terms And Conditions -->
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="check_terms" name="check_terms" required>
                        <label class="form-check-label" for="check_terms" style="font-size: .8rem;">Read and accept our <span id="register_now">Terms of Use and Conditions.</span></label> 
                    </div>

                    <div class="d-none mb-4 p-3" id="terms">
                        <h3><strong>Terms and Conditions</strong></h3>

                        <p>Welcome to Business Permit Registration!</p>

                        <p>These terms and conditions outline the rules and regulations for the use of Business Permit Registration's Website, located at Business Permit Registration.</p>

                        <p>By accessing this website we assume you accept these terms and conditions. Do not continue to use Business Permit Registration if you do not agree to take all of the terms and conditions stated on this page.</p>

                        <p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>

                        <h3><strong>Cookies</strong></h3>

                        <p>We employ the use of cookies. By accessing Business Permit Registration, you agreed to use cookies in agreement with the Business Permit Registration's Privacy Policy. </p>

                        <p>Most interactive websites use cookies to let us retrieve the user’s details for each visit. Cookies are used by our website to enable the functionality of certain areas to make it easier for people visiting our website. Some of our affiliate/advertising partners may also use cookies.</p>

                        <h3><strong>License</strong></h3>

                        <p>Unless otherwise stated, Business Permit Registration and/or its licensors own the intellectual property rights for all material on Business Permit Registration. All intellectual property rights are reserved. You may access this from Business Permit Registration for your own personal use subjected to restrictions set in these terms and conditions.</p>

                        <p>You must not:</p>
                        <ul>
                            <li>Republish material from Business Permit Registration</li>
                            <li>Sell, rent or sub-license material from Business Permit Registration</li>
                            <li>Reproduce, duplicate or copy material from Business Permit Registration</li>
                            <li>Redistribute content from Business Permit Registration</li>
                        </ul>

                        <p>This Agreement shall begin on the date hereof. Our Terms and Conditions were created with the help of the <a href="https://www.termsandconditionsgenerator.com">Terms And Conditions Generator</a>.</p>

                        <p>Parts of this website offer an opportunity for users to post and exchange opinions and information in certain areas of the website. Business Permit Registration does not filter, edit, publish or review Comments prior to their presence on the website. Comments do not reflect the views and opinions of Business Permit Registration,its agents and/or affiliates. Comments reflect the views and opinions of the person who post their views and opinions. To the extent permitted by applicable laws, Business Permit Registration shall not be liable for the Comments or for any liability, damages or expenses caused and/or suffered as a result of any use of and/or posting of and/or appearance of the Comments on this website.</p>

                        <p>Business Permit Registration reserves the right to monitor all Comments and to remove any Comments which can be considered inappropriate, offensive or causes breach of these Terms and Conditions.</p>

                        <p>You warrant and represent that:</p>

                        <ul>
                            <li>You are entitled to post the Comments on our website and have all necessary licenses and consents to do so;</li>
                            <li>The Comments do not invade any intellectual property right, including without limitation copyright, patent or trademark of any third party;</li>
                            <li>The Comments do not contain any defamatory, libelous, offensive, indecent or otherwise unlawful material which is an invasion of privacy</li>
                            <li>The Comments will not be used to solicit or promote business or custom or present commercial activities or unlawful activity.</li>
                        </ul>

                        <p>You hereby grant Business Permit Registration a non-exclusive license to use, reproduce, edit and authorize others to use, reproduce and edit any of your Comments in any and all forms, formats or media.</p>

                        <h3><strong>Hyperlinking to our Content</strong></h3>

                        <p>The following organizations may link to our Website without prior written approval:</p>

                        <ul>
                            <li>Government agencies;</li>
                            <li>Search engines;</li>
                            <li>News organizations;</li>
                            <li>Online directory distributors may link to our Website in the same manner as they hyperlink to the Websites of other listed businesses; and</li>
                            <li>System wide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site.</li>
                        </ul>

                        <p>These organizations may link to our home page, to publications or to other Website information so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products and/or services; and (c) fits within the context of the linking party’s site.</p>

                        <p>We may consider and approve other link requests from the following types of organizations:</p>

                        <ul>
                            <li>commonly-known consumer and/or business information sources;</li>
                            <li>dot.com community sites;</li>
                            <li>associations or other groups representing charities;</li>
                            <li>online directory distributors;</li>
                            <li>internet portals;</li>
                            <li>accounting, law and consulting firms; and</li>
                            <li>educational institutions and trade associations.</li>
                        </ul>

                        <p>We will approve link requests from these organizations if we decide that: (a) the link would not make us look unfavorably to ourselves or to our accredited businesses; (b) the organization does not have any negative records with us; (c) the benefit to us from the visibility of the hyperlink compensates the absence of Business Permit Registration; and (d) the link is in the context of general resource information.</p>

                        <p>These organizations may link to our home page so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products or services; and (c) fits within the context of the linking party’s site.</p>

                        <p>If you are one of the organizations listed in paragraph 2 above and are interested in linking to our website, you must inform us by sending an e-mail to Business Permit Registration. Please include your name, your organization name, contact information as well as the URL of your site, a list of any URLs from which you intend to link to our Website, and a list of the URLs on our site to which you would like to link. Wait 2-3 weeks for a response.</p>

                        <p>Approved organizations may hyperlink to our Website as follows:</p>

                        <ul>
                            <li>By use of our corporate name; or</li>
                            <li>By use of the uniform resource locator being linked to; or</li>
                            <li>By use of any other description of our Website being linked to that makes sense within the context and format of content on the linking party’s site.</li>
                        </ul>

                        <p>No use of Business Permit Registration's logo or other artwork will be allowed for linking absent a trademark license agreement.</p>

                        <h3><strong>iFrames</strong></h3>

                        <p>Without prior approval and written permission, you may not create frames around our Webpages that alter in any way the visual presentation or appearance of our Website.</p>

                        <h3><strong>Content Liability</strong></h3>

                        <p>We shall not be hold responsible for any content that appears on your Website. You agree to protect and defend us against all claims that is rising on your Website. No link(s) should appear on any Website that may be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or other violation of, any third party rights.</p>

                        <h3><strong>Your Privacy</strong></h3>

                        <p>Please read Privacy Policy</p>

                        <h3><strong>Reservation of Rights</strong></h3>

                        <p>We reserve the right to request that you remove all links or any particular link to our Website. You approve to immediately remove all links to our Website upon request. We also reserve the right to amen these terms and conditions and it’s linking policy at any time. By continuously linking to our Website, you agree to be bound to and follow these linking terms and conditions.</p>

                        <h3><strong>Removal of links from our website</strong></h3>

                        <p>If you find any link on our Website that is offensive for any reason, you are free to contact and inform us any moment. We will consider requests to remove links but we are not obligated to or so or to respond to you directly.</p>

                        <p>We do not ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we promise to ensure that the website remains available or that the material on the website is kept up to date.</p>

                        <h3><strong>Disclaimer</strong></h3>

                        <p>To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website. Nothing in this disclaimer will:</p>

                        <ul>
                            <li>limit or exclude our or your liability for death or personal injury;</li>
                            <li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;</li>
                            <li>limit any of our or your liabilities in any way that is not permitted under applicable law; or</li>
                            <li>exclude any of our or your liabilities that may not be excluded under applicable law.</li>
                        </ul>

                        <p>The limitations and prohibitions of liability set in this Section and elsewhere in this disclaimer: (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer, including liabilities arising in contract, in tort and for breach of statutory duty.</p>

                        <p>As long as the website and the information and services on the website are provided free of charge, we will not be liable for any loss or damage of any nature.</p>
                    </div>

                    <script>
                        $(document).ready(function(){
                            $('input[name="check_terms"]').click(function(){
                                if($(this).prop("checked") == true){
                                    $('#terms').removeClass('d-none');
                                }
                                else if($(this).prop("checked") == false){
                                    $('#terms').addClass('d-none');
                                }
                                if($('#terms').hasClass('d-none')) {

                                    $('input[name="register"]').prop( "disabled", false );
                                }
                                else {

                                    $('input[name="register"]').prop( "disabled", true );
                                }
                            });
                        });
                        $('#terms').on('scroll', function() {
                            var scrollTop = $(this).scrollTop();
                            if (scrollTop + $(this).innerHeight() >= this.scrollHeight) {
                                $('input[name="register"]').prop( "disabled", false );
                            } 
                            else if (scrollTop <= 0) {
                                $('input[name="register"]').prop( "disabled", true );
                            }
                            else {
                                $('input[name="register"]').prop( "disabled", true );
                            }
                        });
                    </script>
                    <!-- End Terms And Conditions -->

					<div class="form-group center">
						<input type="submit" name="register" id="next" class="btn btn-lg" value="Register">
					</div>
				</form>

                <div class="center">
                    Already a member?<a href="login.php" id="register_now"> Log in</a>
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

