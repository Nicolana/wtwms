<?php

namespace app\index\controller;

use think\Request;
use think\Validate;
use think\Controller;
use think\facade\Session;
use app\index\model\User;
use app\index\model\Role;

class Login extends Controller{
    public function index(){
        return view();
    }

    public function login(Request $request){
        // $err = $this->validateLogin($rquest);
        // if ($err) {
            // $this->error($err);
        // }

        // 正常输入登录

        if ($request->isPost()){
            $username = $request->param('username');

            $userModel = new User();
            $user = $userModel->findByName($username);

            if (!is_null($user)){ // 检查用户是否存在
                // 检验密码是否正确
                $password = $request->param('password');
                if ($user['password'] == md5($password)){
                    Session::set('uid', $user->id, 'think');
                    Session::set('company', $user->company, 'think');
                    $role = Role::get(['id' => $user->role]);
                    Session::set('storage', $role->storages, 'think');
                    return [
                        'error' => 0,
                        'msg'   =>  '登录成功'
                    ];
                }
            }
            // 该用户不存在或者密码错误
            return [
                    'error' => 100,
                    'msg'   => '用户名或者密码错误'
                ];
        }
    }

    public function validateLogin(Request $request){
        $validate = new Validate($this->rule());
    }

    public function quit(){
        Session::delete('uid', 'think');
        Session::delete('company', 'think');
        Session::delete('user_company'); // 清理用户菜单
        return $this->redirect(url('@index/login'));
    }
}

 ?>
