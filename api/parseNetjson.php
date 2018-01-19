<?php
set_time_limit(0);
ini_set("memory_limit","2048M");

$nodeSrc = file("../rawdata/node.csv");
$edgeSrc = file("../rawdata/edge.csv");

$popSrc = file("../rawdata/addr.csv");
$spfs = json_decode(file_get_contents("../rawdata/spf.json"), true);
$linkSrc = json_decode(file_get_contents("../rawdata/util.json"), true);

//pop
$popObjArr = array();
$popArr = array();
foreach($popSrc as $pop){

	$arr = explode(",",trim($pop));
	$tmpObj = new stdClass; 
	
	//cname,name,lat,lon,addr,ox,oy
	$tmpObj->cname = urlencode($arr[0]);
	$tmpObj->name = $arr[1];
	$tmpObj->lat = $arr[2];
	$tmpObj->lon = $arr[3];
	$tmpObj->addr = urlencode($arr[4]);
	$tmpObj->fx = $arr[5];
	$tmpObj->fy = $arr[6];
	
	$popArr[$arr[1]] = $tmpObj;
	array_push($popObjArr, $tmpObj);
}

//node
$nodeObjArr = array();
$nodeArr = array();

foreach($nodeSrc as $node){

	$arr = explode(",",trim($node));
	$tmpObj = new stdClass; 
	
	if(strpos($node, "loopback") !== false) {
		echo $node; continue;
	}
	//loopback,hostname,location
	$tmpObj->loopback = $arr[0];
	$tmpObj->hostname = $arr[1];
	$tmpObj->location = $arr[2];
	
	$x_bais = 50*rand(-3,3);
	$y_bais = 50*rand(-3,3);
	$tmpObj->fx = $popArr[$tmpObj->location]->fx*2+$x_bais;
	$tmpObj->fy = $popArr[$tmpObj->location]->fy+$y_bais;
	
	array_push($nodeObjArr, $tmpObj);
	array_push($nodeArr, $arr[1]);
}

//edge
$edgeObjArr = array();
$edgeArr = array();

foreach($edgeSrc as $edge){

	$arr = explode(",",trim($edge));
	$tmpObj = new stdClass; 
	
	if(strpos($edge, "circuitID") !== false) {
		continue;
	} else {
		//circuitID,hostname1,loopback1,hostname2,loopback2,bw,metric1to2,metric2to1
		$tmpObj->id = $arr[0];
		$tmpObj->hostname1 = $arr[1];
		$tmpObj->loopback1 = $arr[2];
		$tmpObj->hostname2 = $arr[3];
		$tmpObj->loopback2 = $arr[4];
		$tmpObj->bw = $arr[5];
		$tmpObj->m1to2 = $arr[6];
		$tmpObj->m2to1 = $arr[7];
		
		$edgeArr[$arr[0]] = $tmpObj;
		array_push($edgeObjArr, $tmpObj);
	}
}

//link
$linkObjArr = array();

foreach($linkSrc as $src => $dstArr){

	foreach($dstArr as $dst => $arr){
		
		$tmpObj = new stdClass; 
		
		//circuitID,hostname1,loopback1,hostname2,loopback2,bw,metric1to2,metric2to1
		$tmpObj->source = $src;
		$tmpObj->target = $dst;
		$tmpObj->traffic = $arr['traffic'];
		$tmpObj->utilization = $arr['utilization'];
		$tmpObj->bw = $arr['bw'];
		$tmpObj->metric = $arr['metric'];
		
		$tmpArr = array();
		$cidsArr = explode("&", trim($arr['CIDs']));
		
		foreach($cidsArr as $id){
			if(array_key_exists($id, $edgeArr)){
				array_push($tmpArr, $edgeArr[$id]);
			}
		}
		$tmpObj->CIDs = $tmpArr;
		
		array_push($linkObjArr, $tmpObj);
	}
}

//spf
$spfObjArr = array();
foreach($spfs as $spf){
	
	if($spf['code'] < 0) continue;
	
	array_push($spfObjArr, $spf);
}

//generate JSON
$obj = new stdClass; 

$obj->type = "IDC Topology";
$obj->label = "HiNet";
$obj->version = "0.9";
$obj->nodes = $nodeObjArr;
$obj->pops = $popObjArr;
$obj->links = $linkObjArr;
$obj->edges = $edgeObjArr;
$obj->spf = $spfObjArr;

//output
$ret = file_put_contents("../rawdata/netjson.json", urldecode(json_encode($obj)));
echo $ret;

?>