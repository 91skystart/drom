<?php

namespace app\index\validate;

class DmbuildManage extends Base
{
    protected $rule = [
        'campus_id|校区' => 'require|integer',
        'build_id|楼栋' => 'require|integer',
        'job_num|工号' => 'require|min:1|max:20|unique:dmbuildManage|checkNum',
        'name|姓名' => 'require|min:1|max:10|checkName',
        'phone|联系电话' => 'require|max:14|checkTel',
        'idcard|身份证' => 'require|max:30|checkId',
    ];

    protected $message = [
        'campus_id.require'  => '请选择校区',
        'campus_id.integer'  =>  '校区参数无效',

        'build_id.require' =>  '请选择楼栋',
        'build_id.integer' =>  '楼栋参数无效',

        'job_num.require' =>  '请填写工号',
        'job_num.min' =>  '工号不能少于1个字符',
        'job_num.max' =>  '工号不能大于20个字符',
        'job_num.checkNum' => '当前校区下不存在此工号',

        'name.require' =>  '请填写姓名',
        'name.min' =>  '姓名不能少于1个字符',
        'name.max' =>  '姓名不能大于10个字符',
        'name.checkName' => '姓名与工号不匹配',

        'phone.require' =>  '请填写联系电话',
        'phone.max' =>  '联系电话不能大于14个字符',
        'phone.checkTel' => '电话格式不正确',

        'idcard.require' =>  '请填写身份证',
        'idcard.max' =>  '身份证不能大于30个字符',
        'idcard.checkId' => '身份证格式不正确'


    ];

    protected $scene = [
        'add'  =>  ['campus_id','build_id','job_num','name','phone','idcard'],
        'save'  =>  ['campus_id','build_id','job_num','name','phone','idcard'],
    ];

    protected function checkNum(){
        $jobNum = model('Admin')->where(['ad_num' => $this->param['job_num'], 'cp_id' => $this->param['campus_id']])->find();
        if(!$jobNum){
            return false;
        }
        return true;
    }

    protected function checkName(){
        $name = model('Admin')->where(['ad_num' => $this->param['job_num'], 'ad_sname' => $this->param['name']])->find();
        if(!$name){
            return false;
        }
        return true;
    }

    protected function checkTel($value){
		if(!preg_match('/^1[3,4,5,6,7,8,9][\d]{1}[\d]{8}$/',$value)) 
			return false;
		return true;
	}

    protected function checkId($val){
        return is_idcard($val)? true: false;
    }

}