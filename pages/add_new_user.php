<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors =array();
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

		if (empty($_POST['name'])) {
			$errors[] = 'name';
		}else{
			$name = addslashes($_POST['name']);
		}
		if (empty($_POST['email'])) {
			$errors[] = 'email';
		}else{
			$email = $_POST['email'];
			if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)){
		        $errors[]='error_email';
		    }
		}

		$level = $_POST['level'];
		$online = 0;
		$st = $_POST['st'];
		$note=$_POST['note'];
		$avatar = "upload_avatar/default.jpg";
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$join_day=date('d/m/Y');
		if (empty($errors)) {
			$query_user_sl = "SELECT user FROM tbuser WHERE user = '{$user}'";
			$result_user_sl = mysqli_query($dbc,$query_user_sl);
			check_query($result_user_sl,$query_user_sl);
			if (mysqli_num_rows($result_user_sl) == 1) {
				$message_user_exist =1;
			}else{
				$query_in = "INSERT INTO tbuser(user,password,name,email,level,online,st,note,avatar,join_day) VALUES ('{$user}','{$password}','{$name}','{$email}',$level,$online,$st,'{$note}','{$avatar}','{$join_day}')";
				$result_in = mysqli_query($dbc,$query_in);
				check_query($result_in,$query_in);
				if (mysqli_affected_rows($dbc) == 1) {
					?>
					<script type="text/javascript">
						swal("Successful!", "This account has been creacted!", "success");
					</script>
					<?php
				}
			}
		}	
	}
 ?>         
    <div id="page-wrapper">
       <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong><li class="fa fa-user-plus"></li> Add New User</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<form  id="form" name="add_new_user" method="POST">
			    	<div class="panel panel-default">
			    		<div class="panel-heading">
			    			<button type="reset" class="btn btn-primary"><li class="fa fa-repeat"></li> <strong>Reset</strong></button>
	    					<button type="submit" name="submit" class="btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-plus"></li> <strong>Add New User</strong></button>
	    					<a href="import_user.php" class="btn btn-info"><li class="fa fa-download"></li> <strong>Import From Files</strong></a>
			    			<a href="list_user.php" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back List User</strong></a>
			    		</div>
			    		<div class="panel-body">
			    			<div class="col-lg-12">
			    				<?php 
									
									if (isset($message_user_exist)) {
										?>	
											<div class="alert alert-danger">
											  <li class="fa fa-exclamation-triangle"></li><strong> Oh snap!</strong> That username is exist. Try another !!!.
											</div>
										<?php
									}
									if (isset($errors) && in_array('username',$errors) OR isset($errors) && in_array('password',$errors) OR isset($errors) && in_array('name',$errors) OR isset($errors) && in_array('email',$errors)) {
	    								?>
											<div class="alert alert-danger">
											  <li class="fa fa-exclamation-triangle"></li><strong> Oh snap!</strong> Change a few things up and try submitting again. 
											</div>
										<?php
			    					}
								?>	
			    			</div>
			    			<div class="col-lg-12">
			    				<div class="col-lg-6">
				    				<div class="form-group">
				    					<label><li class="fa fa-puzzle-piece"></li> Username</label>
				    					<input type="text" name="user" class="form-control" value="<?php if(isset($user)){echo $user;}?>" >
				    					<div class="text-color-error">
				    					<?php 
				    						if (isset($errors) && in_array('user',$errors)) {
				    							echo "*This field is required.";
				    						}
				    						if (isset($errors) && in_array('error_user',$errors)) {
				    							echo "*Username has invalid character.";
				    						}
				    					 ?>
				    					 </div>
				    				</div>
				    			</div>
								<div class="col-lg-3">
				    				<div class="form-group">
				    					<label><li class="fa fa-lock"></li> Password</label>
				    					<input type="password" name="password" class="form-control">
				    					<div class="text-color-error">
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
				    				</div>
								</div>
								<div class="col-lg-3">
				    				<div class="form-group">
				    					<label><li class="fa fa-check-square-o"></li> Confirm Password</label>
				    					<input type="password" name="confirm_password" class="form-control">
				    					<div class="text-color-error">
				    					<?php 
					    					if (empty($_POST['confirm_password'])) {
					    						if (isset($errors) && in_array('space_confirm_password',$errors)) {
					    							echo "*This field is required.";
					    						}
					    					}else{
					    						if (isset($errors) && in_array('same_confirm_password',$errors)) {
					    							echo "*These passwords don't match. Try again ?.";
					    						}
					    					}
					    				?>
				    					</div>
				    				</div>
								</div>
								<div class="col-lg-6">
				    				<div class="form-group">
				    					<label><li class="fa fa-h-square"></li> Full Name</label>
				    					<input type="text" name="name" class="form-control" value="<?php if(isset($name)){echo $name;}?>">
				    					<div class="text-color-error">
				    					<?php 
				    						if (isset($errors) && in_array('name',$errors)) {
				    							echo "*This field is required.";
				    						}
				    					 ?>
				    					 </div>
				    				</div>
								</div>
								<div class="col-lg-6">
				    				<div class="form-group">
				    					<label><li class="fa fa-envelope"></li> Email</label>
				    					<input type="text" name="email" class="form-control" value="<?php if(isset($email)){echo $email;}?>">
				    					<div class="text-color-error">
				    					<?php 
				    						if (isset($errors) && in_array('email',$errors)) {
				    							echo "*This field is required.";
				    						}
				    						if (isset($errors) && in_array('error_email',$errors)) {
				    							echo "*This email is not valid. Please try email other.";
				    						}
				    					 ?>
				    					 </div>
				    				</div>
								</div>
								<div class="col-lg-2">
				    				<div class="form-group">
				    					<label><li class="fa fa-level-up"></li> Level</label>
				    					<div class="funkyradio">
										    <div class="funkyradio-primary">
										        <input type="radio" name="level" value="1" id="radio1" checked/>
										        <label for="radio1"><li class="fa fa-user"></li> User</label>
										    </div>
										    <div class="funkyradio-primary">
										        <input type="radio" name="level" value="2" id="radio2" />
										        <label for="radio2"><li class="fa fa-user-secret"></li> Administrator</label>
										    </div>
										</div>
				    				</div>
				    			</div>
				    			<div class="col-lg-2">
						        	<div class="form-group">
						        	<label><li class="fa fa fa-share-alt-square"></li> Status</label>
									    <div class="funkyradio">
										    <div class="funkyradio-primary">
										        <input type="radio" name="st" value="2" id="radio3" checked/>
										        <label for="radio3"><li class="glyphicon glyphicon-ok"></li> Active</label>
										    </div>
										    <div class="funkyradio-primary">
										        <input type="radio" name="st" value="1" id="radio4" />
										        <label for="radio4"><li class="glyphicon glyphicon-remove"></li> Inactive</label>
										    </div>
										</div>
									</div>
						        </div>
						        <div class="col-lg-8">
									<div class="form-group">
									<label><li class="fa fa-sticky-note"></li> Notes </label>
										<textarea class="form-control" name="note" rows="4"><?php if (isset($note)){echo $note;} ?></textarea>
									</div>
								</div>
			    			</div>
						</div>
			    	</div>
			    </form>
        	</div>
        </div>
    </div>
<?php include('include/footer.php'); ?>
