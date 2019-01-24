<?php
namespace app\index\model;
use think\Model;
class Bclass extends Model
{

	//设置主键
	protected $pk = 'cl_id';
	protected $resultSetType = 'collection';
	protected $createTime = false;
	protected $updateTime = false;

}
