<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Menu;

class Demo extends Controller{
    public function index(){
        $menuModel = new Menu();
        $data = $menuModel->getMenuTree();
        dump($data);
    }
}


 ?>
