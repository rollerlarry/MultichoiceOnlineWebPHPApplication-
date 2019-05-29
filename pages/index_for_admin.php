
<?php 
include('include/header.php');
include('include/sidebar.php');
include('function/myconnect.php');
include('function/function.php'); 
    $query_qu = "SELECT COUNT(id) FROM tbquestion";
    $result_qu = mysqli_query($dbc,$query_qu);
    check_query($result_qu,$query_qu);
    list($count_qu) = mysqli_fetch_array($result_qu,MYSQLI_NUM);

    $query_le = "SELECT COUNT(id_exam) FROM tb_name_exam";
    $result_le = mysqli_query($dbc,$query_le);
    check_query($result_le,$query_le);
    list($count_le) = mysqli_fetch_array($result_le,MYSQLI_NUM);

    $query_me = "SELECT COUNT(id_ext) FROM tbexamination";
    $result_me = mysqli_query($dbc,$query_me);
    check_query($result_me,$query_me);
    list($count_me) = mysqli_fetch_array($result_me,MYSQLI_NUM);

    
 ?>         
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><strong><i class="fa fa-cog fa-spin fa-1x fa-fw"></i><span class="sr-only">Loading...</span> Dashboard</strong> </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-university fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><strong><?php echo $count_qu;?></strong></div>
                                    <div><strong>Question Bank</strong></div>
                                </div>
                            </div>
                        </div>
                        <a href="list_question_bank.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><strong><?php echo $count_le;?></strong></div>
                                    <div><strong>List Exam</strong></div>
                                </div>
                            </div>
                        </div>
                        <a href="list_exam.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-graduation-cap  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><strong><?php echo $count_me;?></strong></div>
                                    <div><strong>Examinations Management</strong></div>
                                </div>
                            </div>
                        </div>
                        <a href="list_examination.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><strong><?php echo $count_me;?></strong></div>
                                    <div><strong>Examinations Result</strong></div>
                                </div>
                            </div>
                        </div>
                        <a href="result_all_examination.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-lg-12">
                   <div class="panel panel-primary">
                        <div class="panel-heading">
                            <li class="fa fa-pie-chart"></li> Overview
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-6 ">
                                <div class="panel-heading">
                                    <div class="row">
                                            <div id="container" style="height: 400px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="panel-heading">
                                    <div class="row">
                                            <div id="container1" style="height: 400px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-7 text-right">
                                            <div id="piechart2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include('include/footer.php') ?>
<?php 
  $sql_select_s1 = "SELECT COUNT(id) FROM tbuser  WHERE st=2";
  $result_us1 = mysqli_query($connect,$sql_select_s1);
  list($count_us1) = mysqli_fetch_array($result_us1,MYSQLI_NUM);

  $sql_select_s2 = "SELECT COUNT(id) FROM tbuser WHERE st=1";
  $result_us2 = mysqli_query($connect,$sql_select_s2);
  list($count_us2) = mysqli_fetch_array($result_us2,MYSQLI_NUM);

  $sql_select_q1 = "SELECT COUNT(id) FROM tbquestion WHERE subject='Math'";
  $result_qu1 = mysqli_query($connect,$sql_select_q1);
  list($count_qu1) = mysqli_fetch_array($result_qu1,MYSQLI_NUM);

  $sql_select_q2 = "SELECT COUNT(id) FROM tbquestion WHERE subject='English'";
  $result_qu2 = mysqli_query($connect,$sql_select_q2);
  list($count_qu2) = mysqli_fetch_array($result_qu2,MYSQLI_NUM);

  $sql_select_q3 = "SELECT COUNT(id) FROM tbquestion WHERE subject='Informatics'";
  $result_qu3 = mysqli_query($connect,$sql_select_q3);
  list($count_qu3) = mysqli_fetch_array($result_qu3,MYSQLI_NUM);

  $sql_select_q4 = "SELECT COUNT(id) FROM tbquestion WHERE subject='Physical'";
  $result_qu4 = mysqli_query($connect,$sql_select_q4);
  list($count_qu4) = mysqli_fetch_array($result_qu4,MYSQLI_NUM);
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    //Charts User
    Highcharts.chart('container', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Overview About Users'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['Active User', <?php echo $count_us1; ?>],
                ['Inactive User', <?php echo $count_us2; ?>],
            ]
        }]
    });
    //Charts Question
    Highcharts.chart('container1', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Overview About Question Bank'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['Math', <?php echo $count_qu1 ?>],
                ['English', <?php echo $count_qu2 ?>],
                ['Informatics', <?php echo $count_qu3 ?>],
                ['Physical', <?php echo $count_qu4 ?>],
            ]
        }]
    });
</script>
