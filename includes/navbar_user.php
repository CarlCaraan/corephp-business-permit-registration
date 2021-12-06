<?php
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
        $user_gender = $_SESSION['user_gender'];
        $account = "google";
        $email_status = "verified";


        //Create Username
		$username = strtolower($first_name . "_" . $last_name);
		$check_username_query = mysqli_query($con, "SELECT user_name FROM register_user WHERE user_name='$username'");
        $row = mysqli_fetch_array($check_username_query);

		//if username exist add number to username
		$i = 0;
		while(mysqli_num_rows($check_username_query) != 0) {
			$i++; //Add 1 to i
			$username = $username . "_" . $i;
			$check_username_query = mysqli_query($con, "SELECT user_name FROM register_user WHERE user_name='$username'");
		}

        //Add credentials to db
        $check_email_query = mysqli_query($con, "SELECT user_email FROM register_user WHERE user_email='$user_email'");

    	if(mysqli_num_rows($check_email_query) == 0) {
    		$query = mysqli_query($con, "INSERT INTO register_user (first_name, last_name, user_email, user_gender, user_name) VALUES (
    			'$first_name', '$last_name', '$user_email', '$user_gender', '$username'
    		)");

            $update_account_query = mysqli_query($con, "UPDATE register_user SET account='$account', user_email_status='$email_status' WHERE user_email='$user_email'");
        }
        $username = $row['user_name'];
        $_SESSION['user_name'] = $username;


    }
}


if(isset($_SESSION['user_name'])) {
    $userLoggedIn = $_SESSION['user_name'];

    $users_details_query = mysqli_query($con, "SELECT * FROM register_user WHERE user_name='$userLoggedIn'");
    $user = mysqli_fetch_array($users_details_query);

}
else {
	header("location:login.php");
}

define('USERSITE', true);

?>


<!-- Start Navigation -->
<nav class="navbar navbar-expand-md py-1 fixed-top">
<div class="container">
	<a class="navbar-brand-wrapper" href="index.php">
		<div class="logo-container">
			<span class="navbar-brand mx-0 float-left" href="index.php"><img src="assets/images/icons/favicon.png" alt=""></span>
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
				<a class="nav-link <?php if($page=='user'){echo 'active';}?>" href="userhome.php">Registration</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php if($page=='submit'){echo 'active';}?>" href="submit.php">Submit</a>
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

				<div class="dropdown-menu mb-2" id="dropdown_menu" aria-labelledby="navbar_username">
					<h5 class="dropdown-header">Account</h5>
					<a class="dropdown-item <?php if($page=='settings'){echo 'active';}?>" href="settings_user.php">Settings</a>
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


<!-- Start of Async Drift Code -->
<script>
"use strict";

!function() {
  var t = window.driftt = window.drift = window.driftt || [];
  if (!t.init) {
    if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
    t.invoked = !0, t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ],
    t.factory = function(e) {
      return function() {
        var n = Array.prototype.slice.call(arguments);
        return n.unshift(e), t.push(n), t;
      };
    }, t.methods.forEach(function(e) {
      t[e] = t.factory(e);
    }), t.load = function(t) {
      var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
      o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
      var i = document.getElementsByTagName("script")[0];
      i.parentNode.insertBefore(o, i);
    };
  }
}();
drift.SNIPPET_VERSION = '0.3.1';
drift.load('sgpeumma7u65');
</script>
<!-- End of Async Drift Code -->
