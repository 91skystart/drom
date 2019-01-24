<?php

namespace app\index\validate;

class Dmbuild extends Base
{
    protected $rule = [
        'campus_id' => 'require|integer',
        'build_name' => 'require|min:1|max:10',
    ];

    protected $message = [
        'campus_id.require'  => '请选择校区',
        'campus_id.integer'  =>  '校区参数无效',

        'build_name.require' =>  '楼栋名称不能为空',
        'build_name.min' =>  '楼栋名称最少1个字符',
        'build_name.max' =>  '楼栋名称最多10个字符',

    ];

    protected $scene = [
        'add'  =>  ['campus_id','build_name'],
        'save'  =>  ['campus_id','build_name'],
    ];

}