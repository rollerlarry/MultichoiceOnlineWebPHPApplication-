<?php
    	include('function/myconnect.php');

		//Xóa file trong thư mục
		$sql_select="SELECT link_download FROM tbupload_student";
		$result1=mysqli_query($dbc,$sql_select) or die ("Không thể truy vấn");
		while ($rows=mysqli_fetch_array($result1)) {
			unlink($rows['link_download']); 
		}

		//Xóa dữ liệu bảng tbexamination
		$sql_delete3="DELETE FROM tbexamination";
		mysqli_query($dbc,$sql_delete3) or die ("Không thể xóa kỳ thi");
		header("Location: list_examination.php");
?>