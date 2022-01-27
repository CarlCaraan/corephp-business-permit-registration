<?php
require_once './pdo_handler.php';

$userLoggedIn = $_SESSION['user_name'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];

if(isset($_POST['upload'])) {
    $file_name = $_FILES['file']['name'];
    $file_temp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $name = date("Y-m-d h-i-s") . "." . $file_name;
    $path = "../../assets/uploads/" . $name;
    $date_added = date("Y-m-d");

    $added_by = $userLoggedIn;


    $uploadOk = 1;
    $fileType = strtolower(pathinfo($path,PATHINFO_EXTENSION));

    // Check file size
    if($file_size > 50000000) {
        $uploadOk = 0;
        session_start();
        $_SESSION['upload_message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <strong>Sorry</strong> your file is too large!
                        </div>";

        header('Location: ../../submit.php');
    }
    // This field is required
    else if ($file_name == "") {
        $uploadOk = 0;

        session_start();
        $_SESSION['upload_message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            This field must not be <strong>empty</strong>!
                        </div>";

        header('Location: ../../submit.php');
    }
    // Allow certain file formats
    else if($fileType != "pdf") {
        $uploadOk = 0;

        session_start();
        $_SESSION['upload_message'] = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <strong>Sorry</strong> ,only pdf files are allowed!
                        </div>";

        header('Location: ../../submit.php');
    }
    else {
        $uploadOk = 1;

        session_start();
        $_SESSION['upload_message'] = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <strong>Success</strong> your file has been uploaded!
                        </div>";

        header('Location: ../../submit.php');
    }

    try {
        if($uploadOk == 1 && move_uploaded_file($file_temp, $path)) {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO posts (added_by, file_name, file_size, date_added, first_name, last_name) VALUES ('$added_by', '$name', '$file_size', '$date_added', '$first_name', '$last_name')";
            $conn->exec($query);
        }
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
}
?>
