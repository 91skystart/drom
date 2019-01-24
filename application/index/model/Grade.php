<?php
namespace app\index\model;
use think\Model;
class Grade extends Model
{

	//设置主键
	protected $pk = 'gd_id';
	protected $resultSetType = 'collection';
	protected $createTime = false;
	protected $updateTime = false;

	//是否毕业
	const STATUS_NO= 1;
	const STATUS_YES = 2;

	public static function getAttrStatus()
	{
		return [
				self::STATUS_NO => '未毕业',
				self::STATUS_YES => '已毕业',
		];
	}

}
