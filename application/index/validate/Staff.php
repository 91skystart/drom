<?php

namespace app\index\validate;

class Staff extends Base
{
    protected $rule = [
        'ad_num|工号' => 'max:25|unique:admin',
        'ad_sname|姓名' => 'min:1|max:25',
        'ad_sex|性别' => 'in:1,2,3',
//        'ad_tel|电话' => 'length:11',
        'ad_identify|身份证' => 'max:20',
        'contact_address|联系地址' => 'max:100',
        'department|聘用部门' => 'max:10',
        'profession|工种' => 'max:10',
        'into_time|任职时间' => 'dateFormat:Y-m-d',
        'out_time|离职日期' => 'dateFormat:Y-m-d'
    ];

    protected $message = [
        'ad_sex.in'  => '请选择性别',
    ];

    public function sceneAdmin()
    {
        return $this
            ->append('ad_num', 'require')
            ->append('ad_sname', 'require')
            ->append('ad_sex', 'require')
//            ->append('ad_tel', 'require')
            ->append('ad_identify', 'require');
    }

    public function sceneInfo()
    {
        return $this
//            ->append('ad_num', 'require')
            ->append('contact_address', 'require')
            ->append('department', 'require')
            ->append('profession', 'require')
            ->append('into_time', 'require')
            ->append('out_time', 'require');
    }

}