<?php

namespace app\index\validate;

class DmbuildManage extends Base
{
    protected $rule = [
        'campus_id|校区' => 'require|integer',
        'build_id|楼栋' => 'require|integer',
        'job_num|工号' => 'require|min:1|max:20|unique:dmbuildManage',
        'name|姓名' => 'require|min:1|max:10',
        'phone|联系电话' => 'require|max:14',
        'idcard|身份证' => 'require|max:30',
    ];

    protected $message = [
        'campus_id.require'  => '请选择校区',
        'campus_id.integer'  =>  '校区参数无效',

        'build_id.require' =>  '请选择楼栋',
        'build_id.integer' =>  '楼栋参数无效',

        'job_num.require' =>  '请填写工号',
        'job_num.min' =>  '工号不能少于1个字符',
        'job_num.max' =>  '工号不能大于20个字符',

        'name.require' =>  '请填写姓名',
        'name.min' =>  '姓名不能少于1个字符',
        'name.max' =>  '姓名不能大于10个字符',

        'phone.require' =>  '请填写联系电话',
        'phone.max' =>  '联系电话不能大于14个字符',

        'idcard.require' =>  '请填写身份证',
        'idcard.max' =>  '身份证不能大于30个字符',


    ];

    protected $scene = [
        'add'  =>  ['campus_id','build_id','job_num','name','phone','idcard'],
        'save'  =>  ['campus_id','build_id','job_num','name','phone','idcard'],
    ];

    protected function checkNum($val)
    {
        $model = new Campus();
        if ($val && !$model->find($val)) {
            return '校区不存在';
        }
        return true;
    }

}