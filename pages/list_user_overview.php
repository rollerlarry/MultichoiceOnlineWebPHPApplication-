<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
 ?>         
    <div id="page-wrapper">
    	<div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><li class="fa fa-list"></li><strong> List Overview User</strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<div class="panel panel-default">
	        		<div class="panel-heading">
	        			<a href="list_user.php" class="btn btn-danger " ><li class="fa fa-sign-out "></li> <strong>Back List User</strong></a>
	        		</div>

	        		<div class="panel-body">
	        			<legend><strong><li class="fa fa-user-secret"></li> Administrator</strong></legend>
	        			<?php 
	        				$query = "SELECT id,avatar,name,phone,primary_occupation,address FROM tbuser WHERE level=2 ORDER BY id DESC ";
    						$result = mysqli_query($dbc,$query);
    						check_query($result,$query);
    						while ($user = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    							?>
	    							<div class="col-lg-2">
						                <div class="contact-box center-version">
						                    <a href="details_info_user.php?id=<?php echo $user['id']; ?>" style="text-decoration: none;">
						                        <img alt="image" class="img-responsive img-thumbnail " src="<?php echo $user['avatar']; ?>">
						                        <h3 class="m-b-xs"><strong><?php echo $user['name']; ?></strong></h3>
						                        <div class="font-bold"><strong><i class="fa fa-briefcase"></i> Primary:  </strong><?php echo $user['primary_occupation']; ?></div>
						                        <address class="m-t-md">
						                           <strong><li class="fa fa-map-marker"></li> Address: </strong><?php echo $user['address']; ?>
						                           <br>
						                           <abbr title="Phone"><strong><i class="fa fa-phone"></i> Phone: </strong></abbr> <?php echo $user['phone']; ?>
						                        </address>
						                    </a>
						                    <div class="contact-box-footer">
						                        <div class="m-t-xs btn-group">
						                            <a class="btn btn-xs btn-white"><i class="fa fa-phone"></i> Call </a>
						                            <a class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> Email</a>
						                            <a class="btn btn-xs btn-white"><i class="fa fa-plus"></i> Follow</a>
						                        </div>
						                    </div>
						                </div>
					            	</div>
    							<?php
    						}
	        			 ?>

	        		</div>
	        		<div class="panel-body">
	        			<legend><strong><li class="fa fa-user"></li> User</strong></legend>
	        			<?php 
	        				$query = "SELECT id,avatar,name,phone,primary_occupation,address FROM tbuser WHERE level=1 ORDER BY id DESC ";
    						$result = mysqli_query($dbc,$query);
    						check_query($result,$query);
    						while ($user = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    							?>
	    							<div class="col-lg-2">
						                <div class="contact-box center-version">
						                    <a href="details_info_user.php?id=<?php echo $user['id']; ?>" style="text-decoration: none;">
						                        <img alt="image" class="img-responsive img-thumbnail " src="<?php echo $user['avatar']; ?>">
						                        <h3 class="m-b-xs"><strong><?php echo $user['name']; ?></strong></h3>
						                        <div class="font-bold"><strong><i class="fa fa-briefcase"></i> Primary:  </strong><?php echo $user['primary_occupation']; ?></div>
						                        <address class="m-t-md">
						                           <strong><li class="fa fa-map-marker"></li> Address: </strong><?php echo $user['address']; ?>
						                           <br>
						                           <abbr title="Phone"><strong><i class="fa fa-phone"></i> Phone: </strong></abbr> <?php echo $user['phone']; ?>
						                        </address>
						                    </a>
						                    <div class="contact-box-footer">
						                        <div class="m-t-xs btn-group">
						                            <a class="btn btn-xs btn-white"><i class="fa fa-phone"></i> Call </a>
						                            <a class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> Email</a>
						                            <a class="btn btn-xs btn-white"><i class="fa fa-plus"></i> Follow</a>
						                        </div>
						                    </div>
						                </div>
					            	</div>
    							<?php
    						}
	        			 ?>

	        		</div>
	        	</div>
	        </div>
	    </div>
    </div>
<?php include('include/footer.php') ?>
