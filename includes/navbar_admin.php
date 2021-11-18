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

            $update_account_query = mysqli_query($con, "UPDATE register_user SET account='$account', user_email_status='$email_status' WHERE user_email='$user_email'");
        }
        $username = $row['user_name'];
        $_SESSION['user_name'] = $username;

        //Stop Login using google account when existing user have local account
        $check_account_query = mysqli_query($con, "SELECT account FROM register_user WHERE user_name='$username'");
        $account = mysqli_fetch_array($check_account_query);

        if($account['account'] == "local") {
            header("Location:login.php");
        }

    }
}


if(isset($_SESSION["user_name"])) {
    $userLoggedIn = $_SESSION['user_name'];

    $users_details_query = mysqli_query($con, "SELECT * FROM register_user WHERE user_name='$userLoggedIn'");
    $user = mysqli_fetch_array($users_details_query);

    //Authorized for Admin only
    if($user["user_type"] == "admin") {
        define('USERSITE', true);
    }

}
else {
	header("location:login.php");
}

if(!defined('USERSITE')) {
    header( "refresh:0;url=userhome.php" );
    die();
}

?>

<!-- Dark Mode Switch -->
<div class="theme-switch-wrapper">
    <span id="toggle-icon">
        <span class="toggle-text">Light Mode</span>
        <i class="fas fa-sun" data-fa-transform="grow-5"></i>
    </span>

    <!-- Default bootstrap switch -->
    <div class="theme-switch custom-control custom-switch">
      <input type="checkbox" class="custom-control-input" id="customSwitches">
      <label class="custom-control-label" for="customSwitches"></label>
    </div>
</div>

<!-- Start Navigation -->
<nav class="navbar navbar-expand-md fixed-top">
<div class="container-fluid">
	<a class="navbar-brand" href="#"><img src="assets/images/icons/favicon.ico" alt=""></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="custom-toggler-icon"><i class="fas fa-bars"></i></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link <?php if($page=='admin'){echo 'active';}?>" href="adminhome.php">Admin Panel</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php if($page=='settings'){echo 'active';}?>" href="settings_admin.php">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php if($page=='logout'){echo 'active';}?>" href="includes/handlers/logout.php">Logout</a>
			</li>
		</ul>
	</div>
</div>
</nav>
<!--- End Navigation -->
