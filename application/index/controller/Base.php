<?php
namespace app\index\controller;

use app\index\model\User,
    app\index\model\Menu,
    app\index\model\Storage,
    think\Controller;
use think\facade\Session;
use think\exception\HttpResponseException;

class Base extends Controller
{
    protected $menuList;
    protected $where;

    protected function initialize()
    {
        if (!Session::get('uid'))
        {
            return $this->redirect(url('@index/login'));
        }
        $userModel = new User();
        $service = new Menu();
        $role = $userModel->findRole();
        $user_info = $userModel->findBy(Session::get('uid'));
        // $role = $user_info->findRole;
        $this->assign('my_info', $user_info);

        // 设置菜单目录
        $this->menuList =$service->getMenuShow($user_info);
        $this->assign('_menuList', $this->menuList);

        // 设置仓库查询条件
        $store = Storage::get(['id' => Session::get('storage')]);
        $this->assign('storage', $store);
        $this->where = [
            "storage" => Session::get('storage')
        ];

        // 检验权限
        $super_admin = config('super_admin');
        if(isset($super_admin) && in_array($user_info->id, $super_admin)) {
            return true;
        }
        if (!$service->checkPermission($role->ids, $this->request->controller(), $this->request->action())){
            if ($this->request->isAjax()) {
                throw new HttpResponseException(json(['error' => 101, 'msg' => '没有操作权限']));
            }
            $this->error("没有操作权限!");
        }
    }
}
 ?>
