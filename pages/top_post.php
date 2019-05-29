<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
 ?>
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><li class="fa fa-flag "></li><strong> TOP Post</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
	        		<div class="panel-heading">
	        			<a href="top_post.php" type="submit" name="submit" class="btn btn-info" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Loading</strong>"><li class="fa fa-flag "></li> <strong>TOP Post</strong></a>
	        			<a href="list_post.php" class="btn btn-danger " ><li class="fa fa-sign-out "></li> <strong>Back List Post</strong></a>
	        		</div>
	        		<div class="panel-body">
	        			<table class="table table-striped table-bordered table-hover">
	        				<thead>
	        					<tr>
	        						<th><li class="fa fa-caret-right"></li> TOP</th>
	        						<th><li class="fa fa-clock-o"></li> Time</th>
	        						<th><li class="fa fa-calendar"></li> Day</th>
	        						<th><li class="fa  fa-text-width"></li> Title</th>
	        						<th><li class="fa fa-user"></li> Poster</th>
	        						<th><li class="fa fa-street-view"></li> Who See</th>
	        						<th><li class="fa fa-share-alt-square"></li> Status</th>
	        						<th><li class="fa fa-pencil-square"></li> Edit</th>
	        						<th><li class="fa fa-minus-square"></li> Delete</th>
	        					</tr>
	        				</thead>
	        				<tbody>
	        					<div class="alert alert-success">
								  	<li class="fa fa-smile-o fa-2x"></li><strong> TOP!</strong> Top 3 posts.
								</div>
										<?php
											$i=1;
											$query = "SELECT id,view,post_time,post_day,title,poster,who,st FROM tbpost ORDER BY view DESC LIMIT 3";
			        						$result = mysqli_query($dbc,$query);
			        						check_query($result,$query);
												while ($post = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			        							?>
			        							<tr>
			        								<td><?php echo $i++ ?></td>
			        								<td><?php echo $post['post_time'] ?></td>
			        								<td><?php echo $post['post_day'] ?></td>
			        								<td><?php echo $post['title'] ?></td>
			        								<td><?php echo $post['poster'] ?></td>
			        								<td>
			        									<?php
			        										if ($post['who'] == "Public") {
			        											?>
																	<li class="fa fa-globe"> </li> Public
			        											<?php
			        										}else{
			        											?>
																	<li class="fa fa-lock"> </li> Only me
			        											<?php
			        										}
			        										
			        									?>
			        								</td>
			        								<td>
			        									<?php
			        										if ($post['st'] == "Display") {
			        											?>
																	<li class="glyphicon glyphicon-eye-open"> </li> Display
			        											<?php
			        										}else{
			        											?>
																	<li class="glyphicon glyphicon-eye-close"> </li> Not Display
			        											<?php
			        										}
			        										
			        									?>
		        									</td>
													<td><a href="edit_post.php?id=<?php echo $post['id']; ?>" ><li class="fa fa-edit fa-2x"></li></a></td>
													<td><a href="delete_post.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure delete ?')"><li class="fa fa-trash fa-2x"></li></a></td>
			        							</tr>
												<?php
												}
												?>
													<!-- <div class="alert alert-danger">
													  	<li class="fa fa-frown-o"></li><strong> Oops!</strong> No data matched your query.
													</div> -->
												<?php
										
									?>
	        				</tbody>
	        			</table>
	        		</div>
	        	</div>
	        </div>
        </div>
    </div>
<?php include('include/footer.php') ?>
