<?php
namespace app\index\controller;

use app\index\model\Brand as BrandModel;

class Brand extends Base{

    public function index(){
        $data = $this->request->get();
        $where = $this->where;

        (empty($data['status']) || $data['status']) || $where['status'] = $data;
        empty($data['name']) || $where['name'] = ['like', '%'.data['name']];
        empty($data['mfc']) || $where['mfc'] = ['like', '%'.data['like']];

        $this->assign(['list' => BrandModel::page($where)]);
        return view();
    }

    public function create(){
        return view();
    }

    public function save(){
        $this->request->isPost() || die('request not post!');

        $param = $this->request->param(); // 获取参数
        $error = $this->_validate($param);

        if (is_null($error)) {
            if (BrandModel::get(['name' => $param['name']])) {
                return ['error' => 100, 'msg' => '名称已经存在'];
                exit();
            }

            $brand = new BrandModel();
            $brand->name = $param['name'];
            $brand->mfc = $param['mfc'];
            $brand->desc = $param['desc'];
            $brand->status = $param['status'];
            $brand->storage = $this->where['storage'];
            $brand->add_time = time();

            if ($brand->save()) {
                return ['error' => 0, 'msg' => '保存成功'];
            } else {
                return ['error' => 100, 'msg' => '保存失败'];
            }
        } else {
            return ['error' => 100, 'msg' => $error];
        }
    }

    public function edit($id){
        $this->assign(['info' => BrandModel::get($id)]);
        return view();
    }

    public function update(){
        $this->request->isPost() || die("request not post!");

        $param = $this->request->param(); // 获取参数
        $error = $this->_validate($param); // 是否通过验证

        if (is_null($error)) {
            $brand = BrandModel::get($param['id']);
            $brand->name = $param['name'];
            $brand->mfc = $param['mfc'];
            $brand->status = $param['status'];
            $brand->desc = $param['desc'];

            if ($brand->save()) {
                return ['error' => 0, 'msg' => '保存成功'];
            } else {
                return ['error' => 100, 'msg' => '保存失败'];
            }
        } else {
            return ['error' => 100, 'msg' => $error];
        }
    }

    public function delete($id){
        $target = BrandModel::get($id);
        if ($target->delete()){
            return ['error' => 0, 'msg' => '删除成功'];
        } else {
            return ['error' => 100, 'msg' => '删除失败'];
        }
    }

    private function _validate($data){
        // 验证
        $validate = validate('BrandValidate');
        if (!$validate->check($data)){
            return $validate->getError();
        }
    }
}

 ?>
