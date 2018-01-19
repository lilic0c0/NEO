<?php
//get Param
$type = isset($_REQUEST['type'])?$_REQUEST['type']:'TypeA';

$filePath = 'rawdata/calc_fail_node.json'; 
$fetchData = file_exists($filePath)?json_decode(file_get_contents($filePath)):json_decode(RestCall());

if($type == 'TypeA'){
	$rawData = $fetchData->TypeA;
} else if($type == 'TypeB'){
	$rawData = $fetchData->TypeB;
} else if($type == 'TypeC'){
	$rawData = $fetchData->TypeC;
}

$dataArr = array();
foreach($rawData as $rt => $rs){
	
	$tmpArr = array();
	// ["TPDB-ROUTER-3316"]=> int(0)	

	$tmpArr[0] = $rt;
	$tmpArr[1] = $rs;	
			
	array_push($dataArr, $tmpArr);
}

$tmpObj = new stdClass; 
$tmpObj->data = $dataArr;

echo json_encode($tmpObj);
?>
<?php

function RestCall(){

	$toURL = "http://localhost/nwopt/calc_fail_node/test.php";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $toURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
        
	return $result;
}

?>