<?php
   ob_start();
	include('include/header.php');
	include('include/sidebar.php');
	include('function/myconnect.php');
	include('function/function.php');
	if(!empty($_GET['id_ext'])){
		$id_ext=$_GET['id_ext'];
	    $sql_select7="SELECT * FROM tbexamination where id_ext=$id_ext";
	    $result7=mysqli_query($dbc,$sql_select7);
	    $row7=mysqli_fetch_array($result7);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	     	if (($_FILES['file']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') || ($_FILES['file']['type'] == 'application/vnd.ms-excel.sheet.macroEnabled.12'
			|| ($_FILES['file']['type'] == 'application/vnd.ms-excel.sheet.binary.macroEnabled.12') || ($_FILES['file']['type'] == 'application/vnd.ms-excel') || ($_FILES['file']['type'] == 'application/excel')) && ($_FILES['file']['size'] < 20000000))
			{
				//  Include thư viện PHPExcel_IOFactory vào
				include '../../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

				$inputFileName = $_FILES['file']['tmp_name'];
					//  Tiến hành đọc file excel
					try {
					    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
					    $objPHPExcel = $objReader->load($inputFileName);
					} catch(Exception $e) {
					    die('Lỗi không thể đọc file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
					}
					//  Lấy thông tin cơ bản của file excel

					// Lấy sheet hiện tại
					$sheet = $objPHPExcel->getSheet(0); 

					// Lấy tổng số dòng của file, trong trường hợp này là 6 dòng
					$highestRow = $sheet->getHighestRow(); 

					// Lấy tổng số cột của file, trong trường hợp này là 4 dòng
					$highestColumn = $sheet->getHighestColumn();

					// Khai báo mảng $rowData chứa dữ liệu

					//  Thực hiện việc lặp qua từng dòng của file, để lấy thông tin
					for ($row = 1; $row <= $highestRow; $row++){ 
					    // Lấy dữ liệu từng dòng và đưa vào mảng $rowData
					    $rowData[] = $sheet->rangeToArray('B' . $row . ':' . $highestColumn . $row, NULL, TRUE,FALSE);
					} 
					//In dữ liệu của mảng
					// echo "<pre>";
					// print_r($rowData);
					// echo "</pre>";
					$c=0; //số thí sinh không hợp lệ
					$t=0; //số thí sinh trùng lặp
					$s=0; //số thí sinh được thêm vào
					for($i=1; $i<$highestRow; $i++){
						if(!empty($rowData[$i][0][0])){
							include('function/myconnect.php');
							$sql_select="SELECT * From tbstdext where id='{$rowData[$i][0][0]}' and id_ext='{$id_ext}'";
							$result=mysqli_query($dbc,$sql_select) or die ("Không thể truy vấn");
							if(mysqli_num_rows($result) == 0){
								$sql_select2="SELECT * From tbuser where id='{$rowData[$i][0][0]}' and level=1";
								$result2=mysqli_query($dbc,$sql_select2) or die ("Không thể truy vấn 2");
								if(mysqli_num_rows($result2) == 1){
									$score=0;
									$sql_insert="INSERT INTO tbstdext(id,id_ext,score)  VALUES ({$rowData[$i][0][0]},{$id_ext},{$score})";
							        mysqli_query($dbc,$sql_insert) or die ("Không thể tạo thí sinh1");
							        $s++;
							    }
							    else
							    	$c++;
						    }
						    else
						    	$t++;
						}
					}
					$file=$_FILES['file']['name'];
					$folder= "./upload_student";
					if(!is_dir($folder))
	            		mkdir($folder);
			     	if(move_uploaded_file($_FILES['file']['tmp_name'],"./upload_student/".$file)){
			     		date_default_timezone_set('Asia/Ho_Chi_Minh');
			     		$name_file=$_POST['filename'];
						$time = date('Y-m-d H:i:s');
						$link='upload_student/'.$name_file;
						$sql_insert1="INSERT INTO tbupload_student(time,name_file,link_download,id_ext) VALUES ('{$time}','{$name_file}','{$link}',{$id_ext})";
						$result1=mysqli_query($dbc,$sql_insert1);
						if (mysqli_affected_rows($dbc)==1) {
							?>
								<script type="text/javascript">
									swal("Successful!", "This file has been upload!", "success");
								</script>
							<?php
						}
			     	}
			     	header("Location: import_student.php?id_ext=$id_ext&c=$c&t=$t&s=$s");
			}
	     	else{
	     		$error="The upload file is not valid, please try again with excel file";
				header("Location: import_student.php?id_ext=$id_ext&error=$error");

	     	}
		}
	}
	else
		header("Location: list_examination.php");
 ?>
    <div id="page-wrapper">
        <div class="row">
        	<div class="col-lg-12">
        		<h1 class="page-header"><li class="fa fa-download"></li><strong> Import Students: <?php echo $row7['name_ext']; ?></strong></h1>
        	</div>
        </div>
        <div class="row">
        	<div class="col-lg-12">
        		<form name="import_question" method="POST" enctype="multipart/form-data"">
			    	<div class="panel panel-default">
			    		<div class="panel-heading">
			    			<button type="submit" name="submit" class="btn btn-success"><li class="fa fa-download"></li> <strong>Import</strong></button>
			    			<a href="delete_upload_all_student.php?id_ext=<?php echo $id_ext; ?>" class="btn btn-warning" onclick="return confirm('Are you sure clear upload history ?')"><li class="fa fa-eraser"></li> <strong>Clear History</strong></a>
			    			<a href="list_student.php?id_ext=<?php echo $id_ext; ?>" class="btn btn-danger" ><li class="fa fa-sign-out"></li> <strong>Back List Student</strong></a>
			    		</div>
			    		<div class="panel-body">
			    			<div class="col-lg-12">
			    				<div class="col-lg-12">
									<div class="form-group">
									    <div class="row">
									      <div class="col-lg-6">
									        <div class="form-group">
									          <label for="file" class="sr-only">File</label>
									          <div class="input-group">
									            <input type="text" name="filename" class="form-control" placeholder="No file selected" >
									            <span class="input-group-btn">
									              <div style="position: relative;" class="btn btn-default  custom-file-uploader">
									                <input style="display: block;position: absolute;top: 0;right: 0;bottom: 0;left: 0;opacity: 0;" type="file" name="file" onchange="this.form.filename.value = this.files[0].name" />
									                <li class="fa fa-file-excel-o"></li> <strong>Select a file</strong>
									              </div>
									              	
									            </span>
									            
									          </div>
									        </div>
									      </div>
									     
									    </div>

									</div>

								</div>

							</div>
							<div class="col-lg-12">
								<div class="col-lg-6">
							    	<div class="panel panel-default">
						    			<div class="panel-heading">
							    			 <h4><li class="fa fa-history"></li> Upload History</h4>
							    		</div>
							    		<div class="panel-body">
											<div class="form-group">
												<table class="table table-striped table-bordered table-hover">
													<thead>
					            						<tr>
					            							<th>#</th>
					            							<th><li class="fa fa-calendar"></li> Date Time</th>
					                                        <th><li class="fa fa-file"></li> File</th>
					                                        <th><li class="fa fa-cloud-download"></li> Download</th>
					                                        <th><li class="fa fa-minus-square"></li> Delete</th>
					            						</tr>
					            					</thead>
					            					<tbody>
					            					<?php
					            						$sql_select="SELECT * FROM tbupload_student where id_ext={$id_ext} ORDER BY id_file DESC";
					            						$result=mysqli_query($dbc,$sql_select) or die("không thể truy vấns tbupload_student");
					            						$ord=1;
					            						while ($upload = mysqli_fetch_array($result)) {
			        									?>
						            						<tr>
						            							<td><?php echo $ord; ?></td>
						            							<td><?php echo $upload['time']; ?></td>
							            						<td><?php echo $upload['name_file']; ?></td>
							            						<td><a href="<?php echo $upload['link_download']; ?>"><li class="fa fa-download fa-2x"></li></a></td>
							            						<td><a href="delete_upload_student.php?id_file=<?php echo $upload['id_file']; ?>&id_ext=<?php echo $id_ext; ?>" onclick="return confirm('Are you sure delete ?')"><li class="fa fa-trash-o fa-2x"></li></a></td>
						            						</tr>
						            					<?php
						            					$ord++;
						            					}
						            				?>
					            					</tbody>
												</table>
											</div>
							    		</div>
							    	</div>
						    	</div>

						    	 <div class="col-lg-6">
									<div class="panel panel-default">
						    			<div class="panel-heading">
							    			 <h4><li class="fa fa-sticky-note-o"></li> Notes</h4>
							    		</div>
							    		<div class="panel-body">
											<div class="form-group">
												<li>All excel files (<strong>XML/XLSX</strong>) are allowed  (by default there is no file type restriction).</li>
												<li>The maximum file size for uploads in this demo is <strong>20 MB</strong> (default file size is unlimited).</li>
												<li>Uploaded files will be deleted automatically <strong>after 50 day or less</strong> (demo files are stored in memory).</li>
												<li>Please refer to the project website and documentation for more information.</li>
											</div>
							    		</div>
							    	</div>
							    	<div>
											<?php
												if(!empty($_GET['s'])){
													if($_GET['s']>0){
													   	?>
															<script type="text/javascript">
																swal("Successful!", "This file has been upload!", "success");
															</script>
														<?php
													}
						                            echo "<div class='alert alert-success alert-dismissable'><i class='fa fa-check' aria-hidden='true'></i> There were ".$_GET['s']." students added to the list!<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
						                        }
												if(!empty($error)){
						                            echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> ".$error."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
						                        }
						                        if(!empty($_GET['error'])){
						                            echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> ".$_GET['error']."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
						                        }
						                        if(!empty($_GET['t']) || !empty($_GET['c'])){
						                            $t=$_GET['t'];
						                            $c=$_GET['c'];
						                            if($c>0 && $t>0){
						                                echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> There are $t duplicate students and $c invalid students in the newly uploaded file<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
						                            }
						                            elseif($c>0 && $t==0){
						                                echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Has $c invalid students in the newly uploaded file<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
						                            }
						                            elseif($t>0 && $c==0){
						                                echo "<div class='alert alert-danger alert-dismissable'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Has $t duplicate students in the newly uploaded file<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>";
						                            }

						                        }
											?>
										</div>
						      	</div>
						    </div>
			    		</div>
			    	</div>
			    </form>
		    </div>
		</div>
    </div>
<?php 
   ob_flush();
	include('include/footer.php') 
?>