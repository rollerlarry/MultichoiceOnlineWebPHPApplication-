<?php
    ob_start();
    include('include/header.php');
    include('include/sidebar.php');
    include('function/myconnect.php');

    if(isset($_GET['id_ext'])){
        $id_ext=$_GET['id_ext'];
        $sql_select="SELECT * FROM tbexamination where id_ext='{$id_ext}'";
        $result=mysqli_query($dbc,$sql_select);
        $row=mysqli_fetch_array($result);
        $name_ext=$row['name_ext'];
        $subject=$row['subject'];
        $start_time=$row['start_time'];
        $time_exam=$row['time_exam'];
        $time_delay=$row['time_delay'];
        $id_exam=$row['id_exam'];
        $notes=$row['notes'];
    }
    else
        header("Location: list_examination.php");
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><strong><li class="fa fa-cogs"></li>  Installation: <?php echo $row['name_ext']; ?></strong></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form role="form" action="edit_examination.php" method="POST">
                        <button type="submit" class="btn btn-success" name="btnsua" value="Save" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i><strong> Processing</strong>"><li class="fa fa-save"></li><strong> Save</strong></button>
                    <a href="list_examination.php" class="btn btn-danger"><li class="fa fa-sign-out"></li><strong> Back Examinations Management</strong></a>
                </div>
                                <!-- /.panel-heading -->
                <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group has-success">
                                    <input type="hidden" name="id_ext" value="<?php echo $id_ext; ?>">
                                    <div class="form-group">
                                        <label class="control-label"><li class="fa fa-fa"></li> Name</label>
                                        <input class="form-control" name="name_ext" value="<?php echo $name_ext; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group has-success">
                                    <label class="control-label"><li class="fa fa-file-text-o"></li> Choose Exam</label>
                                    <select class="form-control" name="id_exam">
                                    <?php
                                        $sql_select2="SELECT * FROM tb_name_exam where subject='{$subject}'";
                                        $result2=mysqli_query($dbc,$sql_select2) or die ("Không thể truy vấn bảng tbexam");
                                        while ($rows2=mysqli_fetch_array($result2)) {
                                            $id_exam2=$rows2['id_exam'];
                                            $name_exam=$rows2['name_exam'];
                                            if($id_exam==$id_exam2)
                                                $chon="selected='selected'";
                                            else
                                                $chon=" ";
                                            echo "<option value='".$id_exam2."' ".$chon.">".$name_exam."</option>";
                                        }
                                        if(empty($id_exam)){
                                            $null=null;
                                            echo "<option value='{$null}' selected='selected'>None</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputWarning" ><li class="fa fa-clock-o"></li> Time exam (minute)</label>
                                    <input type="text" name="time_exam" value="<?php echo $time_exam; ?>" class="form-control" id="inputWarning">
                                    <?php
                                        if(isset($_GET['error'])){
                                            echo "<div class='alert alert-danger alert-dismissable'>".$_GET['error']."
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            </div>";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputWarning" ><li class="fa fa-clock-o"></li> Delay time (minute)</label>
                                    <input type="text" name="time_delay" value="<?php echo $time_delay; ?>" class="form-control" id="inputWarning">
                                    <?php
                                        if(isset($_GET['error1'])){
                                            echo "<div class='alert alert-danger alert-dismissable'>".$_GET['error1']."
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                            </div>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <label><li class="fa fa-sticky-note"></li> Notes</label>
                                    </div>
                                    <div class="panel-body">
                                        <textarea class="form-control" rows="8" name="notes"><?php echo $notes;  ?></textarea>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>

                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
</div>
        <?php
            if(isset($_GET['msg'])){
                ?>
                <script type="text/javascript">
                    swal("Successful!", "The informations has been saved!", "success");
                </script>
                <?php
            }                                                
        ?>
<?php
   ob_flush();
    include('include/footer.php');
?>