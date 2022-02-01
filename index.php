<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'includes/head.php'; ?>
	<title>Business Permit Registration</title>
	<link rel="stylesheet" href="assets/css/animate.css">
</head>

<body id="landingpage_body">

	<!-- Start Home Section -->
	<div id="home">
		<!-- Navigation -->
		<header>
			<?php $page = 'home';
			include 'includes/navbar_landingpage.php'; ?>
		</header>

		<!--========= Start Carousel Section =========-->
		<section>
			<!--- Start Landing Page Image -->
			<div class="landing">
				<div class="home-wrap">
					<div class="home-inner home-inner2">
					</div>
				</div>
			</div>
			<!--- End Landing Page Image -->
			<div class="caption">
				<!-- Header Text -->
				<div class="container center">
					<h4 class="pt-4 pb-5" id="landing_page_heading">MUNICIPALITY OF STA. MARIA, LAGUNA - BUSINESS REGISTRATION</h4>
				</div>
				<!-- Body Image -->
				<div class="owl-carousel owl-theme container">
					<div class="item image-carousel">
						<img src="assets/images/landing_page/image1.jpg" alt="">
					</div>
					<div class="item image-carousel">
						<img src="assets/images/landing_page/image2.jpg" alt="">
					</div>
				</div>
				<!-- Footer alert -->
				<div class="container">
					<div class="alert alert-info alert-dismissible fade show text-dark pt-3 pb-4 mt-4" role="alert">
						<strong><i class="fas fa-bullhorn"></i> Visit our Facebook Page!</strong><br>
						Check out our page for the latest updates:
						<a id="landing_page_atag" href="https://www.facebook.com/MayorCindySML" target="_blank">
							https://www.facebook.com/MayorCindySML
						</a>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>
			</div>
		</section>
		<!--========= End Carousel Section =========-->

		<!--========= Start Steps Instructions Section =========-->
		<section id="instruction_container">
			<div class="container py-5">
				<div class="container center">
					<h4 class="mb-4 wow fadeInUp" id="landing_page_heading">BUSINESS PERMIT REGISTRATION INSTRUCTIONS</h4>
				</div>
				<div class="row">
					<div class="col-md-3 wow fadeInLeft" data-wow-duration=".3s" data-wow-delay=".3s">
						<div class="center step-item rounded mx-auto">
							<a href="assets/images/landing_page/step1.jpg" data-lightbox="example-set" data-title="Step 1">
								<img class="step-image" src="assets/images/landing_page/step1.jpg" alt="">
							</a>
						</div>
						<div class="center my-3">
							<h4 class="step-headings">STEP 1</h4>
							<p class="step-body" align="left">
								Once registered and signed
								in, click “<b>Registration</b>” and
								complete the form by filling
								in the necessary info then
								click “<b>Create PDF</b>” when
								done. A PDF file will be
								downloaded.
							</p>
						</div>
					</div>
					<div class="col-md-3 wow fadeInLeft" data-wow-duration=".6s" data-wow-delay=".6s">
						<div class="center step-item rounded mx-auto">
							<a href="assets/images/landing_page/step2.jpg" data-lightbox="example-set" data-title="Step 2">
								<img class="step-image" src="assets/images/landing_page/step2.jpg" width="100px" alt="">
							</a>
						</div>
						<div class="center my-3">
							<h4 class="step-headings">STEP 2</h4>
							<p class="step-body" align="left">
								Click “<b>Submit</b>” then click
								“<b>Choose File,</b>” a dialog
								box will appear. Locate and
								select the downloaded
								PDF file from your
								device then click “<b>Open.</b>”
								Finally, click “<b>Upload File.</b>”
							</p>
						</div>
					</div>
					<div class="col-md-3 wow fadeInLeft" data-wow-duration=".9s" data-wow-delay=".9s">
						<div class="center step-item rounded mx-auto">
							<a href="assets/images/landing_page/step3.jpg" data-lightbox="example-set" data-title="Step 3">
								<img class="step-image" src="assets/images/landing_page/step3.jpg" width="100px" alt="">
							</a>
						</div>
						<div class="center my-3">
							<h4 class="step-headings">STEP 3</h4>
							<p class="step-body" align="left">
								Wait for the approval of your
								business permit. Usually, it
								takes three (3) days to process.
								You can check the approval
								status in the “<b>Submit</b>” tab.
							</p>
						</div>
					</div>
					<div class="col-md-3 wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="1.2s">
						<div class="center step-item rounded mx-auto">
							<a href="assets/images/landing_page/step4.jpg" data-lightbox="example-set" data-title="Step 4">
								<img class="step-image" src="assets/images/landing_page/step4.jpg" width="100px" alt="">
							</a>
						</div>
						<div class="center my-3">
							<h4 class="step-headings">STEP 4</h4>
							<p class="step-body" align="left">
								Once approved, pay the fee
								and receive the physical copy
								of your business permit at the
								<b>Municipal Hall</b> located at
								<b>Real Velasquez Street,
									Poblacion Dos, Sta. Maria,
									Laguna</b>.
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--========= End Steps Instructions Section =========-->

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

	<!--- Top Scroll -->
	<a href="#home" class="top-scroll">
		<i class="fas fa-angle-up"></i>
	</a>
	<!--- End of Top Scroll -->

	<!-- All Scripts -->
	<?php include 'includes/scripts.php'; ?>
</body>

</html>