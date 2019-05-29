<?php
   ob_start();
    include('include/header.php');
    include('include/sidebar.php');
    include('function/myconnect.php');
    include('function/function.php'); 


    $sql_select="SELECT distinct subject from tbexam";
    $result=mysqli_query($dbc,$sql_select) or die ("Lỗi truy vấn");
    if(isset($_POST['name_ext']) && isset($_POST['subject'])){
        $name_ext=addslashes($_POST['name_ext']);
        $subject=$_POST['subject'];
        $code=rand_string(6);
        $sql_insert="INSERT INTO tbexamination (name_ext,subject,code) VALUES ('{$name_ext}','{$subject}','{$code}')";
        mysqli_query($dbc,$sql_insert) or die ("Không thể tạo kỳ thi") ;
        if(mysqli_affected_rows($dbc) == 1){
            ?>
            <script type="text/javascript">
                swal("Successful!", "This examination has been creacted!", "success");
            </script>
            <?php
            header("Locantion: list_examination.php");  
        }
        else
            $messenge_false="Create exam failed!";
    }
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
<head>
    <meta http-equiv="refresh" content="60;url=http://localhost/ITC/pages/list_examination.php">
</head>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><strong><li class="fa fa-database"></li> Examinations Management</strong></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" ><li class="fa fa-plus"></li><strong> Add a examination</strong></button>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><li class='fa fa-close'></li></button>
                                <h4 class="modal-title"><li class="fa fa-plus"></li><strong> Add examination</strong></h4>
                            </div>
                            <div class="modal-body">
                            <form role="form" action="#" method="POST">
                                <div class="form-group has-warning">
                                    <label class="control-label" for="inputSuccess">Name</label>
                                    <input type="text" class="form-control" id="inputSuccess" name="name_ext">
                                </div>
                                <div class="form-group">
                                    <label>Choose Subject</label>
                                    <select class="form-control" name="subject">
                                        <?php
                                            while ($row=mysqli_fetch_array($result)){
                                            $subject=$row['subject'];
                                            echo "<option value='".$subject."'>".$subject."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-save"></li><strong> Create</strong></button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                      
                    </div>
                  </div>
                   
                    <!-- End Modal -->

                    <button type="button" class="btn btn-info"><li class="fa fa-life-ring"></li><strong> Support</strong></button>
                     <a href="delete_all_examination.php" onclick="return Confirm1();" class="btn btn-danger"><li class="fa fa-minus-circle"></li><strong> Delete all</strong></a>
                     <a href="index_for_admin.php" class="btn btn-danger"><li class="fa fa-sign-out"></li><strong> Back Home</strong></a>
                </div>                
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-hover" >
                            <form action="list_examination.php" method="GET">
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
                                        echo    "<a href='list_examination.php' type='button' class='btn btn-primary' name='bt-refresh'><span class='fa fa-refresh fa-spin' aria-hidden='true'></span> Refresh</a>";
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
                                    <th><li class="fa fa-h-square"></li> Name</th>
                                    <th><li class="fa fa-barcode"></li> Exam Code</th>
                                    <th><li class="fa fa-book"></li> Subject</th>
                                    <th><li class="fa fa-share-alt-square"></li> Status</th>
                                    <th><li class="fa fa-calendar-check-o"></li> Start Time</th>
                                    <th><li class="fa fa-list"></li> List student</th>
                                    <th><li class="fa fa-wrench"></li> Installation</th>
                                    <th><li class="fa fa-refresh"></li> Reset</th>
                                    <th><li class="fa fa-minus-square"></li> Delete</th>
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
                                            echo    "<td >".$i."</td>";
                                            echo    "<td>".$row['id_ext']."</td>";    
                                            echo    "<td>".$row['name_ext']."</td>";
                                            echo    "<td>".$row['code']."</td>";
                                            echo    "<td>".$row['subject']."</td>";

                                            if(empty($row['start_time'])){
                                                echo    "<td><a href='process_examination.php?id_ext=".$id_ext."&page=$page'><li class='fa fa-rocket'><strong> Start</strong></li></a></td>";
                                            }
                                            elseif( (strtotime(date('Y-m-d H:i:s')) >= strtotime($row['start_time']))  && (strtotime(date('Y-m-d H:i:s')) < (strtotime($row['start_time'])+$row['time_delay']*60))){
                                                echo    "<td><li class='fa fa-spinner fa-spin' style='color: Indigo;'></li><span style='color: Indigo;'><strong>&nbsp Delaying...</strong></span></td>";    
                                            }
                                            elseif( (strtotime(date('Y-m-d H:i:s')) >= strtotime($row['start_time'])+$row['time_delay']*60)  && (strtotime(date('Y-m-d H:i:s')) <= (strtotime($row['start_time'])+$row['time_exam']*60+$row['time_delay']*60))){
                                                echo    "<td><li class='fa fa-hourglass fa-spin' style='color: green;'></li><span style='color: green;'><strong>&nbsp Examing...</strong></span></td>";    
                                            }
                                            else{
                                                echo    "<td><a href='#'><li class='fa fa-lock' style='color: red;'><strong> Finished</strong></li></a></td>";    
                                            }

                                            if(!empty($row['start_time']))
                                                echo "<td style='color: green'>".$row['start_time']."</td>";
                                            else
                                                echo "<td>None</td>";
                                            $id_ext=$row['id_ext'];
                                            $count=mysqli_num_rows($result3);
                                            echo    "<td><a href='list_student.php?id_ext=".$id_ext."'><li class='fa fa-users'> <strong>(".$count." students)</strong></li></a></td>";
                                            echo    "<td><a href='install_examination.php?id_ext=".$id_ext."'><li class='fa fa-cogs fa-2x'> </li></a></td>";
                                            echo    "<td><a onclick='return Confirm2();' href='reset_examination.php?id_ext=".$id_ext."'><li class='fa fa-refresh fa-2x'> </li></a></td>";
                                            echo    "<td><a onclick='return Confirm();' href='delete_examination.php?id_ext=".$id_ext."'><li class='fa fa-trash fa-2x'></li></a></td>";
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
                                    echo "<a href='list_examination.php?page={$prepage}&ip-search={$search}'>Previous</a>";
                                }                     
                                echo "</li>";
                            }
                            else{
                                if ($page==0) {
                                    echo "<li class='paginate_button previous disabled'><a>Previous</a>";
                                }
                                else{
                                    echo "<li class='paginate_button previous'>";
                                    echo "<a href='list_examination.php?page=$prepage'>Previous</a>";
                                }                     
                                echo "</li>";
                            }
                                if(isset($sotrang)){
                                    for ( $i = 0; $i < $sotrang; $i ++ ){
                                        if(isset($search)){
                                            if($i==$page)
                                                echo "<li class='paginate_button active'><a href='list_examination.php?page={$i}&ip-search={$search}'><strong>".$i."</strong></a></li>";
                                            else
                                                echo "<li class='paginate_button'><a href='list_examination.php?page={$i}&ip-search={$search}'><strong>".$i."</strong></a></li>";
                                        }
                                        else{
                                            if($i==$page)
                                                echo "<li class='paginate_button active'><a href='list_examination.php?page={$i}'><strong>".$i."</strong></a></li>";
                                            else
                                                echo "<li class='paginate_button'><a href='list_examination.php?page={$i}'><strong>".$i."</strong></a></li>";
                                        }
                                    }
                                }
                            if(isset($search)){
                                if ($page>=($sotrang-1)) { //lơn hơn cho trường hợp chỉ 1 trang
                                    echo "<li class='paginate_button next disabled'><a>Next</a>";
                                }
                                else{
                                    echo "<li class='paginate_button next'>";
                                    echo "<a href='list_examination.php?page={$nextpage}&ip-search={$search}'>Next</a>";
                                }
                                echo "</li>";
                            }
                            else{
                                if ($page>=($sotrang-1)) {
                                    echo "<li class='paginate_button next disabled'><a>Next</a>";
                                }
                                else{
                                    echo "<li class='paginate_button next'>";
                                    echo "<a href='list_examination.php?page=$nextpage'>Next</a>";
                                }
                                echo "</li>";
                            }
                            ?>
                        </ul>
                    </div>
            </div>
        </div><!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <?php
                if (!empty($messenge_false)) {
                    echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> ".$messenge_false."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
                }
                if(!empty($error)){
                    echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> ".$error."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
                }
                if(!empty($_GET['error'])){
                    echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> ".$_GET['error']."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
                }
            ?>  
        </div>   
    </div> 
</div>  
    <script type="text/javascript">

        function Confirm() {
            return confirm("Do you want to delete this? List of students in the examination will will also be deleted!");
        }
        function Confirm1() {
            return confirm("Do you want to delete all examination? List of students in the examination will also be deleted!");
        }
        function Confirm2() {
            return confirm("Do you want to reset this examination? List of students in the examination has not been changed!");
        }

      </script>
    <!-- /.panel-body -->
<?php
    ob_flush();
    include('include/footer.php');
?>
