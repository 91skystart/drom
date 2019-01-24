<?php

namespace app\index\validate;
use app\index\model\Campus;
use app\index\model\DmBuild;
use app\index\model\DmFloor;
use app\index\model\DmDormitory;
use app\index\model\Grade;
use app\index\model\Bclass;

class DmAssess extends Base
{
    protected $rule = [
        'student_num|学号' => 'min:1|max:20',
        'name|姓名' => 'min:1|max:20',
        'sex|性别' => 'in:1,2',
        'campus_id|校区' => 'checkCampus',
        'build_id|楼栋' => 'checkbuild',
        'floor_id|楼层' => 'checkFloor',
        'dormitory_id|房间号' => 'checkDormitory',
        'grade_id|年级' => 'checkGrade',
        'class_id|班级' => 'checkClass',
        'info|内容' => 'max:500',
        'remarke|备注' => 'max:500',
        'type|类型' => 'in:1,2',
        'date|发生日期' => 'dateFormat:Y-m-d',
    ];

    public function sceneAdd()
    {
        return $this
            ->append('student_num', 'require')
            ->append('name', 'require')
            ->append('sex', 'require')
            ->append('campus_id', 'require')
            ->append('build_id', 'require')
            ->append('floor_id', 'require')
            ->append('dormitory_id', 'require')
            ->append('grade_id', 'require')
            ->append('class_id', 'require')
            ->append('info', 'require')
            ->append('remarke', 'require')
            ->append('type', 'require')
            ->append('date', 'require');
    }

    public function sceneSave()
    {
        return $this
            ->append('student_num', 'require')
            ->append('name', 'require')
            ->append('sex', 'require')
            ->append('campus_id', 'require')
            ->append('build_id', 'require')
            ->append('floor_id', 'require')
            ->append('dormitory_id', 'require')
            ->append('grade_id', 'require')
            ->append('class_id', 'require')
            ->append('info', 'require')
            ->append('remarke', 'require')
            ->append('type', 'require')
            ->append('date', 'require');
    }

    protected function checkCampus($val)
    {
        $model = new Campus();
        if ($val && !$model->find($val)) {
            return '校区不存在';
        }
        return true;
    }

    protected function checkbuild($val){
        $model = new DmBuild();
        if ($val && !$model->find($val)) {
            return '楼栋不存在';
        }
        return true;
    }

    protected function checkFloor($val){
        $model = new DmFloor();
        if ($val && !$model->find($val)) {
            return '楼层不存在';
        }
        return true;
    }

    protected function checkDormitory($val){
        $model = new DmDormitory();
        if ($val && !$model->find($val)) {
            return '房间不存在';
        }
        return true;
    }

    protected function checkGrade($val){
        $model = new Grade();
        if ($val && !$model->find($val)) {
            return '年级不存在';
        }
        return true;
    }

    protected function checkClass($val){
        $model = new Bclass();
        if ($val && !$model->find($val)) {
            return '班级不存在';
        }
        return true;
    }



}