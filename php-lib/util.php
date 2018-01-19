<?php

function init($data){

	//copy file
	$ret = array();
	
	//node
	$inputNode = file_get_contents("uploads/".$data['node']);
	$ret['node'] = file_put_contents("rawdata/node.csv", $inputNode);
	
	//edge
	$inputEdge = file_get_contents("uploads/".$data['edge']);
	$ret['edge'] = file_put_contents("rawdata/edge.csv", $inputEdge);
	
	//demand
	$inputDemand = file_get_contents("uploads/".$data['demand']);
	$ret['demand']  = file_put_contents("rawdata/demand.csv", $inputDemand );
	
	return $ret;
}

?>
