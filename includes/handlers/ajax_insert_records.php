<?php
$connect = mysqli_connect("localhost", "root", "", "business");

if(!empty($_POST)) {

    $added_by = mysqli_real_escape_string($connect, $_POST["added_by"]);
    $date_added = mysqli_real_escape_string($connect, $_POST["date_added"]);
    $status = mysqli_real_escape_string($connect, $_POST["status"]);

    if($_POST["records_id"] != '') {
        $query = "
        UPDATE posts
        SET added_by='$added_by',
        date_added='$date_added',
        status='$status'
        WHERE id='".$_POST["records_id"]."'";
    }
    else {
        // $query = "
        // INSERT INTO users(first_name, last_name, username, email, password, signup_date, user_type, gender)
        // VALUES('$first_name', '$last_name','$username', '$email', '$password_1', '$signup_date', '$user_type', '$gender');
        // ";
    }
    if(mysqli_query($connect, $query)) {

    }

}


?>
