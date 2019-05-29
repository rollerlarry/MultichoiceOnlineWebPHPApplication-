<?php
	include('function/myconnect.php');
	include('function/function.php');
	if(isset($_GET['id_ext'])){
		$id_ext=$_GET['id_ext'];

		$sql_select="SELECT link_download FROM tbupload_student where id_ext=$id_ext";
		$result1=mysqli_query($dbc,$sql_select) or die ("Không thể truy vấn");
		while ($rows=mysqli_fetch_array($result1)) {
			unlink($rows['link_download']);
		}

		$sql_delete = "DELETE FROM tbupload_student where id_ext=$id_ext";
		$result2 = mysqli_query($dbc,$sql_delete) or die ("Không thể xóa");
		header("Location: import_student.php?id_ext=$id_ext");
	}
	else
		header("Location: list_student.php?id_ext=$id_ext");
?>