<?php
require_once 'pdo_handler.php';
require("../../config/config.php");

session_start();

if(isset($_POST['records_id'])) {
    $records_id = $_POST['records_id'];

	$records_data_query = mysqli_query($con, "SELECT file_name FROM posts WHERE id='$records_id'");
	$row = mysqli_fetch_array($records_data_query);

    $query = $conn->prepare("DELETE FROM posts WHERE id='$records_id'");
    $query->execute();

    unlink("../../assets/uploads/" . $row['file_name']);

    $_SESSION['delete_message'] = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        Row has been <strong>trashed</strong>!
                                    </div>";

    header('Location: ../../adminrecords.php');
}

?>
