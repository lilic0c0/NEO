<?php
date_default_timezone_set('Asia/Taipei');
$stamp = date("Ymd_His"); 

$edgeArr = json_decode($_REQUEST['edges']);
$fileName = ($_REQUEST['filename'] != "")?$_REQUEST['filename']:"na";

//203.75.189.43,SKC1-ROUTER-3611,SKC1 

//output
$outputStr = "";
foreach($edgeArr as $edge){
	$outputStr.= "{$edge->circuitID},{$edge->hostname1},{$edge->loopback1},{$edge->hostname2},{$edge->loopback2},{$edge->bandWides},{$edge->metric1to2},{$edge->metric2to1}\n";
}

$ret = file_put_contents("rawdata/edge_{$fileName}_{$stamp}_.csv", $outputStr);
echo $ret;

?>
