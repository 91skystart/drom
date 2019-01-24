<?php
namespace app\index\model;
use think\Model;
class DmVisit extends Model
{

	//设置主键
	protected $pk = 'id';
	protected $resultSetType = 'collection';
	protected $createTime = false;
	protected $updateTime = false;

    const VISIT_TYPE_TEACHER = 1; // 老师访问
    const VISIT_TYPE_OUTER = 2; // 外来人员

	public function campus()
	{
		return $this->hasOne('Campus', 'cp_id', 'campus_id');
	}

	public function build()
	{
		return $this->hasOne('DmBuild', 'id', 'build_id');
	}

	public function floor()
	{
		return $this->hasOne('DmFloor', 'id', 'floor_id');
	}

	public function dormitory(){
		return $this->hasOne('DmDormitory', 'id', 'dormitory_id');
	}

}
