<?php
$connect = mysqli_connect("localhost", "root", "", "business");

if(!empty($_POST)) {

    $first_name = mysqli_real_escape_string($connect, $_POST["first_name"]);
    $last_name = mysqli_real_escape_string($connect, $_POST["last_name"]);
    $user_gender = mysqli_real_escape_string($connect, $_POST["user_gender"]);
    $user_email = mysqli_real_escape_string($connect, $_POST["user_email"]);
    $user_datetime = mysqli_real_escape_string($connect, $_POST["user_datetime"]);
    $user_email_status = mysqli_real_escape_string($connect, $_POST["user_email_status"]);
    $user_type = mysqli_real_escape_string($connect, $_POST["user_type"]);
    $password = "password";
    $user_password = password_hash($password, PASSWORD_DEFAULT);
    $user_name = strtolower($first_name . "_" . $last_name);

    if($_POST["register_user_id"] != '') {
        $query = "
        UPDATE register_user
        SET first_name='$first_name',
        last_name='$last_name',
        user_gender='$user_gender',
        user_email='$user_email',
        user_datetime='$user_datetime',
        user_email_status='$user_email_status',
        user_type='$user_type'
        WHERE register_user_id='".$_POST["register_user_id"]."'";
    }
    else {
        $query = "
        INSERT INTO register_user(first_name, last_name, user_gender, user_email, user_datetime, user_email_status, user_type, user_password, user_name)
        VALUES('$first_name', '$last_name', '$user_gender', '$user_email', '$user_datetime', '$user_email_status', '$user_type', '$user_password', '$user_name');
        ";
    }
    if(mysqli_query($connect, $query)) {

    }

}


?>
