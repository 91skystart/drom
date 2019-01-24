<?php
namespace app\index\model;
use think\Model;
class Admin extends Model
{

	//设置主键
	protected $pk = 'ad_uid';
	protected $resultSetType = 'collection';
	protected $createTime = false;
	protected $updateTime = false;

	public function grade()
	{
		return $this->hasOne('Grade','gd_id','gd_id');
	}

	public function bclass(){
		return $this->hasOne('Bclass','cl_id','cl_id');
	}

}
