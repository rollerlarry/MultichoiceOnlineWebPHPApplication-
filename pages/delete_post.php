<?php
	include('function/myconnect.php');
	include('function/function.php');
	if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_rang'=>1))) { //Kiểm tra id có phải là số không 
		$id = $_GET['id'];
		//Truy vấn xóa
		$query = "DELETE FROM tbpost WHERE id={$id}";
		$result = mysqli_query($dbc,$query);
		check_query($result,$query);
		header('Location: list_post.php');
	}else{
		header('Location: list_post.php');

	}
	
?>