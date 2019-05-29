<?php
	include('function/myconnect.php');
	include('function/function.php');
		$query = "DELETE FROM tbquestion";
		$result = mysqli_query($dbc,$query);
		check_query($result,$query);
		header('Location: list_question_bank.php');
?>