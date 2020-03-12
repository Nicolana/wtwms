<?php
namespace app\index\model;

use think\Model;

class Power extends Model{

    private $ipk = "id";

    public static function page($where, $limit=10){
        return Power::where($where)->paginate($limit);
    }

}
 ?>
