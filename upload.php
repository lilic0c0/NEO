<?php
date_default_timezone_set('Asia/Taipei');

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$fileInfo = pathinfo($_FILES['upl']['name']);
/*
	if(!in_array(strtolower($fileInfo['extension']), $allowed)){
		echo '{"status":"error"}';
		exit;
	}
*/
	$stamp = date("Ymd_His"); 
	$fileNameBig5 = str_replace(".{$fileInfo['extension']}", "", iconv( "UTF-8" , "big5" , $fileInfo['basename']));
	$fileNewPath = "uploads/{$fileNameBig5}_{$stamp}.{$fileInfo['extension']}";
	
	if(move_uploaded_file($_FILES['upl']['tmp_name'], strtolower($fileNewPath))){
		echo '{"status":"success"}';
		exit;
	}
}

echo '{"status":"error"}';
exit;
?>