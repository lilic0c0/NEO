<?php

$ECMP = file_get_contents("../rawdata/spf.json");
$TD = file_get_contents("../rawdata/demand.csv");

$tmpObj = new stdClass; 

$preDemand = RestCall_SPF2($ECMP, $TD);

$tmpObj->ret = file_put_contents("../rawdata/preDemand", $preDemand);
$tmpObj->status = "success";

echo json_encode($tmpObj);

function RestCall_SPF2($ECMP,$TD){


        $toURL = "http://localhost/nwopt/putDemand/";
        $post_array = array(
                        'json_ecmp_in' => $ECMP,
                        'csv_td_in' => $TD,
                        );

        //echo "csv_td_in=$TD"; exit;
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
