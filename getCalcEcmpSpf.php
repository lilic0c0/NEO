<?php
error_reporting(0);

//get data
if($ret = file_get_contents("rawdata/spf.json")){
	$rawData = json_decode($ret);
} else {
	$rawData = json_decode(RestCall());
}

$dataArr = array();
foreach($rawData as $item){
	
	$tmpArr = array();
	
	//"source":"TPDB-ROUTER-3316","target":"TPDB-ROUTER-4402","cost":1000,"through":[null]
	if($item->code == 1){
		
		$tmpObj = new stdClass; 

		$tmpObj->source = $item->source;
		$tmpObj->target = $item->target;
		$tmpObj->cost = $item->cost;
		
		foreach($item->through as $spf){
			if($spf == null) {
				$tmpObj->through = "";
				break;
			}
			
			$path = "(";
			foreach($spf as $node){
				$path.= $node.",";
			}
			$tmpObj->through.= $path."),";
		}
		
		array_push($dataArr, $tmpObj);
	}
}

echo json_encode($dataArr);
?>
<?php

function RestCall(){

	$toURL = "http://localhost/nwopt/calcEcmpSpf/test.php";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $toURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
        
	return $result;
}

?>