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
<nav class="navbar navbar-expand-md fixed-top">
<div class="container-fluid">
	<a class="navbar-brand" href="#"><img src="assets/images/icons/favicon.ico" alt=""></a>
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
			<li class="nav-item">
				<a class="nav-link <?php if($page=='settings'){echo 'active';}?>" href="settings_user.php">Settings</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php if($page=='logout'){echo 'active';}?>" href="includes/handlers/logout.php">Logout</a>
			</li>
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
