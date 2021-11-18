<?php
require_once 'includes/form_handlers/pdo_handler.php';

if(isset($_GET['file_name'])) {
    $name = $_GET['file_name'];
    header("Content-Disposition: attachment; filename=" . $name);
    header("Content-Type: application/octet-stream;");
    readfile("assets/uploads/" . $name);
    $conn = null;

    header('Location: submit.php');

}

?>
