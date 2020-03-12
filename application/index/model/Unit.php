<?php
namespace app\index\model;

use think\Model;


class Unit extends Model{

    public static function page($where, $limit=10){

        return Unit::where($where)->paginate($limit);
    }
}

 ?>
