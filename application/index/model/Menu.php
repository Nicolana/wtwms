<?php
namespace app\index\model;
use think\Model;
use app\index\model\User;
use think\facade\Log;

class Menu extends Model{
    public function getMenuTree($ids=null, $menuList=null)
    {
        if (empty($ids) && empty($menuList)) {
            $where = ['status' => 0,];
        } elseif(empty($menuList)) {
            $where = ['status' => 0, 'id' => ['in', "$ids"]];
        }
        $menu = $this->where($where)->select();
        return $this->menuTree($menu->toArray());

    }

    public function menuTree(array $menuList, $pid=0, $child='child'){
        $result = [];
        foreach($menuList as $key => $val){
            if ($val['pid'] == $pid){
                $result[] = $val;
                unset($menuList[$key]);
            }
        }

        foreach($result as $key => $val){
            $result[$key][$child] = $this->menuTree($menuList, $val['id']);
        }
        return $result;
    }

    public function getMenuShow($obj){
        // 是否是昌吉管理员
        $super_admin = config('super_admin');
        if (isset($super_admin) && in_array($obj->id, $super_admin)) {
            $_menuList = $this->getMenuTree();
        } else {
            $_menuList = $this->getMenuTree($obj->findRole->ids);
        }
        return $_menuList;
    }

    public function getPermissionTree()
    {
        $menuList = $this->select();
        if (empty($menuList)) return [];
        return $this->menuTree($menuList->toArray());
    }
}
 ?>
