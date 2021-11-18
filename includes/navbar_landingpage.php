<!-- Start Navigation -->
<nav class="navbar navbar-expand-md fixed-top">
<div class="container-fluid">
	<a class="navbar-brand" href="#"><img src="assets/images/icons/favicon.ico" alt=""></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="custom-toggler-icon"><i class="fas fa-bars"></i></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link <?php if($page=='home'){echo 'active';}?>" href="index.php">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php if($page=='login'){echo 'active';}?>" href="login.php">Sign In</a>
			</li>
			<li class="nav-item">
				<a class="nav-link <?php if($page=='register'){echo 'active';}?>" href="register.php">Sign Up</a>
			</li>
		</ul>
	</div>
</div>
</nav>
<!--- End Navigation -->
