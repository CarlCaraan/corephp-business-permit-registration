<?php
require_once 'pdo_handler.php';
require("../../config/config.php");

if(isset($_POST['records_id'])) {
    $records_id = $_POST['records_id'];

	$records_data_query = mysqli_query($con, "SELECT file_name FROM posts WHERE id='$records_id'");
	$row = mysqli_fetch_array($records_data_query);

    $query = $conn->prepare("DELETE FROM posts WHERE id='$records_id'");
    $query->execute();

    unlink("../../assets/uploads/" . $row['file_name']);
    header('Location: ../../adminrecords.php');
}

?>
