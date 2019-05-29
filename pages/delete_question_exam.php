<?php
	include('function/myconnect.php');
	include('function/function.php');
	if (isset($_GET['id_exam']) && filter_var($_GET['id_exam'],FILTER_VALIDATE_INT,array('min_rang'=>1))) { 
		if (isset($_GET['id_question']) && filter_var($_GET['id_question'],FILTER_VALIDATE_INT,array('min_rang'=>2))) {
			$id_exam = $_GET['id_exam'];
			$subject =$_GET['subject'];
			$id_question = $_GET['id_question'];
		}
		echo $_GET['id_exam'];
		echo $_GET['subject'];
		// Truy vấn xóa
		$query = "DELETE FROM tbexam WHERE id_exam= $id_exam AND id_question = $id_question";
		$result = mysqli_query($dbc,$query);
		check_query($result,$query);
		
		header("Location: view_details_exam.php?id_exam=$id_exam&subject=$subject");
	}else{
		header("Location: view_details_exam.php?id_exam=$id_exam&subject=$subject");
	}
?>
