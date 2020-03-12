<?php
namespace app\index\controller;

use app\index\model\Unit as UnitModel;

class Unit extends Base{

    public function index()
    {
        $data = $this->request->get();
        $where = [];
        //封装where查询条件
        (empty($data['status']) || $data['status'] == '')	|| $where['status'] 	= 	$data['status'];
        empty($data['name'])	|| $where['name']		= 	['like','%'.$data['name'] ];
        empty($data['sn'])		|| $where['id'] 		= 	$data['sn'];

        $this->assign(['list' => UnitModel::page($where)]);
        return view();
    }

    public function create()
    {
        return view();
    }

    public function save()
    {
        $this->request->isPost() || die('request not post!');

        $param = $this->request->param();
        $error = $this->_validate($param);

        if( is_null( $error ) ){

            if( UnitModel::get(['name' => $param['name'] ]) ){
                return ['error'	=>	100,'msg'	=>	'名称已经存在'];
                exit();
            }

            $unit 			= new UnitModel();
            $unit->name 	= $param['name'];
            $unit->desc 	= $param['desc'];
            $unit->status 	= $param['status'];
            $unit->add_time = time();

            // 检测错误
            if( $unit->save() ){
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

            $unit 			= UnitModel::get($param['id']);
            $unit->name 	= $param['name'];
            $unit->desc 	= $param['desc'];
            $unit->status 	= $param['status'];

            // 检测错误
            if( $unit->save() ){
                return ['error'	=>	0,'msg'	=>	'保存成功'];
            }else{
                return ['error'	=>	100,'msg'	=>	'保存失败'];
            }

        }else{
            return ['error'	=>	100,'msg'	=>	$error];
        }
    }

    public function edit($id){
        $this->assign(['info' => UnitModel::get($id)]);
        return view();
    }

    public function delete($id){
        if( UnitModel::destroy($id) ){
            return ['error'	=>	0,'msg'	=>	'删除成功'];
        }else{
            return ['error'	=>	100,'msg'	=>	'删除失败'];
        }

        // 支持批量删除多个数据
        // User::destroy('1,2,3');
        // // 或者
        // User::destroy([1,2,3]);
    }

    // 验证器
    private function _validate($data){
        // 验证
        $validate = validate('UnitValidate');
        if(!$validate->check($data)){
            return $validate->getError();
        }
    }
}

 ?>
