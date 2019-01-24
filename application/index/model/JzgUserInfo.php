<?php
namespace app\index\model;
use think\Model;
class JzgUserInfo extends Model
{

	//设置主键
	protected $pk = 'id';
	protected $resultSetType = 'collection';
	protected $createTime = false;
	protected $updateTime = false;

}
