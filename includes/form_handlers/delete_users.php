<?php
require_once 'pdo_handler.php';

if(isset($_POST['register_user_id'])) {
    $register_user_id = $_POST['register_user_id'];

    $query = $conn->prepare("DELETE FROM register_user WHERE register_user_id='$register_user_id'");
    $query->execute();

    $_SESSION['delete_message'] = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        Row has been <strong>deleted</strong>!
                                    </div>";

    header('Location: ../../adminusers.php');
}

?>
