<?php
/**
 *  Roles.php
 *
 * @description
 * @author Lang <411857327@qq.com>
 */

namespace app\index\model;


use think\Model;

class Roles extends Model
{
    protected $pk = 'rs_id';
    protected $resultSetType = 'collection';
    protected $createTime = false;
    protected $updateTime = false;
}