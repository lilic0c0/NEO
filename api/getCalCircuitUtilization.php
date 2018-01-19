<?php
include_once("../php-lib/parse_csv.php");
include_once("../php-lib/common.php");

$putDemandOut = file_get_contents("../rawdata/preDemand");
$input_edge = file_get_contents(".../rawdata/edge.csv");
$input_links_array = strcut_input_links($input_edge);
$r2r_links = parse_input_links_array_to_r2r_link($input_links_array,"","");
$r2r_links_json = json_encode($r2r_links);

//run
$utilization = RestCall_BD1($r2r_links_json, $putDemandOut);

$tmpObj = new stdClass; 
$tmpObj->ret = file_put_contents("../rawdata/util.json", $utilization);
$tmpObj->status = "success";

echo json_encode($tmpObj);

function RestCall_BD1($r2r_links_json, $putDemandOut){


        $toURL = "http://localhost/nwopt/calc_circuit_utilization/";
        $post_array = array(
                        'r2r_links' => $r2r_links_json,
                        'realtd_in' => $putDemandOut,
                        );

        //echo "json_in=$PRE1_OUT end1"; exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $toURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
        $result = curl_exec($ch);
        curl_close($ch);
        //echo $result;
        return $result;
}

?>
