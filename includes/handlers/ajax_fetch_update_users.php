  <?php
 //ajax_fetch_update_users.php
 $connect = mysqli_connect("localhost", "root", "", "business");
 if(isset($_POST["register_user_id"]))
 {
    $query = "SELECT * FROM register_user WHERE register_user_id='".$_POST["register_user_id"]."'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
 }
 ?>
