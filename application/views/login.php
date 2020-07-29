<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>Login | Heaplan</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->

	<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/linearicons/style.css">

	<!-- MAIN CSS -->

	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->

	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/img/favicon.png">
	<style>
		
		#layoutAuthentication {
		display: -ms-flexbox;
		display: flex;
		-ms-flex-align: center;
		align-items: center;
		padding-top: 40px;
		padding-bottom: 40px;
		min-height: 100vh;
		background-color: #f5f5f5;
		}
		#layoutAuthentication .layoutAuthentication_content {
		width: 100%;
		max-width: 620px;
		padding: 15px;
		margin: auto;
		}

		.layoutAuthentication_content .header{
		padding: .75rem 1.25rem;
		margin-bottom: 0;
		}

		.layoutAuthentication_content .logo img {
		max-width: 70%;
		}

		.layoutAuthentication_content .header .lead {
		font-size: 18px;
		padding: 4px;
		margin: 10px 0;
		font-weight: 400;
		background-color: #62a1ce;
		color: #fff;
		text-align: center;
		}

		#login_button{
		width: 190px;
		}

		.layoutAuthentication_content .footer{
		padding: .75rem 1.25rem;
		margin-bottom: 0;
		border-top: 1px solid rgba(0,0,0,.125);
		}

		.card .alert-danger{
			margin: 5px 20px !important;
		}
		.error {
			color: #F00;
			background-color: #FFF;
		}
	</style>
</head>

<body>
     <main>
        <div id="layoutAuthentication">
            <div class="layoutAuthentication_content">
                <div class="card shadow">
                    <div class="header">
                        <div class="logo text-center">
							<<img src="https://heaplan.com/portal/assets/img/logo.png" alt="Heaplan">
                        </div>
                        <p class="lead">CLIENT LOGIN</p>
                    </div>
                   <?php
						if (isset($error)) {

						    echo '<p class="alert alert-danger"><strong>Error: </strong>'.$error.'</p>';
						}
						?>
                    <div class="card-body">
                        <form id="form_login" name="form_login" method="POST">
                            <div class="form-group">
                                <label class="small mb-1" for="username">Username: <span>*</span></label>
                                <input class="form-control" id="username" name="username" />
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="password">Password: <span>*</span></label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" class="form-control" id="password" name="password" aria-describedby="basic-eye"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-eye"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a href="forgot.php">Forgot Password?</a>
                                <button type="submit" class="btn btn-primary" id="login_button">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="footer text-center">
                        <div>
                        </div>
                    </div>
                </div>        
            </div>
        </div>
	 </main>
	 <script src="//code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src='//cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js'></script>
     <script>
         $(document).ready(function() {

			  //login password
			$("#form_login").validate({
				rules:{
					username: {
						required: true,
					},
					password: {
						required: true,
					},
				},
				messages:{
					username: {
						required: 'Please enter username',
						alphanumeric: 'Please enter valid username'
					},
					password: {
						required: 'Please enter password',
						minLength: 'Password is too short'
					},
				},
				errorPlacement: function(error, element) {
					var id = element.attr('id');
					if (id == 'password') {
						error.insertAfter($(element).parent());
					}else{
						error.insertAfter(element);
					}
				}
			});


            $("#basic-eye").on('click', function(e) {
                e.preventDefault();
                if($('#password').attr("type") == "text"){
                    $('#password').attr('type','password');
                    $('#basic-eye i').addClass("fa-eye-slash");
                    $('#basic-eye i').removeClass("fa-eye" );
                }else if($('#password').attr("type") == "password"){
                    $('#password').attr('type','text');
                    $('#basic-eye i').removeClass("fa-eye-slash");
                    $('#basic-eye i').addClass("fa-eye");
                }
            });
        });
     </script>
    </body>
</html>
