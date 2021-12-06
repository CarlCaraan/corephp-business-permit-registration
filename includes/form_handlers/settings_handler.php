<?php
//For Basic Information Form
if(isset($_POST['update_details'])) {

	$firstname = $_POST['first_name'];
	$lastname = $_POST['last_name'];
	$gender = $_POST['user_gender'];
	$email = $_POST['user_email'];


	$email_check = mysqli_query($con, "SELECT * FROM register_user WHERE user_email='$email'");
	$row = mysqli_fetch_array($email_check);
	$matched_user = $row['user_name'];

	if($matched_user == "" || $matched_user == $userLoggedIn) {
			$message = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                    	    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    	    <strong>Details</strong> Updated!
                        </div>";
			$query = mysqli_query($con, "UPDATE register_user SET first_name='$firstname', last_name='$lastname', user_gender='$gender' WHERE user_name='$userLoggedIn'");
	}
	else
		$message = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <strong>Email</strong> is already in use!
                    </div>";
}
else
	$message = "";

//For Password Form
if(isset($_POST['update_password'])) {
    $old_password = strip_tags($_POST['old_password']);
    $new_password_1 = strip_tags($_POST['new_password_1']);
    $new_password_2 = strip_tags($_POST['new_password_2']);

    $password_query = mysqli_query($con, "SELECT user_password FROM register_user WHERE user_name='$userLoggedIn'");
    $row = mysqli_fetch_array($password_query);
    $db_password = $row['user_password'];

    if(!empty($db_password)) {
        if(password_verify($old_password, $db_password)) {
            if($new_password_1 == $new_password_2) {

                if(strlen($new_password_1) <= 4) {
                    $password_message = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                            <strong>Sorry</strong> your password must be greater than 4 characters!
                                        </div>";
                }
                else {
                    $new_password_md5 = password_hash($new_password_1, PASSWORD_DEFAULT);
                    $password_query = mysqli_query($con, "UPDATE register_user SET user_password='$new_password_md5' WHERE user_name='$userLoggedIn'");
                    $password_message = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                            Your<strong> Password</strong> has been changed!
                                        </div>";
                }
            }
            else {
                $password_message = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        Your<strong> New Password</strong> doesn't match!
                                    </div>";
            }
        }
        else {
            $password_message = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                    Your<strong> Current Password</strong> is incorrect!
                                </div>";
        }
    }
    else {
        if($new_password_1 == $new_password_2) {

            if(strlen($new_password_1) <= 4) {
                $password_message = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        <strong>Sorry</strong> your password must be greater than 4 characters!
                                    </div>";
            }
            else {
                $new_password_md5 = password_hash($new_password_1, PASSWORD_DEFAULT);
                $password_query = mysqli_query($con, "UPDATE register_user SET user_password='$new_password_md5' WHERE user_name='$userLoggedIn'");
                $password_message = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        Your<strong> Password</strong> has been changed!
                                    </div>";
            }
        }
        else {
            $password_message = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                    Your<strong> New Password</strong> doesn't match!
                                </div>";
        }
    }

}
else {
    $password_message = "";
}
