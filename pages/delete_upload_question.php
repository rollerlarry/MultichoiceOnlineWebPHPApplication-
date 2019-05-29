<?php
	include('function/myconnect.php');
	include('function/function.php');
	if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_rang'=>1))) { //Kiểm tra id có phải là số không 
		$id = $_GET['id'];

		$query_sl="SELECT link_download FROM tbupload_question WHERE id=$id";
		$result_sl=mysqli_query($dbc,$query_sl);
		check_query($result_sl,$query_sl);
		$rows=mysqli_fetch_array($result_sl);
		unlink($rows['link_download']);
		unlink($rows['link_download'].'.zip');
		//Truy vấn xóa
		$query = "DELETE FROM tbupload_question WHERE id={$id}";
		$result = mysqli_query($dbc,$query);
		check_query($result,$query);
		header('Location: import_question.php');
	}else{
		header('Location: import_question.php');

	}
	
?>