<?php
require_once 'includes/form_handlers/pdo_handler.php';


if(isset($_POST['upload'])) {
    $file_name = $_FILES['file']['name'];
    $file_temp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $name = date("Y-m-d h-i-s") . "." . $file_name;
    $path = "assets/uploads/" . $name;
    $date_added = date("Y-m-d H:i:s");

    $added_by = $userLoggedIn;


    $uploadOk = 1;
    $fileType = strtolower(pathinfo($path,PATHINFO_EXTENSION));

    // Check file size
    if($file_size > 500000) {
      $uploadOk = 0;
      $upload_message = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <strong>Sorry</strong> your file is too large!
                        </div>";
    }
    // Allow certain file formats
    else if($fileType != "pdf") {
      $uploadOk = 0;
      $upload_message = "<div class='alert alert-danger alert-dismissible fade show mt-2'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <strong>Sorry</strong> ,only pdf files are allowed!
                        </div>";
    }
    else {
      $uploadOk = 1;
      $upload_message = "<div class='alert alert-success alert-dismissible fade show mt-2'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <strong>Success</strong> your file has been uploaded!
                        </div>";
    }

    try {
        if($uploadOk == 1 && move_uploaded_file($file_temp, $path)) {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO posts (added_by, file_name, file_size, date_added) VALUES ('$added_by', '$name', '$file_size', '$date_added')";
            $conn->exec($query);
        }
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
}
else {
	$upload_message = "";
}

?>
