<?php
//get data
if($ret = file_get_contents("rawdata/util.json")){
	$rawData = json_decode($ret);
} else {
	$rawData = json_decode(RestCall());
}

$dataArr = array();
foreach($rawData as $src => $srcData){

	foreach($srcData as $dst => $CircuitData){
		
		$tmpObj = new stdClass; 
		//{"TPDB-ROUTER-3316":{"TPDB-ROUTER-4402":{"CIDs":"HB10102116&","traffic":0,"utilization":0,"bw":1000,"metric":1000}

		$tmpObj->src = $src;
		$tmpObj->dst = $dst;
		$tmpObj->CIDs = $CircuitData->CIDs;
		$tmpObj->traffic = $CircuitData->traffic;
		$tmpObj->utilization = $CircuitData->utilization;
		$tmpObj->bw = $CircuitData->bw;
		$tmpObj->metric = $CircuitData->metric;			
			
		array_push($dataArr, $tmpObj );

	}

}

echo json_encode($dataArr);
?>
<?php

function RestCall(){

	$toURL = "http://localhost/nwopt/calc_circuit_utilization/test.php";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $toURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
        
	return $result;
}

?>