<!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    
                    <!-- <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>
                    </li> -->
                    <br>
                    <?php 
                        $id=$_SESSION['id'];
                        $connect = mysqli_connect("localhost","root","","itc");
                        mysqli_query($connect,"SET NAMES 'utf8'");
                        $sql_select="SELECT name FROM tbuser WHERE id = $id";
                        $result = mysqli_query($connect,$sql_select);
                        $rows=mysqli_fetch_array($result);
                     ?>
                    <div class="form-group text-center">
                        <img alt="image" class="img-responsive img-thumbnail " src="images/avatar.jpg">
                        <h3><?php echo $rows['name']; ?></h3>
                        
                    </div>
                    <li>
                        <a href="index_for_admin.php" class="active"><i class="fa fa-dashboard fa-fw"></i><strong> Dashboard</strong></a>
                    </li>
                     <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i> <strong>User</strong><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="add_new_user.php" class="fa fa-plus"> Add New User</a>
                            </li>
                            <li>
                                 <a href="list_user.php" class="fa fa-list"> List User</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-newspaper-o fa-fw"></i> <strong>Post</strong><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="add_new_post.php" class="fa fa-plus"> Add New Post</a>
                            </li>
                            <li>
                                 <a href="list_post.php" class="fa fa-list"> List Post</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-bell-o fa-fw"></i> <strong>Notifications</strong><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                 <a href="send_notification_all_user.php" class="fa fa-paper-plane"> Send Notifications</a>
                            </li>
                            <li>
                                 <a href="list_notification.php" class="fa fa-list"> List Notification</a>
                            </li>
                        </ul>
                    </li>

                   
                    <li>
                        <a href="faqs.php"><i class="fa fa-life-ring fa-fw"></i> <strong>FAQs</strong><span class="fa arrow"></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>