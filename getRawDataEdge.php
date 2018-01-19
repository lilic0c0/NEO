<?php
$edgeArr = file('rawdata/edge.csv'); 

$dataArr = array();

foreach($edgeArr as $edge){

	$arr = explode(",",trim($edge));
	
	$tmpObj = new stdClass;
	$tmpObj->circuitID= $arr[0];
	$tmpObj->hostname1= $arr[1];
	$tmpObj->loopback1= $arr[2];
	$tmpObj->hostname2= $arr[3];
	$tmpObj->loopback2= $arr[4];
	$tmpObj->bandWides= $arr[5];
	$tmpObj->metric1to2= $arr[6];
	$tmpObj->metric2to1= $arr[7];
	
	array_push($dataArr, $tmpObj);
}

echo json_encode($dataArr);
?>