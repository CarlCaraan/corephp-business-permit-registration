<?php
require("config/config.php");
require("gconfig.php");
include("includes/classes/User.php");
?>

<!DOCTYPE html>
<html>

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<?php include 'includes/head.php'; ?>
	<title>Users | Admin</title>
</head>

<body>

	<!-- Start Admin Section -->
	<div class="home">

		<!-- Navigation -->
		<header>
			<?php
			$page = 'admin';
			$side = 'admin_users';
			include 'includes/navbar_admin.php';
			?>
		</header>

		<!-- Start Vertical navbar -->
		<div class="vertical-nav" id="sidebar">

			<!-- Dashboard -->
			<p class="text-uppercase center text-white p-2 my-0" id="sidebar_headings">Admin Panel</p>

			<ul class="nav flex-column">
				<li class="nav-item">
					<a href="adminhome.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_home') {
																							echo 'background-color: var(--nav-link); border-radius: 5px;';
																						} ?>">
						<div class="row center">
							<div class="col-2 py-0">
								<div class="center" id="icon_wrapper"><i class="fas fa-chart-bar" id="sidebar_icons"></i></div>
							</div>
							<div class="col-8 py-0">
								<div class="ml-2" id="sidebar_text_wrapper">Dashboard</div>
							</div>
						</div>
					</a>
				</li>
				<h6 class="text-uppercase font-weight-bold mx-auto my-3" id="registration_text">User Management</h6>
				<li class="nav-item">
					<a href="adminusers.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_users') {
																							echo 'background-color: var(--nav-link); border-radius: 5px;';
																						} ?>">
						<div class="row center">
							<div class="col-2 py-0">
								<div class="center" id="icon_wrapper"><i class="fas fa-user-friends" id="sidebar_icons"></i></div>
							</div>
							<div class="col-8 py-0">
								<div class="ml-2" id="sidebar_text_wrapper">Users</div>
							</div>
						</div>
					</a>
				</li>
				<h6 class="text-uppercase font-weight-bold mx-auto my-3" id="registration_text">Permit Management</h6>
				<li class="nav-item">
					<a href="adminrecords.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_records_pending') {
																								echo 'background-color: var(--nav-link); border-radius: 5px;';
																							} ?>">
						<div class="row center">
							<div class="col-2 py-0">
								<div class="center" id="icon_wrapper"><img src="assets/images/icons/records_pending_icon.png" width="32px" alt=""></div>
							</div>
							<div class="col-8 py-0">
								<div class="ml-2" id="sidebar_text_wrapper">Records<span class="badge badge-warning">Pending</span></div>
							</div>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a href="adminrecords_approved.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_records_approved') {
																										echo 'background-color: var(--nav-link); border-radius: 5px;';
																									} ?>">
						<div class="row center">
							<div class="col-2 py-0">
								<div class="center" id="icon_wrapper"><img src="assets/images/icons/records_approved_icon.png" width="32px" alt=""></div>
							</div>
							<div class="col-8 py-0">
								<div class="ml-2" id="sidebar_text_wrapper">Records<span class="badge badge-success">Approved</span></div>
							</div>
						</div>
					</a>
				</li>
				<li class="nav-item">
					<a href="adminrecords_reject.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_records_reject') {
																										echo 'background-color: var(--nav-link); border-radius: 5px;';
																									} ?>">
						<div class="row center">
							<div class="col-2 py-0">
								<div class="center" id="icon_wrapper"><img src="assets/images/icons/records_rejected_icon.png" width="32px" alt=""></div>
							</div>
							<div class="col-8 py-0">
								<div class="ml-2" id="sidebar_text_wrapper">Records<span class="badge badge-danger">Rejected</span></div>
							</div>
						</div>
					</a>
				</li>
				<h6 class="text-uppercase font-weight-bold mx-auto my-3" id="registration_text">Trash Management</h6>
				<li class="nav-item">
					<a href="admintrashed.php" class="nav-link" id="admin_navlink" style="<?php if ($side == 'admin_trashed') {
																								echo 'background-color: var(--nav-link); border-radius: 5px;';
																							} ?>">
						<div class="row center">
							<div class="col-2 py-0">
								<div class="center" id="icon_wrapper"><i class="fas fa-archive" id="sidebar_icons"></i></div>
							</div>
							<div class="col-8 py-0">
								<div class="ml-2" id="sidebar_text_wrapper">Archives</div>
							</div>
						</div>
					</a>
				</li>
			</ul>

		</div>
		<!-- End Vertical navbar -->

		<!-- Start Page Content holder -->
		<div class="page-content" id="admin_content">

			<!-- Toggle button -->
			<button id="sidebarCollapse" type="button" class="btn border-0">
				<i class="fas fa-bars mt-1" id="sidebar_icons"></i>
			</button>

			<!-- Start Table Container -->
			<div class="container-fluid">
				<div class="card card-default mt-3" id="setting_container">
					<h3 class="font-weight-bold pl-4 pt-4" id="setting_headings">Users</h3>
					<div class="card-body">
						<div class="form-group">
							<input type="search" name="search_box" id="search_box" class="form-control login-input" placeholder="Search...">
						</div>

						<!-- Flash Delete Message -->
						<?php
						if (isset($_SESSION['delete_message'])) {
							echo $_SESSION['delete_message'];
							unset($_SESSION['delete_message']);
						}
						?>

						<!-- Flash Update Message -->
						<?php
						if (isset($_SESSION['update_message'])) {
							echo $_SESSION['update_message'];
							unset($_SESSION['update_message']);
						}
						?>

						<div class="table-responsive" id="dynamic_content">
							<div id="users_table">
								<!--- Ajax Content Here --->
							</div>
						</div>
					</div>
				</div>
			</div> <!-- End container-fluid -->

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

	<!-- Javascript -->
	<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
	<script src="bootstrap-4.6.0-dist/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script><!-- Modern Date Picker -->
	<script src="assets/js/darkmode.js"></script> <!-- Dark Mode JS -->

</body>

</html>

<!-- Start Modal Section -->

<!-- Start Delete Modal -->
<div class="modal fade" id="delete_modal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title text-info">Delete this row?</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<p>Are you sure you want to delete this user?</p>
				<form method="POST" action="includes/form_handlers/delete_users.php" id="form-delete-user">
					<input type="hidden" name="register_user_id">
				</form>
			</div>

			<div class="modal-footer">
				<button type="submit" form="form-delete-user" class="btn btn-danger">Delete</button>
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
				<div class="center w-100">
					<h4 class="modal-title text-info ml-4" id="add_user_headings">Edit User Details</h4>
				</div>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<form method="post" id="insert_form">
					<label for="first_name">First Name</label>
					<input type="text" name="first_name" id="first_name" class="form-control" required><br>

					<label for="last_name">Last Name</label>
					<input name="last_name" id="last_name" class="form-control" required></input><br>

					<div class="user_gender_disable">
						<label for="user_gender">Gender</label>
						<select name="user_gender" id="user_gender" class="form-control" required>
							<option disabled selected>Select Gender (optional)</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select><br>
					</div>

					<div class="user_email_disable">
						<label for="user_email">Email</label>
						<input name="user_email" id="user_email" class="form-control" required></input><br>
					</div>

					<label for="user_datetime">Sign Up Date</label>
					<input type="text" name="user_datetime" id="user_datetime" class="form-control" required></input><br>

					<label for="user_email_status">Status</label>
					<select name="user_email_status" id="user_email_status" class="form-control" required>
						<option value="verified">Verified</option>
						<option value="not verified">Not Verified</option>
					</select><br>

					<label for="user_type">User Type</label>
					<select name="user_type" id="user_type" class="form-control" required>
						<option value="admin">Admin</option>
						<option value="user">User</option>
					</select><br>
			</div>

			<div class="modal-footer">
				<input type="hidden" name="register_user_id" id="register_user_id">
				<input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info">
				<input type="reset" class="btn btn-secondary"></input>
				</form>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div> <!-- End Insert User Modal -->
<!-- End Modal Section -->


<!-- Modern Datetime picker UI -->
<script>
	flatpickr('#user_datetime', {
		enableTime: false
	})
</script>


<!-- Start ajax_fetch_users -->
<script>
	$(document).ready(function() {

		load_data(1);

		function load_data(page, query = '') {
			$.ajax({
				url: "includes/handlers/ajax_fetch_users.php",
				method: "POST",
				data: {
					page: page,
					query: query
				},
				success: function(data) {
					$('#dynamic_content').html(data);
				}
			});
		}

		$(document).on('click', '.page-link', function() {
			var page = $(this).data('page_number');
			var query = $('#search_box').val();
			load_data(page, query);
		});

		$('#search_box').keyup(function() {
			var query = $('#search_box').val();
			load_data(1, query);
		});

	});
</script>
<!-- End ajax_fetch_users -->