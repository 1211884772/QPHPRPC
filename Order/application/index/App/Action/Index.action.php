<?php


class IndexAction extends CommonAction
{
    public function index(){
        return 'qphprpc';
    }

    public function getList(){
        return 'this is rpc';
    }

	public function login(){
		$username ='mumu';
		$password = '123456';
		$model = new UserModel();
        $data = $model->table('mm_user')->where("username ='{$username}' and pwd='{$password}'")->select();
        $model->getLastSql();
        var_dump($data);


        $jwt = new JwtTokenUtil();
        $token = $jwt->getToken(array('user_id'=>$data['id']));
        $data_arr=array('token'=>$token);
   
		return $data_arr;
	}

}
