<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login | Klorofil - Free Bootstrap Dashboard Template</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/img/favicon.png">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="content">
						<div class="header">
							<div class="logo text-center"><img src="<?php echo base_url() ?>assets/img/logo-dark.png" alt="Klorofil Logo"></div>
							<p class="lead">Login to your account</p>
						</div>
						<form class="form-auth-small" action="" method="post">
							
							<div class="form-group">
								<div class="col-md-6">
									<label for="first_name" class="control-label sr-only">First Name:</label>
									<input type="text" class="form-control" id="first_name" value="" placeholder="First Name">
								</div>
								<div class="col-md-6">
									<label for="last_name" class="control-label sr-only">Last Name:</label>
									<input type="text" class="form-control" id="last_name" value="" placeholder="Last Name">
								</div>
							</div>

							<div class="form-group">
								<label for="cnic" class="control-label sr-only">CNIC#</label>
								<input type="text" class="form-control" id="cnic" value="" placeholder="CNIC">
							</div>

							<div class="form-group">
								<label class="fancy-radio">
									<input name="gender" value="male" type="radio">
									<span><i></i>Male</span>
								</label>
								<label class="fancy-radio">
									<input name="gender" value="female" type="radio">
									<span><i></i>Female</span>
								</label>
							</div>

							<div class="form-group">
								<label for="dob" class="control-label sr-only">DOB</label>
								<input type="text" class="form-control" id="dob" value="" placeholder="DOB">
							</div>

							<div class="form-group">
								<label for="address" class="control-label sr-only">Address</label>
								<input type="address" class="form-control" id="address" name="address" value="" placeholder="Address">
							</div>

							<div class="form-group">
								<label for="contact" class="control-label sr-only">Contact#</label>
								<input type="contact" class="form-control" id="contact" name="contact" value="" placeholder="Contact">
							</div>

							<div class="form-group">
								<label for="email" class="control-label sr-only">Email</label>
								<input type="email" class="form-control" id="email" name="email" value="" placeholder="Email">
							</div>

							<div class="form-group">
								<label for="username" class="control-label sr-only">Username</label>
								<input type="text" class="form-control" id="username" name="username" value="" placeholder="Username">
							</div>

							<div class="form-group">
								<label for="password" class="control-label sr-only">Password</label>
								<input type="password" class="form-control" id="password" name="password" value="" placeholder="Password">
							</div>

							
							<button type="submit" class="btn btn-primary btn-lg btn-block">REGISTER</button>

							<div class="bottom">
								<span class="helper-text"><i class="fa fa-lock"></i> <a href="#">Forgot password?</a></span>
							</div>
						</form>
					</div>
					
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
