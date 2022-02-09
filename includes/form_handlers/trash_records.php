<?php
require_once 'pdo_handler.php';
require("../../config/config.php");

session_start();

if(isset($_POST['records_id'])) {
    $records_id = $_POST['records_id'];

    $query = $conn->prepare("UPDATE posts SET deleted='yes' WHERE id='$records_id'");
    $query->execute();

    $_SESSION['delete_message'] = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        Row has been <strong>archived</strong>!
                                    </div>";

    header('Location: ../../adminrecords.php');
}

?>
