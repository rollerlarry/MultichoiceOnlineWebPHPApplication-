<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
		$id = $_SESSION['id'];
		//Đổ dữ liệu ra ô
		$query_id = "SELECT avatar,name,birth_day,phone,address,gender,marital_status,primary_occupation,secondary_occupation,skill,main_languages,overview FROM tbuser WHERE id = {$id}";
		$result_id = mysqli_query($dbc,$query_id);
		check_query($result_id,$query_id);
		//Kiểm tra id có tồn tại không
		if (mysqli_num_rows($result_id) == 1) {
			list($avatar,$name,$birth_day,$phone,$address,$gender,$marital_status,$primary_occupation,$secondary_occupation,$skill,$main_languages,$overview) = mysqli_fetch_array($result_id,MYSQLI_NUM);
		}else{
			$message_not_exist =1;
		}
		//
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors = array();
			if (empty($_POST['name'])) {
				$errors[] = 'name';
			}else{
				$name = addslashes($_POST['name']);
			}
			if (empty($_POST['birth_day'])) {
				$errors[] = 'birth_day';
			}else{
			 	$birth_day = $_POST['birth_day'];
			}
			if (empty($_POST['phone'])) {
				$errors[] = 'phone';
			}else{
			 	$phone = addslashes($_POST['phone']);
			}
			if (empty($_POST['address'])) {
				$errors[] = 'address';
			}else{
			 	$address = addslashes($_POST['address']);
			}
			$gender = $_POST['gender'];
			$marital_status = $_POST['marital_status'];
			$primary_occupation = addslashes($_POST['primary_occupation']);
			$skill = addslashes($_POST['skill']);
			$secondary_occupation = addslashes($_POST['secondary_occupation']);
			$main_languages = $_POST['main_languages'];
			$overview = addslashes($_POST['overview']);
			if($_FILES['img']['name'] == NULL){ 
		        $link_img = $avatar;
		     }else{
		     	if (($_FILES['img']['type'] != "image/gif")
		     		&& ($_FILES['img']['type'] != "image/png")
		     		&& ($_FILES['img']['type'] != "image/jpeg")
		     		&& ($_FILES['img']['type'] != "image/jpg")){
		     		$errors[]='type';
		     	}elseif ($_FILES['img']['size']>200000) {
					$errors[]='size';
				}else{
		     		$img=$_FILES['img']['name'];
					$link_img='upload_avatar/'.$img;
					move_uploaded_file($_FILES['img']['tmp_name'],"./upload_avatar/".$img);
		     	}
		     }
			if (empty($errors)) {
				$query_up = "UPDATE tbuser
					SET
						avatar = '{$link_img}',
						name = '{$name}',
						birth_day = '{$birth_day}', 
						phone = '{$phone}',
						address = '{$address}',
						gender = '{$gender}',
						marital_status = '{$marital_status}',
						primary_occupation = '{$primary_occupation}',
						skill = '{$skill}',
						secondary_occupation = '{$secondary_occupation}',
						main_languages = '{$main_languages}',
						overview = '{$overview}'
					WHERE id = {$id}";
				$result_up = mysqli_query($dbc,$query_up);
				check_query($result_up,$query_up);
				if (mysqli_affected_rows($dbc) == 1) {
					?>
						<script type="text/javascript">
							swal("Save Successful!", "This account has been changes!", "success");
						</script>
					<?php
				}else{
					$message_not_successful=1;
				}
			}
		}
 ?>    
    <div id="page-wrapper">
    	<div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong ><li class="fa fa-id-card"></li> My Profile </strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<form class="form-horizontal" name="profile" method="POST" enctype="multipart/form-data">
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
									?>	
								</div>
			    			</div>
		        			<div class="col-md-8 ">
		        				<div class="col-md-2 hidden-xs">
									<img src="<?php echo $avatar; ?>" class="img-responsive img-thumbnail ">
									<p></p>
									<input type="file" name="img" id="imageUpload" class="hide"/> 
									<label for="imageUpload" class="btn btn-default"><li class="fa fa-folder-open"></li> Select file</label>
									<div class="text-color-error">
			    					<?php 
			    						if (isset($errors) && in_array('type',$errors)) {
			    							echo "*The upload file is not valid.";
			    						}
			    						if (isset($errors) && in_array('size',$errors)) {
			    							echo "*Image file is not larger than 2MB.";
			    						}
			    					 ?>
			    					 </div>
								</div>
									<fieldset>
										<legend><strong>Avatar</strong></legend>
											<div class="form-group">
												<label class="col-md-4 control-label"><li class="fa fa-h-square"></li> Name (Full name) *</label>
				  								<div class="col-md-4">
				  									<div class="input-group">
				  										<div class="input-group-addon">
				  											<i class="fa fa-user"></i>
				  										</div>
				  										<input name="name" type="text" placeholder="Name (Full name)" class="form-control input-md" value="<?php echo $name; ?>">
				  									</div>
				  									<div class="text-color-error">
							    					<?php 
							    						if (isset($errors) && in_array('name',$errors)) {
							    							echo "*This field is required.";
							    						}
							    					 ?>
							    					 </div>
				  								</div>
												  	<div class="col-md-4" >
												  		<div class="input-group">
													       	<div class="input-group-addon">
														     <i class="fa fa-birthday-cake"></i>
													       	</div>
													       	<input name="birth_day" type="date" placeholder="d/m/y" class="form-control input-md" value="<?php echo $birth_day; ?>">
												      	</div>
												      	<div class="text-color-error">
								    					<?php 
								    						if (isset($errors) && in_array('birth_day',$errors)) {
								    							echo "*This field is required.";
								    						}
								    					 ?>
								    					 </div>
												  </div>
											</div>
											<div class="form-group">
											   <label class="col-md-4 control-label" for="Temporary Address"><li class="fa fa-map-marker"></li> Address *</label>  
											  <div class="col-md-4">
											  <div class="input-group">
											       <div class="input-group-addon"><i class="fa fa-home" ></i></div>
											 <input  name="address" type="text" placeholder="Address" class="form-control input-md" value="<?php echo $address; ?>">
											      </div>
											      <div class="text-color-error">
							    					<?php 
							    						if (isset($errors) && in_array('address',$errors)) {
							    							echo "*This field is required.";
							    						}
							    					 ?>
							    					 </div>
											 
											    
											  </div>
											  <div class="col-md-4">
											  	<div class="input-group">
											       	<div class="input-group-addon">
											     	<i class="fa fa-phone"></i>
											       	</div>
											    		<input name="phone" type="text" placeholder="Phone number " class="form-control input-md" value="<?php echo $phone; ?>">
											      	</div>
											      	<div class="text-color-error">
							    					<?php 
							    						if (isset($errors) && in_array('phone',$errors)) {
							    							echo "*This field is required.";
							    						}
							    					 ?>
							    					 </div>
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="radios"><li class="fa fa-quora"></li> Marital Status:</label>
											  <div class="col-md-4"> 
											  <?php 
											  	if ($marital_status == "Married") {
											  		?>
													    <div class="funkyradio">
														    <div class="funkyradio-primary">
														        <input type="radio" name="marital_status" value="Married" id="radio3" checked/>
														        <label for="radio3">Married</label>
														    </div>
														    <p></p>
														    <div class="funkyradio-primary">
														        <input type="radio" name="marital_status" value="Unmarried" id="radio4" />
														        <label for="radio4">Unmarried</label>
														    </div>
														</div>
											  		<?php
											  	}else{
											  		?>
														 <div class="funkyradio">
														    <div class="funkyradio-primary">
														        <input type="radio" name="marital_status" value="Married" id="radio3" />
														        <label for="radio3">Married</label>
														    </div>
														    <p></p>
														    <div class="funkyradio-primary">
														        <input type="radio" name="marital_status" value="Unmarried" id="radio4" checked/>
														        <label for="radio4">Unmarried</label>
														    </div>
														</div>
											  		<?php
											  	}
											   ?>
											  </div>

											  <div class="col-md-4">
											  	
											  	
												<?php 
											  	if ($gender == "Male") {
											  		?>
												    <div class="funkyradio">
													    <div class="funkyradio-primary">
													        <input type="radio" name="gender" value="Male" id="radio5" checked/>
													        <label for="radio5"><li class="fa fa-male"></li> Male</label>
													    </div>
													    <p></p>
													    <div class="funkyradio-primary">
													        <input type="radio" name="gender" value="Female" id="radio6" />
													        <label for="radio6"><li class="fa fa-female"></li> Female</label>
													    </div>
													</div>
												    <?php
											  	}else{
											  		?>
											  		<div class="funkyradio">
													    <div class="funkyradio-primary">
													        <input type="radio" name="gender" value="Male" id="radio5" />
													        <label for="radio5"><li class="fa fa-male"></li> Male</label>
													    </div>
													    <p></p>
													    <div class="funkyradio-primary">
													        <input type="radio" name="gender" value="Female" id="radio6" checked/>
													        <label for="radio6"><li class="fa fa-female"></li> Female</label>
													    </div>
													</div>
												    <?php
											  	}
											   ?>
												
												</div>
											</div>
											<hr>
											<div class="form-group">
											  <label class="col-md-4 control-label" for="Primary Occupation">Primary Occupation</label>  
											  <div class="col-md-4">
											  		<div class="input-group">
											       		<div class="input-group-addon">
											    			 <i class="fa fa-briefcase"></i>
										      			</div>
											     			 <input name="primary_occupation" type="text" placeholder="Primary Occupation" class="form-control input-md" value="<?php echo $primary_occupation; ?>">
									      			</div>
											  </div>
											  <div class="col-md-4">
											  	<label class="col-md-4 control-label" >Skills</label>  
											  		<div class="input-group">
											       		<div class="input-group-addon">
											     			<i class="fa fa-graduation-cap"></i>
											       		</div>
											     			<input name="skill" type="text" placeholder="Skills" class="form-control input-md" value="<?php echo $skill; ?>">
											      </div>
											  </div>
											</div>

											<div class="form-group">
											  <label class="col-md-4 control-label" for="Secondary Occupation (if any)">Secondary Occupation (if any)</label>  
											  <div class="col-md-4">
											  <div class="input-group">
											       <div class="input-group-addon">
											      <i class="fa fa-briefcase"></i>
											       </div>
											     <input name="secondary_occupation" type="text" placeholder="Secondary Occupation (if any)" class="form-control input-md" value="<?php echo $secondary_occupation; ?>">
											      </div>
											  </div>
											</div>
											<div class="form-group">
											  <label class="col-md-4 control-label" for="Languages Known"><li class="fa fa-language"></li> Main Languages *</label>
											  <div class="col-md-4">
													<?php 
											  	if ($main_languages == "English") {
											  		?>
											  		<div class="funkyradio">
												    	<div class="funkyradio-primary">
													        <input type="radio" name="main_languages" value="English" id="radio1" checked/>
													        <label for="radio1"><img src="images/United-Kingdom.png"> English</label>
													    </div>
													</div>
													    <p></p>
													<div class="funkyradio">
													    <div class="funkyradio-primary">
													        <input type="radio" name="main_languages" value="VietNamese" id="radio2" />
													        <label for="radio2"><img src="images/Vietnam.png"> VietNamese</label>
													    </div>
													</div>
												    <?php
											  	}else{
											  		?>
											  		<div class="funkyradio">
											  			<div class="funkyradio-primary">
													        <input type="radio" name="main_languages" value="English" id="radio1" />
													        <label for="radio1"><img src="images/United-Kingdom.png"> English</label>
													    </div>
													</div>
													    <p></p>
													<div class="funkyradio">
													    <div class="funkyradio-primary">
													        <input type="radio" name="main_languages" value="VietNamese" id="radio2" checked/>
													        <label for="radio2"><img src="images/Vietnam.png"> VietNamese</label>
													    </div>
													</div>
												    <?php
											  	}
											   ?>
											    
											  </div>
											</div>
											<div class="form-group">
											  <label class="col-md-4 control-label" for="Overview (max 200 words)"><li class="fa fa-stack-overflow"></li> Overview </label>
											  <div class="col-md-8">                     
											    <textarea class="form-control" rows="10" name="overview"><?php echo $overview; ?></textarea>
											  </div>
											</div>
									</fieldset>
							</div>
		        		</div>
		        	</div>
	        	</form>
	        	
	        </div>
	    </div>
    </div>
<?php include('include/footer.php') ?>
