<?php

namespace app\index\controller;
use app\index\model\Campus;
use app\index\model\DmBuild;
class Dmfloor extends Common
{

    protected function _initialize() {

        $this->model = new \app\index\model\DmFloor;
        $this->order = 'id desc';
        $this->vd = 'DmFloor';
        $this->with = 'campus,build';
        parent::_initialize();
        //搜索
        if(!empty($this->req->param('floor_name'))){
            $this->search['floor_name'] =['like', $this->req->param('floor_name').'%'];
        }
        $this->assign('floor_name',$this->req->param('floor_name'));

        $campus_model = new Campus;

        $campus = $campus_model->field('cp_id,cp_name')->select()->toArray();
        $this->assign('campus',$campus);

    }

    public function getInfo(){
        if($this->req->isPost()) {
            $build_model = new DmBuild;
            $id = $this->req->post('id');
            $vo = $this->model->find($id);
            $build = $build_model->select()->toArray();
            return json(['status' => 1, 'msg' => '获取成功','data'=>$vo,'build'=>$build]);
        }

        return json(['status' => 0, 'msg' => '获取失败！']);
    }

}
