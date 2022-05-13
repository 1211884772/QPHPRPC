<?php


class Action
{

    public $input;
    //前置执行
    public function before(){
        $input = new Input();
        $this->input = $input->parse();
    }

    //后置执行
    public function after(){

    }

    public function call($actionObj,$action){
        $this->before();
        $rpcData=$actionObj->$action();
        $this->after();
        //rpc
        return $rpcData;
    }

    public function display($view,$data=array()){
        global $MODULE;
        //extract() 函数从数组中将变量导入到当前的符号表
        extract($data);
        require APP_PATH.'application/'.$MODULE.'/App/View/'.$view;
    }

    public function redireact($url){
        echo "<script>location.href='{$url}'</script>";
    }

}
