<?php

namespace app\index\validate;


class Campus extends Base
{
    protected $rule = [
        'cp_name' => 'require|min:1|max:20',
        'cp_addr' => 'require|min:1|max:30',
        'cp_resp' => 'require|min:1|max:4',
        'cp_tel' => 'require|max:14',
    ];

    protected $message = [
        'cp_name.require'  =>  '校区名称不能为空',
        'cp_name.max'  =>  '校区名称最多20个字符',
        'cp_name.min'  =>  '校区名称最少1个字符',

        'cp_addr.require' =>  '校区地址不能为空',
        'cp_addr.min' =>  '校区地址最少1个字符',
        'cp_addr.max' =>  '校区地址最多30个字符',

        'cp_resp.require' =>  '校区联系人不能为空',
        'cp_resp.min' =>  '校区联系人最少1个字符',
        'cp_resp.max' =>  '校区联系人最多30个字符',

        'cp_tel.require' =>  '电话号码不能为空',
    ];

    protected $scene = [
        'save'  =>  ['cp_name','cp_addr','cp_resp','cp_tel'],
    ];

}