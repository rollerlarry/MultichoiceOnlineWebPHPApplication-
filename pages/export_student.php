<?php
	// Bước 1: 
	// Lấy dữ liệu từ database
	include('function/myconnect.php');
	$id_ext=$_GET['id_ext'];
	//lấy tên kỳ thi
	$sql_select1="SELECT name_ext from tbexamination where id_ext={$id_ext}";
	$result1=mysqli_query($dbc,$sql_select1) or die ("Lỗi truy vấn 1");
	$row=mysqli_fetch_array($result1);
	$name_ext=$row['name_ext'];
	$sql_select="SELECT * from tbuser where id in (SELECT id FROM tbstdext where id_ext={$id_ext}) and level=1";
	$result=mysqli_query($dbc,$sql_select) or die ("Lỗi truy vấn");
	$i=0;
	while ($rows=mysqli_fetch_array($result)){
		// echo "<pre>";
		// print_r($rows);
		// echo "</pre>";
		$data[$i][]=$i+1;
		$data[$i][]=$rows['id'];
		$data[$i][]=$rows['name'];
		$i++;
	}
	// echo "-----------------------------------------------";
	// 	echo "<pre>";
	// 	print_r($data);
	// 	echo "</pre>"; 
	// Bước 2: Import thư viện phpexcel
	include '../../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
	 
	// Bước 3: Khởi tạo đối tượng mới và xử lý
	$PHPExcel = new PHPExcel();
	 
	// Bước 4: Chọn sheet - sheet bắt đầu từ 0
	$PHPExcel->setActiveSheetIndex(0);
	 
	// Bước 5: Tạo tiêu đề cho sheet hiện tại
	$PHPExcel->getActiveSheet()->setTitle('List of students');
	 
	// Bước 6: Tạo tiêu đề cho từng cell excel, 
	// Các cell của từng row bắt đầu từ A1 B1 C1 ...
	$PHPExcel->getActiveSheet()->setCellValue('A1', '#');
	$PHPExcel->getActiveSheet()->setCellValue('B1', 'ID');
	$PHPExcel->getActiveSheet()->setCellValue('C1', 'Name');
	 
	// Bước 7: Lặp data và gán vào file
	// Vì row đầu tiên là tiêu đề rồi nên những row tiếp theo bắt đầu từ 2
	$rowNumber = 2;
	foreach ($data as $index => $item) 
	{
	    // A1, A2, A3, ...
	    $PHPExcel->getActiveSheet()->setCellValue('A' . $rowNumber, ($index + 1));
	     
	    // B1, B2, B3, ...
	    $PHPExcel->getActiveSheet()->setCellValue('B' . $rowNumber, $item[1]);
	 
	    // C1, C2, C3, ...
	    $PHPExcel->getActiveSheet()->setCellValue('C' . $rowNumber, $item[2]);
	       
	     
	    // Tăng row lên để khỏi bị lưu đè
	    $rowNumber++;
	}
	 
	// Bước 8: Khởi tạo đối tượng Writer
	$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
	 
	// Bước 9: Trả file về cho client download
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename='List of {$name_ext} examination.xls'");
	header('Cache-Control: max-age=0');
	if (isset($objWriter)) {
	    $objWriter->save('php://output');
	}
?>