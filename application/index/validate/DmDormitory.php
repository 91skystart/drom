<?php

namespace app\index\validate;

class DmDormitory extends Base
{
    protected $rule = [
        'campus_id|校区' => 'require|integer',
        'build_id|楼栋' => 'require|integer',
        'floor_id|楼层' => 'require|integer',
        'room_num|房间号' => 'require',
        'several|几人间' =>'require|integer',
        'television|电视' => 'integer',
        'washer|洗衣机' => 'integer',
        'stool|凳子' => 'integer',
        'desk|桌子' => 'integer',
        'bed|床铺' => 'integer',
        'wardrobe|衣柜' => 'integer',
    ];

    protected $message = [
        'campus_id.require'  => '请选择校区',
        'campus_id.integer'  =>  '校区参数无效',
        'build_id.require'  => '请选择楼栋',
        'build_id.integer'  =>  '楼栋参数无效',
        'floor_id.require'  => '请选择楼层',
        'floor_id.integer'  =>  '楼层参数无效',
        'room_num.require'  => '请填写房间号',
        'several.require'  => '请填写几人间',
        'several.integer'  =>  '几人间必须是数字',
        'television.integer'  =>  '电视必须是数字',
        'washer.integer'  =>  '洗衣机数量必须是数字',
        'stool.integer'  =>  '凳子数量必须是数字',
        'desk.integer'  =>  '桌子数量必须是数字',
        'bed.integer'  =>  '床铺数量必须是数字',
        'wardrobe.integer'  =>  '衣柜数量必须是数字',

    ];

    protected $scene = [
        'add'  =>['campus_id','build_id','floor_id','room_num','several','television','washer','stool','desk','bed','wardrobe'],
        'save'  =>['campus_id','build_id','floor_id','room_num','several','television','washer','stool','desk','bed','wardrobe'],
    ];

}