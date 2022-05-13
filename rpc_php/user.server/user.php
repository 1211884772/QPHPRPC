<?php

header("Content-type:text/html;charset=utf-8");//设置框架编码
ini_set("data.timezone", "Asia/Shanghai");//设置时区
define('APP_PATH', 'D:/phpstudy_pro/WWW/rpc/User/');//定义我们的项目路径常量
define('RPC_RUN',true);//是否开启rpc
define('Lib', APP_PATH.'QPHP');//定义我们框架目录常量
define('APP_DEBUG', TRUE);
//===================================
global $RESOURCE;//定义我们的项目资源目录常量
global $MODULE;//模块名称
global $ACTION;//控制器名称
global $MOD;//方法名称

class user
{
    public function get_data($action){
        global $RESOURCE;
        global $MODULE;
        global $ACTION;
        global $MOD;

        if(!RPC_RUN){
            //PHP $_REQUEST 用于收集HTML表单提交的数据
            $_REQUEST['module'] = $GLOBALS['argv']['1'];
            $_REQUEST['action'] = $GLOBALS['argv']['2'];
            $_REQUEST['mod'] = $GLOBALS['argv']['3'];
            $module = 'index';
            if(isset($_SERVER['REQUEST_URI'])){
                $url = $_SERVER['REQUEST_URI'];
                if(strpos($url,'.php')!=false){
                    $url = preg_replace("/\/\w*.php/","",$url);
                }
                $_arr=explode('/',$url);
                $module = strtolower($_arr[1]);
                $action = ucfirst($_arr[2]).'Action';
                $mod = isset($_arr[3])?$_arr[3]:'index';
                if(empty($module)){
                    $module = 'index';
                }
                if(empty($action)){
                    $action = 'IndexAction';
                }
                if(strpos($mod,'?')!=false){
                    $mod = preg_replace("/\?[\w=&]*/","",$mod);
                }
            }
            $MODULE= isset($_REQUEST['module'])&&!empty($_REQUEST['module'])?strtolower($_REQUEST['module']):$module;
            $ACTION=isset($_REQUEST['action'])&&!empty($_REQUEST['action'])?$_REQUEST['action'].'Action':$action;
            $MOD=isset($_REQUEST['mod'])&&!empty($_REQUEST['mod'])?$_REQUEST['mod']:$mod;
        }else{
            $_REQUEST['argv_rpc'] = $action;
            $_arr=explode('/',$_REQUEST['argv_rpc']);
            $MODULE= isset($_arr[0])&&!empty($_arr[0])?strtolower($_arr[0]):'index';
            $ACTION=isset($_arr[1])&&!empty($_arr[1])?$_arr[1].'Action':'IndexAction';
            $MOD=isset($_arr[2])&&!empty($_arr[2])?$_arr[2]:'index';
        }
        $RESOURCE = APP_PATH . 'application/'.$MODULE.'/Resource';
        ini_set("display_errors", true);//是否抛出错误 上线修改为false
        //加载vendor
        require_once APP_PATH . 'vendor/autoload.php';
        require_once Lib . '/QPHP.php';
        $app = new QPHP();
        $rpcData = $app->run();
        $app = null;
        return $rpcData;
    }
}

//$user = new user();
//$a=$user->get_data();
//var_dump($a);


