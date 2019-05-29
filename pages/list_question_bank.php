<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
    if (isset($_REQUEST['submit'])) {
        $search = addslashes($_GET['search']);
        if (empty($search)) {
            $message_box =1;
        }else{
            $query_sl = "SELECT content,subject FROM tbquestion  WHERE content like '%$search%' OR subject like '%$search%'";
            $result_sl = mysqli_query($dbc,$query_sl);
            check_query($result_sl,$query_sl);
            if (mysqli_num_rows($result_sl) == 0) {
                $message_error_select=1;
            }else{
                $message_select =1;
            }
        }
    }
 ?>         
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><strong ><li class="fa fa-list"></li> List Question Bank</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
        			<div class="panel-heading">
        				<a href="add_new_question.php" class="btn btn-success"><li class="fa fa-plus"></li> <strong>Add New Question</strong></a>
                        <a href="import_question.php" class="btn btn-info"><li class="fa fa-download"></li> <strong>Import Question from Excel</strong></a>
                        <a href="export_question.php" class="btn btn-primary"><li class="fa fa-upload"></li> <strong>Export Question To Excel</strong></a>
                        
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal3"><li class="fa fa-life-ring"></li> <strong>Support</strong></button>
                            <div id="myModal3" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><li class="fa fa-life-ring"></li> Support </h4>
                                  </div>
                                  <div class="modal-body">
                                    
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <a href="delete_all_question.php" class="btn btn-danger" onclick="return confirm('Are you sure delete all ?')"><li class="fa fa-trash-o"></li> <strong>Delete All</strong></a>
                        <a href="index_for_admin.php" class="btn btn-danger"><li class="fa fa-sign-out"></li> <strong>Back Home</strong></a>
        			</div>
        			<div class="panel-body">
                        <div class="col-lg-11">
                            <form name="search" method="GET" action="#">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" name="search" placeholder="Search ">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit" name="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <p></p>
                        </div>
                        <?php 
                            if (isset($search)){
                                ?>
                                     <div class="col-lg-1">
                                        <a href="list_question_bank.php" class="btn btn-primary"><i class="fa fa-refresh fa-spin fa-fw"></i> <strong>Refresh</strong></a>
                                    </div>
                                <?php
                            }
                         ?>
                        <div class="col-lg-12">
            				<table class="table table-striped table-bordered table-hover">
            					<thead>
            						<tr>
            							<th>#</th>
            							<th><li class="fa fa-book"></li> Question Content</th>
                                        <th><li class="fa fa-audio-description"></li> Subjects</th>
            							<th><li class="fa fa-pencil-square"></li> See and Edit</th>
            							<th><li class="fa fa-minus-square"></li> Delete</th>
            						</tr>
            					</thead>
            					<tbody>
            						<?php 
                                        if (isset($message_box)){
                                            ?>
                                                <div class="alert alert-danger">
                                                    <li class="fa fa-frown-o"></li><strong> Oops!</strong> Please enter content in search box !!!.
                                                </div>
                                            <?php
                                        }elseif(isset($message_error_select)){
                                            ?>
                                                <div class="alert alert-danger">
                                                    <li class="fa fa-frown-o"></li><strong> Sorry !</strong>  Don't have data matched your query.
                                                </div>
                                            <?php
                                        }elseif(isset($message_select)) {
                                            $search = addslashes($_GET['search']);
                                            $query = "SELECT id,content,subject,answer_a,answer_b,answer_c,answer_d,answer_true,guide FROM tbquestion  WHERE content like '%$search%' OR subject like '%$search%' ORDER BY id DESC";
                                            $result = mysqli_query($dbc,$query);
                                            check_query($result,$query);
                                            $count_sl ="SELECT COUNT(id) FROM tbquestion  WHERE content like '%$search%' OR subject like '%$search%'";
                                            $result_sl = mysqli_query($dbc,$count_sl);
                                            list($count_id) = mysqli_fetch_array($result_sl,MYSQLI_NUM);
                                            ?>
                                                <div class="alert alert-success">
                                                    <li class="fa fa-smile-o"></li> Have data matched your query. There are <strong><?php echo $count_id; ?></strong> results found.
                                                </div>
                                            <?php
                                            $ordernum =1;
                                            while ($question = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                            ?>
                                                <tr>
                                                    <td><?php echo $ordernum; ?></td>
                                                    <td><?php echo $question['content']; ?></td>
                                                    <td><?php echo $question['subject']; ?></td>
                                                    <td>
                                                        <a href="edit_question.php?id=<?php echo $question['id']; ?>"><li class="fa fa-edit fa-2x"></li></a></td>    
                                                    </td>
                                                    <td><a href="delete_question.php?id=<?php echo $question['id']; ?>" onclick="return confirm('Are you sure delete ?')"><li class="fa fa-trash fa-2x"></li></a></td>
                                                </tr>
                                            <?php
                                            $ordernum++;
                                            }
                                        }else{
                                            //Đặt số bản ghi cần hiển thị
                                            $limit=10;
                                            //Xác định vị trí bắt đầu
                                            if (isset($_GET['s']) && filter_var($_GET['s'],FILTER_VALIDATE_INT,array('min_range'=>1))) {
                                                $start=$_GET['s'];
                                            }else{
                                                $start=0;
                                            }
                                            //Xác định page
                                            if (isset($_GET['p']) && filter_var($_GET['p'],FILTER_VALIDATE_INT,array('min_range'=>1))) {
                                                $per_page=$_GET['p'];
                                            }else{
                                                //Nếu p k có thì sẽ truy vấn csdl để tìm xem có bn bản ghi -> page
                                                $query_pg="SELECT COUNT(id) FROM tbquestion";
                                                $result_pg=mysqli_query($dbc,$query_pg);
                                                check_query($result_pg,$query_pg);
                                                //Tính số bản ghi
                                                list($record)=mysqli_fetch_array($result_pg,MYSQLI_NUM);
                                                //Tìm số trang bằng cách chia số bản ghi cho $limit
                                                if ($record > $limit) {
                                                    $per_page=ceil($record/$limit);
                                                }else{
                                                    $per_page=1;
                                                }
                                            }
                                            $ordernum =1;
                							$query = "SELECT id,content,subject,answer_a,answer_b,answer_c,answer_d,answer_true,guide FROM tbquestion ORDER BY id DESC LIMIT {$start},{$limit}";
                							$result = mysqli_query($dbc,$query);
                							check_query($dbc,$query);
                							while ($question = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                							?>
                								<tr>
                									<td><?php echo $ordernum; ?></td>
                									<td><?php echo $question['content']; ?></td>
                                                    <td><?php echo $question['subject']; ?></td>
                									<td>
                                                        <a href="edit_question.php?id=<?php echo $question['id']; ?>"><li class="fa fa-edit fa-2x"></li></a></td>    
                                                    </td>
        											<td><a href="delete_question.php?id=<?php echo $question['id']; ?>" onclick="return confirm('Are you sure delete ?')"><li class="fa fa-trash fa-2x"></li></a></td>
                								</tr>
                							<?php
                                            $ordernum++;
                							}
                						?>
                                        </table>
                                        <div style="text-align: center;">
                                        <?php
                                            echo "<ul class='pagination'>";
                                            //Kiểm tra nếu page > 1 thì hiển thị ra
                                            if ($per_page > 1) {
                                                $current_page = ($start/$limit) + 1;
                                                //Nếu không phải là trang đầu thì hiển trị trang trước (Nút Back)
                                                if ($current_page != 1) {
                                                    echo "<li><a href='list_question_bank.php?s=".($start - $limit)."&p={$per_page}'>Back</a></li>";
                                                }
                                                //Hiển thị những phần còn lại của trang
                                                for ($i=1; $i < $per_page; $i++) { 
                                                    if ($i != $current_page) {
                                                        echo "<li><a href='list_question_bank.php?s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
                                                    }else{
                                                        echo "<li class='active'><a>{$i}</a></li>";
                                                    }
                                                }
                                                //Nếu không phải là trang cuối thì hiện nút Next
                                                if ($current_page != $per_page) {
                                                    echo "<li><a href='list_question_bank.php?s=".($start + $limit)."&p={$per_page}'>Next</a></li>";
                                                }

                                            }
                                            echo "</ul>";   
                                            }
                                        ?>
                                        </div>
            					</tbody>
            				</table>
            			</div>
                    </div>
        		</div>
        	</div>
        </div>
    </div>
<?php include('include/footer.php') ?>
