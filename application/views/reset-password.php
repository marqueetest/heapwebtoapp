<?php
    if($_GET["email"]){
        $email = $_GET["email"];
    }else{
        $email = "";
    }
?>
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

		.card .alert-danger, .card .alert-success{
			margin: 5px 20px !important;
		}
        
		label.error {
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
                            <p class="lead">Reset Password</p>
                        </div>
                        <?php
                            if (isset($error)) {

                                echo '<p class="alert alert-danger"><strong>Error: </strong>'.$error.'</p>';
                            }
                        ?>
                        <?php
                            if( $this->session->flashdata("error") ) {
                                ?>
                                <div class="alert alert-danger">
                                    <?php echo $this->session->flashdata("error") ?>
                                </div>
                                <?php
                            }

                            if( $this->session->flashdata("success") ) {
                                ?>
                                <div class="alert alert-success">
                                    <?php echo $this->session->flashdata("success") ?>
                                </div>
                                <?php
                            }
                        ?>
                        <div class="error-block text-danger text-center d-none" style="padding:5px">
                            <span></span>
                        </div>
                        <div class="card-body">
                            <form id="reset_passord" method="POST">
                                <div class="form-group">
                                    <label class="small mb-1" for="change_user_email">Email Address:</label>
                                    <?php if($email != ''){  ?>
                                        <input class="form-control" id="change_user_email" name="change_user_email" type="text" value="<?php echo $email ?>" readonly>
                                    <?php } else { ?>
                                        <input class="form-control" id="change_user_email" name="change_user_email" type="text" value="" readonly>
                                    <?php }  ?>
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="otp">Reset PinCode:</label>
                                    <input type="text" class="form-control" id="change_user_code" name="change_user_code" placeholder="Reset PinCode">
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="chnage_new_password">New Password:</label>
                                    <input type="password" class="form-control" id="chnage_new_password" name="chnage_new_password">
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="chnage_repeat_password">Repeat Password:</label>
                                    <input type="password" class="form-control" id="chnage_repeat_password" name="chnage_repeat_password">
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a href="<?php echo base_url(). "authentication/login" ?>">Return to login</a>
                                    <button type="submit" class="btn btn-primary" id="restPasswordbtn">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
           </div>
        </div>

        <script src="//code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src='//cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js'></script>

        <script>
            $(document).ready(function() {

                $.validator.addMethod("emailValidation", function(value, element) {
                    var email_Regex =/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return this.optional(element) ||  email_Regex.test(value);
                }, "Please enter valid Email");

                $.validator.addMethod("equal_pass", function(value, element) {
                    var password = $("#chnage_new_password").val();
                    if(password != value){
                        return false;
                    }
                    return true;
                }, "Enter repeat password same as password");


                //reset password
                $("#reset_passord").validate({
                    rules:{
                        change_user_code :{
                            required: true,
                        },
                        change_user_email: {
                            required: true,
                            emailValidation : true
                        },
                        chnage_new_password: {
                            required: true,
                        },
                        chnage_repeat_password: {
                            required: true,
                            equal_pass: true
                        },
                        
                    },
                    messages:{
                        change_user_code: "Please enter the otp we sent you on mail",
                        chnage_new_password: {
                            required: 'Please enter new password',
                        },
                        change_user_email: {
                            required: 'Please enter email',
                        },
                        chnage_repeat_password: {
                            required: 'Please enter repeat password',
                            equalTo: 'Enter repeat password same as password'
                        },
                    },
                });
            });
        </script>
    </body>
</html>
