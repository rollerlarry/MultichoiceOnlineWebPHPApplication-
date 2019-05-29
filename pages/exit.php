<?php 
include('function/myconnect.php');
include('function/function.php'); 
	session_start();
	
	$id = $_SESSION['id'];
	
	header('Location: ./login.php');
	 $query_up = "UPDATE tbuser
	              SET online=0
	              WHERE id={$id}";
	  $result_up = mysqli_query($dbc,$query_up);
	  check_query($dbc,$query_up);   
	 session_destroy();         
?>