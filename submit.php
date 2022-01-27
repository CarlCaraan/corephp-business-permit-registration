<?php
require("config/config.php");
include("includes/classes/User.php");
?>

<html>

<head>
	<?php include 'includes/head.php'; ?>
	<title>Registration | Welcome</title>
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

		<div class="container pt-5">
			<div class="card card-default">
				<div class="card-header">
					<h3 class="center">Step 2 - Submit a PDF File</h3>
					<p class="center">Make sure you attach in pdf file format</p>
				</div>

				<div class="card-body">
					<!-- Submit File -->
					<div class="jumbotron center py-4">
						<form action="includes/form_handlers/upload_pdf.php" method="POST" enctype="multipart/form-data">
							<input class="form-control" type="file" name="file" value="">
							<input class="btn btn-lg btn-success mt-3" type="submit" name="upload" value="Upload File" <?php echo $disabled_button; ?>>
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
						<table class="table table-hover table-bordered">
							<thead class="bg-light">
								<tr>
									<th>Name</th>
									<th>File Name</th>
									<th>Status</th>
									<th>Date Filed</th>
									<th>Action</th>
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
									}
								?>
									<tr>
										<td><?php echo $row['last_name'] . ", " . $row['first_name'] ?></td>
										<td><?php echo $row['file_name'] ?></td>
										<td>
											<?php //echo number_format($row['file_size'] / 1024 / 1024, 2) . "MB" ?>
											<span class="btn btn-<?php echo $pending; ?> btn-sm <?php echo $pending_text; ?> edit_data" name="edit" id="<?php echo $row['id']; ?>"><?php echo $pending_icon . $row["status"]; ?></span>
										</td>
										<td><?php echo $row['date_added'] ?></td>
										<td>
											<a href="download_pdf.php?file_name=<?php echo $row['file_name'] ?>"><i class="fas fa-download text-primary mr-1"></i></a>
											<a id="delete" href="delete_pdf.php?file_name=<?php echo $row['file_name'] ?>"><i class="fas fa-trash text-danger" id="trash_icon"></i></a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div> <!-- End Table Responsive -->
				</div> <!-- End Card-Body -->
			</div> <!-- End Card -->

		</div> <!-- End Container -->

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