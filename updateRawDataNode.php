<?php
date_default_timezone_set('Asia/Taipei');
$stamp = date("Ymd_His"); 

$nodeArr = json_decode($_REQUEST['nodes']);
$fileName = ($_REQUEST['filename'] != "")?$_REQUEST['filename']:"na";

//203.75.189.43,SKC1-ROUTER-3611,SKC1 

//output
$outputStr = "";
foreach($nodeArr as $node){
	$outputStr.= "{$node->loopback},{$node->name},{$node->location}\n";
}

$ret = file_put_contents("uploads/node_{$fileName}_{$stamp}_.csv", $outputStr);
echo $ret;

?>