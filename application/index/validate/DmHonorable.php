<?php

namespace app\index\validate;
use app\index\model\Campus;
use app\index\model\DmBuild;
use app\index\model\DmFloor;
use app\index\model\DmDormitory;

class DmHonorable extends Base
{
    protected $rule = [
        'student_num|学号' => 'min:1|max:20',
        'name|姓名' => 'min:1|max:10',
        'campus_id|校区' => 'checkCampus',
        'build_id|楼栋' => 'checkbuild',
        'floor_id|楼层' => 'checkFloor',
        'dormitory_id|房间号' => 'checkDormitory',
        'goods_name|物品名称' => 'max:50',
        'moveout_date|搬出时间' => 'dateFormat:Y-m-d H:i',
    ];

    public function sceneAdd()
    {
        return $this
            ->append('student_num', 'require')
            ->append('name', 'require')
            ->append('campus_id', 'require')
            ->append('build_id', 'require')
            ->append('floor_id', 'require')
            ->append('dormitory_id', 'require')
            ->append('goods_name', 'require')
            ->append('moveout_date', 'require');

    }

    public function sceneSave()
    {

     return $this
         ->append('student_num', 'require')
         ->append('name', 'require')
         ->append('campus_id', 'require')
         ->append('build_id', 'require')
         ->append('floor_id', 'require')
         ->append('dormitory_id', 'require')
         ->append('goods_name', 'require')
         ->append('moveout_date', 'require');

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

}