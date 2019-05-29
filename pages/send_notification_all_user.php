<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
	if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
		$errors=array();
		if (empty($_POST['title'])){
			$errors[]='title';
		}else{
			$title=addslashes($_POST['title']);
		}
		if (empty($_POST['content'])){
			$errors[]='content';
		}else{
			$content=addslashes($_POST['content']);
		}
		if (empty($_POST['send_notification'])){
			$errors[]='send_notification';
		}else{
			$send=addslashes($_POST['send_notification']);
		}
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$send_time=date('g:i A');
		$send_day=$_POST['send_day'];
		if (empty($errors)) {
			if ($send == 2) {

				$query_co="SELECT COUNT(id) FROM tbuser WHERE level=1";
				$result_co=mysqli_query($dbc,$query_co);
				check_query($result_co,$query_co);
				list($count_id)=mysqli_fetch_array($result_co,MYSQLI_NUM);
				$id_user=array();
				$count=0;
				while ( $count < $count_id) {
					$query_sl_id="SELECT id FROM tbuser WHERE level=1 ORDER BY RAND() ";
					$result_sl_id=mysqli_query($dbc,$query_sl_id);
					check_query($result_sl_id,$query_sl_id);
					$rows=mysqli_fetch_array($result_sl_id);
					if (in_array($rows['id'],$id_user)) {
						$count=$count+0;
					}else{
						$id_user[]=$rows['id'];
						$count++;
					}
				}
				foreach ($id_user as $v) {
					$query_sl_n="SELECT name FROM tbuser WHERE id=$v";
					$result_sl_n=mysqli_query($dbc,$query_sl_n);
					check_query($result_sl_n,$query_sl_n);
					$rows=mysqli_fetch_array($result_sl_n);
					$receiver=$rows['name'];
					$query ="INSERT INTO tbnotification(id_user,title,content,receiver,send_time,send_day) VALUES ($v,'{$title}','{$content}','{$receiver}','{$send_time}','{$send_day}')"; 
					$result = mysqli_query($dbc,$query);
					check_query($result,$query);
					if (mysqli_affected_rows($dbc) == 1) {
							?>
							<script type="text/javascript">
							         swal("Successful!", "This exam has been creacted!", "success");
							</script>
							<?php
					}else{
						$message_not_successful =1;
					}
				}
			}else{
				if (empty($_POST['user'])) {
					$errors[]='user';
				}else{
					$name_user = addslashes($_POST['user']);
				}
				if (empty($_POST['send_notification'])) {
					$errors[]='send';
				}else{
					$send = $_POST['send_notification'];
				}
				if (empty($errors)) {
					$query_sl = "SELECT id,name FROM tbuser WHERE user = '{$name_user}'";
					$result_sl = mysqli_query($dbc,$query_sl);
					check_query($result_sl,$query_sl);
					$rows=mysqli_fetch_array($result_sl);
					$id_user = $rows['id'];
					$receiver = $rows['name'];
					$query ="INSERT INTO tbnotification(id_user,title,content,receiver,send_time,send_day) VALUES ($id_user,'{$title}','{$content}','{$receiver}','{$send_time}','{$send_day}')"; 
					$result = mysqli_query($dbc,$query);
						check_query($result,$query);
					if (mysqli_affected_rows($dbc)==1) {
						?>
							<script type="text/javascript">
								swal("Send Successful!", "This notification has been send to <?php echo $receiver; ?>", "success");
							</script>
						<?php
					}else{
						$message_not_successful = 1;
					}
				}
			}
		}
	}
?>        
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong ><li class="fa fa-paper-plane"></li></li> Send Notification</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<form name="send_notification_all_user" method="POST" >
	        		<div class="panel panel-default">
		        		<div class="panel-heading">
		        			<button type="reset" class="btn btn-primary"><li class="fa fa-repeat"></li> <strong>Reset</strong></button>
		        			<button type="submit" name="submit" class="btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-paper-plane"></li> <strong> Send Notification</strong></button>
		        			<a href="list_notification.php" class="btn btn-danger " ><li class="fa fa-sign-out "></li> <strong>Back List Notification </strong></a>
		        		</div>
		        		<div class="panel-body">
		        			<div class="col-lg-12">
		    					<div class="col-lg-12">
				    				<?php 
										if (isset($errors) && in_array('title',$errors) OR isset($errors) && in_array('content',$errors)) {
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
										<label><li class="fa  fa-text-width"></li> Title</label>
										<input type="text" name="title" class="form-control" placeholder="Title" value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">
										<div class="text-color-error">
			    							<?php 
					    						if (isset($errors) && in_array('title',$errors)) {
					    							echo "*This field is required.";
					    						}
					    					?>
			    						</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
						        	<label><li class="fa fa-paper-plane"></li> Send All User</label>
									    <div class="funkyradio">
										    <div class="funkyradio-primary">
										        <input type="radio" name="send_notification" value="2" id="radio5" />
										        <label for="radio5">All </label>
										        <div class="text-color-error">
				    							<?php 
						    						if (isset($errors) && in_array('send_notification',$errors)) {
						    							echo "*This field is required.";
						    						}
						    					?>
				    							</div>
										    </div>
										</div>
									</div>
								</div>

								<div class="col-lg-2">
									<div class="form-group">
						        	<label><li class="fa fa-paper-plane"></li> Send One </label>
									    <div class="funkyradio">
										    <div class="funkyradio-primary">
										        <input type="radio" name="send_notification" value="1" id="radio4" />
										        <label for="radio4">One</label>
										    </div>
										    <div class="text-color-error">
				    							<?php 
						    						if (isset($errors) && in_array('send_notification',$errors)) {
						    							echo "*This field is required.";
						    						}
						    					?>
				    							</div>
										    <div class="text-color-error">
			    							<?php 
					    						if (isset($errors) && in_array('send',$errors)) {
					    							echo "*This field is required.";
					    						}
					    					 ?>
			    							</div>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
						        	<label><small>Enter user if you choose send one.</small> </label>
									    <input type="text" name="user" class="form-control" placeholder="Username of the recipient" value="<?php if(isset($name_user)){echo $name_user;}?>">
										    <div class="text-color-error">
			    							<?php 
					    						if (isset($errors) && in_array('user',$errors)) {
					    							echo "*This field is required.";
					    						}
					    					 ?>
			    							</div>
			    							<div class="text-color-error">
				    							<?php 
						    						if (isset($errors) && in_array('send_notification',$errors)) {
						    							echo "*This field is required.";
						    						}
						    					?>
			    							</div>
									</div>
								</div>
								</div>
							<div class="col-lg-12">
								<div class="col-lg-12">
									<div class="form-group">
										<label><li class="fa fa-book"></li> Content</label>
										<textarea id="content" class="form-control"  name="content" rows="8" ><?php if(isset($_POST['content'])){echo $_POST['content'];} ?></textarea>
										<div class="text-color-error">
			    							<?php 
					    						if (isset($errors) && in_array('content',$errors)) {
					    							echo "*This field is required.";
					    						}
					    					 ?>
			    						</div>
									</div>
								</div>
							</div>
		        		</div>
		        		<input id="datepicker" data-date-format="dd-mm-yyyy" class="form-control" readonly="true" type="hidden" name="send_day" > 
		        	</div>
		        </form>
	        </div>
        </div>
    </div>
<?php include('include/footer.php') ?>
