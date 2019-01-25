<?php

namespace app\index\validate;

class Dmbuild extends Base
{
    protected $rule = [
        'campus_id' => 'require|integer',
        'build_name' => 'require|checkName|min:1|max:10',
    ];

    protected $message = [
        'campus_id.require'  => '请选择校区',
        'campus_id.integer'  =>  '校区参数无效',

        'build_name.require' =>  '楼栋名称不能为空',
        'build_name.min' =>  '楼栋名称最少1个字符',
        'build_name.max' =>  '楼栋名称最多10个字符',
        'build_name.checkName' => '楼层名已存在'
    ];

    protected $scene = [
        'add'  =>  ['campus_id','build_name'],
        'save'  =>  ['campus_id','build_name'],
    ];

    protected function checkName($value){
        $param = \think\Request::instance()->param();
        $buildModel = new \app\index\model\DmBuild;
        $gOne = $buildModel->where(['campus_id' => $param['campus_id'], 'build_name' => $value])->find();
        if($gOne){
            return false;
        }
        return true;
    }

}