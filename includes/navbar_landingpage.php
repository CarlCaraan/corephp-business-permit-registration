<!-- Start Navigation -->
<nav class="navbar navbar-expand-md py-1 fixed-top">
<div class="container">
	<a class="navbar-brand-wrapper" href="index.php">
		<div class="logo-container">
			<span class="navbar-brand mx-0 float-left" href="index.php"><img src="assets/images/icons/favicon.png" alt=""></span>
		</div>
		<div class="logo-text-container float-right mt-1 ml-2">
			<h6 class="text-white font-weight-bold mb-0" id="brand-text">Sta. Maria, Laguna</h6>
			<span id="brand-text2">Business Registration</span>
		</div>
	</a>

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="custom-toggler-icon"><i class="fas fa-bars"></i></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link <?php if($page=='home'){echo 'active';}?>" href="index.php">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php if($page=='contact'){echo 'active';}?>" href="contact.php">Contact Us</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php if($page=='login'){echo 'active';}?>" href="login.php">Login or Register</a>
			</li>
		</ul>
	</div>
</div>
</nav>
<!--- End Navigation -->
