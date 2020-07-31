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
        <div id="layoutAuthentication">
           <div class="layoutAuthentication_content">
                <div class="card shadow">
                        <div class="header">
                            <div class="logo text-center">
                            <img src="https://heaplan.com/portal/assets/img/logo.png" alt="Heaplan">
                            </div>
                            <p class="lead">Password Recovery</p>
                        </div>
                        <?php
                            if (isset($error)) {

                                echo '<p class="alert alert-danger"><strong>Error: </strong>'.$error.'</p>';
                            }
                        ?>
                        <div class="card-body">
                            <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div>
                            <form id="forgot_password" method= "POST">
                                <div class="form-group">
                                    <label class="small mb-1" for="forgot_user_email">Email Address: <span>*</span></label>
                                    <input class="form-control" id="forgot_user_email" name="forgot_user_email" type="email" aria-describedby="emailHelp" placeholder="Enter email address" />
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a href="login">Return to login</a>
                                    <button type="submit" class="btn btn-primary" id="forgotPasswordbtn">Reset Password</button>
                                </div>
                            </form>
                        </div>
                        <div class="footer text-center">
                            <!-- <div><a href="register.php">Need an account? Sign up!</a></div> -->
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </body>
        <script src="//code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src='//cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js'></script>
        <script>
         $(document).ready(function() {

        $.validator.addMethod("emailValidation", function(value, element) {
            var email_Regex =/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return this.optional(element) ||  email_Regex.test(value);
        }, "Please enter valid Email");

            $("#forgot_password").validate({
                rules:{
                    forgot_user_email: {
                        required: true,
                        emailValidation : true
                    },
                },
                messages:{
                    forgot_user_email: {
                        required: 'Please enter email id',
                    },
                },
                errorPlacement: function(error, element) {
                    var id = element.attr('id');
                    if (id == 'forgot_user_email') {
                        error.insertAfter($(element).parent());
                    }else{
                        error.insertAfter(element);
                    }
                }
            });
        });
     </script>
</html>
