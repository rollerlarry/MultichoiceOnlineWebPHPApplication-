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
    else
         header("Location: list_examination.php");
    //Thêm sinh viện trong modal
    if(isset($_POST['id'])){
        $id=$_POST['id'];
        //kiểm tra thí sinh này có trong bảng tbuser không
        $sql_select2="SELECT * from tbuser where id={$id} and level=1";
        $result2=mysqli_query($dbc,$sql_select2);
        $kiemtra2=mysqli_num_rows($result2);
        if($kiemtra2>0){
            $sql_select3="SELECT * from tbstdext where id_ext={$id_ext} and id={$id}";
            $result3=mysqli_query($dbc,$sql_select3);
            $kiemtra3=mysqli_num_rows($result3);
            if($kiemtra3==0){
                $sql_insert="INSERT INTO tbstdext(id,id_ext) VALUES ({$id},{$id_ext})";
                mysqli_query($dbc,$sql_insert) or die ("Không thể thêm thí sinh");
                if(mysqli_affected_rows($dbc) == 1){
                    ?>
                    <script type="text/javascript">
                        swal("Successful!", "This examination has been creacted!", "success");
                    </script>
                    <?php
                    $messenge_true="There is a student just added to the list!";
                    header("Location: list_student.php?id_ext=$id_ext&messenge_true=$messenge_true");
                } 
                else
                    $messenge_false="Add student failed!";
            }
            else
                $error="This student has participated in this examination";
        }
        else
            $error="This student does not exist";
    }

    //Thêm nhiều thí sinh
    if(isset($_POST['btnds'])){
        // $dsid=$_POST['dsid'];
        $i=0;
        $dsid=$_POST['dsid'];
        foreach($dsid as $value) {
            $sql_insert6 ="INSERT INTO tbstdext(id, id_ext) VALUES ({$value},{$id_ext})";
            $result6 =mysqli_query($dbc,$sql_insert6) or die ("Không thể truy vấn 6");
            $i++;
        }
        $messenge_true="There are $i students just added to the list!";
        header("Location: list_student.php?id_ext=$id_ext&messenge_true=$messenge_true");

    }
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><strong><li class="fa fa-list"></li> List of Students: <?php echo $row7['name_ext']; ?></strong></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <!-- Modal content-->
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><li class="fa fa-plus"></li><strong> Add a student with ID</strong></button>
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><li class='fa fa-close'></li></button>
                                <h4 class="modal-title"><li class="fa fa-plus"><strong> Add Student</strong></h4>
                            </div>
                            <div class="modal-body">
                                <form action="#" method="POST">
                                    <div class="form-group" style="">
                                        <label>Enter Student' ID: </label>
                                        <div class="form-group input-group">
                                            <input type="text" name="id" class="form-control" required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" type="submit" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-plus"></li><strong> Add</strong>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><strong>Close</strong></button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Model -->
                    
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal3"><li class="fa fa-plus"></li><strong> Add more students</strong></button>
                    <div class="modal fade" id="myModal3" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><li class='fa fa-close'></li></button>
                                <h4 class="modal-title"><li class="fa fa-plus"><strong> Add more students</strong></h4>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th><li class="fa fa-pencil-square-o"><strong> Choose</strong></th>
                                            <th><li class="fa fa-hashtag"><strong> ID</strong></th>
                                            <th><li class="fa fa-vcard"><strong> Name</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                $sql_select5 ="SELECT * from tbuser where id NOT IN (SELECT id FROM tbstdext where id_ext={$id_ext} ) and level=1";
                                                $result5=mysqli_query($dbc,$sql_select5) or die ("Không thể  truy vấn 5");
                                                echo "<form action='#' method='POST'>";
                                                while ($row=mysqli_fetch_array($result5)) {
                                                    $id_kq=$row['id'];
                                                    echo "<tr>";
                                                    echo    "<td>
                                                                <div class='btn-group btn-group' data-toggle='buttons'>
                                                                  <label class='btn'>
                                                                      <input  type='checkbox' name='dsid[]' value='".$id_kq."' id='".$id_kq."'><i class='fa fa-square-o fa-2x'></i><i class='fa fa-check-square-o fa-2x'></i>
                                                                  </label>
                                                                </div>
                                                            </td>";
                                                    echo    "<td>".$row['id']."</td>";
                                                    echo    "<td>".$row['name']."</td>";
                                                    echo "</tr>";
                                                }
                                    echo "</tbody>";
                                echo "</table>"; 
                            echo "</div>";
                            echo "<div class='modal-footer'>";
                                                echo "<button class='btn btn-success' type='submit' name='btnds' value='add' ><li class='fa fa-plus'><strong> Add more students</strong></button>";
                                                echo "</form>";
                                        ?>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><strong>Close</strong></button>
                            </div>
                            </div>
                        </div>
                    </div>
 

                    <a href="import_student.php?id_ext=<?php echo $id_ext; ?>" type="button" class="btn btn-primary" ><li class="fa fa-download"></li><strong> Import Excel</strong></a>
                    <?php
                        $sql_select4="SELECT * from tbstdext where id_ext={$id_ext}";
                        $result4 = mysqli_query($dbc,$sql_select4) or die("Không thể truy vấn");
                        $sotsinh=mysqli_num_rows($result4);
                        if($sotsinh>0){
                            echo "<a href='export_student.php?id_ext=$id_ext' class='btn btn-warning'><li class='fa fa-upload'></li><strong> Export Excel</strong></a>";
                        }
                        else
                            echo "<a href='export_student.php?id_ext=$id_ext' class='btn btn-warning disabled'><li class='fa fa-upload'></li><strong> Export Excel</strong></a>";
                    ?>
                    
                    <button type="button" class="btn btn-info"><li class="fa fa-life-ring"></li><strong> Support</strong></button>
                    <a href="delete_all_student.php?id_ext=<?php echo $id_ext; ?>"  class="btn btn-danger" onclick="return Confirm1();"><li class="fa fa-minus-circle"></li><strong> Delete all</strong></a>
                    <a href="list_examination.php" class="btn btn-danger"><li class="fa fa-sign-out"></li><strong> Back Examinations Management</strong></a>
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-hover" >
                            <form action="list_student.php" method="GET">
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
                                        echo    "<a href='list_student.php?id_ext=$id_ext' type='button' class='btn btn-primary' name='bt-refresh'><span class='fa fa-refresh fa-spin' aria-hidden='true'></span> Refresh</a>";
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
                                    <th><li class="fa fa-ticket"></li><strong> ID</strong></th>
                                    <th><li class="fa fa-vcard"></li><strong> Name</strong></th>
                                    <th><li class="fa fa-minus-square"></li><strong> Delete</strong></th>
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
                                            echo    "<td><a href='delete_student.php?id=".$id."&id_ext=".$id_ext."' onclick='return Confirm();'><li class='fa fa-user-times fa-2x'></li></a></td>";
                                            echo "</tr>";
                                            $i++;
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
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
                                echo "<a href='list_student.php?id_ext=$id_ext&page={$prepage}&ip-search={$search}'>Previous</a>";
                            }                     
                            echo "</li>";
                        }
                        else{
                            if ($page==0) {
                                echo "<li class='paginate_button previous disabled'><a>Previous</a>";
                            }
                            else{
                                echo "<li class='paginate_button previous'>";
                                echo "<a href='list_student.php?id_ext=$id_ext&page=$prepage'>Previous</a>";
                            }                     
                            echo "</li>";
                        }
                            if(isset($sotrang)){
                                for ( $i = 0; $i < $sotrang; $i ++ ){
                                    if(isset($search)){
                                        if($i==$page)
                                            echo "<li class='paginate_button active'><a href='list_student.php?id_ext=$id_ext&page={$i}&ip-search={$search}'><strong>".$i."</strong></a></li>";
                                        else
                                            echo "<li class='paginate_button'><a href='list_student.php?id_ext=$id_ext&page={$i}&ip-search={$search}'><strong>".$i."</strong></a></li>";
                                    }
                                    else{
                                        if($i==$page)
                                            echo "<li class='paginate_button active'><a href='list_student.php?id_ext=$id_ext&page={$i}'><strong>".$i."</strong></a></li>";
                                        else
                                            echo "<li class='paginate_button'><a href='list_student.php?id_ext=$id_ext&page={$i}'><strong>".$i."</strong></a></li>";
                                    }
                                }
                            }
                                            if(isset($search)){
                        if ($page>=($sotrang-1)) { //lơn hơn cho trường hợp chỉ 1 trang
                            echo "<li class='paginate_button next disabled'><a>Next</a>";
                        }
                        else{
                            echo "<li class='paginate_button next'>";
                            echo "<a href='list_student.php?id_ext=$id_ext&page={$nextpage}&ip-search={$search}'>Next</a>";
                        }
                        echo "</li>";
                        }
                        else{
                            if ($page>=($sotrang-1)) {
                                echo "<li class='paginate_button next disabled'><a>Next</a>";
                            }
                            else{
                                echo "<li class='paginate_button next'>";
                                echo "<a href='list_student.php?id_ext=$id_ext&page=$nextpage'>Next</a>";
                            }
                            echo "</li>";
                        }

                    ?>
                </ul>
            </div>
        </div>
    </div>
                <!-- /.panel-body -->
    <div class="row">
        <div class="col-lg-12">
            <?php
                if(!empty($_GET['messenge_true'])){
                    ?>
                    <script type="text/javascript">
                        swal("Successful!", "Add successful student", "success");
                    </script>
                    <?php
                    echo "<div class='alert alert-success alert-dismissable'><i class='fa fa-check' aria-hidden='true'></i> ".$_GET['messenge_true']."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
                }
                elseif (!empty($messenge_false)) {
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
            return confirm("Do you want to remove this student from the list of students?");   
        }

        function Confirm1() {
            return confirm("Do you want to remove the list of students?");   
        }
      </script>

<?php
       ob_flush();
    include('include/footer.php');
?>
