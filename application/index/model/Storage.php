<?php
namespace app\index\model;

use think\Model;

class Storage extends Model{
    protected $pk = "id";

    public static function page($where, $length=10){
        return Storage::where($where)->paginate($length);
    }

    public static function findByName($name){
        return Storage::get(['name' => $name]);
    }

    public static function findById($id){
        return Storage::get($id);
    }
    
    public function store($data){
        $this->data($data);
        return $this->save();
    }

}

 ?>
