<?php
require("config/config.php");
include("includes/classes/User.php");
?>

<html>

<head>
	<?php include 'includes/head.php'; ?>
	<title>Upload | Busines Permit Registration</title>
</head>

<body>

	<!-- Start Home Section -->
	<div id="home" class="offset">

		<!-- Navigation -->
		<header>
			<?php $page = 'submit';
			include 'includes/navbar_user.php'; ?>
			<?php include("includes/form_handlers/pdo_handler.php"); ?>
		</header>

		<?php
		$check_data_query = mysqli_query($con, "SELECT * FROM posts WHERE added_by='$userLoggedIn'");
		if (mysqli_num_rows($check_data_query) >= 2) {
			$disabled_button = "disabled";
		} else {
			$disabled_button = "";
		}
		?>

		<!--========= Start Main Content Section =========-->
		<div class="container" id="submit_main_content">
			<div class="card pt-0" id="setting_container">
				<div class="pt-4">
					<h3 class="center mb-0 text-uppercase" id="registration_headings">Step 2-3</h3>
					<h3 class="center text-uppercase" id="setting_headings">Submission and approval status</h3>
					<p class="center mx-2" id="registration_text">
						Click “<strong>Choose File,</strong>” a dialog box will appear. Locate and select the downloaded<br>
						PDF file from your device then click “<strong>Open.</strong>” Finally, click “<strong>Upload File.</strong>”
					</p>
				</div>

				<div class="card-body pt-0">
					<!-- Submit File -->
					<div class="center pt-4">
						<form action="includes/form_handlers/upload_pdf.php" method="POST" enctype="multipart/form-data">
							<h5 class="text-uppercase font-weight-bold text-left" id="registration_text2">Submission</h5>
							<input class="form-control registration-input" type="file" name="file" value="">
							<input class="btn btn-lg mt-3" id="registration_button" type="submit" name="upload" value="Upload File" <?php echo $disabled_button; ?>>
							<?php
							if (isset($_SESSION['upload_message'])) {
								echo $_SESSION['upload_message'];
								unset($_SESSION['upload_message']);
							}
							?>
							<?php
							if (isset($_SESSION['delete_message'])) {
								echo $_SESSION['delete_message'];
								unset($_SESSION['delete_message']);
							}
							?>
						</form>
					</div>

					<!-- Start Table -->
					<div class="table-responsive">
						<table class="table table-hover">
							<h5 class="text-uppercase font-weight-bold" id="registration_text2">Approval Status</h5>
							<thead>
								<tr id="admin_table_headings">
									<th width="35%">File Name</th>
									<th>Status</th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								<?php
								$query = $conn->prepare("SELECT * FROM posts WHERE added_by='$userLoggedIn' ORDER BY id DESC");
								$query->execute();

								$pending = "warning";
								$pending_icon = "<i class='fas fa-exclamation-circle mr-1'></i>";
								$pending_text = "text-dark";

								while ($row = $query->fetch()) {
									if ($row["status"] == "Verified") {
										$pending = "success";
										$pending_icon = "<i class='fas fa-check-circle mr-1'></i>";
										$pending_text = "text-light";
									} else if ($row["status"] == "Please Resubmit") {
										$pending = "danger";
										$pending_icon = "<i class='fas fa-exclamation-circle mr-1'></i>";
										$pending_text = "text-light";
									} else {
										$pending = "warning";
										$pending_icon = "<i class='fas fa-exclamation-circle mr-1'></i>";
										$pending_text = "text-dark";
									}

								?>
									<tr>
										<td><?php echo $row['file_name'] ?></td>
										<td>
											<?php //echo number_format($row['file_size'] / 1024 / 1024, 2) . "MB" 
											?>
											<span
											<?php
											if(($row['status'] == "Please Resubmit") || ($row['status'] == "Verified")) echo "data-toggle='modal' data-target='.bd-example-modal-sm'";
											?>
											 class="btn btn-<?php echo $pending; ?> btn-sm <?php echo $pending_text; ?> edit_data" name="edit" id="<?php echo $row['id']; ?>">
												<?php echo $pending_icon . $row["status"]; ?>
											</span>
										</td>
										<td>
											<a class="btn btn-sm btn-info" href="download_pdf.php?file_name=<?php echo $row['file_name'] ?>"><i class="fas fa-paperclip" id="paperclip_icon"></i> View Attachment</a>
										</td>
										<td class="pt-3">
											<small>
												<?php echo $row['date_added'] ?>
											</small>
										</td>
										<td class="pt-3">
											<a id="delete" href="delete_pdf.php?file_name=<?php echo $row['file_name'] ?>"><i class="fas fa-times text-secondary" id="close_icon"></i></a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php
						if ($query->rowCount() == 0) {
							$no_data = '
							<div class="w-100 center">
								<span><i class="fas fa-info-circle text-info"></i> Upload your requirements.</span>
							</div>
							';
						} else {
							$no_data = '';
						}
						echo $no_data;
						?>
					</div> <!-- End Table Responsive -->
				</div> <!-- End Card-Body -->
			</div> <!-- End Card -->

		</div> <!-- End Container -->
		<!--========= End Main Content Section =========-->

		<!--========= Start Footer Section =========-->
		<?php include 'includes/user_footer.php'; ?>
		<!--========= End Footer Section =========-->
	</div>
	<!-- End Home Section -->

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
	
	<!-- All Scripts -->
	<?php include 'includes/scripts.php'; ?>

	<script src="assets/js/darkmode.js"></script> <!-- Dark Mode JS -->
	<!-- SweetAlert2 -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- SweetAlert2 -->
	<script>
		$(function() {
			$(document).on('click', '#delete', function(e) {
				e.preventDefault();
				var link = $(this).attr("href");

				Swal.fire({
					title: 'Are you sure?',
					text: "Delete this PDF?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = link
						Swal.fire(
							'Deleted!',
							'Your file has been deleted.',
							'success'
						)
					}
				})
			});
		});
	</script>
</body>


</html>

<!-- Small modal -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
		  Important Notice
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	  </div>
      <div class="modal-body">
		  Please check your email.
	  </div>
    </div>
  </div>
</div>