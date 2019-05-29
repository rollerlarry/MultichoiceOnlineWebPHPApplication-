<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
	$query_id = "SELECT user FROM tbuser WHERE id = {$id}";
	$result_id = mysqli_query($dbc,$query_id);
	check_query($result_id,$query_id);
	$rows=mysqli_fetch_array($result_id);
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors = array();
		if (empty($_POST['old_password'])) {
			$errors[] = 'old_password';
		}else{
			$old_password = $_POST['old_password'];
			if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*[a-z0-9-]+$", $old_password)){
		        $errors[]='error_old_password';
		    }else{
		    	$strlen=strlen($old_password);
				if ($strlen < 6) {
					$errors[]='error_len_old_password';
				}else{
					$old_password = $_POST['old_password'];
				}
		    }
		}

		if (empty($_POST['new_password'])) {
			$errors[] = 'new_password';
		}else{
			$new_password = $_POST['new_password'];
			if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*[a-z0-9-]+$", $new_password)){
		        $errors[]='error_new_password';
		    }else{
		    	$strlen=strlen($new_password);
				if ($strlen < 6) {
					$errors[]='error_len_new_password';
				}else{
					$new_password = $_POST['new_password'];
				}
		    }
		}
		if (empty($_POST['confirm_password'])) {
			$errors[] = 'confirm_password';
		}else{
			$password = md5($_POST['confirm_password']);
		}

		if (($_POST['new_password']) != ($_POST['confirm_password'])){
  			$errors[]='same_confirm_password';
  		}
  		if (empty($errors)) {
  			$id=$_SESSION['id'];
			$query = "SELECT id,user,password FROM tbuser WHERE password = '{$old_password}' AND id = $id";
			$result = mysqli_query($dbc,$query);
			check_query($result,$query);
			if (mysqli_num_rows($result) == 1) {
				if (trim($_POST['new_password']) != trim($_POST['confirm_password'])) {
					$message_not_same = 1;
				}else{
					$query_up = "UPDATE tbuser
								SET password = (trim('$new_password'))
								WHERE id = $id";
					$result_up = mysqli_query($dbc,$query_up);
					check_query($result_up,$query_up);
					if (mysqli_affected_rows($dbc) == 1) {
						?>
						<script type="text/javascript">
							swal("Changes Successful!", "This password has been changes !", "success");
						</script>
						<?php
					}
				}
			}else{
				$message_wrong_oldpassword =1;
			}
  		}
	}
 ?>           
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong><li class="fa fa-refresh"></li> Change Password</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<form name="change_password_admin" method="POST">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
					<div class="panel-heading">
						<button type="submit" name="submit" class="btn btn-primary" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-save"></li> <strong>Save Changes</strong></button>
						<a href="index_for_admin.php" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back Home</strong></a>
					</div>
					<div class="panel-body">
			    			<div class="col-md-6 col-md-offset-3">
			    				<div class="col-lg-12">
				    				<?php 
										if (isset($errors) && in_array('old_password',$errors) OR isset($errors) && in_array('new_password',$errors) OR isset($errors) && in_array('confirm_password',$errors)) {
		    								?>
												<div class="alert alert-danger">
												  <li class="fa fa-exclamation-triangle"></li><strong> Oh snap!</strong> Change a few things up and try submitting again. 
												</div>
											<?php
				    					}
									?>	
				    			</div>
			    				<div class="col-lg-4">
				    				<div class="form-group">
				    					<label><li class="fa fa-puzzle-piece"></li> Username</label>
				    					<input type="text" name="user" class="form-control" disabled="true" value="<?php echo $rows['user']; ?>">
				    				</div>
				    			</div>
				    			<div class="col-lg-8">
				    				<div class="form-group">
				    					<label><li class="fa fa-unlock-alt"></li> Old Password</label>
				    					<input type="password" name="old_password" class="form-control" >
				    					<div class="text-color-error">
				    					<?php 
				    						if (isset($errors) && in_array('old_password',$errors)) {
				    							echo "*This field is required.";
				    						}
				    						if (isset($message_wrong_oldpassword)) {
				    							echo "*Wrong old password .Try again !!!";
				    						}
				    						if (isset($errors) && in_array('error_old_password',$errors)) {
				    							echo "*Old Password has invalid character.";
				    						}
				    						if (isset($errors) && in_array('error_len_old_password',$errors)) {
				    							echo "*Requires old password more than 6 characters.";
				    						}
				    					 ?>
				    					 </div>
				    				</div>
				    			</div>
				    			<div class="col-lg-6">
				    				<div class="form-group">
				    					<label><li class="fa fa-lock"></li> New Password</label>
				    					<input type="password" name="new_password" class="form-control" >
				    					<div class="text-color-error">
				    					<?php 
				    						if (isset($errors) && in_array('new_password',$errors)) {
				    							echo "*This field is required.";
				    						}
				    						if (isset($errors) && in_array('error_new_password',$errors)) {
				    							echo "*New password has invalid character.";
				    						}
				    						if (isset($errors) && in_array('error_len_new_password',$errors)) {
				    							echo "*Requires old password more than 6 characters.";
				    						}
				    					 ?>
				    					 </div>
				    				</div>
								</div>
								<div class="col-lg-6">
				    				<div class="form-group">
				    					<label><li class="fa fa-check-square-o"></li> Confirm Password</label>
				    					<input type="password" name="confirm_password" class="form-control" >
				    					<div class="text-color-error">
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
				    				</div>
								</div>
			    			</div>
						</div>  
					</div>     		
	        	</div>
	        </div>
        </form>
    </div>
<?php include('include/footer.php') ?>
