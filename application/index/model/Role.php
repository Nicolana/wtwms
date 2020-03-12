<?php
namespace app\index\model;
use think\Model;

class Role extends Model
{
	protected $pk = 'id';

	public static function findById($id)
	{
		return Role::get($id);
	}

	public static function findByName($name)
	{
		return Role::get(['name' => $name]);
	}

	public static function removeById($id)
	{
		$role = Role::get($id);
		return $role->delete();
	}
}
