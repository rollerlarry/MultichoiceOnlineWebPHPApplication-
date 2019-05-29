<?php
include('function/myconnect.php');
include('function/function.php');  
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$string=random_string(20,3);
			$email = $_POST['email'];
			$query_in = "UPDATE tbuser SET reset_password ='{$string}' WHERE email ='{$email}' ";
	        $result_in = mysqli_query($dbc,$query_in);
	        check_query($result_in,$query_in);
	        
            $to = $email;
            $subject = "Click link to get new password. ";
            $message = "http://localhost/ITC/pages/get_password.php?email=$email&code=$string";
            $from = "haoitk38@gmail.com";
            $headers = "From: $from";
            @mail($to,$subject,$message,$headers); 
      	}
	 ?>
<!DOCTYPE html>
<html lang="en" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>
			ITC | Login Page 
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
		<link rel="stylesheet" href="../css/style.css">
	</head>
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
											Forgotten Password ?
										</h3>
										<div class="m-login__desc">
											Enter your email to reset your password 
										</div>
									</div>
									<form class="m-login__form m-form" action="" method="POST">
										<div class="form-group m-form__group">
											<input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
										</div>
										<div class="m-login__form-action">
											<button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
												Request
											</button>
											<a  href="login.php" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">
												Cancel
											</a>
										</div>
									</form>
								</div>
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
