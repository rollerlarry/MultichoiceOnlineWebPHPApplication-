<?php
	include('function/myconnect.php');
	include('function/function.php');
		$query = "DELETE FROM tbnotification";
		$result = mysqli_query($dbc,$query);
		check_query($result,$query);
		header('Location: list_notification.php');
?>