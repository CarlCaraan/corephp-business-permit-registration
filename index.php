<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'includes/head.php'; ?>
	<title>Business Permit Registration</title>
</head>

<body id="landingpage_body">

	<!-- Start Home Section -->
	<div class="home">
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
					<div class="home-inner">
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
						<strong><i class="fas fa-bullhorn"></i> Visit our Fb Page!</strong><br>
						You should check our page for more updates:
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
				<div class="row">
					<div class="col-md-4">

					</div>
					<div class="col-md-4">

					</div>
					<div class="col-md-4">

					</div>
					<div class="col-md-4">

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

	<!-- All Scripts -->
	<?php include 'includes/scripts.php'; ?>
	<!-- Start Owl Carousel -->
	<script>
		$('.owl-carousel').owlCarousel({
			loop: false,
			margin: 10,
			nav: false,
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 1
				},
				1000: {
					items: 1
				}
			}
		})
	</script>
	<!-- End Owl Carousel -->
</body>

</html>