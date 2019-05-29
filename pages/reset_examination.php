<?php
	if(isset($_GET['id_ext'])){
		$id_ext=$_GET['id_ext'];
		include('function/myconnect.php');
		//Xóa kỳ thi
		$sql_delete="UPDATE tbexamination SET start_time=null WHERE id_ext={$id_ext}";
		mysqli_query($dbc,$sql_delete) or die ("Không thể reset kỳ thi");
	}
	header("Location: list_examination.php");
?>