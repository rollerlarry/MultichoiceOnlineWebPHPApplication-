<?php
   ob_start();
    include('include/header.php');
    include('include/sidebar.php');
    include('function/myconnect.php');
    include('function/function.php'); 
    //Xử lý phân trang
    $kt_tren1trang=10; //ky thi tối đa hiển thị trên 1 trang
    if ( !isset($_GET['page'])){
        $page = 0 ;
    }
    else
        $page=$_GET['page'];
    if(isset($_GET['bt-search'])){
        if(!empty($_GET['ip-search'])){
            $search=addslashes($_GET['ip-search']);
            $re2 = mysqli_query($dbc,"SELECT * FROM tbexamination where id_ext like '%$search%' or name_ext like '%$search%'") or die("Không thể truy vấn1");
            $sokt=mysqli_num_rows($re2);
            //Thông báo kết quả nội dung tìm kiếm
            if($sokt==0)
                $note1="No results matching query were found for <strong>$search<strong>";
            else
                $note2="There are $sokt results found";
            $sotrang=ceil($sokt/$kt_tren1trang);
            $start_page=$page*$kt_tren1trang;
            $result2 = mysqli_query($dbc,"SELECT * FROM tbexamination where id_ext like '%$search%' or name_ext like '%$search%' ORDER BY id_ext ASC LIMIT {$start_page}, {$kt_tren1trang} ") or die("Không thể truy vấn");
        }
        else{
            $remind="Please enter a search keyword";
        }

    }
    else{
        $sql_select2="SELECT * from tbexamination";
        $re2=mysqli_query($dbc,$sql_select2);
        $sokt=mysqli_num_rows($re2);
        $sotrang=ceil($sokt/$kt_tren1trang);
        $start_page=$page*$kt_tren1trang;
        $result2=mysqli_query($dbc,"SELECT * from tbexamination ORDER BY id_ext ASC LIMIT {$start_page}, {$kt_tren1trang}") or die("Không thể truy vấn2");
    }


?>
<div id="page-wrapper">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><strong><li class="fa fa-database"></li> Examinations Result</strong></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">

                <a href="index_for_admin.php" class="btn btn-danger"><li class="fa fa-sign-out"></li><strong> Back Home</strong></a>
            </div>
                            <!-- /.panel-heading -->                      
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-hover" >
                    <form action="result_all_examination.php" method="GET">
                        <div class="row">
                            <div class="col-lg-11 search">
                                <div class="input-group custom-search-form">
                                    <input class="form-control" type="text" name="ip-search">
                                    <span class="input-group-btn"><button style="border-radius: 0px 5px 5px 0px;" type="submit" class="btn btn-primary" name="bt-search" value="search"><i class="fa fa-search" aria-hidden="true"></i> Search</button></span>
                                </div>
                            </div>
                        <?php
                            if(isset($_GET['ip-search'])){
                                echo "<div class='col-lg-1 search'>";
                                echo    "<a href='result_all_examination.php' type='button' class='btn btn-primary' name='bt-refresh'><span class='fa fa-refresh fa-spin' aria-hidden='true'></span> Refresh</a>";
                                echo "</div>";
                            }
                        ?>
                        </div>
                    </form>
                    <?php
                        if(isset($remind))
                            echo "<div class='alert alert-warning alert-dismissable' >
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>$remind 
                                    </div>";
                        elseif(isset($note1))
                            echo "<div class='alert alert-danger alert-dismissable' >
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>$note1
                                    </div>";
                        elseif(isset($note2))
                            echo "<div class='alert alert-info alert-dismissable' >
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>$note2
                                    </div>";
                    ?>
                    <thead>
                        <tr>
                            <th><li class="fa fa-hashtag"></li></th>
                            <th><li class="fa fa-ticket"></li> ID</th>
                            <th><li class="fa fa-h-square"></li> Name_examination</th>
                            <th><li class="fa fa-list"></li> Result</th>
                            <th><li class="fa fa-list-ol"></li> Rank</th>
                            <th><li class="fa fa-area-chart"></li> Statistics</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($result2)){
                                $i=1+$page*$kt_tren1trang;
                                while ($row=mysqli_fetch_array($result2)) {
                                    $id_ext=$row['id_ext'];
                                    $sql_select3="SELECT id FROM tbstdext where id_ext='{$id_ext}'";
                                    $result3=mysqli_query($dbc,$sql_select3) or die ("Không thể  truy vấn select 3");

                                    echo "<tr>";
                                    echo    "<td>".$i."</td>";
                                    echo    "<td>".$row['id_ext']."</td>";
                                    echo    "<td>".$row['name_ext']."</td>";
                                    $id_ext=$row['id_ext'];
                                    $count=mysqli_num_rows($result3);
                                    if(!empty($row['start_time'])){
                                        echo    "<td><a href='examination_result.php?id_ext=".$id_ext."'><li class='fa fa-list-alt'> <strong>(".$count." students)</strong></li></a></td>";
                                        echo    "<td><a href='rank_examination.php?id_ext=".$id_ext."'><li class='fa fa-list-ol fa-2x'></li></a></td>";
                                        echo    "<td><a href='statistic_examination.php?id_ext=".$id_ext."'><li class='fa fa-line-chart fa-2x'></li></a></td>";
                                    }
                                    else{
                                        echo    "<td><a style='color: red;' href='#'><li class='fa fa-list-alt'> <strong>(No results)</strong></li></a></td>";
                                        echo    "<td><a style='color: red;' href='#'><li class='fa fa-list-ol fa-2x'></li></a></td>";
                                        echo    "<td><a style='color: red;' href='#'><li class='fa fa-line-chart fa-2x'></li></a></td>";
                                    }
                                    echo "</tr>";
                                    $i++;
                                }
                            }
                        ?>  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
            <!-- /.table-responsive -->
<div class="row">
    <div class="col-lg-6">
        <div class="dataTables_info" id="dataTables-example_info" role="status" aria-live="polite">
        <?php
            if(!isset($sotrang) && !isset($sokt)){
                $sotrang=0;
                $sokt=0;
            }
            if($sokt==0){
                echo "Showing 0 to 0 of 0 entries";
            }
            else{
                $temp=$page*$kt_tren1trang+1;
                if($page==($sotrang-1)){
                    echo "Showing $temp to $sokt of $sokt entries"; 
                }
                else{
                    $ht=$temp+$kt_tren1trang-1;
                    echo "Showing $temp to $ht of $sokt entries";
                }
            }
        ?>
        </div>
    </div>
        <div class="col-lg-6">
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination">
                    <?php
                    $nextpage=$page+1;
                    $prepage=$page-1;
                    if(isset($search)){
                        if ($page==0) {
                            echo "<li class='paginate_button previous disabled'><a>Previous</a>";
                        }
                        else{
                            echo "<li class='paginate_button previous'>";
                            echo "<a href='result_all_examination.php?page={$prepage}&ip-search={$search}'>Previous</a>";
                        }                     
                        echo "</li>";
                    }
                    else{
                        if ($page==0) {
                            echo "<li class='paginate_button previous disabled'><a>Previous</a>";
                        }
                        else{
                            echo "<li class='paginate_button previous'>";
                            echo "<a href='result_all_examination.php?page=$prepage'>Previous</a>";
                        }                     
                        echo "</li>";
                    }
                        if(isset($sotrang)){
                            for ( $i = 0; $i < $sotrang; $i ++ ){
                                if(isset($search)){
                                    if($i==$page)
                                        echo "<li class='paginate_button active'><a href='result_all_examination.php?page={$i}&ip-search={$search}'><strong>".$i."</strong></a></li>";
                                    else
                                        echo "<li class='paginate_button'><a href='result_all_examination.php?page={$i}&ip-search={$search}'><strong>".$i."</strong></a></li>";
                                }
                                else{
                                    if($i==$page)
                                        echo "<li class='paginate_button active'><a href='result_all_examination.php?page={$i}'><strong>".$i."</strong></a></li>";
                                    else
                                        echo "<li class='paginate_button'><a href='result_all_examination.php?page={$i}'><strong>".$i."</strong></a></li>";
                                }
                            }
                        }
                    if(isset($search)){
                        if ($page>=($sotrang-1)) { //lơn hơn cho trường hợp chỉ 1 trang
                            echo "<li class='paginate_button next disabled'><a>Next</a>";
                        }
                        else{
                            echo "<li class='paginate_button next'>";
                            echo "<a href='result_all_examination.php?page={$nextpage}&ip-search={$search}'>Next</a>";
                        }
                        echo "</li>";
                    }
                    else{
                        if ($page>=($sotrang-1)) {
                            echo "<li class='paginate_button next disabled'><a>Next</a>";
                        }
                        else{
                            echo "<li class='paginate_button next'>";
                            echo "<a href='result_all_examination.php?page=$nextpage'>Next</a>";
                        }
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
    </div>
</div><!-- row -->

    </div>
        <?php
            if(!empty($_GET['messenge_true'])){
                echo "<div class='alert alert-success alert-dismissable'><i class='fa fa-check' aria-hidden='true'></i> ".$_GET['messenge_true']."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
            }
            elseif (!empty($messenge_false)) {
                echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> ".$messenge_false."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
            }
            elseif (!empty($messenge_true)) {
                echo "<div class='alert alert-success alert-dismissable'><i class='fa fa-check' aria-hidden='true'></i> ".$messenge_true."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
            }
            if(!empty($error)){
                echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> ".$error."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
            }
            if(!empty($_GET['error'])){
                echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> ".$_GET['error']."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
            }
        ?>      
    <script type="text/javascript">

        function Confirm() {
            return confirm("Do you want to delete this? Students list in the examination will will also be deleted");
        }
        function Confirm1() {
            return confirm("Do you want to delete all examination? Students list in the examination will also be deleted");
        }
 

      </script>
<?php
   ob_flush();
    include('include/footer.php');
?>
