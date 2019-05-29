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
	//Đổ dữ liệu ra ô
		$query_id = "SELECT subject,content,number_answer,answer_a,answer_b,answer_c,answer_d,answer_true,guide FROM tbquestion WHERE id = {$id}";
		$result_id = mysqli_query($dbc,$query_id);
		check_query($result_id,$query_id);
	//Kiểm tra id có tồn tại không
		if (mysqli_num_rows($result_id) == 1) {
			list($subject,$question_content,$number_answer,$answer_a,$answer_b,$answer_c,$answer_d,$answer_true,$guide) = mysqli_fetch_array($result_id,MYSQLI_NUM);
		}else{
			$message_not_exist =1;
		}
	//Bắt lỗi
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$errors =array();
			if (empty($_POST['subject'])) {
				$errors[] = 'subject';
			}else{
				$subject = $_POST['subject'];
			}
			if (empty($_POST['question_content'])) {
				$errors[] = 'question_content';
			}else{
				$question_content = addslashes($_POST['question_content']);
			}
			if (empty($_POST['number_answer'])) {
				$errors[] = 'number_answer';
			}else{
				$number_answer = $_POST['number_answer'];
				if (is_numeric($number_answer)){
					$number_answer = $_POST['number_answer'];
				}else{
					$errors[]='not_number';
				}
				if ($number_answer >= 5 || $number_answer <=1){
					$errors[]='error_number';
				}
			}
			if ($number_answer == 2){
				if (($_POST['answer_a'])==NULL) {
					$errors[] = 'answer_a';
				}else{
					$answer_a = addslashes($_POST['answer_a']);
				}

				if (($_POST['answer_b'])==NULL) {
					$errors[] = 'answer_b';
				}else{
					$answer_b = addslashes($_POST['answer_b']);
				}	
			}elseif ($number_answer == 3) {
				if (($_POST['answer_a'])==NULL) {
					$errors[] = 'answer_a';
				}else{
					$answer_a = addslashes($_POST['answer_a']);
				}

				if (($_POST['answer_b'])==NULL) {
					$errors[] = 'answer_b';
				}else{
					$answer_b = addslashes($_POST['answer_b']);
				}

				if (($_POST['answer_c'])==NULL) {
					$errors[] = 'answer_c';
				}else{
					$answer_c = addslashes($_POST['answer_c']);
				}
			}elseif ($number_answer == 4) {
				if (($_POST['answer_a'])==NULL) {
					$errors[] = 'answer_a';
				}else{
					$answer_a = addslashes($_POST['answer_a']);
				}

				if (($_POST['answer_b'])==NULL) {
					$errors[] = 'answer_b';
				}else{
					$answer_b = addslashes($_POST['answer_b']);
				}

				if (($_POST['answer_c'])==NULL) {
					$errors[] = 'answer_c';
				}else{
					$answer_c = addslashes($_POST['answer_c']);
				}

				if (($_POST['answer_d'])==NULL) {
					$errors[] = 'answer_d';
				}else{
					$answer_d = addslashes($_POST['answer_d']);
				}
			}
			
			if (!empty($_POST['answer_a'])) {
				if (($_POST['answer_a'])==($_POST['answer_b']) || ($_POST['answer_a'])==($_POST['answer_c']) || ($_POST['answer_a'])==($_POST['answer_d'])) {
					$errors[] = 'answer_same';
				}
			}
			if (!empty($_POST['answer_b'])) {
				if (($_POST['answer_b'])==($_POST['answer_a']) || ($_POST['answer_b'])==($_POST['answer_c']) || ($_POST['answer_b'])==($_POST['answer_d'])) {
					$errors[] = 'answer_same';
				}
			}
			if (!empty($_POST['answer_c'])) {
				if (($_POST['answer_c'])==($_POST['answer_a']) || ($_POST['answer_c'])==($_POST['answer_b']) || ($_POST['answer_c'])==($_POST['answer_d'])) {
					$errors[] = 'answer_same';
				}
			}
			if (!empty($_POST['answer_d'])) {
				if (($_POST['answer_d'])==($_POST['answer_a']) || ($_POST['answer_d'])==($_POST['answer_b']) || ($_POST['answer_d'])==($_POST['answer_c'])) {
					$errors[] = 'answer_same';
				}
			}
			if (empty($_POST['answer_true'])) {
				$errors[] = 'answer_true';
			}else{
				$answer_true = addslashes($_POST['answer_true']);
				if (($number_answer == 2 && $answer_true =="c") || ($number_answer == 2 && $answer_true=="d") || ($number_answer == 3 && $answer_true=="d")) {
					$errors[] = 'errors_answer_true';
				}
			}
			$guide = $_POST['guide'];
			if (empty($errors)) {
				if ($number_answer==2) {
					$query = "UPDATE tbquestion
						SET content='{$question_content}',
							number_answer=$number_answer,
							answer_a='{$answer_a}',
							answer_b='{$answer_b}',
							answer_c= '',
							answer_d= '',
							answer_true='{$answer_true}',
							guide='{$guide}',
							subject='{$subject}'
						WHERE id={$id}";
					$result = mysqli_query($dbc,$query);
					check_query($result,$query);
					if (mysqli_affected_rows($dbc) == 1) {
						?>
							<script type="text/javascript">
							         swal("Edit Successful!", "This question has been edit :)", "success");
							</script>
						<?php
					}else{
						$message_not_successful =1;
					}
				}elseif ($number_answer==3) {
					$query = "UPDATE tbquestion
						SET content='{$question_content}',
							number_answer=$number_answer,
							answer_a='{$answer_a}',
							answer_b='{$answer_b}',
							answer_c='{$answer_c}',
							answer_true='{$answer_true}',
							guide='{$guide}',
							subject='{$subject}'
						WHERE id={$id}";
					$result = mysqli_query($dbc,$query);
					check_query($result,$query);
					if (mysqli_affected_rows($dbc) == 1) {
						?>
							<script type="text/javascript">
							         swal("Edit Successful!", "This question has been edit :)", "success");
							</script>
						<?php
					}else{
						$message_not_successful =1;
					}
				}elseif ($number_answer==4) {
					$query = "UPDATE tbquestion
						SET content='{$question_content}',
							number_answer=$number_answer,
							answer_a='{$answer_a}',
							answer_b='{$answer_b}',
							answer_c='{$answer_c}',
							answer_d='{$answer_d}',
							answer_true='{$answer_true}',
							guide='{$guide}',
							subject='{$subject}'
						WHERE id={$id}";
					$result = mysqli_query($dbc,$query);
					check_query($result,$query);
					if (mysqli_affected_rows($dbc) == 1) {
						?>
							<script type="text/javascript">
							         swal("Edit Successful!", "This question has been edit :)", "success");
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
        		<h1 class="page-header"><strong ><li class="fa fa-pencil-square"></li> Edit Question</strong></h1>
        	</div>
        </div>
    	<div class="row">
    		<div class="col-lg-12">
    			<form name="add_new_question" method="POST">
	    			<div class="panel panel-default">
	    				<div class="panel-heading">
	    					<button type="submit" name="submit" class="btn btn-primary" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-save"></li> <strong>Save Changes</strong></button>
	    					<a href="list_question_bank.php" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back List Question</strong></a>
	    				</div>
	    				<div class="panel-body">
	    					<div class="col-lg-12">
	    						<div class="col-lg-12">
	    							<?php 
	    								if (isset($message_not_successful)) {
										?>
											<div class="alert alert-danger">
											  <li class="fa fa-frown-o"></li><strong> Oops!</strong> You have not changed anything yet.
											</div>
										<?php
										}
	    								if (isset($errors) && in_array('subject',$errors) OR isset($errors) && in_array('content',$errors) OR isset($errors) && in_array('answer_a',$errors) OR isset($errors) && in_array('answer_b',$errors) OR isset($errors) && in_array('answer_c',$errors) OR isset($errors) && in_array('answer_d',$errors)) {
	    								?>
											<div class="alert alert-danger">
											  <li class="fa fa-exclamation-triangle"></li><strong> Oh snap!</strong> Change a few things up and try submitting again. 
											</div>
										<?php
			    						}
	    							?>
	    						</div>
	    						<div class="col-lg-8">
    								<label><li class="fa fa-audio-description"></li> Subjects</label>
	    						</div>
	    						<div class="col-lg-4">
    								<label><li class="fa fa-list-ol"></li> Number Answer (2 - 4)</label>
    							</div>
	    					</div>
	    					<?php 
	    						if ($subject=="Math") {
	    							?>
	    							<div class="col-lg-12">
			    						<div class="form-group">
			    							<div class="col-lg-2">
												<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Math" id="radio1" checked="checked" >
												        <label for="radio1"><li class="fa fa-audio-description"></li> <strong>Math</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="English" id="radio2" >
												        <label for="radio2"><li class="fa fa-audio-description"></li> <strong>English</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Informatics" id="radio3" >
												        <label for="radio3"><li class="fa fa-audio-description"></li> <strong>Informatics</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Physical" id="radio4" >
												        <label for="radio4"><li class="fa fa-audio-description"></li> <strong>Physical</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
										    	<input type="text" name="number_answer" class="form-control" value="<?php if(isset($number_answer)){echo $number_answer;}?>">
										    	<div class="text-color-error">
				    							<?php  
				    								if (isset($errors) && in_array('number_answer',$errors)) {
				    									echo "*Enter number answer.";
				    								}
				    								if (isset($errors) && in_array('not_number',$errors)) {
				    									echo "*This field is an number.";
				    								}
				    								if (isset($errors) && in_array('error_number',$errors)) {
				    									echo "*This field have invalid number.";
				    								}
				    							?>
				    							</div>
										    </div>
								        </div>
								    </div>
	    							<?php
	    						}elseif ($subject=="English") {
	    							?>
	    							<div class="col-lg-12">
			    						<div class="form-group">
			    							<div class="col-lg-2">
												<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Math" id="radio1"  >
												        <label for="radio1"><li class="fa fa-audio-description"></li> <strong>Math</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="English" id="radio2" checked="checked">
												        <label for="radio2"><li class="fa fa-audio-description"></li> <strong>English</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Informatics" id="radio3" >
												        <label for="radio3"><li class="fa fa-audio-description"></li> <strong>Informatics</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Physical" id="radio4" >
												        <label for="radio4"><li class="fa fa-audio-description"></li> <strong>Physical</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
										    	<input type="text" name="number_answer" class="form-control" value="<?php if(isset($number_answer)){echo $number_answer;}?>">
										    	<div class="text-color-error">
				    							<?php  
				    								if (isset($errors) && in_array('number_answer',$errors)) {
				    									echo "*Enter number answer.";
				    								}
				    								if (isset($errors) && in_array('not_number',$errors)) {
				    									echo "*This field is an number.";
				    								}
				    								if (isset($errors) && in_array('error_number',$errors)) {
				    									echo "*This field have invalid number.";
				    								}
				    							?>
				    							</div>
										    </div>
								        </div>
								    </div>
	    							<?php
	    						}elseif ($subject=="Informatics") {
	    							?>
	    							<div class="col-lg-12">
			    						<div class="form-group">
			    							<div class="col-lg-2">
												<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Math" id="radio1"  >
												        <label for="radio1"><li class="fa fa-audio-description"></li> <strong>Math</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="English" id="radio2" >
												        <label for="radio2"><li class="fa fa-audio-description"></li> <strong>English</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Informatics" id="radio3" checked="checked">
												        <label for="radio3"><li class="fa fa-audio-description"></li> <strong>Informatics</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Physical" id="radio4" >
												        <label for="radio4"><li class="fa fa-audio-description"></li> <strong>Physical</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
										    	<input type="text" name="number_answer" class="form-control" value="<?php if(isset($number_answer)){echo $number_answer;}?>">
										    	<div class="text-color-error">
				    							<?php  
				    								if (isset($errors) && in_array('number_answer',$errors)) {
				    									echo "*Enter number answer.";
				    								}
				    								if (isset($errors) && in_array('not_number',$errors)) {
				    									echo "*This field is an number.";
				    								}
				    								if (isset($errors) && in_array('error_number',$errors)) {
				    									echo "*This field have invalid number.";
				    								}
				    							?>
				    							</div>
										    </div>
								        </div>
								    </div>
	    							<?php
	    						}elseif ($subject=="Physical") {
	    							?>
	    							<div class="col-lg-12">
			    						<div class="form-group">
			    							<div class="col-lg-2">
												<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Math" id="radio1"  >
												        <label for="radio1"><li class="fa fa-audio-description"></li> <strong>Math</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="English" id="radio2" >
												        <label for="radio2"><li class="fa fa-audio-description"></li> <strong>English</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Informatics" id="radio3">
												        <label for="radio3"><li class="fa fa-audio-description"></li> <strong>Informatics</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
			    							 	<div class="funkyradio">
												    <div class="funkyradio-primary">
												        <input type="radio" name="subject" value="Physical" id="radio4" checked="checked">
												        <label for="radio4"><li class="fa fa-audio-description"></li> <strong>Physical</strong></label>
												    </div>
												</div>
			    							</div>
			    							<div class="col-lg-2">
										    	<input type="text" name="number_answer" class="form-control" value="<?php if(isset($number_answer)){echo $number_answer;}?>">
										    	<div class="text-color-error">
				    							<?php  
				    								if (isset($errors) && in_array('number_answer',$errors)) {
				    									echo "*Enter number answer.";
				    								}
				    								if (isset($errors) && in_array('not_number',$errors)) {
				    									echo "*This field is an number.";
				    								}
				    								if (isset($errors) && in_array('error_number',$errors)) {
				    									echo "*This field have invalid number.";
				    								}
				    							?>
				    							</div>
										    </div>
								        </div>
								    </div>
	    							<?php
	    						}else{
	    							
	    						}
	    					?>
						    <br>
						    <div class="col-lg-12">
						    	<div class="col-lg-7">
						    		<div class="form-group">
		    							<label><li class="fa fa-book"></li> Question Content</label>
		    							<textarea id="content" class="form-control" rows="12" name="question_content" ><?php if (isset($question_content)){echo $question_content;}?></textarea>
		    							<div class="text-color-error">
		    							<?php  if (isset($errors) && in_array('question_content',$errors)) {
		    								echo "*Enter question content.";
		    							}?>
		    							</div>
		    						</div>
						    	</div>
						    	<div class="col-lg-5">
						    		<div class="form-group">
		    							<label><li class="fa fa-arrow-circle-o-right"></li> Answer A</label>
		    							<textarea class="form-control" rows="2" name="answer_a"><?php if (isset($answer_a)){echo $answer_a;} ?></textarea>
		    							<div class="text-color-error">
		    							<?php  if (isset($errors) && in_array('answer_a',$errors)) {
		    								echo "*Enter answer a.";
		    							}?>
		    							</div>
		    						</div>
		    						<div class="form-group">
		    							<label><li class="fa fa-arrow-circle-o-right"></li> Answer B</label>
		    							<textarea class="form-control" rows="2" name="answer_b" ><?php if (isset($answer_b)){echo $answer_b;} ?></textarea>
		    							<div class="text-color-error">
		    							<?php  if (isset($errors) && in_array('answer_b',$errors)) {
		    								echo "*Enter answer b.";
		    							}?>
		    							</div>
		    						</div>
		    						<div class="form-group">
		    							<label><li class="fa fa-arrow-circle-o-right"></li> Answer C</label>
		    							<textarea class="form-control" rows="2" name="answer_c"><?php if (isset($answer_c)){echo $answer_c;} ?></textarea>
		    							<div class="text-color-error">
		    							<?php  if (isset($errors) && in_array('answer_c',$errors)) {
		    								echo "*Enter answer c.";
		    							}?>
		    							</div>
		    						</div>
		    						<div class="form-group">
		    							<label><li class="fa fa-arrow-circle-o-right"></li> Answer D</label>
		    							<textarea class="form-control" rows="2" name="answer_d"><?php if (isset($answer_d)){echo $answer_d;} ?></textarea>
		    							<div class="text-color-error">
		    							<?php  if (isset($errors) && in_array('answer_d',$errors)) {
		    								echo "*Enter answer d.";
		    							}?>
		    							
		    							</div>
		    						</div>
		    						<div class="text-color-error">
	    								<?php  if (isset($errors) && in_array('answer_same',$errors)) {
		    								echo "*Have two answer same.";
		    							}?>
	    							</div>
						    	</div>
						    </div>
						    <div class="col-lg-12">
						    	<div class="col-lg-7">
									<div class="form-group">
		    							<label><li class="fa fa-glide"></li> Guide</label>
		    							<textarea class="form-control" rows="3" name="guide"><?php if (isset($guide)){echo $guide;} ?></textarea>
		    						</div>
						    	</div>
						    	<div class="col-lg-5">
		    						<div class="form-group">
		    							<label style="display: block;"><li class="fa fa-arrow-circle-o-right"></li> Answer True</label>
									        	<?php 
									        		if ($answer_true=="a") {
									        			?>
															<div class="btn-group btn-group-vertical" data-toggle="buttons">
														        <div class="btn-group btn-group-vertical" data-toggle="buttons">
																	<label class="btn">
																		  <input type="radio" name="answer_true" value="a" checked><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer A</span>
																	</label>

																	<label class="btn">
																	 	 <input type="radio" name="answer_true" value="b"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer B</span>
																	</label>
																</div>
														    </div>
														    <div class="btn-group btn-group-vertical" data-toggle="buttons">
														        <div class="btn-group btn-group-vertical" data-toggle="buttons">
														        	<div class="col-lg-8"></div>
																	<label class="btn">
																	 	 <input type="radio" name="answer_true" value="c"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer C</span>
																	</label>
																	<div class="col-lg-8"></div>
																	<label class="btn">
																	  	<input type="radio" name="answer_true" value="d"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer D</span>
																	</label>
																</div>
														    </div>
									        			<?php
									        		}elseif($answer_true=="b") {
									        			?>
															<div class="btn-group btn-group-vertical" data-toggle="buttons">
														        <div class="btn-group btn-group-vertical" data-toggle="buttons">
																	<label class="btn">
																		  <input type="radio" name="answer_true" value="a" ><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer A</span>
																	</label>

																	<label class="btn">
																	 	 <input type="radio" name="answer_true" value="b" checked><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer B</span>
																	</label>
																</div>
														    </div>
														    <div class="btn-group btn-group-vertical" data-toggle="buttons">
														        <div class="btn-group btn-group-vertical" data-toggle="buttons">
														        	<div class="col-lg-8"></div>
																	<label class="btn">
																	 	 <input type="radio" name="answer_true" value="c"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer C</span>
																	</label>
																	<div class="col-lg-8"></div>
																	<label class="btn">
																	  	<input type="radio" name="answer_true" value="d"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer D</span>
																	</label>
																</div>
														    </div>
									        			<?php
									        		}elseif($answer_true=="c") {
									        			?>
															<div class="btn-group btn-group-vertical" data-toggle="buttons">
														        <div class="btn-group btn-group-vertical" data-toggle="buttons">
																	<label class="btn">
																		  <input type="radio" name="answer_true" value="a" ><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer A</span>
																	</label>

																	<label class="btn">
																	 	 <input type="radio" name="answer_true" value="b"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer B</span>
																	</label>
																</div>
														    </div>
														    <div class="btn-group btn-group-vertical" data-toggle="buttons">
														        <div class="btn-group btn-group-vertical" data-toggle="buttons">
														        	<div class="col-lg-8"></div>
																	<label class="btn">
																	 	 <input type="radio" name="answer_true" value="c" checked><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer C</span>
																	</label>
																	<div class="col-lg-8"></div>
																	<label class="btn">
																	  	<input type="radio" name="answer_true" value="d"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer D</span>
																	</label>
																</div>
														    </div>
									        			<?php
									        		}else{
									        			?>
															<div class="btn-group btn-group-vertical" data-toggle="buttons">
														        <div class="btn-group btn-group-vertical" data-toggle="buttons">
																	<label class="btn">
																		  <input type="radio" name="answer_true" value="a" ><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer A</span>
																	</label>

																	<label class="btn">
																	 	 <input type="radio" name="answer_true" value="b"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer B</span>
																	</label>
																</div>
														    </div>
														    <div class="btn-group btn-group-vertical" data-toggle="buttons">
														        <div class="btn-group btn-group-vertical" data-toggle="buttons">
														        	<div class="col-lg-8"></div>
																	<label class="btn">
																	 	 <input type="radio" name="answer_true" value="c"><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer C</span>
																	</label>
																	<div class="col-lg-8"></div>
																	<label class="btn">
																	  	<input type="radio" name="answer_true" value="d" checked><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i><span> Answer D</span>
																	</label>
																</div>
														    </div>
									        			<?php
									        		}
									        	 ?>
									    </div>
	                                    <div class="text-color-error">
		    							<?php  
		    								if (isset($errors) && in_array('answer_true',$errors)) {
		    								echo "*Enter answer true.";
		    								}
		    								if (isset($errors) && in_array('errors_answer_true',$errors)) {
		    								echo "*Error choose the answer true.";
		    								}
		    							?>
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
