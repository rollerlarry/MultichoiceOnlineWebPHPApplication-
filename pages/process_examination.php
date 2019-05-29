<?php
	date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time_today=date('g:i A');
	if(isset($_GET['id_ext'])){
		$id_ext=$_GET['id_ext'];
		$page=$_GET['page'];
		$dt = date('Y-m-d H:i:s');
		// echo $dt->format('Y-m-d H:i:s'); //Test thời gian
		include('function/myconnect.php');
        $sql_select="SELECT id_exam FROM tbexamination where id_ext='{$id_ext}'";
        $result=mysqli_query($dbc,$sql_select) or die ("Không thể  truy vấn 1");
        $row=mysqli_fetch_array($result);
        if(!empty($row['id_exam'])){
			$sql_update="UPDATE tbexamination SET start_time='{$dt}' WHERE id_ext={$id_ext}";
			mysqli_query($dbc,$sql_update) or die ("Lỗi UPDATE");
			header("Location: list_examination.php?page=$page");
		}
		else{
			$error="The examination has not set up the exam!";
			header("Location: list_examination.php?page=$page&error=$error");
		}
	}
	else
		header("Location: list_examination.php");

?>
