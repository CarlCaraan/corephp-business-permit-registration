<?php
require("config/config.php");
include("includes/classes/User.php");
?>

<html>
<head>
	<?php include 'includes/head.php'; ?>
	<title>Admin Panel</title>
</head>

<body>

	<!-- Start Admin Section -->
	<div class="home">

		<!-- Navigation -->
		<header>
		<?php
		$page = 'admin';
		$side = 'dashboard_records';
		include 'includes/navbar_admin.php';
		?>
		</header>



		<!-- Start Vertical navbar -->
		<div class="vertical-nav" id="sidebar">

			<a title="Go to your account settings" href="settings_admin.php" id="username_container">
				<?php
					$fullname_obj = new User($con, $userLoggedIn);
					echo $fullname_obj->getFirstAndLastName();
				?>
			</a>

			<!-- Dashboard -->
		    <p class="font-weight-bold text-uppercase px-3 mt-5">Dashboard</p>

		    <ul class="nav flex-column mb-0">
		        <li class="nav-item">
		            <a href="adminhome.php" class="nav-link" id="admin_navlink" style="<?php if($side=='dashboard_users'){echo 'background-color: #ACACAC;';}?>">
		                <i class="fas fa-users mr-3 text-success"></i>Users
		            </a>
		        </li>

		        <li class="nav-item">
		            <a href="adminrecords.php" class="nav-link" id="admin_navlink" style="<?php if($side=='dashboard_records'){echo 'background-color: #ACACAC;';}?>">
		                <i class="fas fa-book-open mr-3 text-success"></i>Records
		            </a>
		        </li>
		    </ul>

		</div>
		<!-- End Vertical navbar -->


		<!-- Start Page Content holder -->
		<div class="page-content" id="admin_content">

		    <!-- Toggle button -->
		    <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded shadow-sm">
		        <i class="fas fa-bars text-success"></i>
		    </button>

			<!-- Start Table -->
        	<div class="card-header"><h3 class="font-weight-bold text-uppercase" id="admin_record_headings">User Records</h3></div>
	        <div class="card-body">
	        	<div class="form-group">
	            	<input type="text" name="search_box" id="search_box" class="form-control" placeholder="Search...">
	        	</div>
	        	<div class="table-responsive" id="dynamic_content">
					<div id="records_table">
						<!--- Ajax Content Here --->
					</div>
	        	</div>
	        </div>

		</div>
		<!-- End Page Content holder -->



	</div>
	<!-- End Admin Section -->


<!-- Start Internet Notification Popup Message -->
<div class="connections">
	<div class="connection offline">
		<i class="material-icons wifi-off">wifi_off</i>
		<p>you are currently offline</p>
		<a href="#" class="refreshBtn">Refresh</a>
		<i class="material-icons close">close</i>
	</div>
	<div class="connection online">
		<i class="material-icons wifi">wifi</i>
		<p>your Internet connection was restored</p>
		<i class="material-icons close">close</i>
	</div>
</div>
<!-- End Internet Notification Popup Message -->


</body>

<!-- Javascript -->
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
<script src="bootstrap-4.6.0-dist/js/bootstrap.min.js"></script>
<script src="assets/js/custom.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script><!-- Modern Date Picker -->
<script src="assets/js/darkmode.js"></script> <!-- Dark Mode JS -->

</html>

<!-- Start Modal Section -->

<!-- Start Delete Modal -->
<div class="modal fade" id="delete_modal" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">

  		<div class="modal-header">
			<h4>Delete Record</h4>
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
    	</div>

    	<div class="modal-body">
    		<p>Are you sure you want to delete this record?</p>
            <form method="POST" action="includes/form_handlers/delete_records.php" id="form-delete-record">
                <input type="hidden" name="records_id">
            </form>
    	</div>

    	<div class="modal-footer">
			<button type="submit" form="form-delete-record" class="btn btn-danger">Delete</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    	</div>

    </div>

	</div>
</div>
<!-- End Delete Modal -->

<!-- Start Insert/Update User Modal -->
<div class="modal fade" id="add_data_Modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">User Records</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

            <div class="modal-body">
                <form method="post" id="insert_form">
                    <label for="added_by">Name</label>
                    <input type="text" name="added_by" id="added_by" class="form-control" required><br>

                    <label for="date_added">Date Added</label>
                    <input name="date_added" id="date_added" class="form-control" required></input><br>

                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                    </select><br>

	                <input type="hidden" name="records_id" id="records_id">
	                <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success">
					<input type="reset" class="btn btn-secondary"></input>
                </form>
            </div>

            <div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
       </div>
  </div>
</div> <!-- End Insert User Modal -->
<!-- End Modal Section -->


<!-- Modern Datetime picker UI -->
<script>
    flatpickr('#date_added', {
        enableTime: true
    })
</script>


<!-- Start ajax_fetch_users -->
<script>
$(document).ready(function(){

    load_data(1);

    function load_data(page, query = '')
    {
      $.ajax({
        url:"includes/handlers/ajax_fetch_records.php",
        method:"POST",
        data:{page:page, query:query},
        success:function(data)
        {
            $('#dynamic_content').html(data);
        }
      });
    }

    $(document).on('click', '.page-link', function(){
        var page = $(this).data('page_number');
        var query = $('#search_box').val();
        load_data(page, query);
    });

    $('#search_box').keyup(function(){
        var query = $('#search_box').val();
        load_data(1, query);
    });

});
</script>
<!-- End ajax_fetch_users -->
