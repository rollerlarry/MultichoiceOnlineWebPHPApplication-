<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
	//Kiểm tra id có phải là số không
	if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_rang'=>1))) {
		$id = $_GET['id'];
	}else{
		header('Location: list_post_bank.php');
	}
	//Đổ dữ liệu ra ô
	$query_id = "SELECT title,content FROM tbnotification WHERE id = {$id}";
	$result_id = mysqli_query($dbc,$query_id);
	check_query($result_id,$query_id);
	//Kiểm tra id có tồn tại không
	if (mysqli_num_rows($result_id) == 1) {
		list($title,$content) = mysqli_fetch_array($result_id,MYSQLI_NUM);
	}else{
		$message_not_exist =1;
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
		$errors=array();
		if (empty($_POST['title'])){
			$errors[]='title';
		}else{
			$title=$_POST['title'];
		}
		if (empty($_POST['content'])){
			$errors[]='content';
		}else{
			$content=$_POST['content'];
		}
		if (empty($errors)) {
			$query_up = "UPDATE tbnotification
							SET title = '{$title}',
								content = '{$content}'
							WHERE id = $id";
			$result_up = mysqli_query($dbc,$query_up);
			check_query($result_up,$query_up);
			if (mysqli_affected_rows($dbc) == 1) {
				?>
					<script type="text/javascript">
						swal("Edit Successful!", "This notification has been edit!", "success");
					</script>
				<?php
			}else{
				$message_not_successful = 1;
			}
		}
	}
?>        
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong ><li class="fa fa-pencil-square"></li> Edit Notification</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<form name="send_notification_all_user" method="POST" >
	        		<div class="panel panel-default">
		        		<div class="panel-heading">
		        			<button type="submit" name="submit" class="btn btn-primary" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-save"></li> <strong>Save Changes</strong></button>
		        			<a href="list_notification.php" class="btn btn-danger " ><li class="fa fa-sign-out "></li> <strong>Back List Notification</strong></a>
		        		</div>
		        		<div class="panel-body">
		        			<div class="col-lg-12">
			    				<?php 
			    					if (isset($message_not_successful)) {
										?>
											<div class="alert alert-danger">
											  <li class="fa fa-frown-o"></li><strong> Oops!</strong> You have not changed anything yet !!!.
											</div>
										<?php
									}
									if (isset($errors) && in_array('title',$errors) OR isset($errors) && in_array('content',$errors)) {
	    								?>
											<div class="alert alert-danger">
											  <li class="fa fa-exclamation-triangle"></li><strong> Oh snap!</strong> Change a few things up and try submitting again. 
											</div>
										<?php
			    					}
								?>	
			    			</div>
			    			<div class="col-lg-12">
			        			<div class="form-group">
									<label><li class="fa  fa-text-width"></li> Title</label>
									<input type="text" name="title" class="form-control" placeholder="Title" value="<?php echo $title; ?>">
									<div class="text-color-error">
		    							<?php 
				    						if (isset($errors) && in_array('title',$errors)) {
				    							echo "*This field is required.";
				    						}
				    					?>
		    						</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label><li class="fa fa-book"></li> Content</label>
									<textarea id="content" class="form-control"  name="content" rows="8" ><?php echo $content; ?></textarea>
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
		        </form>
	        </div>
        </div>
    </div>
<?php include('include/footer.php') ?>
