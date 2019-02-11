<?php

namespace app\index\validate;

class DmDormitory extends Base
{
    protected $rule = [
        'campus_id|校区' => 'require|integer',
        'build_id|楼栋' => 'require|integer',
        'floor_id|楼层' => 'require|integer',
        'room_num|房间号' => 'require|checkName',
        'several|几人间' =>'require|integer|checkp',
        'television|电视' => 'integer|checktv',
        'washer|洗衣机' => 'integer|checkxx',
        'stool|凳子' => 'integer|checkarchair',
        'desk|桌子' => 'integer|checkdesk',
        'bed|床铺' => 'integer|checkbed',
        'wardrobe|衣柜' => 'integer|checkarm',
    ];

    protected $message = [
        'campus_id.require'  => '请选择校区',
        'campus_id.integer'  =>  '校区参数无效',
        'build_id.require'  => '请选择楼栋',
        'build_id.integer'  =>  '楼栋参数无效',
        'floor_id.require'  => '请选择楼层',
        'floor_id.integer'  =>  '楼层参数无效',
        'room_num.require'  => '请填写房间号',
        'room_num.checkName' => '该房间已存在',
        'several.require'  => '请填写几人间',
        'several.integer'  =>  '几人间必须是数字',
        'several.checkp' => '房间人数不能超过8人',
        'television.integer'  =>  '电视必须是数字',
        'television.checktv' => '电视数量不能超过该房间人数',
        'washer.integer'  =>  '洗衣机数量必须是数字',
        'washer.checkxx' => '洗衣机数量不能超过该房间人数',
        'stool.integer'  =>  '凳子数量必须是数字',
        'stool.checkarchair' => '凳子数量不能超过该房间人数',
        'desk.integer'  =>  '桌子数量必须是数字',
        'desk.checkdesk' => '桌子数量不能超过该宿舍的人数',
        'bed.checkbed' => '床铺的数量不能超过该房间人数',
        'bed.integer'  =>  '床铺数量必须是数字',
        'wardrobe.integer'  =>  '衣柜数量必须是数字',
        'wardrobe.checkarm' => '衣柜的数量不能超过该房间的人数'

    ];

    protected $scene = [
        'add'  =>['campus_id','build_id','floor_id','room_num','several','television','washer','stool','desk','bed','wardrobe'],
        'save'  =>['campus_id','build_id','floor_id','room_num','several','television','washer','stool','desk','bed','wardrobe'],
    ];

    protected function checkName($value){
        $param = \think\Request::instance()->param();
        $buildModel = new \app\index\model\DmDormitory;
        $gOne = $buildModel->where(['campus_id' => $param['campus_id'], 'build_id' => $param['build_id'], 'floor_id' => $param['floor_id'], 'room_num' => $param['room_num']])->find();
        if(isset($param['id']) && $param['id'] == $gOne['id']) return true;
        if($gOne){
            return false;
        }
        return true;
    }

    protected function checktv($value){
        $param = \think\Request::instance()->param();
        if($param['several'] < $param['television'])
            return false;
        else 
            return true;
    }
    protected function checkxx($value){
        $param = \think\Request::instance()->param();
        if($param['several'] < $param['washer'])
            return false;
        else 
            return true;
    }
    public function checkarchair($value){
        $param = \think\Request::instance()->param();
        if($param['several'] < $param['stool'])
            return false;
        else 
            return true;
    }

    public function checkdesk($value){
        $param = \think\Request::instance()->param();
        if($param['several'] < $param['desk'])
            return false;
        else 
            return true;
    }

    public function checkbed($value){
        $param = \think\Request::instance()->param();
        if($param['several'] < $param['bed'])
            return false;
        else 
            return true;
    }

    public function checkarm($value){
        $param = \think\Request::instance()->param();
        if($param['several'] < $param['wardrobe'])
            return false;
        else 
            return true;
    }

    public function checkp($value){
        $param = \think\Request::instance()->param();
        if($param['several'] > 8)
            return false;
        else 
            return true;
    }

}