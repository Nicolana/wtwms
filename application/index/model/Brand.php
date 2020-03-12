<?php
namespace app\index\model;

use think\Model;

class Brand extends Model{

    public static function page($where, $limit=10){
        return Brand::where($where)->paginate($limit);
    }
    

}

 ?>
