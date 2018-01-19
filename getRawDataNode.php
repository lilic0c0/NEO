<?php
$nodeSrc = file('rawdata/node.csv'); 

$dataArr = array();

foreach($nodeSrc as $node){

	$tmpObj = new stdClass; 
	$arr = explode(",",trim($node));
	
	$tmpObj->loopback = $arr[0]; 
	$tmpObj->name = $arr[1]; 
	$tmpObj->location = $arr[2]; 
	
	array_push($dataArr, $tmpObj);
}

echo json_encode($dataArr);
?>