<?php
$demandArr = file('rawdata/demand.csv'); 

$dataArr = array();

foreach($demandArr as $demand){

	$arr = explode(",",trim($demand));
	
	$tmpObj = new stdClass;
	$tmpObj->src = $arr[0];
	$tmpObj->dst = $arr[1];
	$tmpObj->traff = $arr[2];
	
	
	array_push($dataArr, $tmpObj);
}

echo json_encode($dataArr);
?>