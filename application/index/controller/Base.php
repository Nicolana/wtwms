<?php
namespace app\index\controller;

use app\index\model\User,
    app\index\model\Menu,
    think\Controller;
use think\facade\Session;
// use think\Session;

class Base extends Controller
{
    protected $menuList;

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

        $this->menuList =$service->getMenuShow($user_info);
        $this->assign('_menuList', $this->menuList);

        // 检验权限
        $super_admin = config('super_admin');
        if(isset($super_admin) && in_array($user_info->id, $super_admin)) {
            return true;
        }
        // if (!$service->checkPermission($role->ids, $this->request->controller(), ))
    }
}
 ?>
