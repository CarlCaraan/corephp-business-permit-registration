<?php
ini_set('display_errors', 'Off');
if (isset($_GET["code"])) {

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    if (!isset($token['error'])) {

        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];
        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();

        //Set SESSION Variables
        if (!empty($data['given_name'])) {
            $_SESSION['first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }

        //Set Variables
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $user_email = $_SESSION['user_email'];
        $account = "google";
        $email_status = "verified";
        $user_type = "user";

        //Create Username
		$username = strtolower($first_name . "_" . $last_name);
		$check_username_query = mysqli_query($con, "SELECT user_name FROM register_user WHERE user_name='$username'");
        $row = mysqli_fetch_array($check_username_query);

		//If username exist add number to username
		$i = 0;
		while(mysqli_num_rows($check_username_query) != 0) {
			$i++; //Add 1 to i
			$username = $username . "_" . $i;
			$check_username_query = mysqli_query($con, "SELECT user_name FROM register_user WHERE user_name='$username'");
		}

        //Add credentials to db
        $check_email_query = mysqli_query($con, "SELECT user_email FROM register_user WHERE user_email='$user_email'");

    	if(mysqli_num_rows($check_email_query) == 0) {
    		$query = mysqli_query($con, "INSERT INTO register_user (first_name, last_name, user_email, user_name) VALUES (
    			'$first_name', '$last_name', '$user_email', '$username'
    		)");

            $update_account_query = mysqli_query($con, "UPDATE register_user SET account='$account', user_type='$user_type', user_email_status='$email_status' WHERE user_email='$user_email'");


			$check_username = mysqli_query($con, "SELECT user_name FROM register_user WHERE user_name='$username'");
			$row = mysqli_fetch_array($check_username);
			$username = $row['user_name'];
			$_SESSION['user_name'] = $username;
        }

		$username = $row['user_name'];
		$_SESSION['user_name'] = $username;
    }
}

if(isset($_SESSION["user_name"])) {
    $userLoggedIn = $_SESSION['user_name'];
    $users_details_query = mysqli_query($con, "SELECT * FROM register_user WHERE user_name='$userLoggedIn'");
    $user = mysqli_fetch_array($users_details_query);

	//Authorized for Admin only
	if ($user["user_type"] == "admin") {
		define('USERSITE', true);
	}
}else{
    header( "Location: login.php" );
}
if(!defined('USERSITE')) {
    header( "refresh:0;url=userhome.php" );
    die();
}
?>

<!-- Start Navigation -->
<nav class="navbar navbar-expand-md py-1 fixed-top">
<div class="container-fluid">
	<a class="navbar-brand-wrapper" href="adminhome.php">
		<div class="logo-container">
			<span class="navbar-brand mx-0 float-left"><img src="assets/images/icons/favicon.png" alt=""></span>
		</div>
		<div class="logo-text-container float-right mt-1 ml-2">
			<h6 class="text-white font-weight-bold mb-0" id="brand-text">Sta. Maria, Laguna</h6>
			<span class="text-white" id="brand-text2">Business Registration</span>
		</div>
	</a>

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="custom-toggler-icon"><i class="fas fa-bars"></i></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">

			<li class="nav-item">
				<a class="nav-link <?php if($page=='admin'){echo 'active';}?>" href="adminhome.php">Admin Panel</a>
			</li>

			<!-- Start Dropdown Menu -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle text-white <?php if($page=='settings'){echo 'active';}?>" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
					<span id="navbar_username" class="<?php if($page=='settings'){echo 'active';}?>">
						<?php
							$fullname_obj = new User($con, $userLoggedIn);
							echo $fullname_obj->getFirstAndLastName();
						?>
					</span>
				</a>

				<div class="dropdown-menu mb-2 dropdown-menu-md-right" id="dropdown_menu" aria-labelledby="navbar_username">
					<h5 class="dropdown-header">Account</h5>
					<a class="dropdown-item <?php if($page=='settings'){echo 'active';}?>" href="settings_admin.php">Settings</a>
					<a class="dropdown-item" href="includes/handlers/logout.php">Logout</a>
					<h5 class="dropdown-header">Appearance</h5>

					<!-- Dark Mode Switch -->
					<div class="dropdown-item">
						<!-- Default bootstrap switch -->
						<div class="theme-switch custom-control custom-switch" id="darkmode_text">
							<input type="checkbox" class="custom-control-input" id="customSwitches">
							<label class="custom-control-label" for="customSwitches"></label>
						</div>
						<span id="toggle-icon">
							<i class="fas fa-sun mt-0"></i>
							<span class="toggle-text">Light</span>
						</span>
					</div>
					
					<!-- Stop closing dropdown menu onclick -->
					<script>
						$('.dropdown-menu').on('click', function (e) {
							e.stopPropagation();
						});
					</script>
				</div>
			</li>
			<!-- End Dropdown menu -->

		</ul>
	</div>
</div>
</nav>
<!--- End Navigation -->
