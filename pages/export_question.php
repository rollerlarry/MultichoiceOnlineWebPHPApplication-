<meta charset="utf-8">
<?php 
	include('function/myconnect.php');
	include('function/function.php');
	$query = "SELECT *FROM tbquestion";
	$results = mysqli_query($dbc,$query);
	check_query($results,$query);
	if (mysqli_num_rows($results) > 0) {
			$output =' 
			<table class="table" border="1">
				<tr> 
					<th colspan="8">List Question</th>
				</tr>
				<tr>
					<th>Subjects</th>
					<th>Question Content</th>
					<th>Answer A</th>
					<th>Answer B</th>
					<th>Answer C</th>
					<th>Answer D</th>
					<th>Answer True</th>
					<th>Guide</th>
				</tr>
			';
			while ($question_ex = mysqli_fetch_array($results,MYSQLI_ASSOC)) {
				$output .='  
					<tr>
						<td>'.$question_ex["subject"].'</td>
						<td>'.$question_ex["content"].'</td>
						<td>'.$question_ex["answer_a"].'</td>
						<td>'.$question_ex["answer_b"].'</td>
						<td>'.$question_ex["answer_c"].'</td>
						<td>'.$question_ex["answer_d"].'</td>
						<td>'.$question_ex["answer_true"].'</td>
						<td>'.$question_ex["guide"].'</td>
					</tr>
				';
			}
			$output.='</table>';
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=list_question.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			echo $output;
	}
 ?>

