<?php

$input_edge = file_get_contents("../rawdata/edge.csv");
$fail_hostname = "";	//"PHMK-ROUTER-3202";
$fail_circuit = "";

$tmpObj = new stdClass; 

$spfTopo = RestCall_PRE1($input_edge,$fail_hostname,$fail_circuit);

$tmpObj->ret = file_put_contents("../rawdata/spftopo", $spfTopo);
$tmpObj->status = "success";

echo json_encode($tmpObj);

function RestCall_PRE1($input_edge,$fail_hostname,$fail_circuit){


        $toURL = "http://localhost/nwopt/getSpfTopo/";
        $post_array = array(
                        'fail_hostname' => $fail_hostname,
                        'fail_circuit' => $fail_circuit,
                        'csv_in' => $input_edge
                        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $toURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_array);
        $result = curl_exec($ch);
        curl_close($ch);
		
        return $result;
}

?>
