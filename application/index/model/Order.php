<?php
namespace app\index\model;

use think\Model;

class Order extends Model{

    public static function page($where, $limit = 10) {
        return Order::where($where)->paginate($limit);
    }
}
 ?>
