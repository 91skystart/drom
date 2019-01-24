<?php
namespace app\index\model;
use think\Model;
class Campus extends Model
{

    //设置主键
    protected $pk = 'cp_id';
    protected $resultSetType = 'collection';
    protected $createTime = false;
    protected $updateTime = false;
}
