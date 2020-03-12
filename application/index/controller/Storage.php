<?php
namespace app\index\controller;

use app\index\model\Storage as storageModel;

class Storage extends Base
{
    public function index()
    {
        $data = $this->request->get();
        $where = [];

        //封装where查询条件
    	(empty($data['status']) || $data['status'] == '')	|| $where['status'] 	= 	$data['status'];
    	empty($data['contact'])	|| $where['contact']	=	['like','%'.$data['contact'] ];
    	empty($data['name'])	|| $where['name']		= 	['like','%'.$data['name'] ];
    	empty($data['phone'])	|| $where['phone'] 		= 	$data['phone'];
    	empty($data['sn'])		|| $where['sn'] 		= 	$data['sn'];

        $this->assign(['list' => storageModel::page($where)]);
        return view();
    }

    public function create()
    {
        return view();
    }

    // 保存数据
    public function save()
    {
        $data = $this->request->isPost() || die('request not post');

        $param = $this->request->param();
        $error = $this->_validate($param);

        if (is_null( $error )){
            if (storageModel::findByName($param['name'])){
                return ['error' => 100, 'msg' => '名称已经存在'];
                exit();
            }

            $storage = new storageModel();
            $data = [
                'sn'        => $param['sn'],
                'name'      => $param['name'],
                'contact'   => $param['contact'],
                'phone'     => $param['phone'],
                'desc'      => $param['desc'],
                'address'   => $param['address'],
                'add_time'  => time(),
            ];

            // 检查存数据是否成功
            if($storage->store($data)){
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
        $data = $this->request->isPost() || die('request not post');

        $param = $this->request->param();
        $error = $this->_validate($param);

        if (is_null( $error )){

            $storage = storageModel::get($param['id']);
            $data = [
                'name'      => $param['name'],
                'contact'   => $param['contact'],
                'phone'     => $param['phone'],
                'desc'      => $param['desc'],
                'address'   => $param['address'],
            ];

            // 检查存数据是否成功
            if($storage->store($data)){
                return ['error' => 0, 'msg' => '保存成功'];
            } else {
                return ['error' => 100, 'msg' => '保存失败'];
            }
        } else {
            return ['error' => 100, 'msg' => $error];
        }
    }
    public function edit($id){
        $this->assign(['info' => storageModel::findById($id)]);
        return view();
    }

    public function delete($id){
        if (storageModel::destroy($id)){
            return ['error' => 0, 'msg' => '删除成功'];
        } else {
            return ['error' => 100, 'msg' => '删除失败'];
        }
    }

    private function _validate($data){
        // 验证数据书否合理
        $validate = validate('StorageValidate');
        if (!$validate->check($data)){
            return $validate->getError();
        }
    }
}



 ?>
