<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
	//Kiểm tra id có phải là số không
	if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_rang'=>1))) {
		$id = $_GET['id'];
	}else{
		header('Location: list_question_bank.php');
	}
	$query_id = "SELECT name FROM tbuser WHERE id = $id";
		$result_id = mysqli_query($dbc,$query_id);
		check_query($result_id,$query_id);
		$rows = mysqli_fetch_array($result_id);

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
		$receiver=$_POST['receiver'];
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$send_time=date('g:i A');
		$send_day=date('d-m-Y');			
		if (empty($errors)) {
			$query ="INSERT INTO tbnotification(send_time,send_day,title,content,receiver,id_user) VALUES ('{$send_time}','{$send_day}','{$title}','{$content}','{$receiver}',$id)"; 
			$result = mysqli_query($dbc,$query);
				check_query($result,$query);
			if (mysqli_affected_rows($dbc)==1) {
				?>
					<script type="text/javascript">
						swal("Send Successful!", "This notification has been send to <?php echo $receiver; ?>", "success");
					</script>
				<?php
			}
		}
	}
?>
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong ><li class="fa fa-paper-plane"></li> Send Notification</strong></h1>
        	</div>
        </div>
    	<div class="row">
    		<div class="col-lg-12">
    			<form name="send_notification" method="POST" >
	    			<div class="panel panel-default">
	    				<div class="panel-heading">
	    					<button type="reset" class="btn btn-primary"><li class="fa fa-repeat"></li> <strong>Reset</strong></button>
	    					<button type="submit" name="submit" class="btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-paper-plane"></li> <strong>Send Notification</strong></button>
	    					<a href="list_user.php" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back List User</strong></a>
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
										<label><li class="fa  fa-text-width"></li> Title </label>
										<input type="text" name="title" class="form-control" placeholder="Title" value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">
										<div class="text-color-error">
			    							<?php  if (isset($errors) && in_array('title',$errors)) {
			    								echo "*Enter notification title !!!";
			    							}?>
			    						</div>
									</div>
			    				</div>
			    				<div class="col-lg-6">
			    					<div class="form-group">
										<label><li class="fa fa-user"></li> Receiver</label>
										<input type="text" name="receiver" class="form-control" readonly="true"value="<?php echo $rows['name']; ?>">
									</div>
			    				</div>
			    				<div class="col-lg-12">
									<div class="form-group">
										<label><li class="fa fa-book"></li> Content</label>
										<textarea id="content" class="form-control"  name="content" rows="8" ><?php if(isset($_POST['content'])){echo $_POST['content'];} ?></textarea>
										<div class="text-color-error">
			    							<?php  if (isset($errors) && in_array('content',$errors)) {
			    								echo "*Enter notification content !!!";
			    							}?>
			    						</div>
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
