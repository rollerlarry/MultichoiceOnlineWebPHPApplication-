<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors=array();
		if($_FILES['file']['name'] == NULL){ 
	        $errors[]='file';
	     }else{
	     	if ($_FILES['file']['type'] != "text/xml"){
	     		$errors[]='type';
	     	}else{
	     		$name_file=$_POST['filename'];

	     	}
	     }
		if (empty($errors)) {
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$time=date('H:i - d-m-Y');
			$link='upload/'.$name_file;
			$query_in="INSERT INTO tbupload_question(time,name_file,link_download) VALUES ('{$time}','{$name_file}','{$link}')";
			$result_in=mysqli_query($dbc,$query_in);
			check_query($result_in,$query_in);
			if (mysqli_affected_rows($dbc)==1) {
				?>
					<script type="text/javascript">
						swal("Successful!", "This file has been upload!", "success");
					</script>
				<?php
			}
			$data = array();
			if ($_FILES['file']['tmp_name']) {
				$dom = DOMDocument::load($_FILES['file']['tmp_name']);
				$rows = $dom->getElementsByTagName('Row');
				$first_row = true;
				foreach ($rows as $row) {
					if (!$first_row) {
						$index = 1;
						$cells = $row->getElementsByTagName('Cell');
						foreach ($cells as $cell ) {
							$ind = $cell -> getAttribute('Index');
							if ($ind != null)  {
								$index = $ind;
							}
							if ($index == 1) {
								$subject = $cell->nodeValue;
							}
							if ($index == 2) {
								$content = $cell->nodeValue;
							}
							if ($index == 3) {
								$answer_a = $cell->nodeValue;
							}
							if ($index == 4) {
								$answer_b = $cell->nodeValue;
							}
							if ($index == 5) {
								$answer_c = $cell->nodeValue;
							}
							if ($index == 6) {
								$answer_d = $cell->nodeValue;
							}
							if ($index == 7) {
								$answer_true = $cell->nodeValue;
							}
							if ($index == 8) {
								$guide = $cell->nodeValue;
							}
							$index++;
						}
						$data[]=array(
							'subject' => $subject,
							'content' => $content,
							'answer_a' => $answer_a,
							'answer_b' => $answer_b,
							'answer_c' => $answer_c,
							'answer_d' => $answer_d,
							'answer_true' => $answer_true,
							'guide' => $guide,
						);
					}
					$first_row = false;
				}
			}
			if ($data) {
				$count= 1;
				$count_errors=0;
				$count_sucessful=0;
				foreach ($data as $row ) {
					if ($count>1) {
	    				$a1=$row['subject'];
	    				$a2=$row['content'];
	    				$a3=$row['answer_a'];
	    				$a4=$row['answer_b'];
	    				$a5=$row['answer_c'];
	    				$a6=$row['answer_d'];
	    				$a7=$row['answer_true'];
	    				$a8=$row['guide'];
	    				$query_sl="SELECT content FROM tbquestion WHERE content='{$a2}'";
	    				$result_sl=mysqli_query($dbc,$query_sl);
	    				check_query($result_sl,$query_sl);
	    				if (mysqli_num_rows($result_sl) == 1) {
							$count_errors++;
						}else{
							$query_in = "INSERT INTO tbquestion(subject,content,answer_a,answer_b,answer_c,answer_d,answer_true,guide) VALUES ('{$a1}','{$a2}','{$a3}','{$a4}','{$a5}','{$a6}','{$a7}','{$a8}')";
							$result_in = mysqli_query($dbc,$query_in);
							check_query($result_in,$query_in);
							$count_sucessful++;
						}
					}
					$count++;
				}
			}
			$file=$_FILES['file']['name'];
	     	move_uploaded_file($_FILES['file']['tmp_name'],"./upload/".$file);
	     	//ZIP
	     	$zip = new ZipArchive(); 
			$zip->open('./upload/'.$name_file.'.zip', ZipArchive::CREATE); 
			$zip->addFile('./upload/'.$name_file, $name_file); 
			$zip->close();
		}
	}
 ?>
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><li class="fa fa-download"></li><strong> Import Question </strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<form name="import_question" method="POST" enctype="multipart/form-data"">
			    	<div class="panel panel-default">
			    		<div class="panel-heading">
			    			<button type="submit" name="submit" class="btn btn-success"><li class="fa fa-download"></li> <strong>Import</strong></button>
			    			<a href="delete_upload_all_question.php" class="btn btn-warning" onclick="return confirm('Are you sure clear upload history ?')"><li class="fa fa-eraser"></li> <strong>Clear History</strong></a>
			    			<a href="list_question_bank.php" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back List Question</strong></a>
			    		</div>
			    		<div class="panel-body">
			    			<div class="col-lg-12">
			    				<div class="col-lg-12">
									<div class="form-group">
									    <div class="row">
									      <div class="col-sm-7 col-md-6 col-lg-6">
									        <div class="form-group">
									          <label for="file" class="sr-only">File</label>
									          <div class="input-group">
									            <input type="text" name="filename" class="form-control" placeholder="No file selected" >
									            <span class="input-group-btn">
									              <div style="position: relative;" class="btn btn-default  custom-file-uploader">
									                <input style="display: block;position: absolute;top: 0;right: 0;bottom: 0;left: 0;opacity: 0;" type="file" name="file" onchange="this.form.filename.value = this.files[0].name" />
									                <li class="fa fa-file-excel-o"></li> <strong>Select a file</strong>
									              </div>
									              	
									            </span>
									            
									          </div>
									        <?php
									        	if (isset($count_sucessful)) {
									          	?>
										          	<div class="alert alert-success">
													  <li class="fa fa-check"></li><strong> Yes!</strong> There were <?php echo $count_sucessful; ?> question added to the question bank.
													</div>
												<?php
												}
									          	if (isset($count_errors)) {
									          	?>
										          	<div class="alert alert-danger">
													  <li class="fa fa-exclamation-triangle"></li><strong> Oh snap!</strong> There are <?php echo $count_errors; ?> duplicate question.
													</div>
												<?php
												}
											?>
									          <div class="text-color-error">
					    							<?php
						    							if (isset($errors) && in_array('file',$errors)) {
						    								echo "*Please choose a file.";
						    							}
						    							if (isset($errors) && in_array('type',$errors)) {
						    								echo "*The upload file is not valid, please try again with excel file with .xml";
						    							}
					    							?>
					    						</div>
									        </div>
									      </div>
									     
									    </div>

									</div>

								</div>

							</div>
							<div class="col-lg-12">
								<div class="col-lg-6">
							    	<div class="panel panel-default">
						    			<div class="panel-heading">
							    			 <h4><li class="fa fa-history"></li> Upload History</h4>
							    		</div>
							    		<div class="panel-body">
											<div class="form-group">
												<table class="table table-striped table-bordered table-hover">
													<thead>
					            						<tr>
					            							<th>#</th>
					            							<th><li class="fa fa-calendar"></li> Time</th>
					                                        <th><li class="fa fa-file"></li> File</th>
					                                        <th><li class="fa fa-cloud-download"></li> Download</th>
					                                        <th><li class="fa fa-minus-square"></li> Delete</th>
					            						</tr>
					            					</thead>
					            					<tbody>
					            					<?php
					            						$query_sl="SELECT id,time,name_file,link_download FROM tbupload_question ORDER BY id DESC";
					            						$result_sl=mysqli_query($dbc,$query_sl);
					            						check_query($query_sl,$result_sl);
					            						$ord=1;
					            						while ($upload = mysqli_fetch_array($result_sl,MYSQLI_ASSOC)) {
			        									?>
						            						<tr>
						            							<td><?php echo $ord; ?></td>
						            							<td><?php echo $upload['time']; ?></td>
							            						<td><?php echo $upload['name_file']; ?></td>
							            						<td><a href="<?php echo $upload['link_download']; ?>.zip"><li class="fa fa-download fa-2x"></li></a></td>
							            						<td><a href="delete_upload_question.php?id=<?php echo $upload['id']; ?>" onclick="return confirm('Are you sure delete ?')"><li class="fa fa-trash-o fa-2x"></li></a></td>
						            						</tr>
						            					<?php
						            					$ord++;
						            					}
						            				?>
					            					</tbody>
												</table>
											</div>
							    		</div>
							    	</div>
						    	</div>
						    	 <div class="col-lg-6">
									<div class="panel panel-default">
						    			<div class="panel-heading">
							    			 <h4><li class="fa fa-sticky-note-o"></li> Notes</h4>
							    		</div>
							    		<div class="panel-body">
											<div class="form-group">
												<li>Only excel files (<strong>XML</strong>) are allowed in this demo (by default there is no file type restriction).</li>
												<li>The maximum file size for uploads in this demo is <strong>20 MB</strong> (default file size is unlimited).</li>
												<li>Uploaded files will be deleted automatically <strong>after 50 day or less</strong> (demo files are stored in memory).</li>
												<li>Please refer to the project website and documentation for more information.</li>
											</div>
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
