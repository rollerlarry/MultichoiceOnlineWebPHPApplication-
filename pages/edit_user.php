<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
		//Kiểm tra id có phải là số không
		if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_rang'=>1))) {
			$id = $_GET['id'];
		}else{
			header('Location: list_user.php');
		}
		//Đổ dữ liệu ra ô
		$query_id = "SELECT user,email,name,level,st,note FROM tbuser WHERE id = {$id}";
		$result_id = mysqli_query($dbc,$query_id);
		check_query($result_id,$query_id);
		//Kiểm tra id có tồn tại không
		if (mysqli_num_rows($result_id) == 1) {
			list($user,$email,$name,$level,$st,$note) = mysqli_fetch_array($result_id,MYSQLI_NUM);
		}else{
			$message_not_exist =1;
		}
		//Bắt lỗi các ô
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors =array();
  			$password=$_POST['password'];
  			if ($password!=NULL) {
  				if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*[a-z0-9-]+$", $password)){
			        $errors[]='error_password';
			    }else{
			    	$strlen=strlen($password);
					if ($strlen < 6) {
						$errors[]='error_len_password';
					}else{
						$password=md5($_POST['password']);
					}
		    	}
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
			$st = $_POST['st'];
			$note=$_POST['note'];
			if (empty($errors)){
				if (($_POST['password'])==NULL) {
					$query_up = "UPDATE tbuser
						SET 
							email='{$email}',
							name='{$name}',
							level=$level,
							st=$st,
							note='{$note}'
						WHERE id={$id}";
					$result_up = mysqli_query($dbc,$query_up);
					check_query($result_up,$query_up);
					if (mysqli_affected_rows($dbc) == 1) {
						?>
						<script type="text/javascript">
							swal("Edit Successful!", "This account has been edit!", "success");
						</script>
						<?php
					}else{
						$message_not_successful =1;
					}
				}else{
					$query_up = "UPDATE tbuser
						SET password = '{$password}',
							email='{$email}',
							name='{$name}',
							level=$level,
							st=$st,
							note='{$note}'
						WHERE id={$id}";
					$result_up = mysqli_query($dbc,$query_up);
					check_query($result_up,$query_up);
					if (mysqli_affected_rows($dbc) == 1) {
						?>
						<script type="text/javascript">
							swal("Edit Successful!", "This account has been edit!", "success");
						</script>
						<?php
					}else{
						$message_not_successful =1;
					}
				}
			}
		}	
 ?>         
 <div id="page-wrapper">
       <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong><li class="fa fa-pencil-square"></li> Edit User</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<form  id="form" name="add_new_user" method="POST">
			    	<div class="panel panel-default">
			    		<div class="panel-heading">
	    					<button type="submit" name="submit" class="btn btn-primary" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-save"></li> <strong>Save Changes</strong></button>
			    			<a href="list_user.php" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back List User</strong></a>
			    		</div>
			    		<div class="panel-body">
			    			<div class="col-lg-12">
			    				<div class="col-lg-12">
				    				<?php 
										if (isset($message_not_successful)) {
											?>
												<div class="alert alert-danger">
												  <li class="fa fa-frown-o"></li><strong> Oops!</strong> You have not changed anything yet !!!.
												</div>
											<?php
										}
										if (isset($message_email_exist)) {
											?>	
												<div class="alert alert-danger">
												  <li class="fa fa-exclamation-triangle"></li><strong> Oh snap!</strong> That email is taken. Try another !!!.
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
			    			</div>
			    			<div class="col-lg-12">
			    				<div class="col-lg-6">
				    				<div class="form-group">
				    					<label><li class="fa fa-puzzle-piece"></li> Username</label>
				    					<input type="text" name="user" class="form-control" disabled="true" value="<?php if(isset($user)){echo $user;}?>">
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
					    						if (isset($errors) && in_array('same_confirm_password',$errors)) {
					    							echo "*These passwords don't match. Try again ?.";
					    						}
					    					?>
				    					</div>
				    				</div>
								</div>
								<div class="col-lg-6">
				    				<div class="form-group">
				    					<label><li class="fa fa-h-square"></li> Name</label>
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
				    					<?php 
				    						if ($level == 1) {
				    							?>
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
												<?php
				    						}else{
				    							?>
													<div class="funkyradio">
													    <div class="funkyradio-primary">
													        <input type="radio" name="level" value="1" id="radio1" />
													        <label for="radio1"><li class="fa fa-user"></li> User</label>
													    </div>
													    <div class="funkyradio-primary">
													        <input type="radio" name="level" value="2" id="radio2" checked/>
													        <label for="radio2"><li class="fa fa-user-secret"></li> Administrator</label>
													    </div>
													</div>
				    							<?php
				    						}
				    					 ?>
				    				</div>
				    			</div>
				    			<div class="col-lg-2">
						        	<div class="form-group">
						        	<label><li class="fa fa fa-share-alt-square"></li> Status</label>
						        	<?php 
				    						if ($st == 2) {
				    							?>
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
												<?php
				    						}else{
				    							?>
													<div class="funkyradio">
													    <div class="funkyradio-primary">
													        <input type="radio" name="st" value="2" id="radio3" />
													        <label for="radio3"><li class="glyphicon glyphicon-ok"></li> Active</label>
													    </div>
													    <div class="funkyradio-primary">
													        <input type="radio" name="st" value="1" id="radio4" checked/>
													        <label for="radio4"><li class="glyphicon glyphicon-remove"></li> Inactive</label>
													    </div>
													</div>	
												<?php
				    						}
				    					 ?>
									</div>
						        </div>
						        <div class="col-lg-8">
									<div class="form-group">
									<label><li class="fa fa-sticky-note"></li> Note </label>
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
<?php include('include/footer.php') ?>
