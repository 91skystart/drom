<?php

namespace app\index\validate;

class DmDormitoryManage extends Base
{
    protected $rule = [
        'campus_id|校区' => 'require|integer',
        'build_id|楼栋' => 'require|integer',
        'floor_id|楼层' => 'require|integer',
        'dormitory_id|房间号' => 'require|integer',
        'job_num|工号' =>'require|max:20|unique:dmdormitoryManage|checkNum',
        'name|姓名' =>'require|max:10|checkName',
        'phone|电话' =>'require|max:20|checkTel',
    ];

    protected $message = [
        'campus_id.require'  => '请选择校区',
        'campus_id.integer'  =>  '校区参数无效',
        'build_id.require'  => '请选择楼栋',
        'build_id.integer'  =>  '楼栋参数无效',
        'floor_id.require'  => '请选择楼层',
        'floor_id.integer'  =>  '楼层参数无效',
        'dormitory_id.require'  => '请选择房间号',
        'dormitory_id.integer'  =>  '房间号参数无效',

        'job_num.require'  => '请填写工号',
        'job_num.max:20'  => '工号不能超过20个字符',
        'job_num.unique'  => '工号已存在',
        'job_num.checkNum' => '该校区下不存在此工号',
        'phone.require'  => '请填写电话',
        'phone.max:20'  => '电话不能超过20字符',
        'phone.checkTel' => '电话格式不正确',
        'name.require'  => '请填写姓名',
        'name.max:20'  => '姓名不能超过10字符',
        'name.checkName' => '姓名与工号不匹配'

    ];

    protected $scene = [
        'add'  =>['campus_id','build_id','floor_id','dormitory_id','job_num','phone','name'],
        'save'  =>['campus_id','build_id','floor_id','dormitory_id','job_num','phone','name'],
        ];
    
    protected function checkNum(){
        $aRoel = Db::name('Roles')->select();
        $jobNum = model('Admin')->where(['ad_num' => $this->param['job_num'], 'cp_id' => $this->param['campus_id']])->find();
        if(!$jobNum){
            return false;
        }else{
            $ed = searchRelationIds($jobNum->rs_id, $aRoel, 'rs_pid', 'rs_id',false);
            if(end($ed) != 2){
                return false;
            }
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

}