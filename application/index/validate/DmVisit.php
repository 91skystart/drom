<?php

namespace app\index\validate;
use app\index\model\Campus;
use app\index\model\DmBuild;
use app\index\model\DmFloor;
use app\index\model\DmDormitory;

class DmVisit extends Base
{
    protected $rule = [
        'name|来访问姓名' => 'min:1|max:10',
        'sex|性别' => 'in:1,2,3',
        'idcard|身份证' => 'max:30',
        'campus_id|校区' => 'checkCampus',
        'build_id|楼栋' => 'checkbuild',
        'floor_id|楼层' => 'checkFloor',
        'dormitory_id|房间号' => 'checkDormitory',
        'Teacher_identity|教师身份' => 'max:10',
        'interviewed|被访人姓名' => 'max:10',
        'interviewed_relation|与被访人关系' => 'max:10',
        'type|类型' => 'in:1,2',
        'into_date|进去时间' => 'dateFormat:Y-m-d H:i',
        'out_date|离开时间' => 'dateFormat:Y-m-d H:i'
    ];

    //老师
    public function sceneTeatch()
    {
        return $this
            ->append('name', 'require')
            ->append('campus_id', 'require')
            ->append('build_id', 'require')
            ->append('floor_id', 'require')
            ->append('dormitory_id', 'require')
            ->append('Teacher_identity', 'require')
            ->append('into_date', 'require')
            ->append('out_date', 'require');
    }

    //外来人员
    public function sceneForeign()
    {
        return $this
            ->append('name', 'require')
            ->append('sex', 'require')
            ->append('campus_id', 'require')
            ->append('build_id', 'require')
            ->append('floor_id', 'require')
            ->append('dormitory_id', 'require')
            ->append('interviewed', 'require')
            ->append('interviewed_relation', 'require')
            ->append('into_date', 'require')
            ->append('out_date', 'require');
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