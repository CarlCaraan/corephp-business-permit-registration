<?php
require_once 'pdo_handler.php';

if(isset($_POST['register_user_id'])) {
    $register_user_id = $_POST['register_user_id'];

    $query = $conn->prepare("DELETE FROM register_user WHERE register_user_id='$register_user_id'");
    $query->execute();

    header('Location: ../../adminhome.php');
}

?>
