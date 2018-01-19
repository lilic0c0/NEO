<?php

$PRE1_OUT = file_get_contents("../rawdata/spftopo"); 
$tmpObj = new stdClass; 

$spf = RestCall_SPF1($PRE1_OUT);

$tmpObj->ret = file_put_contents("../rawdata/spf.json", $spf);
$tmpObj->status = "success";

echo json_encode($tmpObj);

function RestCall_SPF1($PRE1_OUT){


        $toURL = "http://localhost/nwopt/calcEcmpSpf/";
        $post_array = array(
                        'json_in' => $PRE1_OUT
                        );

        //echo "json_in=$PRE1_OUT end1"; exit;
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
		curl_setopt($ch, CURLOPT_TIMEOUT,0);
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
