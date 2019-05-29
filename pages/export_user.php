<meta charset="utf-8">
<?php 
	include('function/myconnect.php');
	include('function/function.php');
	$query = "SELECT *FROM tbuser";
	$results = mysqli_query($dbc,$query);
	check_query($results,$query);
	if (mysqli_num_rows($results) > 0) {
			$output =' 
			<table class="table" border="1">
				<tr> 
					<th colspan="3">List User</th>
				</tr>
				<tr>
					<th>Username</th>
					<th>Email</th>
					<th>Name</th>
				</tr>
			';
			while ($question_ex = mysqli_fetch_array($results,MYSQLI_ASSOC)) {
				$output .='  
					<tr>
						<td>'.$question_ex["user"].'</td>
						<td>'.$question_ex["email"].'</td>
						<td>'.$question_ex["name"].'</td>
					</tr>
				';
			}
			$output.='</table>';
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=list_user.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			echo $output;
	}
 ?>

