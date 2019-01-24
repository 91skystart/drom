<?php
namespace app\index\model;
use think\Model;
class DmBuildManage extends Model
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

	public function build()
	{
		return $this->hasOne('DmBuild', 'id', 'build_id');
	}
}
