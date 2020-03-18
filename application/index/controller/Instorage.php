<?php
namespace app\index\controller;

use app\index\model\{
    Order,
    Product,
    Category,
    Brand
};

class Instorage extends Base{

    public function index()
    {
        $data 	= $this->request->get();
        $where 	= $this->where;

        //封装where查询条件
        (empty($data['status']) || $data['status'] == '')	|| $where['status'] = $data['status'];
        empty($data['name'])	|| $where['name']			= 	['like','%'.$data['name'] ];
        empty($data['sn'])		|| $where['sn'] 			= 	$data['sn'];

        $this->assign(['list' => Order::page($where)]);
        return view();
    }

    public function create()
    {
        $status = array_merge(['status' => 0], $this->where);
        // $brands = Brand::all($status);
        $category =  Category::all($status);
        $products = product::all($status);

        $this->assign([
            'products' => json_encode(test_tree($category, $products))
        ]);
        return view();
    }
}
 ?>
