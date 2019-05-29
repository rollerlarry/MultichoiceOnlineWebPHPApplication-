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
			$query_sl = "SELECT name,user,email FROM tbuser WHERE name like '%$search%' OR user like '%$search%' OR email like '%$search%' ORDER BY id DESC";
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
        		<h1 class="page-header"><li class="fa fa-list"></li><strong> List User</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
	        		<div class="panel-heading">
	        			<a href="list_user_overview.php" class="btn btn-info" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Loading</strong>"><li class="fa fa-search "></li> <strong> View Details</strong></a>
	        			<a href="export_user.php" class="btn btn-primary"><li class="fa fa-upload"></li> <strong>Export User To Excel</strong></a>
	        			<a href="delete_all_user.php" class="btn btn-danger" onclick="return confirm('Are you sure delete all ?')"><li class="fa fa-trash-o"></li> <strong>Delete All</strong></a>
	        			<a href="index_for_admin.php" class="btn btn-danger " ><li class="fa fa-sign-out "></li> <strong>Back Home</strong></a>
	        		</div>
	        		<div class="panel-body">
	        			<div class="col-lg-11">
		        			<form name="search" method="GET" action="#">
			        			<div class="input-group custom-search-form">
		                            <input type="text" class="form-control" name="search" placeholder="Search " >
		                                <span class="input-group-btn">
		                                    <button class="btn btn-primary" type="submit" name="submit">
		                                        <i class="fa fa-search"></i> <strong>Search</strong>
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
					                	<a href="list_user.php" class="btn btn-primary"><i class="fa fa-refresh fa-spin fa-fw"></i> <strong>Refresh</strong></a>
					                </div>
		                		<?php
		                	}
		                ?>
		                <div class="col-lg-12">
		        			<table class="table table-striped table-bordered table-hover">
		        				<thead>
		        					<tr>
		        						<th><li class="fa fa-ticket"></li> ID</th>
		        						<th><li class="fa fa-puzzle-piece"></li> Username</th>
		        						<th><li class="fa fa-h-square"></li> Name</th>
		        						<th><li class="fa fa-envelope"></li> Email</th>
		        						<th><li class="fa fa-level-up"></li> Level</th>
		        						<th><li class="fa fa-info-circle"></li> Details Info</th>
		        						<th><li class="fa fa-tachometer"></li> Account Status</th>
		        						<th><li class="fa fa-share-alt-square"></li> Status</th>
		        						<th><li class="fa fa-paper-plane"></li> Send notification</th>
		        						<th><li class="fa fa-refresh"></li> Reset</th>
		        						<th><li class="fa fa-cogs"></li> Fix</th>
		        						<th><li class="fa fa-pencil-square"></li> Edit</th>
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
											$query = "SELECT id,user,name,email,level,st,online FROM tbuser WHERE name like '%$search%' OR user like '%$search%' OR email like '%$search%' ORDER BY id DESC";
			        						$result = mysqli_query($dbc,$query);
			        						check_query($result,$query);
			        							$count_sl ="SELECT COUNT(id)  FROM tbuser WHERE name like '%$search%' OR user like '%$search%' OR email like '%$search%'";
												$result_sl = mysqli_query($dbc,$count_sl);
												list($count_id) = mysqli_fetch_array($result_sl,MYSQLI_NUM);
												?>
													<div class="alert alert-success">
													  	<li class="fa fa-smile-o"></li> Have data matched your query. There are <strong><?php echo $count_id; ?></strong> results found.
													</div>
												<?php
			        						while ($user = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			        							?>
			        							<tr>
			        								<td><?php echo $user['id'] ?></td>
			        								<td><?php echo $user['user'] ?></td>
			        								<td><?php echo $user['name'] ?></td>
			        								<td><?php echo $user['email'] ?></td>
			        								<td>
			        									<?php
			        										if ($user['level'] == 1) {
			        											echo "<li class='fa fa-user'></li> User";
			        										}else{
			        											?>
			        											<div style="color: #337ab7">
			        											<?php
			        											echo "<li class='fa fa-user-secret'></li> Administrator";
			        											?>
			        											</div>
			        											<?php
			        										}
			        									?>
			        								</td>
			        								<td><a href="details_info_user.php?id=<?php echo $user['id']; ?>" style="text-decoration: none;"><li class="fa fa-info-circle"></li> More</a></td>
			        								<td>
														<?php
			        										if ($user['st'] == 2) {
			        										?>
																<button class="btn btn-success btn-sm">Active</button>
			        											<?php
			        										}else{
			        											?>
			        											<button class="btn btn-danger btn-sm">Inactive</button>
			        										<?php
			        										}
			        									?>
			        								</td>
			        								<td>
														<?php
			        										if ($user['online'] == 1) {
			        										?>	
			        											<div style="color: #5cb85c">
																	<li class="fa fa-rss "></li> <b>Online</b>
																</div>
			        											<?php
			        										}else{
			        											?>
			        											<div style="color: #d9534f">
			        												<li class="fa fa-unlink "></li> <b>Offline</b>
			        											</div>
			        										<?php
			        										}
			        									?>
			        								</td>
			        								<td><a href="send_notification.php?id=<?php echo $user['id']; ?>" style="text-decoration: none;"><li class="fa fa-paper-plane"></li> Send Notification</a></td>
													<td><a href="reset_password.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Password after reset its became 123. Are you sure reset ?')"><i class="fa fa-refresh fa-2x"></i></a></td>
													<td><a href="fix_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure fix this account ?')"><li class="fa fa-wrench fa-2x"></li></a></td>
													<td><a href="edit_user.php?id=<?php echo $user['id']; ?>" ><li class="fa fa-edit fa-2x"></li></a></td>
													<td><a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure delete ?')"><li class="fa fa-trash fa-2x"></li></a></td>
			        							</tr>
				        						<?php
				        						}
				        					
										}else{
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
			                                        $query_pg="SELECT COUNT(id) FROM tbuser";
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
											$query = "SELECT id,user,name,email,level,st,online FROM tbuser ORDER BY id DESC LIMIT {$start},{$limit}";
			        						$result = mysqli_query($dbc,$query);
			        						check_query($result,$query);
			        						while ($user = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			        							?>
			        							<tr>
			        								<td><?php echo $user['id'] ?></td>
			        								<td><?php echo $user['user'] ?></td>
			        								<td><?php echo $user['name'] ?></td>
			        								<td><?php echo $user['email'] ?></td>
			        								<td>
			        									<?php
			        										if ($user['level'] == 1) {
			        											echo "<li class='fa fa-user'></li> User";
			        										}else{
			        											?>
			        											<div style="color: #337ab7">
			        											<?php
			        											echo "<li class='fa fa-user-secret'></li> Administrator";
			        											?>
			        											</div>
			        											<?php
			        										}
			        									?>
			        								</td>
			        								<td><a href="details_info_user.php?id=<?php echo $user['id']; ?>" style="text-decoration: none;"><li class="fa fa-info-circle"></li> More</a></td>
			        								<td>
														<?php
			        										if ($user['st'] == 2) {
			        										?>
																<button class="btn btn-success btn-sm">Active</button>
			        											<?php
			        										}else{
			        											?>
			        											<button class="btn btn-danger btn-sm">Inactive</button>
			        										<?php
			        										}
			        									?>
			        								</td>
			        								<td>
														<?php
			        										if ($user['online'] == 1) {
			        										?>	
			        											<div style="color: #5cb85c">
																	<li class="fa fa-rss "></li> <b>Online</b>
																</div>
			        											<?php
			        										}else{
			        											?>
			        											<div style="color: #d9534f">
			        												<li class="fa fa-unlink "></li> <b>Offline</b>
			        											</div>
			        										<?php
			        										}
			        									?>
			        								</td>
			        								<td><a href="send_notification.php?id=<?php echo $user['id']; ?>" style="text-decoration: none;"><li class="fa fa-paper-plane"></li> Send Notification</a></td>
													<td><a href="reset_password.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Password after reset its became 123. Are you sure reset ?')"><i class="fa fa-refresh fa-2x"></i></a></td>
													<td><a href="fix_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure fix this account ?')"><li class="fa fa-wrench fa-2x"></li></a></td>
													<td><a href="edit_user.php?id=<?php echo $user['id']; ?>" ><li class="fa fa-edit fa-2x"></li></a></td>
													<td><a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure delete ?')"><li class="fa fa-trash fa-2x"></li></a></td>
			        							</tr>
			        						<?php
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
				                                    echo "<li><a href='list_user.php?s=".($start - $limit)."&p={$per_page}'>Back</a></li>";
				                                }
				                                //Hiển thị những phần còn lại của trang
				                                for ($i=1; $i < $per_page; $i++) { 
				                                    if ($i != $current_page) {
				                                        echo "<li><a href='list_user.php?s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
				                                    }else{
				                                        echo "<li class='active'><a>{$i}</a></li>";
				                                    }
				                                }
				                                //Nếu không phải là trang cuối thì hiện nút Next
				                                if ($current_page != $per_page) {
				                                    echo "<li><a href='list_user.php?s=".($start + $limit)."&p={$per_page}'>Next</a></li>";
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
