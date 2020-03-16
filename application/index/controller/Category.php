<?php
namespace app\index\controller;

use app\index\model\Category as CategoryModel;

class Category extends Base{
    public function index(){
        $data 	= $this->request->get();
        $where 	= $this->where;

        //封装where查询条件
        (empty($data['status']) || $data['status'] == '')	|| $where['status'] 	= 	$data['status'];
        empty($data['name'])	|| $where['name']		= 	['like','%'.$data['name'] ];
        empty($data['pid'])		|| $where['pid'] 		= 	$data['pid'];
        empty($data['sn'])		|| $where['id'] 		= 	$data['sn'];

        $this->assign([
            'list' => CategoryModel::page($where),
            'category' => CategoryModel::getList(),
        ]);
        return view();
    }

    public function create(){
        $this->assign(['category' => CategoryModel::getList()]);
        return view();
    }

    public function save()
    {
        $this->request->isPost() || die('request not post!');

        $param = $this->request->param();
        $error = $this->_validate($param);

		if( is_null( $error ) ){

			if( CategoryModel::get(['name' => $param['name'] ]) ){
				return ['error'	=>	100,'msg'	=>	'名称已经存在'];
				exit();
			}

			$category 			= new CategoryModel();
			$category->name 	= $param['name'];
			$category->pid 		= $param['pid'];
			$category->desc 	= $param['desc'];
            $category->storage  = $this->where['storage'];
			$category->add_time = time();

			// 检测错误
			if( $category->save() ){
				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];
			}

		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}
    }

    public function update()
    {
        $this->request->isPost() || die('request not post!');

        $param = $this->request->param();
        $error = $this->_validate($param);


        if( is_null( $error ) ){

            $category 			= CategoryModel::get($param['id']);
            $category->name 	= $param['name'];
            $category->pid 		= $param['pid'];
            $category->desc 	= $param['desc'];
            $category->status   = $param['status'];
            // 检测错误
            if( $category->save() ){
                return ['error'	=>	0,'msg'	=>	'保存成功'];
            }else{
                return ['error'	=>	100,'msg'	=>	'保存失败'];
            }

        }else{
            return ['error'	=>	100,'msg'	=>	$error];
        }
    }

    public function edit($id){
        $this->assign([
            'info' => CategoryModel::findById($id),
            'category' => CategoryModel::getList(),
        ]);
        return view();
    }

    public function delete($id){
        if( CategoryModel::destroy($id) ){
    		return ['error'	=>	0,'msg'	=>	'删除成功'];
    	}else{
    		return ['error'	=>	100,'msg'	=>	'删除失败'];
    	}
    }

    // 验证器
    private function _validate($data){
        // 验证
        $validate = validate('CategoryValidate');
        if(!$validate->check($data)){
            return $validate->getError();
        }
    }
}

 ?>
