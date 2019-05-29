<?php
	include('function/myconnect.php');
	include('function/function.php');
	if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_rang'=>1))) { //Kiểm tra id có phải là số không 
		$id = $_GET['id'];
		//Truy vấn xóa
		$query_sl="SELECT link_download FROM tbupload_user WHERE id=$id";
		$result_sl=mysqli_query($dbc,$query_sl);
		check_query($result_sl,$query_sl);
		$rows=mysqli_fetch_array($result_sl);
		unlink($rows['link_download']);
		unlink($rows['link_download'].'.zip');

		$query_de = "DELETE FROM tbupload_user WHERE id={$id}";
		$result_de = mysqli_query($dbc,$query_de);
		check_query($result_de,$query_de);

		header('Location: import_user.php');
	}else{
		header('Location: import_user.php');

	}
	
?>