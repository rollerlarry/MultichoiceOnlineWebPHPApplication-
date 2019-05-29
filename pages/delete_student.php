<?php
	if(isset($_GET['id_ext'])){
		if(isset($_GET['id'])){
			$id=$_GET['id'];
			$id_ext=$_GET['id_ext'];
			include('function/myconnect.php');
			$sql_delete="DELETE FROM tbstdext WHERE id={$id} and id_ext={$id_ext}";
			mysqli_query($dbc,$sql_delete) or die ("Không thể xóa thí sinh");
		}
		header("Location: list_student.php?id_ext=$id_ext");
	}
	else
		header("Location: list_examination.php");
?>