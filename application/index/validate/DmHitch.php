<?php

namespace app\index\validate;
use app\index\model\Campus;
use app\index\model\DmBuild;
use app\index\model\DmFloor;
use app\index\model\DmDormitory;

class DmHitch extends Base
{
    protected $rule = [
        'name|申报人' => 'min:1|max:10',
        'campus_id|校区' => 'checkCampus',
        'build_id|楼栋' => 'checkbuild',
        'floor_id|楼层' => 'checkFloor',
        'dormitory_id|房间号' => 'checkDormitory',
        'type|故障类型' => 'in:1,2',
        'info|内容' => 'max:500',
        'phone|电话' => 'max:500',
        'register_date|登记日期' => 'dateFormat:Y-m-d',
        'handle_date|处理日期' => 'dateFormat:Y-m-d',
    ];

    public function sceneAdd()
    {
        return $this
            ->append('name', 'require')
            ->append('campus_id', 'require')
            ->append('build_id', 'require')
            ->append('floor_id', 'require')
            ->append('dormitory_id', 'require')
            ->append('type', 'require')
            ->append('info', 'require')
            ->append('phone', 'require')
            ->append('register_date', 'require')
            ->append('handle_date', 'require');

    }

    public function sceneSave()
    {
        return $this
            ->append('name', 'require')
            ->append('campus_id', 'require')
            ->append('build_id', 'require')
            ->append('floor_id', 'require')
            ->append('dormitory_id', 'require')
            ->append('type', 'require')
            ->append('info', 'require')
            ->append('phone', 'require')
            ->append('register_date', 'require')
            ->append('handle_date', 'require');

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