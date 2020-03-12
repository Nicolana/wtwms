<?php
namespace app\index\controller;

use app\index\model\User;
use app\index\controller\Base;
use think\Session;
use think\Cookie;

class Index extends Base
{
    public function index()
    {
        // $userModel = new User();
        // $user_info = $userModel->findBy(Cookie('uid'));

        return $this->fetch();
    }

}
