<?php
$connect = mysqli_connect("localhost", "root", "", "business");
session_start();

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

        $_SESSION['update_message'] = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                            Row has been <strong>Updated</strong>!
                                        </div>";

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
