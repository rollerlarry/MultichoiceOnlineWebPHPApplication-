<?php
include('function/myconnect.php');
include('function/function.php');  
	if (isset($_GET['email'])){
		$email = $_GET['email'];
		$code=$_GET['code'];
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (empty($_POST['password'])) {
			$errors[] = 'password';
		}else{
			$password = $_POST['password'];
			if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*[a-z0-9-]+$", $password)){
		        $errors[]='error_password';
		    }else{
		    	$strlen=strlen($password);
				if ($strlen < 6) {
					$errors[]='error_len_password';
				}else{
					$password = $_POST['password'];
				}
		    }
		}
		if (empty($_POST['confirm_password'])) {
			$errors[] = 'space_confirm_password';
		}else{
			$password = md5($_POST['confirm_password']);
		}

		if (($_POST['password']) != ($_POST['confirm_password'])){
  			$errors[]='same_confirm_password';
  		}
  		if (empty($errors)) {
  			$query_sl = "SELECT reset_password FROM tbuser WHERE email = '{$email}'";
			$result_sl = mysqli_query($dbc,$query_sl);
			check_query($result_sl,$query_sl);
			list($code_sl)=mysqli_fetch_array($result_sl,MYSQLI_NUM);
			if ($code_sl == $code) {
				$query_up = "UPDATE tbuser
							SET password = '{$password}'
							WHERE email = '{$email}'";
				$result_up = mysqli_query($dbc,$query_up);
				check_query($result_up,$query_up);
				$message_successful = 1;
			}
  		}
	}

 ?>
<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
			ITC | Get Password 
		</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->
		<!--begin::Base Styles -->
		<link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="assets/demo/default/media/img/logo/favicon.ico" />
	</head>
	<!-- end::Head -->
	<!-- end::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile 		m-login m-login--1 m-login--singin" id="m_login">
				<div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
					<div class="m-stack m-stack--hor m-stack--desktop">
						<div class="m-stack__item m-stack__item--fluid">
							<div class="m-login__wrapper">
								<div class="m-login__logo">
									<a href="#">
										<img src="assets/app/media/img//logos/logo-2.png">
									</a>
								</div>
								<div class="m-login__signin">
									<div class="m-login__head">
										<h3 class="m-login__title">
											Get Password 
										</h3>
										<div class="m-login__desc">
											Enter your new password to get your account
										</div>
									</div>
									<form class="m-login__form m-form" action="" method="POST">
										<div class="form-group m-form__group">
											<input class="form-control m-input" type="password" placeholder="Password" name="password">
										</div>
										<div style="font-size: 12px;color: red">
				    					<?php 
				    						if (isset($errors) && in_array('password',$errors)) {
				    							echo "*This field is required.";
				    						}
				    						if (isset($errors) && in_array('error_password',$errors)) {
				    							echo "*Password has invalid character.";
				    						}
				    						if (isset($errors) && in_array('error_len_password',$errors)) {
				    							echo "*Requires password more than 6 characters.";
				    						}
				    					 ?>
				    					 </div>
										<div class="form-group m-form__group">
											<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="confirm_password">
										</div>
										<div style="font-size: 12px;color: red">
				    					<?php 
					    					if (empty($_POST['confirm_password'])) {
					    						if (isset($errors) && in_array('confirm_password',$errors)) {
					    							echo "*This field is required.";
					    						}
					    					}else{
					    						if (isset($errors) && in_array('same_confirm_password',$errors)) {
					    							echo "*These passwords don't match. Try again ?.";
					    						}
					    					}
					    					?>
				    					</div>
										<div class="m-login__form-action">
											<button  class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
												Get
											</button>
											<a  href="login.php" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">
												Cancel
											</a>
										</div>
									</form>
								</div>
							</div>
							<div style="font-size: 14px;color: green;text-align: center;">
								<?php 
									if (isset($message_successful)) {
										echo ":) Change password successful.";?><a href="login.php"> Login Now</a><?php
									}
								 ?>
							</div>
						</div>
					</div>
				</div>
				<div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url(assets/app/media/img//bg/bg-4.jpg)">
					<div class="m-grid__item m-grid__item--middle">
						<h3 class="m-login__welcome">
							Join Our Application
						</h3>
						<p class="m-login__msg">
							Nothing in education is so astonishing as the amount of ignorance it accumulates in the form of inert facts.
							<br>
							It’s how you deal with failure that determines how you achieve success.
						</p>
					</div>
				</div>
			</div>
		</div>
		<!-- end:: Page -->
		<!--begin::Base Scripts -->
		<script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Base Scripts -->
		<!--begin::Page Snippets -->
		<script src="assets/snippets/pages/user/login.js" type="text/javascript"></script>
		<!--end::Page Snippets -->
	</body>
	<!-- end::Body -->
</html>
