<!DOCTYPE html>
<html lang="en">


<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
	.logohead {
		text-align: center;
		margin-top: 5px;
	}

	#logohead {

		color: #75A8F9;
		font-weight: bold;
	}
	.login-fields input {
    border: 0px !important;
    font-family: 'Open Sans';
    font-size: 13px;
    color: #8e8d8d;
    padding: 11px 15px 10px 50px;
    background-color: #fdfdfd !important;
    width: 100%;
    display: block;
    margin: 0;
    /* box-shadow: inset 2px 2px 4px #f1f1f1; */
	}
	.logorow {
		margin: 0px !important;
	}

	.p-sm-5 {
		padding-bottom: 0px !important;
	}

	.btn-primary {
		background-color: #FF9822 !important;
		border-color: #FF9822 !important;
	}

	.card-title {
		font-weight: bold !important;
		font-size: 25px;
		color: whitesmoke;
	}

	.mb-5 {
		margin: 0px !important;
	}

	#bvglogo {
		margin-top: 5px;
		margin-left: 60%;
		height: 50px;
		width: 50px;
		right: -20px;
	}

	#sperologo {
		margin-top: 10px;
		height: 50px;
		width: 80px;
	}

	body,
	html {
		height: 100%;
	}

	#background {
		background-image: url("./public/img/new/unity_back.jpg");
		background-size: 100% 100%;
		height: 100%;
		background-position: center;
		background-repeat: no-repeat;
		/*background-size: contain;*/
		overflow: hidden;
		padding: 30px;
	}

	.card-body {
		background-color: #75A8F9 !important;
		border-top-right-radius: 10px;
		border-top-left-radius: 10px;
	
	}
	.card{
		border-radius: 10px;
	}

</style>

<meta charset="utf-8">
<title>Assisted Living</title>

<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
     <meta content="Live Demo Assisted Living,HMS is designed for medical practitioners and health-related institutions to assistant them in storing and keeping track of all correlated information such as patient medical records, admission/discharge reports, pharmaceutical management, billing and report generation and more. " name="description">
	 <meta content="free live demo hms,free live demo Assisted Living,live demo,demo,live,Assisted Living live demo,Assisted Living free source codes,source codes,php,mysql,codeigniter,mvc,php frameworks,Assisted Living,hospital,management,system,solution,online demo,demo Assisted Living,live demo,demo trial,trial,hospital solution,clinic management system,clinic solution,management system,system,online management system" name="keywords">
	  <meta content="Jayson Sarino" name="author">

	  <meta property="og:site_name" content="Assisted Living Free Trial Demo">
	  <meta property="og:title" content="Assisted Living">
	  <meta property="og:description" content="Live Demo Assisted Living,HMS is designed for medical practitioners and health-related institutions to assistant them in storing and keeping track of all correlated information such as patient medical records, admission/discharge reports, pharmaceutical management, billing and report generation and more.">
	  <meta property="og:type" content="website">
	  <meta property="og:image" content="http://hms-demo.jaysonsarino.com/public/img/new/hms_logo.png"><!-- link to image for socio -->
<!-- <meta property="og:url" content="http://hms-demo.jaysonsarino.com/"> -->
<!-- 
		<link href="<?php echo base_url() ?>public/login/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>public/login/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" /> -->

<link href="<?php echo base_url() ?>public/login/css/font-awesome.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

<link href="<?php echo base_url() ?>public/login/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url() ?>public/login/css/pages/signin.css" rel="stylesheet" type="text/css">






<body id="background">
	<script src="<?php echo base_url() ?>public/login/js/jquery-1.7.2.min.js"></script>
	<script language="javascript">
		$(document).ready(function() {

		});
	</script>

	<div class="container">
		<div class="row">
			<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
				<div class="card border-0 shadow rounded-3 my-5">
					<div class="card-body p-4 p-sm-5">
						<h1 class="card-title text-center mb-5 fw-light fs-5">Book Your Cab Now</h1>

						<form action="<?php echo base_url() ?>login/validate_login" method="post" id="frmLogin" name="frmLogin">
							<div class="form-floating mb-3">
								<!-- <h1>Login</h1> -->
								<div class="login-details">

									<div class="login-fields">

										<!-- <p>Please provide your details</p> -->
										<br>
										<?php echo validation_errors(); ?>

										<?php

										if (isset($usernamelogin)) {
											$usernamelogin = $usernamelogin;
										} else {
											$usernamelogin = "";
										}

										if (isset($passwordlogin)) {
											$passwordlogin = $passwordlogin;
										} else {
											$passwordlogin = "";
										}

										?>



										<div class="field">
											<label for="username">Username</label>

											<?php
											echo form_input("username", $usernamelogin, "class='login username-field' placeholder='Username' required");
											?>
										</div>
										<!-- /field -->

										<div class="field">
											<label for="password">Password:</label>
											<input type="password" name="password" class="login password-field" placeholder="Password" required value="<?php echo $passwordlogin; ?>" />
										</div> <!-- /password -->
										<div class="login-actions">
											<button class="button btn btn-primary btn-large">Log In</button>
										</div>
									</div>
								</div>
							</div>


						</form>
					</div>
					<div class="card-body2 ">
						<div class="row logorow">
							<div class="col-md-12 logohead">
								<label id="logohead"> Powered By</label>
							</div>
							<div class="col-md-6">
								<img id="bvglogo" src="<?php echo base_url('/public/img/new/bvglogo.png'); ?>" />
							</div>
							<div class="col-md-6">
								<img id="sperologo" src="<?php echo base_url('/public/img/new/sperologo.png'); ?>" />

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>





</html>