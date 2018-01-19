<?php

$addrFile = file("rawdata/addr.csv");
$nodeArr = json_decode($_REQUEST['nodes']);
$addrArr = array();

//台北石牌,SIPR,25.1134442,121.52226029999997,台北市北投區明德路212號4樓,1500,150 

foreach($addrFile as $row){
	
	$arr = explode(",", trim($row));
	$tmpObj = new stdClass;
	$addrArr[$arr[1]] = $arr;
}

foreach($nodeArr as $node){
	
	if(array_key_exists($node->name, $addrArr)){
		$addrArr[$node->name][5] = $node->x;
		$addrArr[$node->name][6] = $node->y;
	}
}

//output
$outputStr = "";
foreach($addrArr as $addr){
	$outputStr.= "{$addr[0]},{$addr[1]},{$addr[2]},{$addr[3]},{$addr[4]},{$addr[5]},{$addr[6]}\n";
}

$ret = file_put_contents("rawdata/addr.csv", $outputStr);
echo $ret;

?>