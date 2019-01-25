<?php

namespace app\index\controller;
use app\index\model\Campus;
class Dmbuild extends Common
{

    protected function _initialize() {

        $this->model = new \app\index\model\DmBuild;
        $this->order = 'id desc';
        $this->vd = 'DmBuild';
        $this->with = 'campus';

        parent::_initialize();
    }
    
    // TODO
    public function importdmbuild(){
        // 'index/dmbuild/importdmbuild';
    }

    public function add()
    {
        $where = [];
        //搜索

        if(!empty($this->req->param('campus_id'))){
            $where['campus_id'] = $this->req->param('campus_id');
        }
        $this->assign('campus_id',$this->req->param('campus_id'));

        if(!empty($this->req->param('id'))){
            $where['id'] = $this->req->param('id');
        }
        $this->assign('id',$this->req->param('id'));

        if(!empty($this->req->param('build_name'))){
            $where['build_name'] =['like', $this->req->param('build_name').'%'];
        }
        $this->assign('build_name',$this->req->param('build_name'));


        $list = $this->model->with($this->with)->where($where)->order($this->order)->paginate($this->pagesize,false, [
                'query' => $this->req->param()]);
        $page = $list->render();

        //数据列表
        $this->assign('list',$list);

        //分页标签
        $this->assign('page',$page);
        //搜索条件保存
        $this->assign('search',$this->search);

        $count = $this->model->where($where)->count();
        $this->assign('count',$count);

        $campus_model = new Campus;

        $campus = $campus_model->field('cp_id,cp_name')->select()->toArray();
        $this->assign('campus',$campus);

        $build = $this->model->select()->toArray();
        $this->assign('build',$build);


        //渲染模板
        return $this->fetch();
    }



    public function edit() {

        $where = [];
        //搜索
        if(!empty($this->req->param('campus_id'))){
            $where['campus_id'] = $this->req->param('campus_id');
        }
        $this->assign('campus_id',$this->req->param('campus_id'));

        if(!empty($this->req->param('id'))){
            $where['id'] = $this->req->param('id');
        }
        $this->assign('id',$this->req->param('id'));

        if(!empty($this->req->param('build_name'))){
            $where['build_name'] =['like', $this->req->param('build_name').'%'];
        }
        $this->assign('build_name',$this->req->param('build_name'));

        $list = $this->model->with($this->with)->where($where)->order($this->order)->paginate($this->pagesize,false, [
                'query' => $this->req->param()]);
        $page = $list->render();

        //数据列表
        $this->assign('list',$list);

        //分页标签
        $this->assign('page',$page);
        //搜索条件保存
        $this->assign('search',$this->search);

        $count = $this->model->where($where)->count();
        $this->assign('count',$count);

        $campus_model = new Campus;

        $campus = $campus_model->field('cp_id,cp_name')->select()->toArray();
        $this->assign('campus',$campus);

        $build = $this->model->select()->toArray();
        $this->assign('build',$build);


        //渲染模板
        return $this->fetch();
    }
}
