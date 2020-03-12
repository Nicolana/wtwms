<?php
namespace app\index\controller;

use app\index\model\Power as PowerModel;


class Power extends Base{

    public function index(){
        $data = $this->request->get();
        $where = [];

        $this->assign(['list' => PowerModel::page($where)])
        return view();
    }
}

 ?>
