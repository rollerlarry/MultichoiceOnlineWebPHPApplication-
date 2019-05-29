<?php 
	function check_query($result,$query){
		global $dbc;
		if (!$result) {
			die("Query {$query} \n </br> MYSQL Errors: ".mysqli_error($dbc));
		}
	}

	function random_string($number_characters,$type=3){ 
		$result="";
	    if($type==1){
	    	$string="ABCDEFGHIJKLMNOPQRSTUVWXYZW";
	    }elseif($type==2){
	    	$string="0123456789";
	    }elseif($type==3){
	    	$string="ABCDEFGHIJKLMNOPQRSTUVWXYZWabcdefghijklmnopqrstuvwxyzw0123456789";
	    }
		    for ($i=0; $i < $number_characters; $i++){
		        $location = mt_rand(0,strlen($string));
		        $result= $result.substr($string,$location,1 );
		    }
	    return $result;
	}
	//Thành Danh (hàm tạo chuỗi ngẫu nhiên với độ dài length)
    function rand_string( $length ) {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = substr( str_shuffle( $chars ), 0, $length );
        return $str;
    }

 ?>