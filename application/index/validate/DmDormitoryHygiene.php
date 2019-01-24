<?php
namespace app\index\validate;
use app\index\model\Campus;
use app\index\model\DmBuild;
use app\index\model\DmFloor;
use app\index\model\DmDormitory;
use app\index\model\Grade;
use app\index\model\Bclass;

class DmDormitoryHygiene extends Base
{
    protected $rule = [

        'campus_id|校区' => 'checkCampus',
        'build_id|楼栋' => 'checkbuild',
        'floor_id|楼层' => 'checkFloor',
        'dormitory_id|房间号' => 'checkDormitory',
        'grade_id|年级' => 'checkGrade',
        'class_id|班级' => 'checkClass',
        'score|得分' => 'max:10',
        'remarke|备注' => 'max:500',
        'date|检查日期' => 'dateFormat:Y-m-d',
    ];

    public function sceneAdd()
    {
        return $this
            ->append('campus_id', 'require')
            ->append('build_id', 'require')
            ->append('floor_id', 'require')
            ->append('dormitory_id', 'require')
            ->append('grade_id', 'require')
            ->append('class_id', 'require')
            ->append('score', 'require')
            ->append('remarke', 'require')
            ->append('date', 'require');
    }

    public function sceneSave()
    {
        return $this
            ->append('campus_id', 'require')
            ->append('build_id', 'require')
            ->append('floor_id', 'require')
            ->append('dormitory_id', 'require')
            ->append('grade_id', 'require')
            ->append('class_id', 'require')
            ->append('score', 'require')
            ->append('remarke', 'require')
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