<?php
    include('function/myconnect.php');
    if(isset($_POST['id_ext']) && isset($_POST['btnsua'])){
        $id_ext=$_POST['id_ext'];
        $name_ext=addslashes($_POST['name_ext']);
        $id_exam=$_POST['id_exam'];
        $time_delay=$_POST['time_delay'];

        if($_POST['time_exam']>=0 && $_POST['time_exam']<=240 && is_numeric($_POST['time_exam'])){
            $time_exam=$_POST['time_exam'];
        }
        else{
            $error="Time is defined as a number between 0 and 240!";
            header("Location: install_examination.php?id_ext=$id_ext&error=$error");
        }
        if($_POST['time_delay']>=0 && $_POST['time_delay']<=240 && is_numeric($_POST['time_delay'])){
            $time_delay=$_POST['time_delay'];
        }
        else{
            $error1="Delay time is defined as a number between 0 and 240!";
            header("Location: install_examination.php?id_ext=$id_ext&error1=$error1");
        }

        $notes=$_POST['notes'];
        $sql_update="UPDATE tbexamination SET name_ext='{$name_ext}', time_exam={$time_exam}, id_exam={$id_exam}, time_delay={$time_delay}, notes='{$notes}' WHERE id_ext={$id_ext}";
        mysqli_query($dbc,$sql_update) or die ("Không thể cập nhật dữ liệu");
        $msg="The informations has been saved";
        header("Location: install_examination.php?id_ext=$id_ext&msg=$msg");
    }
    else
        header("Location: list_examination.php");
?>