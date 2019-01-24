<?php

namespace app\index\controller;

class Campus extends Common
{

    //校区管理
    protected function _initialize() {

        $this->model = new \app\index\model\Campus;
        $this->pk = 'cp_id';
        $this->search = ['cp_id' => ['>', 0]];
        $this->order = 'cp_id desc';
        $this->vd = 'Campus';
        parent::_initialize();

        if(!empty($this->req->param('cp_name'))){
            $this->search['cp_name'] = ['like',$this->req->param('cp_name').'%'];
        }
        $this->assign('cp_name',$this->req->param('cp_name'));
    }
}
