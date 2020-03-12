<?php
namespace app\index\model;

use think\Model,
    think\facade\Request;
use app\index\model\Role,
    app\index\model\Company;

class User extends Model{
    public function store($data){
        $this->data($data);
        return $this->save();
    }

    public function updateBy($id, $data){
        return $this->where('id', $id)->update($data);
    }

    public function findBy($id){
        return $this->where('id', $id)->FindOrEmpty();
    }

    public function deleteBy($id){
        return $this->where('id', $id)->delete();
    }

    public function findByName($username){
        return $this->where('username', $username)->FindOrEmpty();
    }

    public function findRole()
    {
        return $this->hasOne('Role', 'id', 'role');
    }

    public function findCompany()
    {
        return $this->hasOne('Company', 'id', 'company');
    }

    // public function page($where){
    //     return $this->where($where)->paginate(10);
    // }

    public function page(){
        $data = Request::instance()->get();
        $where = [];

        //封装where查询条件
    	(empty($data['role']) 		|| $data['role'] == '')		|| $where['role'] 		= 	$data['role'];
    	(empty($data['status']) 	|| $data['status'] == '')	|| $where['status'] 	= 	$data['status'];
    	(empty($data['company']) 	|| $data['company'] == '')	|| $where['company'] 	= 	$data['company'];
    	empty($data['truename'])	|| $where['truename']		=	[ 'like','%'.$data['truename'] ];
    	empty($data['sn'])			|| $where['sn'] 			= 	$data['sn'];

        return $this->where($where)->paginate(10);
    }

    public static function get_var(){
        $info_var = [
            "role" => Role::all(),
            "company" => Company::all(),
        ];

        return $info_var;
    }
}

 ?>
