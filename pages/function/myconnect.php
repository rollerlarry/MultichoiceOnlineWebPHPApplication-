<?php 
	$dbc = mysqli_connect('localhost','root','','itc');
	if (!$dbc) {
		echo "Connect not successful !!!";
	}else{
		mysqli_set_charset($dbc,'utf8');
	}
 ?>