<?php
namespace app\index\controller;
use think\Request;
use app\index\model\User as UserModel;

class User extends Base{

    public function index(Request $request){
        $userModel = new UserModel();
        $this->assign(UserModel::get_var());
        $this->assign(['list' => $userModel->page()]);
        // $this->assign(['list' => ['h']]);

        return view();
    }

    public function create(){
        $this->assign(UserModel::get_var());
        return view();
    }

    public function save(Request $request){
        $request->isPost() || die('request not post!');

        $param = $request->param();
        // TODO : Validate the input
        $error = null;
        if (is_null( $error ))
        {
            if (UserModel::get(['sn' => $param['sn'] ]))
            {
                return ['error' => 100, 'msg' => '员工编号已经存在'];
                exit();
            }

            $data = [
                'sn'        => $param['sn'],
                'username'  => $param['username'],
                'password'  => md5($param['password']),
                'phone'     => $param['phone'],
                'email'     => $param['email'],
                'truename'  => $param['truename'],
                'status'    => $param['status'],
                'desc'      => $param['desc'],
                'company'   => $param['company'],
                'add_time'  => time(),
            ];

            // 存储并检测错误
            $userModel = new UserModel();
            if ($userModel->store($data)){
                return ['error' => 0, 'msg' => '保存成功'];
            } else {
                return ['error' => 100, 'msg' => '保存失败'];
            }
        }else{
            return ['error' => 100, 'msg' => $error];
        }
    }

    public function edit($id){
        $userModel = new UserModel();
        $this->assign($userModel->get_var());
        $this->assign(['info' => $userModel->findBy($id)]);
        return view();
    }

    public function update(){
        $this->request->isPost() || die('request not post!');

        $param = $this->request->param(); // 获取参数
        $error = $this->_validate($param); // 是否通过验证

        if (is_null($error))
        {
            $userModel = UserModel::get($param['id']);
            $password = $password == $userModel->$password ? $userModel->$password : $password;
            $data = [
                'sn' => $param['sn'],
                'username' => $param['username'],
                'password' => md5($param['password']),
                'phone'    => $param['phone'],
                'email'    => $param['email'],
                'truename' => $param['truename'],
                'status'   => $param['status'],
                'desc'     => $param['desc'],
                'role'     => $param['role'],
                'company'  => $param['company'],
            ];
            // $userModel->updateBy($param['id'], $data)
            if ($userModel->save($data)){
                return ['error' => 0, 'msg' => '修改成功'];
            } else {
                return ['error' => 100, 'msg' => '修改失败'];
            }
        } else {
            return [
                'error' => 100,
                'msg'   => $error
            ];
        }
    }

    public function delete($id){
        $userModel = UserModel::get($id);
        if ($userModel->delete()) {
            return ['error' => 0, 'msg' => '删除成功'];
        } else {
            return ['error' => 100, 'msg' => '删除失败'];
        }
    }

    public function _validate($data){
        // 验证
        $validate = validate('UserValidate');
        if (!$validate->check($data)){
            return $validate->getError();
        }
    }
}

 ?>
