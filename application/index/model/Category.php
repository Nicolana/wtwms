<?php
namespace app\index\model;

use think\Model;

class Category extends Model{
    protected $pk = 'id';

    public static function page($where, $limit=10){
        return Category::where($where)->paginate($limit);
    }

    public static function getList(){
        return Category::all(['status' => 0]);
    }

    public static function findById($id){
        return Category::get($id);
    }
}

 ?>
