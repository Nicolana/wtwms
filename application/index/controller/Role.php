<?php
namespace app\index\controller;

use app\index\model\Role as RoleModel,
    app\index\model\Menu as MenuModel,
    app\index\modle\Power as PowerModle,
    app\index\model\Storage as StorageModel;

class Role extends Base
{
    public function index(){
        // $data = $this->request->get();
        $this->assign(['list' => RoleModel::where('status', 0)->paginate(10)]);
        return view();
    }

    public function create(){
        $menuModel = new MenuModel();
        // dump(permission_jstree_data($menuModel->getPermissionTree()));
        $this->assign([
            'menu' => json_encode(permission_jstree_data($menuModel->getPermissionTree())),
            'storage' => json_encode(permission_jstree_data(StorageModel::all(['status' => 0]))),
        ]);
        return view();
    }

    public function edit($id)
    {
        $info = RoleModel::findById($id);
        $menuModel = new MenuModel();

        $this->assign([
            'info' => $info,
            'menu' => json_encode(permission_jstree_data($menuModel->getPermissionTree(), explode(',', $info->ids))),
            'storage' => json_encode(permission_jstree_data(StorageModel::all(['status' => 0]),explode(',',  $info->storages))),
        ]);
        return view();
    }

    public function save()
    {
        $this->request->isPost() || die('request not post!');

        $param = $this->request->param();
        $error = $this->_validate($param); // 是否铜鼓哦验证

        if (is_null($error))
        {
            if (RoleModel::findByName($param['name'])){
                return ['error' => 100, 'msg' => '名称已经存在'];
                exit();
            }

            $roleModel = new RoleModel();
            $roleModel->name = $param['name'];
            $roleModel->ids = $param['ids'];
            $roleModel->storages = $param['storages'];
            $roleModel->desc = $param['desc'];
            $roleModel->add_time = time();

            if ($roleModel->save())
            {
                return ['error' => 0, 'msg' => '保存成功'];
            } else {
                return ['error' => 100, 'msg' => '保存失败'];
            }
        } else {
            return ['error' => 100, 'msg' => $error];
        }
    }

    public function update()
    {
        $this->request->isPost() || die('request not post!!');

        $param = $this->request->param(); // 获取参数
        $error = $this->_validate($param); // 校验参数是否符号要求

        if (is_null($error)) {
            $role2 = RoleModel::findById($param['id']);
            $role2->name = $param['name'];
            $role2->ids = $param['ids'];
            $role2->storages = $param['storages'];
            $role2->desc = $param['desc'];

            // 检测错误
            if ($role2->save()) {
                return ['error' => 0, 'msg' => '修改成功'];
            } else {
                return ['error' => 100, 'msg' => '修改失败'];
            }
        } else {
            return ['error' => 100, 'msg' => $error];
        }
    }

    public function delete($id){
        if (RoleModel::removeById($id)){
            return ['error' => 0, 'msg' => '删除成功'];
        } else {
            return ['error' => 100, 'msg' => '删除失败'];
        }
    }

    public function action(){
        $this->assign(['list' => Power::where('status', 0)->paginate(10)]);
        return view();
    }

    // 验证器
    private function _validate($data)
    {
        // 验证
        $validate = validate('RoleValidate');
        if (!$validate->check($data)){
            return $validate->getError();
        }
    }
}

 ?>
