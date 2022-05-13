<?php
//netstat -an 查看服务是否启用


$stock_server  = stream_socket_server("tcp://127.0.0.1:8887",$errno,$errstr);
if(!$stock_server){
    echo 'Exception code:'.$errno.'Exception message:'.$errstr;
    exit;
}


while (1){

    try{
        $return_data = [];
        $buff = stream_socket_accept($stock_server);
        $data = fread($buff,2048);
        $_json_data = json_decode($data,true);
        $class = $_json_data['class'];//客户端访问的类
        $file= $class.'.php';
        if(!file_exists($file)){
            throw new Exception('file does not exist','-1');
        }
        require_once $file;

        $method = $_json_data['method'];
        $user_obj = new $class();
        if(isset($_json_data['param'])&&!empty($_json_data['param'])){
            $param = $_json_data['param'];
            $server_data = $user_obj->$method($param);
        }else{
            $server_data = $user_obj->$method();
        }


        $return_data['code'] = 1;
        $return_data['data'] = $server_data;
        $return_data['msg'] = 'ok';
        $return_data_str = json_encode($return_data);

        fwrite($buff,$return_data_str);
        fclose($buff);
    }catch (Exception $e){
        $err['code'] = $e->getCode();
        $err['data'] = '';
        $err['msg'] = $e->getMessage();
        $err_str = json_encode($err);

        fwrite($buff,$err_str);
        fclose($buff);
    }

}
