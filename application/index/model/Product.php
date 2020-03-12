<?php
namespace app\index\model;

use think\Model;

class Product extends Model{

    protected $pk = 'id';

    public static function page($where, $limit=10){
        return Product::where($where)->paginate($limit);
    }

}

 ?>
