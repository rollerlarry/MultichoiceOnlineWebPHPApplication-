<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors=array();
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
		if (empty($_POST['question_number'])) {
			$errors[] = 'question_number';
		}else{
			$question_number = $_POST['question_number'];
			if (is_numeric($question_number)){
				$question_number = $_POST['question_number'];
			}else{
				$errors[]='not_number_question';
			}
		}
		if (empty($_POST['subject'])) {
			$errors[] = 'subject';
		}else{
			$subject = $_POST['subject'];
		}
		if (empty($errors)) {
			$query_sl_co="SELECT COUNT(id) FROM tbquestion WHERE subject='{$subject}'";
			$result_sl_co=mysqli_query($dbc,$query_sl_co);
			list($count) = mysqli_fetch_array($result_sl_co,MYSQLI_NUM);
			if ($count < $question_number) {
				$message_not_enough=1;
			}else{
				$query_sl = "SELECT id_exam FROM tb_name_exam WHERE id_exam = '{$id_exam}'";
				$result_sl = mysqli_query($dbc,$query_sl);
				check_query($result_sl,$query_sl);
				if (mysqli_num_rows($result_sl) == 1) {
					$message_id_exam_exist =1;
				}else{
					$query_in ="INSERT INTO tb_name_exam(id_exam,name_exam,subject) VALUES ($id_exam,'{$name_exam}','{$subject}')";
					$result_in = mysqli_query($dbc,$query_in);
					check_query($result_in,$query_in);
					$count=0;
					$id_question=array();
					while ($count < $question_number) {
						$query_sl_id = "SELECT id FROM tbquestion WHERE subject = '{$subject}' ORDER BY RAND() ";
						$result_sl_id = mysqli_query($dbc,$query_sl_id);
						check_query($result_sl_id,$query_sl_id);
						$rows=mysqli_fetch_array($result_sl_id);
						if (in_array($rows['id'],$id_question)) {
							$count=$count+0;
						}else{
							$id_question[]=$rows['id'];
							$count++;
						}
					}
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
 ?>       
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><li class="fa fa-random"></li><strong> Create Random Exam</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        			<form name="create_random_exam" method="POST">
        				<div class="panel panel-default">
		        		<div class="panel-heading">
		        			<button type="submit" name="submit" class="btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-plus"></li> <strong>Create Random Exam</strong></button>
		        			<a href="list_exam.php" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back List Exam</strong></a>
		        		</div>
		        		<div class="panel-body">
		        			<div class="col-lg-12">
								<div class="col-lg-12">
									<?php 
										if (isset($message_id_exam_exist)) {
										?>
											<div class="alert alert-danger">
											  <li class="fa fa-frown-o"></li><strong> Oops!</strong> This id exam is exist. Try another !!!.
											</div>
										<?php
										}
										if (isset($message_not_enough)) {
										?>
											<div class="alert alert-danger">
											  <li class="fa fa-frown-o"></li><strong> Oops!</strong> The question number in this bank is not enough.
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
			    							<?php  
			    							if (isset($errors) && in_array('id_exam',$errors)) {
			    								echo "*This field is required.";
			    							}
			    							if (isset($errors) && in_array('not_number',$errors)) {
			    								echo "*This field is an number.";
			    							}
			    							?>
			    						</div>   
								    </div>
								</div>
								<div class="col-lg-6">
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
								<div class="col-lg-3">
									<div class="form-group">
									    <label><li class="fa fa-sort-numeric-desc"></li> Number Question</label>
										<input type="text" name="question_number" class="form-control" value="<?php if(isset($question_number)){echo $question_number;} ?>">
										<div class="text-color-error">
			    							<?php  
			    							if (isset($errors) && in_array('question_number',$errors)) {
			    								echo "*This field is required.";
			    							}
			    							if (isset($errors) && in_array('not_number_question',$errors)) {
			    								echo "*This field is an number.";
			    							}
			    							?>
			    						</div>   
								    </div>
								</div>
							</div>
							<div class="col-lg-12">
						    	<div class="col-lg-12">
	    							<label><li class="fa fa-audio-description"></li> Subjects</label>
	    						</div>
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
	    							<div class="col-lg-12">
		    							<div class="text-color-error">
		    							<?php  if (isset($errors) && in_array('subject',$errors)) {
		    								echo "*This field is required.";
		    							}?>
		    							</div>
	    							</div>
						        </div>
						    </div>
						</form>
	        		</div>
	        	</div>
	        </div>
        </div>
    </div>
<?php include('include/footer.php') ?>

