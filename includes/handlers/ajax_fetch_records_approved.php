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
SELECT * FROM posts
";

if($_POST['query'] != '') {
    $query .= '
    WHERE added_by LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
    OR file_name LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
    OR status LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
    ';
}
$query .= 'WHERE deleted="no" AND status="Verified" ORDER BY id ASC ';

$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();
$total_filter_data = $statement->rowCount();

$output = '
<label>Total Records : '.$total_data.'</label>
<table class="table table-striped">
    <tr id="admin_table_headings">
		<th>ID</th>
		<th>Name</th>
		<th>File Name</th>
		<th>Size</th>
		<th>Date Added</th>
		<th class="center">Status</th>
		<th class="center">Attachment</th>
		<th class="center">Action</th>
    </tr>
';
if($total_data > 0)
{
    foreach($result as $row) {

        if($row["status"] == "Verified") {
            $pending = "success";
            $pending_icon = "<i class='fas fa-check-circle mr-1'></i>";
            $pending_text = "text-light";
        }else if ($row["status"] == "Please Resubmit") {
            $pending = "danger";
            $pending_icon = "<i class='fas fa-times-circle mr-1'></i>";
            $pending_text = "text-light";
        }else {
            $pending = "warning";
            $pending_icon = "<i class='fas fa-clock mr-1'></i>";
            $pending_text = "text-dark";
        }

        $output .= '
        <tr>
            <td>'.$row["id"].'</td>
            <td>'.$row["last_name"].', '.$row["last_name"].'</td>
            <td>'.$row["file_name"].'</td>
            <td>'.number_format($row["file_size"]/1024/1024,2) . "MB" . '</td>
            <td>'.$row["date_added"].'</td>
            <td class="center">
                <button class="btn btn-' . $pending . ' btn-sm '. $pending_text .' edit_data" name="edit" id="' . $row["id"] . '" >' . $pending_icon . $row["status"].'</button>
            </td>
            <td class="center">
                <a class="btn btn-primary btn-sm text-light" href="download_pdf.php?file_name='. $row['file_name']. '"><i class="fas fa-paperclip" id="paperclip_icon"></i> View Attachment</a>
            </td>
            <td class="center">
                <div class="mx-auto" style="width: 100px;">
                    <button name="edit" id="' . $row["id"] . '" class="btn btn-info edit_data btn-sm"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-secondary btn-sm" data-id="' . $row["id"] . '" onclick="confirmDelete(this);"><i class="fas fa-archive" id="trash_icon"></i></button>
                </div>
            </td>
        </tr>
        ';
    }
}
else {
$output .= '
    <tr>
        <td colspan="9" align="center">No Data Found</td>
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
        $('#records_id').val("");
        // $('#password_input').css("display", "block");
    });
    $('.edit_data').click(function(){
        // $('#password_input').css("display", "none");
    });
    $(document).on('click', '.edit_data', function(){
        var records_id = $(this).attr("id");
        $.ajax({
            url:"includes/handlers/ajax_fetch_update_records.php",
            method:"POST",
            data:{records_id:records_id},
            dataType:"json",
            success:function(data){
                $('#added_by').val(data.added_by);
                $('#file_name').val(data.file_name);
                $('#date_added').val(data.date_added);
                $('#status').val(data.status);
                $('#records_id').val(data.id);
                $('#insert').val("Update");
                $('#add_data_Modal').modal('show');
            }
        });
    });

    $('#insert_form').on("submit", function(event){
        event.preventDefault();

        $.ajax({
            url:"includes/handlers/ajax_insert_records.php",
            method:"POST",
            data:$('#insert_form').serialize(),
            beforeSend:function(){
                $('#insert').val("Inserting");
            },
            success:function(data){
                $('#insert_form')[0].reset();
                $('#add_data_Modal').modal('hide');
                $('#records_table').html(data);
                setTimeout(function(){
                   window.location.reload(1);
               });
            }
        });
    });
});
</script>
<!-- End ajax_insert_user / ajax_fetch_update_users -->

<!-- Start Delete Records -->
<script>
    function confirmDelete(self) {
        var id = self.getAttribute("data-id");

        document.getElementById("form-delete-record").records_id.value = id;
        $("#delete_modal").modal("show");
    }
</script>
<!-- End Delete Records -->
