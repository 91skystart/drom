<?php
/**
 *  Auth.php
 *
 * @description 权限模型
 * @author Lang <411857327@qq.com>
 */

namespace app\index\model;


use think\Model;

class Auth extends Model
{
    protected $pk = 'au_id';
    protected $resultSetType = 'collection';
    protected $createTime = false;
    protected $updateTime = false;
}