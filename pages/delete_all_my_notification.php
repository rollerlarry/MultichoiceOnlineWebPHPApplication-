<?php
	include('function/myconnect.php');
	include('function/function.php');
		$query = "DELETE FROM tbmynotification";
		$result = mysqli_query($dbc,$query);
		check_query($result,$query);
		header('Location: list_my_notification.php');
?>