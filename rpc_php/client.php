<?php


$client = stream_socket_client("tcp://127.0.0.1:8887",$errno,$errstr);
if(!$client){
    echo 'Exception code:'.$errno.'Exception message:'.$errstr;
    exit;
}

$data['class'] = 'user';
$data['method'] = 'get_name';
$data['param'] = 10;
$_data = json_encode($data);
fwrite($client,$_data);
$server_data = fread($client,2048);
$result = json_decode($server_data,true);

fclose($client);
var_dump($result);
