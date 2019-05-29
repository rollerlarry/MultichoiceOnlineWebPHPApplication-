<?php
	include('function/myconnect.php');
	include('function/function.php');
	if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_rang'=>1))) { //Kiểm tra id có phải là số không 
		$id = $_GET['id'];
		// Truy vấn xóa
		$query_1 = "DELETE FROM tbexam WHERE id_question=$id ";
		$result_1 = mysqli_query($dbc,$query_1);
		check_query($result_1,$query_1);

		$query = "DELETE FROM tbquestion WHERE id=$id ";
		$result = mysqli_query($dbc,$query);
		check_query($result,$query);
		header('Location: list_question_bank.php');
	}else{
		header('Location: list_question_bank.php');
	}
?>
