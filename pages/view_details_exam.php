<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
    //Kiểm tra id có phải là số không
    if (isset($_GET['id_exam']) && filter_var($_GET['id_exam'],FILTER_VALIDATE_INT,array('min_rang'=>1))) {
        $id_exam = $_GET['id_exam'];
    }else{
        header('Location: list_exam.php');
    }
    $query_sl_id = "SELECT name_exam,id_question,subject FROM tbexam WHERE id_exam = $id_exam";
    $result_sl_id = mysqli_query($dbc,$query_sl_id);
    check_query($result_sl_id,$query_sl_id);
    $exam= mysqli_fetch_array($result_sl_id);
    $id_question = $exam['id_question'];
    $name = $exam['name_exam'];
    $subject = $exam['subject'];

 ?>
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong ><li class="fa fa-pencil-square"></li></li> View Details Exam</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
                <form name="view_exam" method="POST">
            		<div class="panel panel-default">
            			<div class="panel-heading">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal3"><li class="fa fa-plus"></li> <strong>Add More Question</strong></button>
                            <div id="myModal3" class="modal fade" role="dialog">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><li class="fa fa-plus-square"></li> Add more question for exam</h4>
                                  </div>
                                  <?php 
                                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                        if (empty($_POST['checkbox'])) {
                                            $errors[] = 'checkbox';
                                        }else{
                                            $question = $_POST['checkbox'];
                                        }

                                        if (empty($errors)) {
                                            foreach ($question as $v) {
                                                $query_m ="INSERT INTO tbexam(id_exam,name_exam,id_question,subject) VALUES ($id_exam,'{$name}',$v,'{$subject}')";
                                                $result_m = mysqli_query($dbc,$query_m);
                                                check_query($result_m,$query_m);
                                            }
                                        }
                                    }
                                   ?>
                                  <div class="modal-body">
                                        <form name="add_more_question" method="POST" enctype="multipart/form-data">
                                            <div class="form-group" >
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
                                                            if (isset($_GET['subject'])) {
                                                                $subject=$_GET['subject'];
                                                            }
                                                            $query = "SELECT id,content,subject FROM tbquestion WHERE id NOT IN (SELECT id_question FROM tbexam WHERE id_exam= $id_exam)  AND subject ='{$subject}' ORDER BY id DESC";
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
                                                         ?>
                                                    </tbody>
                                                </table>
                                                <div class="text-color-error">
                                                    <?php  if (isset($errors) && in_array('checkbox',$errors)) {
                                                        echo "*Enter choose a question for exam !!!";
                                                    }?>
                                                </div>
                                            </div>                                        
                                        </form>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" name="submit" class="btn btn-primary"><li class="fa fa-sign-out"></li> <strong>Add more</strong></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> <strong>Close</strong></button>
                                  </div>
                                </div>

                              </div>
                            </div>
                            <a href="list_exam.php" class="btn btn-danger"><li class="fa fa-sign-out"></li> <strong>Back List Exam</strong></a>
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
                                        <input type="text" name="id_exam" class="form-control" readonly="readonly" value="<?php if(isset($id_exam)){echo $id_exam;} ?>">
                                        <div class="text-color-error">
                                            <?php  if (isset($errors) && in_array('id_exam',$errors)) {
                                                echo "*Enter id exam !!!";
                                            }?>
                                        </div>   
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label><li class="fa fa-h-square"></li> Exam Name</label>
                                        <input type="text" name="name_exam" class="form-control" value="<?php if(isset($name)){echo $name;} ?>">
                                        <div class="text-color-error">
                                            <?php  if (isset($errors) && in_array('name_exam',$errors)) {
                                                echo "*Enter name exam !!!";
                                            }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <label><li class="fa fa-audio-description"></li> Subjects</label>
                                    <div class="text-color-error">
                                    <?php  if (isset($errors) && in_array('subject',$errors)) {
                                        echo "*Enter subject !!!";
                                    }?>
                                    </div>
                                </div>
                                <?php 
                                    if ($subject=="Math") {
                                        ?>
                                            <div class="form-group">
                                                <div class="col-lg-3">
                                                    <div class="funkyradio">
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="subject" value="Math" id="radio1" checked="checked">
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
                                        <?php
                                    }elseif ($subject=="English") {
                                        ?>
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
                                                            <input type="radio" name="subject" value="English" id="radio2" checked="checked">
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
                                        <?php
                                    }elseif ($subject=="Informatics") {
                                         ?>
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
                                                            <input type="radio" name="subject" value="Informatics" id="radio3" checked="checked">
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
                                        <?php
                                    }else{
                                         ?>
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
                                                            <input type="radio" name="subject" value="Physical" id="radio4" checked="checked">
                                                            <label for="radio4"><li class="fa fa-audio-description"></li> <strong>Physical</strong></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                 ?>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <hr>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <label><li class="fa fa-list"></li> List Question Of Exam</label>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th><li class="fa fa-book"></li> Content Question</th>
                                                            <th><li class="fa fa-minus-square"></li> Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            if (isset($_GET['subject'])) {
                                                                $subject=$_GET['subject'];
                                                            }
                                                            $count=0;
                                                            $query_2 = "SELECT id,content FROM tbquestion WHERE id in (SELECT id_question FROM tbexam WHERE id_exam = $id_exam)";
                                                            $result_2 = mysqli_query($dbc,$query_2);
                                                            check_query($result_2,$query_2);
                                                            while ($exam_2 = mysqli_fetch_array($result_2,MYSQLI_ASSOC)){
                                                            $count++;    
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $count; ?></td>
                                                                    <td><?php echo $exam_2['content']; ?></td>
                                                                    <td><a href="delete_question_exam.php?id_exam=<?php echo $id_exam;?>&id_question=<?php echo $exam_2['id'];?>&subject=<?php echo $subject; ?>" onclick="return confirm('Are you sure delete ?')"><li class="fa fa-trash fa-2x"></li></a></td>
                                                                </tr>
                                                            <?php
                                                           }
                                                         ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <label><li class="fa fa-list-ol"></li> Question Number : <?php echo $count; ?></label>
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
