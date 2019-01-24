<?php
/**
 *  Tools.php
 *
 * @description 共有方法的请求
 */

namespace app\index\controller;

use app\index\model\DmBuild;
use app\index\model\DmDormitory;
use app\index\model\DmFloor;

class Tools extends Common
{

    protected function _initialize()
    {
        $this->model = new \app\index\model\Campus;
        $this->pk = 'cp_id';
        $this->search = ['cp_id' => ['>', 0]];
        $this->order = 'cp_id desc';
        $this->vd = 'Campus';
        parent::_initialize();
    }

    /**
     * @description  根据条件获取楼栋列表
     * @author Lang
     * @return \think\response\Json
     */
    public function getbuild()
    {
        if($this->req->isPost())
        {
            $campus_id= $this->req->post('campus_id');
            $build_model = new DmBuild();
            $vo = $build_model->where(['campus_id'=>$campus_id])->select();

            return json(['status' => 1, 'msg' => '获取成功','data'=>$vo]);
        }

        return json(['status' => 0, 'msg' => '获取失败！']);
    }


    /**
     * @description  根据条件获取楼层列表
     * @author Lang
     * @return \think\response\Json
     */
    public function getFloor()
    {
        if($this->req->isPost())
        {
            $campus_id= $this->req->post('campus_id');
            $build_id= $this->req->post('build_id');
            $floor_model = new DmFloor();
            $vo = $floor_model->where(['build_id'=>$build_id,'campus_id'=>$campus_id])
                ->select();

            return json(['status' => 1, 'msg' => '获取成功','data'=>$vo]);
        }

        return json(['status' => 0, 'msg' => '获取失败！']);
    }


    /**
     * @description  根据条件获取宿舍列表
     * @author Lang
     * @return \think\response\Json
     */
    public function getRoom()
    {
        if($this->req->isPost())
        {
            $campus_id= $this->req->post('campus_id');
            $build_id= $this->req->post('build_id');
            $floor_id= $this->req->post('floor_id');
            $dormitory_model = new DmDormitory();
            $vo = $dormitory_model->where(['build_id'=>$build_id,'campus_id'=>$campus_id,'floor_id'=>$floor_id])
                ->select();

            return json(['status' => 1, 'msg' => '获取成功','data'=>$vo]);
        }

        return json(['status' => 0, 'msg' => '获取失败！']);
    }
}