<?php
require_once 'includes/form_handlers/pdo_handler.php';

if(isset($_GET['file_name'])) {
    $name = $_GET['file_name'];

    $query = $conn->prepare("DELETE FROM posts WHERE file_name='$name'");
    $query->execute();

    // Delete Notification
    $query2 = $conn->prepare("DELETE FROM notifications WHERE unique_name='$name' AND seen_status='0'");
    $query2->execute();
    unlink("assets/uploads/" . $name);

    $_SESSION['delete_message'] = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        Your file has been <strong>deleted</strong>!
                                    </div>";

    header('Location: submit.php');
}

?>
