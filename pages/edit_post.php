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
		$query_id = "SELECT title,avatar,summary,content,post_day,post_time,poster,st,who,hashtag FROM tbpost WHERE id = {$id}";
		$result_id = mysqli_query($dbc,$query_id);
		check_query($result_id,$query_id);
	//Kiểm tra id có tồn tại không
		if (mysqli_num_rows($result_id) == 1) {
			list($title,$avatar,$summary,$content,$post_day,$post_time,$poster,$st,$who,$hashtag) = mysqli_fetch_array($result_id,MYSQLI_NUM);
		}else{
			$message_not_exist =1;
		}
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
			$poster = $_POST['poster'];
			$who = $_POST['who'];
			if($_FILES['img']['name'] == NULL){ 
		        $link_img =$avatar;
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
					$link_img='upload/'.$img;
					move_uploaded_file($_FILES['img']['tmp_name'],"./upload/".$img);
		     	}
		    }
			$st = $_POST['st'];
			$hashtag = addslashes($_POST['hashtag']);
			if (empty($errors)) {
				$query_up = "UPDATE tbpost
					SET title = '{$title}',
						avatar = '{$link_img}',
						summary = '{$summary}',
						content = '{$content}',
						poster = '{$poster}',
						who = '{$who}',
						st = '{$st}',
						hashtag = '{$hashtag}'
					WHERE id = $id";
				$result_up = mysqli_query($dbc,$query_up);
				check_query($result_up,$query_up);
				if (mysqli_affected_rows($dbc) == 1) {
					?>
						<script type="text/javascript">
							swal("Edit Successful!", "This post has been edit!", "success");
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
        		<h1 class="page-header"><strong ><li class="fa fa-pencil-square-o"></li> Edit Post</strong></h1>
        	</div>
        </div>
    	<div class="row">
    		<div class="col-lg-12">
    			<form name="edit_post" method="POST" enctype="multipart/form-data">
	    			<div class="panel panel-default">
	    				<div class="panel-heading">
	    					<button type="submit" name="submit" class="btn btn-primary" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-save"></li> <strong>Save Changes</strong></button>
	    					<a href="list_post.php" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back List Post</strong></a>
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
									<input type="text" name="title" class="form-control" placeholder="Post title" value="<?php echo $title ?>">
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
									<textarea class="form-control" name="summary" rows="3" placeholder="Post summary" ><?php echo $summary; ?></textarea>
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
									<textarea id="content" class="form-control"  name="content" rows="10" placeholder="Post content" ><?php echo $content; ?></textarea>
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
										<input type="text" name="post_time" class="form-control" value="<?php echo $post_time; ?>" readonly>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label><li class="fa fa-calendar"></li> Post Day</label>
										<input type="text" name="post_time" class="form-control" value="<?php echo $post_day; ?>" readonly>
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
													<option value="<?php echo $name['name'] ?>"><?php echo $name['name'] ?></option>
						                			<option value="Anonymous">Anonymous</option>
									            </select>
									        </div>
								    </div>
								</div>

							    <div class="col-lg-4">
							    	<div class="form-group">
							        <label><li class="fa fa-street-view"></li> Who will see this content ? </label>
							        	<?php 
							        		if ($who == "Public") {
							        			?>
							        			<div>
										            <select class="form-control" name="who">
										                <option value="Public">Public</option>
										                <option value="Only me">Only me</option>
										            </select>
										        </div>
										        <?php
							        		}else{
							        			?>
												<div>
										           <div>
										            <select class="form-control" name="who">
										            	<option value="Only me">Only me</option>
										                <option value="Public">Public</option>
										            </select>
										        </div>
										        </div>
							        			<?php
							        		}
							        	 ?>
							        </div>
						        </div>
						        <div class="col-lg-4">
						        	<div class="form-group">
									<label><li class="fa fa-picture-o"></li> Post avatar </label>
									<br>
									<img class="btn btn-default"  style="width: 180px;height: 100px;" src="<?php echo $avatar; ?>">
									<p></p>
										<div class="form-group">
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
						       	</div>
						       	<div class="col-lg-2">
						       		<div class="form-group">
						        	<label><li class="fa fa-share-alt-square"></li> Status</label>
						       		<?php 
						       			if ($st == "Display") {
						       				?>
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
											<?php
						       			}else{
						       				?>
						       				<div class="funkyradio">
											   <div class="funkyradio-primary">
											        <input type="radio" name="st" value="Display" id="radio2" />
											        <label for="radio2"><li class="glyphicon glyphicon-eye-open"></li> Display</label>
											    </div>
											    <div class="funkyradio-primary">
											        <input type="radio" name="st" value="Not Display" id="radio3" checked/>
											        <label for="radio3"><li class="glyphicon glyphicon-eye-close"></li> Not Display</label>
											    </div>
											</div>
											<?php
						       			}

						       		 ?>
									</div>
						        </div>
						    	<div class="col-lg-12">
									<div class="form-group">
									<label><li class="fa fa-hashtag"></li> Hashtag </label>
									<code>
										<textarea class="form-control" name="hashtag" rows="3" placeholder="e.g: world,bike,..." ><?php echo $hashtag; ?></textarea></code>
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