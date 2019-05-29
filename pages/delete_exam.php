<?php session_start();
	include('function/myconnect.php');
	include('function/function.php');
	if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_rang'=>1))) { //Kiểm tra id có phải là số không 
		$id_exam = $_GET['id'];
		$query = "DELETE FROM tb_name_exam WHERE id_exam=$id_exam";
		$result = mysqli_query($dbc,$query);
		check_query($result,$query);
		$query_de = "DELETE FROM tbexam WHERE id_exam = $id_exam";
		$result_de = mysqli_query($dbc,$query_de);
		check_query($result_de,$query_de);
		header('Location: list_exam.php');
	}else{
		header('Location: list_exam.php');
	}
?>