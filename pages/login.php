<?php 
  session_start();
  if (isset($_SESSION['id'])) {
    header('Location: index_for_admin.php');
  }
 include('function/myconnect.php'); 
 include('function/function.php'); 

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $errors = array();
      if (empty($_POST['user'])) {
			$errors[] = 'user';
		}else{
			$user = $_POST['user'];
			if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*[a-z0-9-]+$", $user)){
		        $errors[]='error_user';
		    }
		}
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
					$password = md5($_POST['password']);
				}
		    }
		}
      if (empty($errors)) {
        $query = "SELECT id,user,password,level,online,st FROM tbuser WHERE user = '{$user}' AND password = '{$password}'";
        $result = mysqli_query($dbc,$query);
        check_query($result,$query);
        if ($row = mysqli_fetch_array($result)) {
          if ($row['level'] == 2 && $row['st'] == 2) {
            if ($row['online'] == 0) {
                $id= $row['id'];
                $level =$row['level'];
                $_SESSION['id'] = $id;
                $_SESSION['level'] = $level;
                $_SESSION['online'] = $online;
                header('Location: index_for_admin.php');
                $query_up1 = "UPDATE tbuser
                              SET online=1
                              WHERE id={$id}";
                $result_up1 = mysqli_query($dbc,$query_up1);
                check_query($dbc,$query_up1);
            }else{
                $message_online =1;
            }
          }elseif($row['level'] == 1 && $row['st'] == 2){
            if ($row['online'] == 0) {
                $id= $row['id'];
                $level =$row['level'];
                $_SESSION['id'] = $id;
                $_SESSION['level'] = $level;
                header('Location: test.html');
                $query_up2 = "UPDATE tbuser
                              SET online=1
                              WHERE id={$id}";
                $result_up2 = mysqli_query($dbc,$query_up2);
                check_query($dbc,$query_up2);
            }else{
              $message_online =1;
            }
          }else{
            $message_locked =1;
          }
        }else{
          $message = 1;
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
								<!-- Login -->
								<div class="m-login__signin">
									<div class="m-login__head">
										<h3 class="m-login__title">
											Sign In To Admin
										</h3>
									</div>
									<form class="m-login__form m-form" action="" method="POST">
										<div class="form-group m-form__group">
											<input class="form-control m-input" type="text" placeholder="Username" name="user">
										</div>
										<div style="font-size: 12px;color: red">
			    							<?php  
				    							if (isset($errors) && in_array('user',$errors)) {
				    								echo "*This field is required.";
				    							}
				    							if (isset($errors) && in_array('error_user',$errors)) {
				    								echo "*Username has invalid character.";
				    							}
			    							?>
			    						</div>
										<div class="form-group m-form__group">
											<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password">
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
										<div class="row m-login__form-sub">
											<div class="col m--align-left">
												<label class="m-checkbox m-checkbox--focus">
													<input type="checkbox" name="remember">
													Remember me
													<span></span>
												</label>
											</div>
											<div class="col m--align-right">
												<a href="forget_password.php" class="m-link">
													Forget Password ?
												</a>
											</div>
										</div>
										<div class="m-login__form-action">
											<button  class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
												Sign In
											</button>
										</div>
									</form>
								</div>
							</div>
							<div style="font-size: 14px;color: red;text-align: center;">
							<?php 
						        if (isset($message)) {
						          echo ":( Wrong username or password. Please try again !!! ";
						        }
						        if (isset($message_online)) {
						          echo ":( This account is online. Please try later !!! ";
						        }
						         if (isset($message_locked)) {
						          echo ":( This account is locked. Please try later !!! ";
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
