<?php
namespace app\index\model;
use think\Model;
class SxdStudentInfo extends Model
{

	//设置主键
	protected $pk = 's_id';
	protected $resultSetType = 'collection';
	protected $createTime = false;
	protected $updateTime = false;

	//是否分配
	const QUARTER_WAIT= 0;
	const QUARTER_SUCCESS = 1;

	public static function getAttrQuarter()
	{
		return [
				self::QUARTER_WAIT => '未分配',
				self::QUARTER_SUCCESS => '已分配',
		];
	}


    public function admin()
    {
        return $this->hasOne('Admin','ad_uid','ad_uid');
    }
}
