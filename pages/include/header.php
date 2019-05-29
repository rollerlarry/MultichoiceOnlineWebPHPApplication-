<?php 
    session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
    }
    if ($_SESSION['level']==1) {
        header('Location: test.html');
    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ITCode</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/startmin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../css/morris.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="../css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../css/dataTables/dataTables.responsive.css" rel="stylesheet">
    <!-- Danh's CSS -->
    <link rel="stylesheet" type="text/css" href="../css/search.css">

    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
    <script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.0/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
</head>
<body >

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="index_for_admin.php"><strong>ITC</strong></a>
        </div>

        <!-- Top Navigation: Left Menu -->
        <ul class="nav navbar-nav navbar-left navbar-top-links">
            <li><a href="#"><i class="fa fa-home fa-fw"></i> Website</a></li>
        </ul>

         <?php 
            
            $connect = mysqli_connect("localhost","root","","itc");
            mysqli_query($connect,"SET NAMES 'utf8'");
            $sql_select="SELECT id,title FROM tbmynotification";
            $result = mysqli_query($connect,$sql_select);
            
         ?>
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown navbar-inverse">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <?php 
                            while ( $rows=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                ?>
                                     <a href="">
                                        <div>
                                            <i class="fa fa-cogs"></i> <?php echo $rows['title']; ?>
                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                <?php
                            }
                         ?>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="list_my_notification.php">
                            <strong>See All Notification</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> My Account <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="my_profile.php"><i class="fa fa-user fa-fw"></i> My Profile</a>
                    </li>
                    <li><a href="change_password_admin.php"><i class="fa fa-key fa-fw"></i> Password</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="exit.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>