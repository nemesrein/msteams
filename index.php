<?php
    $input = file_get_contents('php://input');
//     $randomfile = fopen("logs/logs-".date("Y-m-d-h-i-s-a").".log", "a") or die("Unable to open file!");
// fwrite($randomfile, "\n". json_encode(json_decode($input)));
// fclose($randomfile);


$post = array();
$post['grant_type'] = 'client_credentials';
$post['client_id'] = "e2ac8049-ddfe-4347-b221-df50d15fc8b0";
$post['client_secret'] = "ENhhG[FtdZS.j?GM[m2IjtblRPez7e01";
$post['scope'] = 'https://api.botframework.com/.default';
$cr = curl_init();

curl_setopt($cr, CURLOPT_URL, "https://login.microsoftonline.com/botframework.com/oauth2/v2.0/token");
curl_setopt($cr, CURLOPT_POST, 1);
        curl_setopt($cr, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cr, CURLOPT_POSTFIELDS, http_build_query($post));
        // curl_setopt($cr, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($cr, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($cr, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded','Host: login.microsoftonline.com']);


$accesstoken = curl_exec($cr);
// $check = curl_getinfo($cr);
$accesstoken = json_decode($accesstoken);
$accesstoken = $accesstoken->access_token;
curl_close($cr);
$data = @json_decode($input,true);
$params = array();
$params['type'] = "message";
$params['text'] = "hi hello hi";
$conversation = $data['conversation']['id'];
$senderId = $data['recipient']['id'];
$params['recipient']['id'] = $senderId;
$service_url = $data['serviceUrl'];
// $activity = $data->channelData->clientActivityID;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $service_url."v3/conversations/".$conversation.'/activities/'.$senderId);
curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$accesstoken, 'Content-Type: application/json']);

$file = fopen("logs/accesstoken-".date("Y-m-d-h-i-s-a").".log", "a") or die("Unable to open file!");
fwrite($file, "\n". $accesstoken);
$return = curl_exec($ch);
$datafile = fopen("logs/decode-data-".date("Y-m-d-h-i-s-a").".log", "a") or die("Unable to open file!");
fwrite($datafile, "\n". json_encode($service_url."v3/conversations/".$conversation.'/activities/'.$senderId));
$file = fopen("logs/result-".date("Y-m-d-h-i-s-a").".log", "a") or die("Unable to open file!");
fwrite($file, "\n". json_encode($return));
