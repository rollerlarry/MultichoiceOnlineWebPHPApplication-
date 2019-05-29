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
		if (empty($_POST['summary'])){
			$errors[]='summary';
		}else{
			$summary=addslashes($_POST['summary']);
		}
		if (empty($_POST['content'])){
			$errors[]='content';
		}else{
			$content=addslashes($_POST['content']);
		}
		$post_time=$_POST['post_time'];
		$post_day=explode("-",$_POST['post_day']);
		$post_day_in=$post_day[0].'-'.$post_day[1].'-'.$post_day[2];
		$poster = $_POST['poster'];
		$who = $_POST['who'];
		if($_FILES['img']['name'] == NULL){ 
	        $link_img ='upload/default.jpg';
	     }else{
	     	if (($_FILES['img']['type'] != "image/gif")
	     		&& ($_FILES['img']['type'] != "image/png")
	     		&& ($_FILES['img']['type'] != "image/jpeg")
	     		&& ($_FILES['img']['type'] != "image/jpg")){
	     		$errors[]='type';
	     	}elseif ($_FILES['img']['size']>2000000) {
				$errors[]='size';
			}else{
	     		$img=$_FILES['img']['name'];
				$link_img='upload_avatar/'.$img;
				move_uploaded_file($_FILES['img']['tmp_name'],"./upload/".$img);
	     	}
	     }
		$st = $_POST['st'];
		$hashtag = addslashes($_POST['hashtag']);
		if (empty($errors)) {
			$query ="INSERT INTO tbpost(title,avatar,summary,content,post_day,post_time,poster,who,st,hashtag) VALUES ('{$title}','{$link_img}','{$summary}','{$content}','{$post_day_in}','{$post_time}','{$poster}','${who}','{$st}','{$hashtag}')"; 
			$result = mysqli_query($dbc,$query);
			check_query($result,$query);
			if (mysqli_affected_rows($dbc)==1) {
				?>
					<script type="text/javascript">
						swal("Successful!", "This post has been creacted!", "success");
					</script>
				<?php
			}
		}
	}
?>
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong ><li class="fa fa-file-text-o"></li> Add New Post</strong></h1>
        	</div>
        </div>
    	<div class="row">
    		<div class="col-lg-12">
    			<form name="add_new_post" method="POST" enctype="multipart/form-data">
	    			<div class="panel panel-default">
	    				<div class="panel-heading">
	    					<button type="reset" class="btn btn-primary"><li class="fa fa-repeat"></li> <strong>Reset</strong></button>
	    					<button type="submit" name="submit" class="btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-pencil"></li> <strong>Add New Post</strong></button>
	    					<a href="list_post.php" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back List Post</strong></a>
	    				</div>
	    				<div class="panel-body">
	    					<div class="col-lg-12">
					    		<?php 
									if (isset($errors) && in_array('title',$errors) OR isset($errors) && in_array('summary',$errors) OR isset($errors) && in_array('content',$errors)) {
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
									<input type="text" name="title" class="form-control" value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">
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
									<label><li class="fa fa-sticky-note"></li> Summary </label>
									<textarea class="form-control" name="summary" rows="3" ><?php if(isset($_POST['summary'])){echo $_POST['summary'];} ?></textarea>
									<div class="text-color-error">
		    							<?php  
			    							if (isset($errors) && in_array('summary',$errors)) {
			    								echo "*This field is required.";
			    							}
		    							?>
		    						</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label><li class="fa fa-book"></li> Content</label>
									<textarea id="content" class="form-control"  name="content" rows="10" placeholder="Post content" ><?php if(isset($_POST['content'])){echo $_POST['content'];} ?></textarea>
									<div class="text-color-error">
		    							<?php  
			    							if (isset($errors) && in_array('content',$errors)) {
			    								echo "*This field is required.";
			    							}
		    							?>
		    						</div>
								</div>
							</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label><li class="fa fa-clock-o"></li> Post Time</label>
										<?php
											date_default_timezone_set('Asia/Ho_Chi_Minh');
											$time_today=date('g:i A');
										?>
										<input type="text" name="post_time" class="form-control" value="<?php echo $time_today; ?>">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label><li class="fa fa-calendar"></li> Post Day</label>
										<div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy"> 
											<input class="form-control" readonly="true" type="text" name="post_day"> 
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-calendar"></i>
											</span> 
										</div>
									</div>
								</div>
								<?php 
									$id = $_SESSION['id'];
									$query_sl = "SELECT name FROM tbuser WHERE id=$id";
									$result_sl = mysqli_query($dbc,$query_sl);
									check_query($result_sl,$query_sl);
									$name = mysqli_fetch_array($result_sl);
								 ?>
								<div class="col-lg-4">
									<div class="form-group">
								        <label><li class="fa fa-user"></li> Poster </label>
								        <div>
								            <select class="form-control" name="poster">
								                <option value="<?php echo $name['name']?>"><?php echo $name['name']?></option>
								                <option value="Anonymous">Anonymous</option>
								            </select>
								        </div>
								    </div>
								</div>

							    <div class="col-lg-4">
							    	<div class="form-group">
							        <label><li class="fa fa-street-view"></li> Who will see this content ? </label>
							        <div>
							            <select class="form-control" name="who">
							                <option value="Public">Public</option>
							                <option value="Only me">Only me</option>
							            </select>
							        </div>
							        </div>
						        </div>
						        <div class="col-lg-4">
									<div class="form-group">
							          	<label><li class="fa fa-picture-o"></li> Post avatar </label>
							         	<div class="input-group">
							            	<input type="text" name="filename" class="form-control" placeholder="No file selected" readonly >
							            		<span class="input-group-btn">
							              			<div style="position: relative;" class="btn btn-default  custom-file-uploader">
							                			<input style="display: block;position: absolute;top: 0;right: 0;bottom: 0;left: 0;opacity: 0;" type="file" name="img" onchange="this.form.filename.value = this.files[0].name" />
							                			<li class="fa fa-file-excel-o"></li> <strong>Select a file</strong>
							              			</div>
							              	
							           			</span>
							         	</div>
							          	<div class="text-color-error">
			    							<?php
				    							if (isset($errors) && in_array('file',$errors)) {
				    								echo "*Please choose a file.";
				    							}
				    							if (isset($errors) && in_array('type',$errors)) {
					    							echo "*The image file is not valid.";
					    						}
					    						if (isset($errors) && in_array('size',$errors)) {
					    							echo "*Image file is not larger than 2MB.";
					    						}
			    							?>
			    						</div>
							        </div>
						       	</div>
						       	<div class="col-lg-2">
						        	<div class="form-group">
						        	<label><li class="fa fa-share-alt-square"></li> Status</label>
									    <div class="funkyradio">
										    <div class="funkyradio-primary">
										        <input type="radio" name="st" value="Display" id="radio2" checked/>
										        <label for="radio2"><li class="glyphicon glyphicon-eye-open"></li> Display</label>
										    </div>
										    <div class="funkyradio-primary">
										        <input type="radio" name="st" value="Not Display" id="radio3" />
										        <label for="radio3"><li class="glyphicon glyphicon-eye-close"></li> Not Display</label>
										    </div>
										</div>
									</div>
						        </div>
						    	<div class="col-lg-12">
									<div class="form-group">
									<label><li class="fa fa-hashtag"></li> Hashtag </label>
									<code>
										<textarea class="form-control" name="hashtag" rows="3" placeholder="e.g: world,bike,..." ><?php if(isset($_POST['hashtag'])){echo $_POST['hashtag'];} ?></textarea></code>
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
