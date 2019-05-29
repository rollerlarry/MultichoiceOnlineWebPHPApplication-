<?php
   ob_start();
    include('include/header.php');
    include('include/sidebar.php');
    include('function/myconnect.php');
    if(isset($_GET['id_ext'])){
        $id_ext=$_GET['id_ext'];
        $sql_select7="SELECT * FROM tbexamination where id_ext=$id_ext";
        $result7=mysqli_query($dbc,$sql_select7);
        $row7=mysqli_fetch_array($result7);

        $sql_select="SELECT * from tbexamination where id_ext={$id_ext}";
        $result = mysqli_query($dbc,$sql_select) or die("Không thể truy vấn1");
        $row= mysqli_fetch_array($result);

        $sql_selecttotal="SELECT id_ext from tbstdext where id_ext={$id_ext}";
        $retotal=mysqli_query($dbc,$sql_selecttotal) or die ("Error total");
        $total=mysqli_num_rows($retotal);
        
        //Data of chart score

        $sql_select0="SELECT score from tbstdext where id_ext={$id_ext} and score=0";
        $re0=mysqli_query($dbc,$sql_select0) or die ("Error 0");
        $count0=mysqli_num_rows($re0);


        $sql_select1="SELECT score from tbstdext where id_ext={$id_ext} and score>=1 and score<=10";
        $re1=mysqli_query($dbc,$sql_select1) or die ("Error 1");
        $count1=mysqli_num_rows($re1);


        $sql_select2="SELECT score from tbstdext where id_ext={$id_ext} and score>=11 and score<=20";
        $re2=mysqli_query($dbc,$sql_select2) or die ("Error 2");
        $count2=mysqli_num_rows($re2);



        $sql_select3="SELECT score from tbstdext where id_ext={$id_ext} and score>=21 and score<=30";
        $re3=mysqli_query($dbc,$sql_select3) or die ("Error 3");
        $count3=mysqli_num_rows($re3);
        @$rate3=$count3/$total*100;

        $sql_select4="SELECT score from tbstdext where id_ext={$id_ext} and score>=31 and score<=40";
        $re4=mysqli_query($dbc,$sql_select4) or die ("Error 4");
        $count4=mysqli_num_rows($re4);


        $sql_select5="SELECT score from tbstdext where id_ext={$id_ext} and score>=41 and score<=50";
        $re5=mysqli_query($dbc,$sql_select5) or die ("Error 5");
        $count5=mysqli_num_rows($re5);


        $sql_select6="SELECT score from tbstdext where id_ext={$id_ext} and score>=51 and score<=60";
        $re6=mysqli_query($dbc,$sql_select6) or die ("Error 6");
        $count6=mysqli_num_rows($re6);


        $sql_select7="SELECT score from tbstdext where id_ext={$id_ext} and score>=61 and score<=70";
        $re7=mysqli_query($dbc,$sql_select7) or die ("Error 7");
        $count7=mysqli_num_rows($re7);


        $sql_select8="SELECT score from tbstdext where id_ext={$id_ext} and score>=71 and score<=80";
        $re8=mysqli_query($dbc,$sql_select8) or die ("Error 8");
        $count8=mysqli_num_rows($re8);


        $sql_select9="SELECT score from tbstdext where id_ext={$id_ext} and score>=81 and score<=90";
        $re9=mysqli_query($dbc,$sql_select9) or die ("Error 9");
        $count9=mysqli_num_rows($re9);


        $sql_select10="SELECT score from tbstdext where id_ext={$id_ext} and score>=91 and score<=100";
        $re10=mysqli_query($dbc,$sql_select10) or die ("Error 10");
        $count10=mysqli_num_rows($re10);


        //Data of chart rate

        $sql_selectAplus="SELECT rate from tbstdext where id_ext={$id_ext} and rate='A+'";
        $reAplus=mysqli_query($dbc,$sql_selectAplus) or die ("Error A+");
        $countAplus=mysqli_num_rows($reAplus);
        @$rateAplus=$countAplus/$total*100;

        $sql_selectA="SELECT rate from tbstdext where id_ext={$id_ext} and rate='A'";
        $reA=mysqli_query($dbc,$sql_selectA) or die ("Error A");
        $countA=mysqli_num_rows($reA);
        @$rateA=$countA/$total*100;

        $sql_selectB="SELECT rate from tbstdext where id_ext={$id_ext} and rate='B'";
        $reB=mysqli_query($dbc,$sql_selectB) or die ("Error B");
        $countB=mysqli_num_rows($reB);
        @$rateB=$countB/$total*100;

        $sql_selectC="SELECT rate from tbstdext where id_ext={$id_ext} and rate='C'";
        $reC=mysqli_query($dbc,$sql_selectC) or die ("Error C");
        $countC=mysqli_num_rows($reC);
        @$rateC=$countC/$total*100;

        $sql_selectD="SELECT rate from tbstdext where id_ext={$id_ext} and rate='D'";
        $reD=mysqli_query($dbc,$sql_selectD) or die ("Error D");
        $countD=mysqli_num_rows($reD);
        @$rateD=$countD/$total*100;

        $sql_selectF="SELECT rate from tbstdext where id_ext={$id_ext} and rate='F'";
        $reF=mysqli_query($dbc,$sql_selectF) or die ("Error F");
        $countF=mysqli_num_rows($reF);
        @$rateF=$countF/$total*100;

        //Data of chart result

        $sql_selectPass="SELECT notes from tbstdext where id_ext={$id_ext} and notes='Pass'";
        $rePass=mysqli_query($dbc,$sql_selectPass) or die ("Error Pass");
        $countPass=mysqli_num_rows($rePass);
        @$ratePass=$countPass/$total*100;

        $sql_selectFail="SELECT notes from tbstdext where id_ext={$id_ext} and notes='Fail'";
        $reFail=mysqli_query($dbc,$sql_selectFail) or die ("Error Fail");
        $countFail=mysqli_num_rows($reFail);
        @$rateFail=$countFail/$total*100;

    }
    else{
        header("Location: list_examination.php");
    }

?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><li class="fa fa-bar-chart-o"></li><strong> Statictis Examination: <?php echo $row7['name_ext']; ?></strong></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                     <a href="result_all_examination.php" class="btn btn-danger"><li class="fa fa-sign-out"></li><strong> Back Examinations Result</strong></a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                    <hr>
                    <div class="col-lg-6">
                        <div id="container1" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                    </div>
                    <div class="col-lg-6">
                        <div id="container2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                    </div>

                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
<?php
   ob_flush();
    include('include/footer.php');
?>
<script type="text/javascript">
 // Create the chart
var name_ext = "<?php echo $row['name_ext']; ?>";
var strong1= "<strong>";
var strong2= "</strong>";
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: strong1+'The scores chart of '+ name_ext +' examination'+strong2
    },
    subtitle: {
        text: 'Click chart context menu to export the chart.'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Number of students in the examination'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [{
        name: 'Score: ',
        colorByPoint: false,
        data: [{
            name: '0',
            y: <?php echo $count0; ?>,
            drilldown: '0'
        }, {
            name: '1-10',
            y: <?php echo $count1; ?>,
            drilldown: '1-10'
        }, {
            name: '11-20',
            y: <?php echo $count2; ?>,
            drilldown: '11-20'
        }, {
            name: '21-30',
            y: <?php echo $count3; ?>,
            drilldown: '21-30'
        }, {
            name: '31-40',
            y: <?php echo $count4; ?>,
            drilldown: '31-40'
        }, {
            name: '41-50',
            y: <?php echo $count5; ?>,
            drilldown: '41-50'
        }, {
            name: '51-60',
            y: <?php echo $count6; ?>,
            drilldown: '51-60'
        }, {
            name: '61-70',
            y: <?php echo $count7; ?>,
            drilldown: '61-70'
        }, {
            name: '71-80',
            y: <?php echo $count8; ?>,
            drilldown: '71-80'
        }, {
            name: '81-90',
            y: <?php echo $count9; ?>,
            drilldown: '81-90'
        }, {
            name: '91-100',
            y: <?php echo $count10; ?>,
            drilldown: '91-100'
        }]
    }],
});
//---------------------------------------------------Chart Rate---------------------------------------------
    Highcharts.chart('container1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: strong1+'The rate chart of '+name_ext +' examination'+strong2
    },
    subtitle: {
        text: 'Click chart context menu to export the chart.'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Rate: ',
        colorByPoint: true,
        data: [{
            name: 'A+',
            y: <?php echo $rateAplus; ?>,
        }, {
            name: 'A',
            y: <?php echo $rateA; ?>,
        }, {
            name: 'B',
            y: <?php echo $rateB; ?>,   
        }, {
            name: 'C',
            y: <?php echo $rateC; ?>,
        }, {
            name: 'D',
            y: <?php echo $rateD; ?>,
        }, {
            name: 'F',
           y:  <?php echo $rateF; ?>,
        }]
    }]
});

//---------------------------------------------------Chart Result---------------------------------------------
    Highcharts.chart('container2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: strong1+'The result chart of '+ name_ext +'examination'+strong2
    },
    subtitle: {
        text: 'Click chart context menu to export the chart.'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Result',
        colorByPoint: true,
        data: [{
            name: 'Pass',
            y: <?php echo $ratePass; ?>,
        }, {
            name: 'Fail',
            y: <?php echo $rateFail; ?>,
        }]
    }]
});
</script>

