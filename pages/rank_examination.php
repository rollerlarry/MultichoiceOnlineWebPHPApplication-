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
        
        $sql_select="SELECT * from tbstdext where id_ext={$id_ext} ORDER BY score DESC LIMIT 0, 99";
        $result = mysqli_query($dbc,$sql_select) or die("Không thể truy vấn2");
    }
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><li class="fa fa-list-ol"></li><strong> Examination Rank (Top 100): <?php echo $row7['name_ext']; ?></strong></h1>
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
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th><li class="fa fa-list-ol"></li> Rank</th>
                                    <th><li class="fa fa-ticket"></li> ID</th>
                                    <th><li class="fa fa-vcard"></li> Name</th>
                                    <th><li class="fa fa-trophy"></li> Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(isset($result)){
                                        $rank=0;
                                        $temp=null;
                                        while ($rows=mysqli_fetch_array($result)) {
                                            $id=$rows['id'];
                                            $sql_select2="SELECT * from tbuser where id={$id} and level=1 ";
                                            $result2=mysqli_query($dbc,$sql_select2);
                                            $row2=mysqli_fetch_array($result2);
                                            if($temp!=$rows['score']){
                                                $rank++;
                                            }
                                            if($rank==1)
                                                echo "<tr class='info'>";
                                            elseif($rank==2)
                                                echo "<tr class='warning'>";
                                            elseif($rank==3)
                                                echo "<tr class='danger'>";
                                            else
                                                echo "<tr>";
                                            if($rank==1) echo "<td> ".$rank." <li class='fa fa-trophy' style='color: gold;'></li></td>";
                                            else echo "<td>".$rank."</td>";
                                            echo    "<td>".$id."</td>";
                                            echo    "<td>".$row2['name']."</td>";
                                            echo    "<td><li style='color: green;list-style-type: none;'>".$rows['score']."</li></td>";
                                            echo "</tr>";
                                            $temp=$rows['score'];
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
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

