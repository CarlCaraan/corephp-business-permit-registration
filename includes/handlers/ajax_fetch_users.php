<?php

$connect = new PDO("mysql:host=localhost; dbname=business", "root", "");

/*function get_total_row($connect)
{
  $query = "
  SELECT * FROM users
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  return $statement->rowCount();
}

$total_record = get_total_row($connect);*/

ini_set('display_errors', 'Off');

$limit = '5';
$page = 1;
if($_POST['page'] > 1) {
    $start = (($_POST['page'] - 1) * $limit);
    $page = $_POST['page'];
}
else {
    $start = 0;
}

$query = "
SELECT * FROM register_user
";

if($_POST['query'] != '') {
    $query .= '
    WHERE user_email LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
    OR first_name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
    OR last_name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
    OR user_type LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
    OR account LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
    OR user_datetime LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
    ';
}

$query .= 'ORDER BY register_user_id ASC ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();

$output = '
<div class="alert alert-success alert-dismissible" id="user_alert_message" style="display: none;">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>User Details!</strong> has been saved!
</div>
<label class="font-weight-bold m-2">Total Users : '.$total_data.'</label>
<div class="float-left mb-3">
    <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-info"><i class="fas fa-user-plus"></i> Add User</button>
</div>
<table class="table table-striped">
    <tr id="admin_table_headings">
		<th>ID</th>
		<th>Name</th>
		<th>Sex</th>
		<th>Email</th>
		<th>Sign Up Date</th>
		<th>Status</th>
		<th>Role</th>
		<th>Account</th>
		<th class="center">Action</th>
    </tr>
';
if($total_data > 0)
{
    foreach($result as $row) {
        $output .= '
        <tr>
            <td>'.$row["register_user_id"].'</td>
            <td>'.$row["first_name"] . " " . $row['last_name'] . '</td>
            <td>'.$row["user_gender"].'</td>
            <td>'.$row["user_email"].'</td>
            <td>'.$row["user_datetime"].'</td>
            <td>'.$row["user_email_status"].'</td>
            <td>'.$row["user_type"].'</td>
            <td>'.$row["account"].'</td>
            <td class="center">
                <div class="mx-auto" style="width: 100px;">
                    <button name="edit" id="' . $row["register_user_id"] . '" class="btn btn-info edit_data"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" data-id="' . $row["register_user_id"] . '" onclick="confirmDelete(this);"><i class="fas fa-trash" id="trash_icon"></i></button>
                </div>
            </td>
        </tr>
        ';
    }
}
else {
$output .= '
    <tr>
        <td colspan="10" align="center">No Data Found</td>
    </tr>
    ';
}

$output .= '
</table>
<br />
<div align="center">
    <ul class="pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';

//echo $total_links;

if($total_links > 4) {
    if($page < 5) {
        for($count = 1; $count <= 5; $count++) {
            $page_array[] = $count;
        }
        $page_array[] = '...';
        $page_array[] = $total_links;
    }
    else {
        $end_limit = $total_links - 5;
        if($page > $end_limit) {
            $page_array[] = 1;
            $page_array[] = '...';

            for($count = $end_limit; $count <= $total_links; $count++) {
                $page_array[] = $count;
            }
        }
        else {
            $page_array[] = 1;
            $page_array[] = '...';

            for($count = $page - 1; $count <= $page + 1; $count++) {
                $page_array[] = $count;
            }
            $page_array[] = '...';
            $page_array[] = $total_links;
        }
    }
}
else {
    for($count = 1; $count <= $total_links; $count++) {
        $page_array[] = $count;
    }
}

$page_array[] = "$count";

for($count = 0; $count < count($page_array); $count++) {
    if($page == $page_array[$count]) {
        $page_link .= '
        <li class="page-item active">
            <a class="page-link" href="#" id="page_current">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
        </li>
        ';

        $previous_id = $page_array[$count] - 1;
        if($previous_id > 0) {
            $previous_link = '<li class="page-item"><a class="page-link text-dark" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
        }
        else {
            $previous_link = '
            <li class="page-item disabled">
                <a class="page-link" href="#">Previous</a>
            </li>';
        }
        $next_id = $page_array[$count] + 1;
        if($next_id > $total_links) {
            $next_link = '
            <li class="page-item disabled">
                <a class="page-link" href="#">Next</a>
            </li>';
        }
        else {
            $next_link = '<li class="page-item"><a class="page-link text-dark" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
        }
    }
    else {
        if($page_array[$count] == '...') {
            $page_link .= '
                <li class="page-item disabled">
                    <a class="page-link" href="#">...</a>
                </li>';
        }
        else {
            $page_link .= '
            <li class="page-item"><a class="page-link text-dark" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>';
        }
    }
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
    </ul>

</div>';

echo $output;

?>

<!-- Start ajax_insert_user / ajax_fetch_update_users -->
<script>
$(document).ready(function(){
    $('#add').click(function(){
        $('#insert').val("Insert");
        $('#insert_form')[0].reset();
        $('#register_user_id').val("");
        $('#add_user_headings').text("Add User")
    });
    $('.edit_data').click(function(){
        $('#add_user_headings').text("Edit User Details")
    });
    $(document).on('click', '.edit_data', function(){
        var register_user_id = $(this).attr("id");
        $.ajax({
            url:"includes/handlers/ajax_fetch_update_users.php",
            method:"POST",
            data:{register_user_id:register_user_id},
            dataType:"json",
            success:function(data){
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('#user_gender').val(data.user_gender);
                $('#user_email').val(data.user_email);
                $('#user_datetime').val(data.user_datetime);
                $('#user_email_status').val(data.user_email_status);
                $('#user_type').val(data.user_type);
                $('#register_user_id').val(data.register_user_id);
                $('#insert').val("Update");
                $('#add_data_Modal').modal('show');
            }
        });
    });

    $('#insert_form').on("submit", function(event){
        event.preventDefault();

        $.ajax({
            url:"includes/handlers/ajax_insert_users.php",
            method:"POST",
            data:$('#insert_form').serialize(),
            beforeSend:function(){
                $('#insert').val("Inserting");
            },
            success:function(data){
                $('#insert_form')[0].reset();
                $('#add_data_Modal').modal('hide');
                $('#users_table').html(data);
                $('#user_alert_message').css("display", "block");
                setTimeout(function(){
                   window.location.reload(1);
               }, 2000);
            }
        });
    });
});
</script>
<!-- End ajax_insert_user / ajax_fetch_update_users -->

<!-- Start Delete Users -->
<script>
    function confirmDelete(self) {
        var id = self.getAttribute("data-id");

        document.getElementById("form-delete-user").register_user_id.value = id;
        $("#delete_modal").modal("show");
    }
</script>
<!-- End Delete Users -->
