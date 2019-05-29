<?php
	include('function/myconnect.php');
	include('function/function.php');
	if(isset($_GET['id_ext'])){
		$id_ext=$_GET['id_ext'];
		if (isset($_GET['id_file']) && filter_var($_GET['id_file'],FILTER_VALIDATE_INT,array('min_rang'=>1))) { //Kiểm tra id có phải là số không 
			$id_file = $_GET['id_file'];
			//Truy vấn
			$sql_select="SELECT link_download FROM tbupload_student WHERE id_file=$id_file";
			$result1=mysqli_query($dbc,$sql_select) or die ("Không thể truy vấn");
			$row=mysqli_fetch_array($result1);
			unlink($row['link_download']);
			//Truy vấn xóa
			$sql_delete = "DELETE FROM tbupload_student WHERE id_file={$id_file}";
			$result2 = mysqli_query($dbc,$sql_delete) or die ("Không thể xóa file");
			header("Location: import_student.php?id_ext=$id_ext");
		}else{
			header("Location: import_student.php?id_ext=$id_ext");

		}
	}
	else
		header("Location: list_examination.php");
	
?>