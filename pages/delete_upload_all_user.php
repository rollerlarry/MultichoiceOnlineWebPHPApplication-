<?php
	include('function/myconnect.php');
	include('function/function.php');
		$query_de_file="SELECT link_download FROM tbupload_user";
		$result_de_file=mysqli_query($dbc,$query_de_file);
		check_query($result_de_file,$query_de_file);
		while ($rows=mysqli_fetch_array($result_de_file)) {
			unlink($rows['link_download']);
			unlink($rows['link_download'].".zip");
		}
		$query_de = "DELETE FROM tbupload_user";
		$result_de = mysqli_query($dbc,$query_de);
		check_query($result_de,$query_de);
		header('Location: import_user.php');
?>