<?php
	include('function/myconnect.php');
	include('function/function.php');
		$query1 = "DELETE FROM tb_name_exam";
		$result1 = mysqli_query($dbc,$query1);
		check_query($result1,$query1);
		$query2 = "DELETE FROM tbexam";
		$result2 = mysqli_query($dbc,$query2);
		check_query($result2,$query2);
		header('Location: list_exam.php');
?>