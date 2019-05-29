<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
 ?>           
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong><li class="fa fa-bell"></li> My Notification</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
	        		<div class="panel-heading">
                        <a href="list_my_notification.php" class="btn btn-danger"><li class="fa fa-sign-out"></li> <strong>Back List My Notification</strong></a>
	        		</div>
	        		<div class="panel-body">
	        			<div class="panel panel-green">
                            <div class="panel-heading">
                                <li class="fa fa-user-circle"></li> Nguyễn Văn A  <li class="fa fa-chevron-right"></li><li class="fa fa-chevron-right"></li>  Fix Account
                            </div>
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <br>Vestibulum tincidunt est vitae ultrices accumsan. <br>Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                                <p ><small class="panel-footer" >22:10 > 22-12-2017</small></p>
                            </div>
                            <div class="panel-footer">
                               	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3"><li class="fa fa-reply-all"></li> <strong>Reply</strong></button>
                                <div id="myModal3" class="modal fade" role="dialog">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><li class="fa fa-reply-all"></li> Reply For User</h4>
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
                                            <form name="reply" method="POST" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label>To</label> <input type="text" name="send_to" class="form-control" value="Nguyễn Văn A" readonly="true">
                                                </div>
                                                <div class="form-group" >
                                                    <textarea class="form-control" rows="10"></textarea>
                                                    <div class="text-color-error">
                                                        <?php  if (isset($errors) && in_array('checkbox',$errors)) {
                                                            echo "*Enter choose a question for exam !!!";
                                                        }?>
                                                    </div>
                                                </div>                                        
                                            </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="submit" name="submit" class="btn btn-primary"><li class="fa fa-reply-all"></li> Reply</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                               	<button class="btn btn-warning"><li class="fa fa-cogs"></li> Fix Problem</button>
                            </div>
                        </div>
	        		</div>
	        	</div>
	        </div>
        </div>
    </div>
<?php include('include/footer.php') ?>
