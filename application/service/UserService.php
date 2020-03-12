<?php
namespace app\service;

use think\Request,
    app\index\model\User,
    app\index\model\Role,
    app\index\model\Company;
    // app\validate\UserValidate;

class UserService\
{
    public function getVar(){
        return [
            'company' => Company::all(),
            'role'  => Role::all(),
        ];
    }

    public function page(){
        $data = Request::instance()->get();
        $where = [];

        // 封装where查询条件
        (empty($data['role']) || $data['role'] == '') || $where['role'] = $data['role'];
        (empty($data['status']) || $data['status'] == '') || $where['status'] = $data['status'];
        (empty($data['company']) || $data['company'] == '') || $where['company'] = $data['company'];
        empty($data['truename']) || $where['truename'] = ['like', '%'.$data['truename']];
        empty($data['sn']) || $where['sn']  = $data['sn'];

        return User::where($where)->paginate(10);
    }
}

 ?>
