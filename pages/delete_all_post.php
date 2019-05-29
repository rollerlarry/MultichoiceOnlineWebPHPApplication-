<?php
	include('function/myconnect.php');
	include('function/function.php');
		$query = "DELETE FROM tbpost";
		$result = mysqli_query($dbc,$query);
		check_query($result,$query);
		header('Location: list_post.php');
?>