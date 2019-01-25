<?php
namespace app\index\model;
use think\Model;
class Sysmodule extends Model{
	public function getAuthSon($p){
        return $this->union(function($query) use ($p){
            $query->table('bp_sysmodule')->where(['sd_obj' => ['in', $p], 'sd_type' => 1]);
        })->where(['sd_obj' => 1, 'sd_type' => 1])->select();
    }
}