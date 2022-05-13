<?php

//$client = stream_socket_client("tcp://127.0.0.1:8886",$errno,$errstr);

$site = $_GET['site'];
if($site=='user') {
    $client = stream_socket_client("tcp://127.0.0.1:8889",$errno,$errstr);
}
if($site=='order') {
    $client = stream_socket_client("tcp://127.0.0.1:8888",$errno,$errstr);
}
if(!$client){
    echo 'Exception code:'.$errno.'Exception message:'.$errstr;
    exit;
}
$data['class'] = $_GET['c'];
$data['method'] = $_GET['m'];
$data['param'] = $_GET['param'];

$_data = json_encode($data);
fwrite($client,$_data);
$server_data = fread($client,2048);
$result = json_decode($server_data,true);
fclose($client);

if($result['code']==1){
    var_dump($result);
}else{
    echo $result['msg'];
}


