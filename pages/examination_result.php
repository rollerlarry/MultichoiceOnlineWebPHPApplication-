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
    //Xử lý phân trang
        $ts_tren1trang=10; //Số sinh viên tối đa hiển thị trên 1 trang
        if ( !isset($_GET['page'])){
            $page = 0 ;
        }
        else
            $page=$_GET['page'];
        if(isset($_GET['bt-search'])){
            if(!empty($_GET['ip-search'])){
                $search=addslashes($_GET['ip-search']);
                $sql_select="SELECT * FROM tbstdext where id_ext={$id_ext} and id in (SELECT id from tbuser where level=1 and (id like '%$search%' or name like '%$search%'))";
                $re = mysqli_query($dbc,$sql_select) or die("Không thể truy vấn11");
                $sots=mysqli_num_rows($re);
                        //Thông báo kết quả nội dung tìm kiếm
                if($sots==0)
                    $note1="No results matching query were found for <strong>$search<strong>";
                else
                    $note2="There are $sots results found";

                $sotrang=ceil($sots/$ts_tren1trang);
                $start_page=$page*$ts_tren1trang;
                $sql_select="SELECT * FROM tbstdext where id_ext={$id_ext} and id in (SELECT id from tbuser where level=1 and (id like '%$search%' or name like '%$search%')) ORDER BY id ASC LIMIT {$start_page}, {$ts_tren1trang}";
                $result = mysqli_query($dbc,$sql_select) or die("Không thể truy vấn2");                        
            }
            else{
                $remind="Please enter a search keyword";
            }
        }
        else{
            $sql_select="SELECT * from tbstdext where id_ext={$id_ext}";
            $re = mysqli_query($dbc,$sql_select) or die("Không thể truy vấn1");
            $sots=mysqli_num_rows($re);
            $sotrang=ceil($sots/$ts_tren1trang);
            $start_page=$page*$ts_tren1trang;
            $sql_select="SELECT * from tbstdext where id_ext={$id_ext} ORDER BY id ASC LIMIT {$start_page}, {$ts_tren1trang}";
            $result = mysqli_query($dbc,$sql_select) or die("Không thể truy vấn2");
        }
    }
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><li class="fa fa-list-alt"></li><strong> Examination Results: <?php echo $row7['name_ext']; ?></strong></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                
                <?php
                    $sql_select4="SELECT * from tbstdext where id_ext={$id_ext}";
                    $result4 = mysqli_query($dbc,$sql_select4) or die("Không thể truy vấn");
                    $sotsinh=mysqli_num_rows($result4);
                    if($sotsinh>0){
                        echo "<a href='export_examination_result.php?id_ext=$id_ext' class='btn btn-warning'><li class='fa fa-upload'></li><strong> Export Excel</strong></a>";
                    }
                    else
                        echo "<a href='export_examination_result.php?id_ext=$id_ext' class='btn btn-warning disabled'><li class='fa fa-upload'></li><strong> Export Excel</strong></a>";
                ?>

                <a href="result_all_examination.php" class="btn btn-danger"><li class="fa fa-sign-out"></li><strong> Back</strong></a>
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-hover" >
                        <form action="examination_result.php" method="GET">
                            <div class="row">
                                <div class="col-lg-11 search">
                                    <div class="input-group custom-search-form">
                                        <input class="form-control" type="text" name="ip-search">
                                        <input type="hidden" name="id_ext" value="<?php echo $id_ext; ?>">
                                        <span class="input-group-btn"><button style="border-radius: 0px 5px 5px 0px;" type="submit" class="btn btn-primary" name="bt-search" value="search"><i class="fa fa-search" aria-hidden="true"></i> Search</button></span>
                                    </div>
                                </div>
                            <?php
                                if(isset($_GET['ip-search'])){
                                    echo "<div class='col-lg-1 search'>";
                                    echo    "<a href='examination_result.php?id_ext=$id_ext' type='button' class='btn btn-primary' name='bt-refresh'><span class='fa fa-refresh fa-spin' aria-hidden='true'></span> Refresh</a>";
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
                                <th><li class="fa fa-vcard"></li> Name</th>
                                <th><li class="fa fa-trophy"></li> Score</th>
                                <th><li class="fa fa-star"></li> Rate</th>
                                <th><li class="fa fa-check"></li> Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($result)){
                                    $i=1+$page*$ts_tren1trang;
                                    while ($rows=mysqli_fetch_array($result)) {
                                        $id=$rows['id'];
                                        $sql_select2="SELECT * from tbuser where id={$id} and level=1";
                                        $result2=mysqli_query($dbc,$sql_select2);
                                        $row2=mysqli_fetch_array($result2);
                                        echo "<tr>";
                                        echo    "<td>".$i."</td>";
                                        echo    "<td>".$id."</td>";
                                        echo    "<td>".$row2['name']."</td>";
                                        echo    "<td><li style='color: green;list-style-type: none;'>".$rows['score']."</li></td>";
                                        echo "<td>".$rows['rate']."</td>";
                                        if($rows['notes']=='Pass')
                                            echo "<td style='color: green'><strong>".$rows['notes']."</strong></td>";
                                        else
                                            echo "<td style='color: red'><strong>".$rows['notes']."</strong></td>";
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
            if(!isset($sotrang) && !isset($sots)){
                $sotrang=0;
                $sots=0;
            }
            if($sots==0){
                echo "Showing 0 to 0 of 0 entries";
            }
            else{
                $temp=$page*$ts_tren1trang+1;
                if($page==($sotrang-1)){
                    echo "Showing $temp to $sots of $sots entries"; 
                }
                else{
                    $ht=$temp+$ts_tren1trang-1;
                    echo "Showing $temp to $ht of $sots entries";
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
                                echo "<a href='examination_result.php?id_ext=$id_ext&page={$prepage}&ip-search={$search}'>Previous</a>";
                            }                     
                            echo "</li>";
                        }
                        else{
                            if ($page==0) {
                                echo "<li class='paginate_button previous disabled'><a>Previous</a>";
                            }
                            else{
                                echo "<li class='paginate_button previous'>";
                                echo "<a href='examination_result.php?id_ext=$id_ext&page=$prepage'>Previous</a>";
                            }                     
                            echo "</li>";
                        }
                            if(isset($sotrang)){
                                for ( $i = 0; $i < $sotrang; $i ++ ){
                                    if(isset($search)){
                                        if($i==$page)
                                            echo "<li class='paginate_button active'><a href='examination_result.php?id_ext=$id_ext&page={$i}&ip-search={$search}'><strong>".$i."</strong></a></li>";
                                        else
                                            echo "<li class='paginate_button'><a href='examination_result.php?id_ext=$id_ext&page={$i}&ip-search={$search}'><strong>".$i."</strong></a></li>";
                                    }
                                    else{
                                        if($i==$page)
                                            echo "<li class='paginate_button active'><a href='examination_result.php?id_ext=$id_ext&page={$i}'><strong>".$i."</strong></a></li>";
                                        else
                                            echo "<li class='paginate_button'><a href='examination_result.php?id_ext=$id_ext&page={$i}'><strong>".$i."</strong></a></li>";
                                    }
                                }
                            }
                                            if(isset($search)){
                        if ($page>=($sotrang-1)) { //lơn hơn cho trường hợp chỉ 1 trang
                            echo "<li class='paginate_button next disabled'><a>Next</a>";
                        }
                        else{
                            echo "<li class='paginate_button next'>";
                            echo "<a href='examination_result.php?id_ext=$id_ext&page={$nextpage}&ip-search={$search}'>Next</a>";
                        }
                        echo "</li>";
                        }
                        else{
                            if ($page>=($sotrang-1)) {
                                echo "<li class='paginate_button next disabled'><a>Next</a>";
                            }
                            else{
                                echo "<li class='paginate_button next'>";
                                echo "<a href='examination_result.php?id_ext=$id_ext&page=$nextpage'>Next</a>";
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
   ob_flush();
    include('include/footer.php');
?>

