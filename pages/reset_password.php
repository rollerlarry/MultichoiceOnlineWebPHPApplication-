<?php
	include('function/myconnect.php');
	include('function/function.php');
	if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_rang'=>1))) { //Kiểm tra id có phải là số không 
		$id = $_GET['id'];
		//Truy vấn và reset password 123
		$query="UPDATE tbuser
			SET password='123'
			WHERE id={$id}";
		$result = mysqli_query($dbc,$query);
		check_query($result,$query);
		header('Location: list_user.php');
	}else{
		header('Location: list_user.php');
	}

	
?>

