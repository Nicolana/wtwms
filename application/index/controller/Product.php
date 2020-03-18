<?php
namespace app\index\controller;

// use app\index\model\Product as ProductModel;
// use app\index\model\Unit,
//     app\index\model\Storage,
//     app\index\model\Category;

use app\index\model\{
    Product as ProductModel,
    Unit,
    Storage,
    Category,
    Brand
};

class Product extends Base{

    public function index(){
        $data 	= $this->request->get();
        $where 	= $this->where;

        //封装where查询条件
        (empty($data['status']) || $data['status'] == '')	|| $where['status'] = $data['status'];
        empty($data['name'])	|| $where['name']			= 	['like','%'.$data['name'] ];
        empty($data['sn'])		|| $where['sn'] 			= 	$data['sn'];


        $this->assign(['list' => ProductModel::page($where)]);
        return view();
    }

    public function create(){
        $status = array_merge(['status' => 0], $this->where);
        $this->assign([
            'unit' => Unit::all( $status),
            'category' => Category::all($status),
            'storage' => Storage::all(['status' => 0, 'id' => $this->where['storage']]),
            'brand' => Brand::all($status),
        ]);
        return view();
    }

    public function edit($id) {
        $status = array_merge(['status' => 0], $this->where);
        $this->assign([
            'unit' => Unit::all( $status),
            'category' => Category::all($status),
            'storage' => Storage::all(['status' => 0, 'id' => $this->where['storage']]),
            'brand' => Brand::all($status),
            'info' => ProductModel::get($id),
        ]);
        return view();
    }

    public function save(){
        $this->request->isPost() || die('request not post!');

        $param = $this->request->param(); // 获取参数
        $error = $this->_validate($param);

        if (is_null($error)){

            if ( ProductModel::get(['name' => $param['name']])){
                return ['error' => 100, 'msg' => '名称已经存在'];
                exit();
            }
            $product 			= new ProductModel();
			$product->sn 		= $param['sn'];
			$product->name 		= $param['name'];
			$product->category 	= $param['category'];
			$product->unit 		= $param['unit'];
			$product->spec 		= $param['spec'];
            $product->brand     = $param['brand']; // 品牌
			$product->price 	= $param['price']; // 批发价格
            $product->retail_price 	= $param['retail_price']; // 零售价格
            $product->in_price = $param['in_price']; // 进货价
            $product->discount = $param['discount'];
			$product->desc 		= $param['desc'];
            $product->storage   = $this->where['storage'];
			// $product->status 	= $param['status'];
			$product->add_time 	= time();

            if ($product->save()){
                return ['error' => 0, 'msg' => '保存成功'];
            } else {
                return ['error' => 100, 'msg' => '保存失败'];
            }
        } else {
            return ['error' => 100, 'msg' => $error];
        }
    }

    public function update(){
        $this->request->isPost() || die('request not post!');

        $param = $this->request->param(); // 获取参数
        $error = $this->_validate($param);

        if (is_null($error)){
            $product 			= ProductModel::get($param['id']);
			$product->name 		= $param['name'];
			$product->category 	= $param['category'];
			// $product->storage 	= $param['storage'];
			$product->unit 		= $param['unit'];
			$product->spec 		= $param['spec'];
            $product->brand     = $param['brand']; // 品牌
			$product->price 	= $param['price']; // 批发价格
            $product->retail_price 	= $param['retail_price']; // 零售价格
            $product->in_price = $param['in_price']; // 进货价
            $product->discount = $param['discount'];
			$product->desc 		= $param['desc'];
			$product->status 	= $param['status'];

            if ($product->save()){
                return ['error' => 0, 'msg' => '保存成功'];
            } else {
                return ['error' => 100, 'msg' => '保存失败'];
            }
        } else {
            return ['error' => 100, 'msg' => $error];
        }
    }

    public function delete($id){
        $target = ProductModel::get($id);
        if ($target->delete()){
            return ['error' => 0, 'msg' => '删除成功'];
        } else {
            return ['error' => 100, 'msg' => '删除失败'];
        }

    }

    private function _validate($data){
        // 验证
        $validate = validate('ProductValidate');
        if (!$validate->check($data)){
            return $validate->getError();
        }
    }
}

 ?>
