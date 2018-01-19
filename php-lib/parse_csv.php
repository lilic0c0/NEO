<?php
/*
   $input_edge = file_get_contents("edge.csv");
   $input_links_array = strcut_input_links($input_edge);
   $spf_link_array = parse_input_links_array_to_spf_link($input_links_array);

   var_dump($spf_link_array);
 */
function strcut_input_links($input_edge,$exclude_hostname="",$exclude_link=""){

	$input_links = parse_csv_to_array($input_edge);
	$input_links_array = array();
	foreach($input_links as $link){
		if($link["metric1to2"]==NULL || $link["metric2to1"]==NULL || $link["hostname1"]==$exclude_hostname || $link["hostname2"]==$exclude_hostname || $link["circuitID"]==$exclude_link)
			continue;
		$input_links_array[$link["hostname1"]][$link["hostname2"]][] = $link;
	}
	return $input_links_array;

}

function getCircuitIDsFrom_input_links_array($input_links_array){
	$circuitIDs = array();
	foreach($input_links_array as $h1 => $h1_items){
		foreach($h1_items as $h2 => $edges){
			foreach($edges as $edge)
				$circuitIDs[] = $edge['circuitID'];
		}
	}
	return $circuitIDs;
}

function parse_input_links_array_to_spf_link($input_links_array){
	$spf_links = array();$min_metric = array();
	foreach($input_links_array as $hostname1 => $input_to_links_array)
		foreach($input_to_links_array as $hostname2 => $links)
		{
			$min_metric[$hostname1][$hostname2] = 999999999;
			$min_metric[$hostname2][$hostname1] = 999999999;
		}

	foreach($input_links_array as $hostname1 => $input_to_links_array)
	{
		foreach($input_to_links_array as $hostname2 => $links)
		{
			foreach($links as $link){
				if($link["metric1to2"]<$min_metric[$hostname1][$hostname2]) 
					$min_metric[$hostname1][$hostname2] = $link["metric1to2"];
				if($link["metric2to1"]<$min_metric[$hostname2][$hostname1]) 
					$min_metric[$hostname2][$hostname1] = $link["metric2to1"];
			}
		}
	}

	foreach($min_metric as $h1 => $tmp1)
		foreach($tmp1 as $h2 => $metric)
		{	
			if($metric!=999999999 && $metric!="NULL")
				$spf_links[] = array($h1,$h2,$metric);
		}
	//var_dump($spf_links);
	return $spf_links;
}

function parse_input_links_array_to_r2r_link($input_links_array,$exclude_hostname="",$exclude_link=""){
	$r2r_links = array();
	foreach($input_links_array as $hostname1 => $input_to_links_array)
	{
		foreach($input_to_links_array as $hostname2 => $links)
		{
			if(($hostname1===$exclude_hostname)||($hostname2===$exclude_hostname)){
				continue;
			}

			$min_metric1to2 = INF;
			$min_metric2to1 = INF;
			$circuitIDs = "";
			$bw = 0;

			foreach($links as $link){
				if($link['circuitID']==$exclude_link)
					continue;
				//echo "$hostname1->$hostname2:\n";
				//var_dump($link);
				$circuitIDs .= "{$link['circuitID']}&";
				$bw += $link['bw'];
				if($link["metric1to2"]<$min_metric1to2) $min_metric1to2 = $link["metric1to2"];
				if($link["metric2to1"]<$min_metric2to1) $min_metric2to1 = $link["metric2to1"];
			}
			if(($min_metric1to2!="NULL")&&($min_metric1to2!==INF)) $r2r_links[$hostname1][$hostname2] = array(/*"src"=>$hostname1,"dst"=>$hostname2,*/"CIDs"=>$circuitIDs,"traffic"=>0,"utilization"=>0,"bw"=>$bw,"metric"=>(int)$min_metric1to2);
			if(($min_metric2to1!="NULL")&&($min_metric2to1!==INF)) $r2r_links[$hostname2][$hostname1] = array(/*"src"=>$hostname2,"dst"=>$hostname1,*/"CIDs"=>$circuitIDs,"traffic"=>0,"utilization"=>0,"bw"=>$bw,"metric"=>(int)$min_metric2to1); 
		}
	}
	//var_dump($spf_links);
	return $r2r_links;
}



function parse_csv_to_array($input_str){
	$input_array = preg_split("/\n/",$input_str);
	array_pop($input_array);

	$th=0;
	$rows = array();

	foreach($input_array as $input){
		$items = preg_split("/,/",$input);
		if($th==0){
			$keys = $items;	
		}else{
			$rows[] = array_combine($keys,$items);
		}
		$th++;
	}
	return $rows;
}

function parse_traffic_demand_csv_to_unique($input_str)
{
	$td_array = parse_csv_to_array($input_str);
	//var_dump($td_array);

	$unique_td = array();
	foreach($td_array as $td){

		$hostname1 = $td["hostname1"];
		$hostname2 = $td["hostname2"];
		$demand = $td["demand"];
		if(!isset($unique_td[$hostname1][$hostname2]))
			$unique_td[$hostname1][$hostname2] = $demand;
		else
			$unique_td[$hostname1][$hostname2] += $demand;
	}
	return $unique_td;
}



?>
