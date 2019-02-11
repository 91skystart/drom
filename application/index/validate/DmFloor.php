<?php

namespace app\index\validate;

class DmFloor extends Base
{
    protected $rule = [
        'campus_id' => 'require',
        'build_id' => 'require',
        'floor_name' => 'require|checkName|min:1|max:10',
    ];

    protected $message = [
        'campus_id.require'  => '请选择校区',
        'build_id.require'  =>  '请选择楼栋',

        'floor_name.require' =>  '楼层名称不能为空',
        'floor_name.min' =>  '楼层名称最少1个字符',
        'floor_name.max' =>  '楼层名称最多10个字符',
        'floor_name.checkName' => '楼层名称已存在'

    ];

    protected $scene = [
        'add'  =>  ['campus_id','build_id','floor_name'],
        'save'  =>   ['campus_id','build_id','floor_name'],
    ];

    protected function checkName(){
        $param = \think\Request::instance()->param();
        $buildModel = new \app\index\model\DmFloor;
        $gOne = $buildModel->where(['build_id' => $param['build_id'], 'floor_name' => $param['floor_name']])->find();
        if(isset($param['id']) && ($param['id'] == $gOne['id'])) return true;
        if($gOne){
            return false;
        }
        return true;
    }

}