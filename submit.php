<?php
require("config/config.php");
include("includes/classes/User.php");
?>

<html>
<head>
	<?php include 'includes/head.php'; ?>
    <?php require 'includes/form_handlers/pdo_handler.php'; ?>
	<title>Registration | Welcome</title>
</head>

<body>

	<!-- Start Home Section -->
	<div id="home" class="offset">

		<!-- Navigation -->
		<header>
		<?php $page = 'submit';include 'includes/navbar_user.php'; ?>
		<?php include("includes/form_handlers/upload_pdf.php"); ?>
		<?php include("delete_pdf.php"); ?>
		</header>

		<?php
		$check_data_query = mysqli_query($con, "SELECT * FROM posts WHERE added_by='$userLoggedIn'");
    	$data_query = mysqli_fetch_array($check_data_query);

		if (!empty($data_query)) {
			$disabled_button = "disabled";
		}
		else {
			$disabled_button = "";
		}
		?>

		<div class="container pt-5">
			<div class="card card-default mt-5">
				<div class="card-header">
		            <h3 class="center">Step 2 - Submit a PDF File</h3>
		            <p class="center">Make sure you attach in pdf file format</p>
				</div>

				<div class="card-body">
            		<!-- Submit File -->
					<div class="jumbotron center py-4">
		                <form class="" action="submit.php" method="POST" enctype="multipart/form-data">
		                    <input class="form-control" type="file" name="file" value="">
		                    <input class="btn btn-lg btn-success mt-3" type="submit" name="upload" value="Upload File" <?php echo $disabled_button; ?>>
		                    <?php echo $upload_message; ?>
		                </form>
					</div>

		            <!-- Start Table -->
					<div class="table-responsive">
				 	   <table class="table table-hover table-bordered">
			                <thead class="bg-light">
			                    <tr>
			                        <th>Name</th>
			                        <th>File Name</th>
			                        <th>File Size</th>
			                        <th>Date Added</th>
			                        <th>Action</th>
			                    </tr>
			               </thead>

							<?php
							$query = $conn->prepare("SELECT * FROM posts WHERE added_by='$userLoggedIn' ORDER BY id DESC");
							$query->execute();

							while($row = $query->fetch()) {
							?>
			                <tbody>
			                    <tr>
			                        <td><?php echo $row['added_by'] ?></td>
			                        <td><?php echo $row['file_name'] ?></td>
			                        <td><?php echo number_format($row['file_size']/1024/1024,2) . "MB" ?></td>
			                        <td><?php echo $row['date_added'] ?></td>
			                        <td>
										<a href="download_pdf.php?file_name=<?php echo $row['file_name'] ?>"><i class="fas fa-download text-primary mr-1"></i></a>
					  					<button type="button" data-toggle="modal" data-target="#myModal"><i class="fas fa-trash text-danger" id="trash_icon"></i></button>
									</td>
			                    </tr>
			                </tbody>
			            </table>
					</div> <!-- End Table Responsive -->
				</div> <!-- End Card-Body -->
			</div> <!-- End Card -->

		</div> <!-- End Container -->


	    <!-- Start Modal Section -->
	    <div class="modal fade" id="myModal" role="dialog">
	   		<div class="modal-dialog">

	    	<!-- Modal content-->
	    	<div class="modal-content">

	      		<div class="modal-header">
					<h4>Delete PDF</h4>
	            	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        	</div>

	        	<div class="modal-body">
	        		<p>Are you sure you want to delete this PDF?</p>
	        	</div>

	        	<div class="modal-footer">
			  		<a class="btn btn-danger" href="delete_pdf.php?file_name=<?php echo $row['file_name'] ?>">Delete</a>
	         		<button type="button" class="btn btn-default btn-secondary" data-dismiss="modal">Cancel</button>
	        	</div>

	        </div>

	   		</div>
	    </div> <!-- End Modal Section-->
				<?php } ?>
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

</body>


</html>
