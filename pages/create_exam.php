<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
	if (isset($_POST['submit_filter'])) {
        $subject_filter=$_POST['subject_filter'];
    }else{
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (empty($_POST['id_exam'])) {
				$errors[] = 'id_exam';
			}else{
				$id_exam =$_POST['id_exam'];
				if (is_numeric($id_exam)){
					$id_exam = $_POST['id_exam'];
				}else{
					$errors[]='not_number';
				}
			}
			if (empty($_POST['name_exam'])) {
				$errors[] = 'name_exam';
			}else{
				$name_exam = addslashes($_POST['name_exam']);
			}
			if (empty($_POST['subject'])) {
				$errors[] = 'subject';
			}else{
				$subject = $_POST['subject'];
			}
			if (empty($_POST['checkbox'])) {
				$errors[] = 'checkbox';
			}else{
				$id_question = $_POST['checkbox'];
			}
			if (empty($errors)) {
				$query_sl = "SELECT id_exam FROM tb_name_exam WHERE id_exam = $id_exam";
				$result_sl = mysqli_query($dbc,$query_sl);
				check_query($result_sl,$query_sl);
				if (mysqli_num_rows($result_sl) == 1) {
					$message_id_exam_exist =1;
				}else{
					foreach ($id_question as $v) {
						$query_sl_check="SELECT subject FROM tbquestion  WHERE id=$v";
						$result_sl_check=mysqli_query($dbc,$query_sl_check);
						check_query($result_sl_check,$query_sl_check);
						$rows=mysqli_fetch_array($result_sl_check);
						if ($rows['subject'] != $subject) {
							$message_error=1;
						}
					}
					if (!isset($message_error)) {
						$query_in ="INSERT INTO tb_name_exam(id_exam,name_exam,subject) VALUES ($id_exam,'{$name_exam}','{$subject}')";
						$result_in = mysqli_query($dbc,$query_in);
						check_query($result_in,$query_in);
						foreach ($id_question as $v) {
							$query ="INSERT INTO tbexam(id_exam,name_exam,id_question,subject) VALUES ($id_exam,'{$name_exam}',$v,'{$subject}')";
							$result = mysqli_query($dbc,$query);
							check_query($result,$query);
						}
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
				}
			}
		}
    }
 ?>        
    <div id="page-wrapper">
    	<div class="row">
	        <div class="col-lg-12">
	        	<h1 class="page-header"><strong ><li class="fa fa-plus-square"></li> Create Exam</strong></h1>
	        </div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<form name="create_exam" method="POST" enctype="multipart/form-data">
					<div class="panel panel-default">
						<div class="panel-heading">
							<button type="reset" class="btn btn-primary"><li class="fa fa-repeat"></li> <strong>Reset</strong></button>
	    					<button type="submit" name="submit" class="btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-plus"></li> <strong>Create Exam</strong></button>
							<a href="list_exam.php" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back List Exam</strong></a>
						</div>
						<div class="panel-body">
							<div class="col-lg-12">
								<div class="col-lg-12">
									<?php 
										if (isset($message_error)) {
										?>
											<div class="alert alert-danger">
											  <li class="fa fa-frown-o"></li><strong> Oops!</strong> Different subject exam and questions. Try again !!!.
											</div>
										<?php
										}
										if (isset($message_id_exam_exist)) {
										?>
											<div class="alert alert-danger">
											  <li class="fa fa-frown-o"></li><strong> Oops!</strong> This id exam is exist. Try another !!!.
											</div>
										<?php
										}
										if (isset($errors) && in_array('id_exam',$errors) OR isset($errors) && in_array('name_exam',$errors) OR isset($errors) && in_array('subject',$errors) OR isset($errors) && in_array('checkbox',$errors)) {
	    								?>
											<div class="alert alert-danger">
											  <li class="fa fa-exclamation-triangle"></li><strong> Oh snap!</strong> Change a few things up and try submitting again. 
											</div>
										<?php
			    						}
									 ?>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
									    <label><li class="fa fa-ticket"></li> ID Exam</label>
										<input type="text" name="id_exam" class="form-control" value="<?php if(isset($id_exam)){echo $id_exam;} ?>">
										<div class="text-color-error">
			    							<?php  if (isset($errors) && in_array('id_exam',$errors)) {
			    								echo "*This field is required.";
			    							}?>
			    							<?php  if (isset($errors) && in_array('not_number',$errors)) {
			    								echo "*This field is an number.";
			    							}?>
			    						</div>   
								    </div>
								</div>
								<div class="col-lg-9">
									<div class="form-group">
										<label><li class="fa fa-h-square"></li> Exam Name</label>
										<input type="text" name="name_exam" class="form-control" value="<?php if(isset($name_exam)){echo $name_exam;} ?>">
										<div class="text-color-error">
			    							<?php  if (isset($errors) && in_array('name_exam',$errors)) {
			    								echo "*This field is required.";
			    							}?>
			    						</div>
									</div>
								</div>
							</div>
							
							
						    <div class="col-lg-12">
	    						<div class="form-group">
	    							<div class="col-lg-3">
										<div class="funkyradio">
										    <div class="funkyradio-primary">
										        <input type="radio" name="subject" value="Math" id="radio1" >
										        <label for="radio1"><li class="fa fa-audio-description"></li> <strong>Math</strong></label>
										    </div>
										</div>
	    							</div>
	    							<div class="col-lg-3">
	    							 	<div class="funkyradio">
										    <div class="funkyradio-primary">
										        <input type="radio" name="subject" value="English" id="radio2" >
										        <label for="radio2"><li class="fa fa-audio-description"></li> <strong>English</strong></label>
										    </div>
										</div>
	    							</div>
	    							<div class="col-lg-3">
	    							 	<div class="funkyradio">
										    <div class="funkyradio-primary">
										        <input type="radio" name="subject" value="Informatics" id="radio3" >
										        <label for="radio3"><li class="fa fa-audio-description"></li> <strong>Informatics</strong></label>
										    </div>
										</div>
	    							</div>
	    							<div class="col-lg-3">
	    							 	<div class="funkyradio">
										    <div class="funkyradio-primary">
										        <input type="radio" name="subject" value="Physical" id="radio4" >
										        <label for="radio4"><li class="fa fa-audio-description"></li> <strong>Physical</strong></label>
										    </div>
										</div>
	    							</div>
						        </div>
						        <div class="col-lg-12">
	    							<div class="text-color-error">
	    							<?php  if (isset($errors) && in_array('subject',$errors)) {
	    								echo "*This field is required.";
	    							}?>
	    							</div>
    							</div>
						    </div>
	
						   
							<div class="col-lg-12">
                                <div class="col-lg-12">
                                    <hr>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <label><li class="fa fa-list"></li> List Question Of Bank</label>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                            <div>
                                            	 <div class="col-lg-3">
										            <select class="form-control" name="subject_filter">
										            	<option value="All">All</option>
										                <option value="Math">Math</option>
										                <option value="English">English</option>
										                <option value="Informatics">Informatics</option>
										                <option value="Physical">Physical</option>
										            </select>
										        </div>
                                            	<form class="form-control" method="POST">
	                                            	<button class="btn btn-default" type="submit" name="submit_filter"><li class="fa fa-filter"> </li> Filter Question</button>
	                                            </form>
                                            </div>
                                            <p></p>
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><li class="fa fa-thumb-tack"></li> Choose</th>
															<th><li class="fa fa-audio-description"></li> Subjects</th>
															<th><li class="fa fa-book"></li> Question Content</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<?php 
                                                    		if (isset($_POST['submit_filter'])) {
                                                    			$subject_filter=$_POST['subject_filter'];
                                                    			if ($subject_filter=='All') {
                                                    				$query = "SELECT id,content,subject FROM tbquestion ORDER BY id DESC";
																	$result = mysqli_query($dbc,$query);
																	check_query($dbc,$query);
																	while ($question = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
																	?>
																		<tr>
																			<td>
																				<div class="btn-group btn-group" data-toggle="buttons">
																				    <label class="btn">
																				      <input  type="checkbox" name="checkbox[]" value="<?php echo $question['id'] ?>"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i> 
																				    </label>
																				</div>
																			</td>
																			<td><?php echo $question['subject']; ?></td>
																			<td><?php echo $question['content']; ?></td>
																		</tr>
																	<?php
																	}
                                                    			}elseif ($subject_filter=='Math') {
                                                    				$query = "SELECT id,content,subject FROM tbquestion WHERE subject = '{$subject_filter}' ORDER BY id DESC";
																	$result = mysqli_query($dbc,$query);
																	check_query($dbc,$query);
																	while ($question = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
																	?>
																		<tr>
																			<td>
																				<div class="btn-group btn-group" data-toggle="buttons">
																				    <label class="btn">
																				      <input  type="checkbox" name="checkbox[]" value="<?php echo $question['id'] ?>"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i> 
																				    </label>
																				</div>
																			</td>
																			<td><?php echo $question['subject']; ?></td>
																			<td><?php echo $question['content']; ?></td>
																		</tr>
																	<?php
																	}
                                                    			}elseif ($subject_filter=='English') {
                                                    				$query = "SELECT id,content,subject FROM tbquestion WHERE subject = '{$subject_filter}' ORDER BY id DESC";
																	$result = mysqli_query($dbc,$query);
																	check_query($dbc,$query);
																	while ($question = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
																	?>
																		<tr>
																			<td>
																				<div class="btn-group btn-group" data-toggle="buttons">
																				    <label class="btn">
																				      <input  type="checkbox" name="checkbox[]" value="<?php echo $question['id'] ?>"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i> 
																				    </label>
																				</div>
																			</td>
																			<td><?php echo $question['subject']; ?></td>
																			<td><?php echo $question['content']; ?></td>
																		</tr>
																	<?php
																	}
                                                    			}elseif ($subject_filter=='Informatics') {
                                                    				$query = "SELECT id,content,subject FROM tbquestion WHERE subject = '{$subject_filter}' ORDER BY id DESC";
																	$result = mysqli_query($dbc,$query);
																	check_query($dbc,$query);
																	while ($question = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
																	?>
																		<tr>
																			<td>
																				<div class="btn-group btn-group" data-toggle="buttons">
																				    <label class="btn">
																				      <input  type="checkbox" name="checkbox[]" value="<?php echo $question['id'] ?>"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i> 
																				    </label>
																				</div>
																			</td>
																			<td><?php echo $question['subject']; ?></td>
																			<td><?php echo $question['content']; ?></td>
																		</tr>
																	<?php
																	}
                                                    			}elseif ($subject_filter=='Physical') {
                                                    				$query = "SELECT id,content,subject FROM tbquestion WHERE subject = '{$subject_filter}' ORDER BY id DESC";
																	$result = mysqli_query($dbc,$query);
																	check_query($dbc,$query);
																	while ($question = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
																	?>
																		<tr>
																			<td>
																				<div class="btn-group btn-group" data-toggle="buttons">
																				    <label class="btn">
																				      <input  type="checkbox" name="checkbox[]" value="<?php echo $question['id'] ?>"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i> 
																				    </label>
																				</div>
																			</td>
																			<td><?php echo $question['subject']; ?></td>
																			<td><?php echo $question['content']; ?></td>
																		</tr>
																	<?php
																	}
                                                    			}
                                                    		}
                                                    	 ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-color-error">
			    							<?php  if (isset($errors) && in_array('checkbox',$errors)) {
			    								echo "*Select at least one question.";
			    							}?>
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
