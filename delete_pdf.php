<?php
require_once 'includes/form_handlers/pdo_handler.php';

if(isset($_GET['file_name'])) {
    $name = $_GET['file_name'];

    $query = $conn->prepare("DELETE FROM posts WHERE file_name='$name'");
    $query->execute();
    unlink("assets/uploads/" . $name);

    header('Location: submit.php');
}

?>
