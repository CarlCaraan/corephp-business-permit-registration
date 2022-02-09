<?php
require_once '../../config/config.php';

if(mysqli_connect_errno())
{
	echo "Failed to connect: " . mysqli_connect_errno();
}
if(isset($_SESSION['user_name'])) {
    $userLoggedIn = $_SESSION['user_name'];
}
else {
	header("location:login.php");
}

if(isset($_POST['update_details'])) {

	$firstname = $_POST['first_name'];
	$lastname = $_POST['last_name'];
	$gender = $_POST['user_gender'];
	$email = $_POST['user_email'];


	$email_check = mysqli_query($con, "SELECT * FROM register_user WHERE user_email='$email'");
	$row = mysqli_fetch_array($email_check);
	$matched_user = $row['user_name'];

    if (empty($_POST['first_name'])) {
        $_SESSION['message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            first name field is <strong>required</strong>.
                        </div>";
    }
    else if (empty($_POST['last_name'])) {
        $_SESSION['message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            last name field is <strong>required</strong>.
                        </div>";
    }
    else if (empty($_POST['user_gender'])) {
        $_SESSION['message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            gender field is <strong>required</strong>.
                        </div>";
    }
	else if($matched_user == "" || $matched_user == $userLoggedIn) {
			$_SESSION['message'] = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                    	    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    	    User details successfully <strong>Updated!</strong> 
                        </div>";

            header('Location: ' . $_SERVER['HTTP_REFERER']);
			$query = mysqli_query($con, "UPDATE register_user SET first_name='$firstname', last_name='$lastname', user_gender='$gender' WHERE user_name='$userLoggedIn'");
	}
	else
    $_SESSION['message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <strong>Email</strong> is already in use!
                    </div>";

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}


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
                    $_SESSION['password_message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                            <strong>Sorry</strong> your password must be greater than 4 characters!
                                        </div>";

                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
                else {
                    $new_password_md5 = password_hash($new_password_1, PASSWORD_DEFAULT);
                    $password_query = mysqli_query($con, "UPDATE register_user SET user_password='$new_password_md5' WHERE user_name='$userLoggedIn'");
                    $_SESSION['password_message'] = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                            Your<strong> Password</strong> has been changed!
                                        </div>";

                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            }
            else {
                $_SESSION['password_message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        Your<strong> New Password</strong> doesn't match!
                                    </div>";

                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
        else {
            $_SESSION['password_message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                    Your<strong> Current Password</strong> is incorrect!
                                </div>";

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    else {
        if($new_password_1 == $new_password_2) {

            if(strlen($new_password_1) <= 4) {
                $_SESSION['password_message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        <strong>Sorry</strong> your password must be greater than 4 characters!
                                    </div>";

                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            else {
                $new_password_md5 = password_hash($new_password_1, PASSWORD_DEFAULT);
                $password_query = mysqli_query($con, "UPDATE register_user SET user_password='$new_password_md5' WHERE user_name='$userLoggedIn'");
                $_SESSION['password_message'] = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        Your<strong> Password</strong> has been changed!
                                    </div>";

                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
        else {
            $_SESSION['password_message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                    Your<strong> New Password</strong> doesn't match!
                                </div>";

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

}

