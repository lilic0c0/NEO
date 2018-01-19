<?php
date_default_timezone_set('Asia/Taipei');
$stamp = date("Ymd_His"); 

$demandArr = json_decode($_REQUEST['demands']);
$fileName = ($_REQUEST['filename'] != "")?$_REQUEST['filename']:"na";

//203.75.189.43,SKC1-ROUTER-3611,SKC1 

//output
$outputStr = "";
foreach($demandArr as $item){
	$outputStr.= "{$item->src},{$item->dst},{$item->traff}\n";
}

$ret = file_put_contents("rawdata/demand_{$fileName}_{$stamp}_.csv", $outputStr);
echo $ret;

?>
