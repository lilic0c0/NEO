<?php
//get data
if($ret = file_get_contents("rawdata/preDemand")){
	$rawData = json_decode(substr($ret, 3));
} else {
	$rawData = json_decode(substr(RestCall(), 3));
}

$dataArr = array();

foreach($rawData as $src => $demand){
	foreach($demand as $dst => $item){
	
		$tmpObj = new stdClass; 
		
		$tmpObj->src = $src;
		$tmpObj->dst = $dst;
		$tmpObj->traffic = $item;
		
		array_push($dataArr, $tmpObj);
	}
}

echo json_encode($dataArr);
?>
<?php

function RestCall(){

	$toURL = "http://localhost/nwopt/putDemand/test2.php";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $toURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
	
}

?>