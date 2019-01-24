<?php
namespace app\index\model;
use think\Model;
class DmBuild extends Model
{

	//设置主键
	protected $pk = 'id';
	protected $resultSetType = 'collection';
	protected $createTime = false;
	protected $updateTime = false;

	public function campus()
	{
		return $this->hasOne('Campus','cp_id','campus_id');
	}
}
