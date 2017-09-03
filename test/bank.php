<?php
 function execPostRequest($url, $data)
   {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
   }

   $access_key = "ga126pcwushsr5al1j9n";           // require your access key from 1pay
   $secret = "74nzt1fm0o5red35fa1cp4wzmu9eg24t";               // require your secret key from 1pay
   $return_url = "http://localhost/mgates/bank_result.php";

   $command = 'request_transaction';
   $amount = $_POST['amount'];   // >10000
   $order_id = $_POST['order_id'];
   $order_info = $_POST['order_info'];

   $data = "access_key=".$access_key."&amount=".$amount."&command=".$command."&order_id=".$order_id."&order_info=".$order_info."&return_url=".$return_url;
   $signature = hash_hmac("sha256", $data, $secret);
   $data.= "&signature=".$signature;
   $json_bankCharging = execPostRequest('http://api.1pay.vn/bank-charging/service/v2', $data);
   $decode_bankCharging=json_decode($json_bankCharging,true);  // decode json
   $pay_url = $decode_bankCharging["pay_url"];
   header("Location: $pay_url");
?>
