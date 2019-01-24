<?php

namespace app\index\controller;
use app\index\model\Campus;
use app\index\model\DmBuild;
class Dmbuildmanage extends Common
{

    protected function _initialize() {

        $this->model = new \app\index\model\DmBuildManage;
        $this->order = 'id desc';
        $this->vd = 'DmBuildManage';
        $this->with = 'campus,build';

        parent::_initialize();
        //搜索
    }

    public function index() {

        $where = [];
        //搜索

        if(!empty($this->req->param('campus_id'))){
            $where['campus_id'] = $this->req->param('campus_id');
        }
        $this->assign('campus_id',$this->req->param('campus_id'));

        if(!empty($this->req->param('build_id'))){
            $where['build_id'] = $this->req->param('build_id');
        }
        $this->assign('build_id',$this->req->param('build_id'));

        if(!empty($this->req->param('name'))){
            $where['name'] =['like', $this->req->param('name').'%'];
        }
        $this->assign('name',$this->req->param('name'));

        if(!empty($this->req->param('job_num'))){
            $where['job_num'] =['like', $this->req->param('job_num').'%'];
        }
        $this->assign('job_num',$this->req->param('job_num'));

        $list = $this->model->with($this->with)->where($where)->order($this->order)->paginate($this->pagesize,false, [
                'query' => $this->req->param()]);
        $page = $list->render();

        //数据列表
        $this->assign('list',$list);

        //分页标签
        $this->assign('page',$page);

        $count = $this->model->where($where)->count();
        $this->assign('count',$count);

        $campus_model = new Campus;
        $Dmbuild_model = new DmBuild;

        $campus = $campus_model->field('cp_id,cp_name')->select()->toArray();
        $this->assign('campus',$campus);

        $build = $Dmbuild_model->select()->toArray();
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

        if(!empty($this->req->param('build_id'))){
            $where['build_id'] = $this->req->param('build_id');
        }
        $this->assign('build_id',$this->req->param('build_id'));

        if(!empty($this->req->param('name'))){
            $where['name'] =['like', $this->req->param('name').'%'];
        }
        $this->assign('name',$this->req->param('name'));

        if(!empty($this->req->param('job_num'))){
            $where['job_num'] =['like', $this->req->param('job_num').'%'];
        }
        $this->assign('job_num',$this->req->param('job_num'));

        $list = $this->model->with($this->with)->where($where)->order($this->order)->paginate($this->pagesize,false, [
                'query' => $this->req->param()]);
        $page = $list->render();

        //数据列表
        $this->assign('list',$list);

        //分页标签
        $this->assign('page',$page);

        $count = $this->model->where($where)->count();
        $this->assign('count',$count);

        $campus_model = new Campus;
        $Dmbuild_model = new DmBuild;

        $campus = $campus_model->field('cp_id,cp_name')->select()->toArray();
        $this->assign('campus',$campus);

        $build = $Dmbuild_model->select()->toArray();
        $this->assign('build',$build);


        //渲染模板
        return $this->fetch();
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
