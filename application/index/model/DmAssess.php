<?php
namespace app\index\model;
use think\Model;
class DmAssess extends Model
{

	//设置主键
	protected $pk = 'id';
	protected $resultSetType = 'collection';
	protected $createTime = 'date';
	protected $updateTime = 'date';


//	protected $insert = ['date'];
//	protected function setDateAttr($value)
//	{

//		return strtotime($value);
//	}

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

	public function grade()
	{
		return $this->hasOne('Grade','gd_id','grade_id');
	}

	public function bclass(){
		return $this->hasOne('Bclass','cl_id','cl_id');
	}

}
