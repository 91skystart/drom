<?php

namespace app\index\controller;
use app\index\model\Campus;
use app\index\model\DmBuild;
use app\index\model\DmFloor;
use app\index\model\DmDormitory;
class Dmdormitorymanage extends Common
{

    protected function _initialize() {

        $this->model = new \app\index\model\DmDormitoryManage;
        $this->order = 'id desc';
        $this->vd = 'DmDormitoryManage';
        $this->with = 'campus,build,floor,dormitory';

        parent::_initialize();
    }

    public function index(){
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

        if(!empty($this->req->param('floor_id'))){
            $where['floor_id'] = $this->req->param('floor_id');
        }
        $this->assign('floor_id',$this->req->param('floor_id'));

        if(!empty($this->req->param('dormitory_id'))){
            $where['dormitory_id'] = $this->req->param('dormitory_id');
        }
        $this->assign('dormitory_id',$this->req->param('dormitory_id'));

        if(!empty($this->req->param('job_num'))){
            $where['job_num'] = ['like','%'.$this->req->param('job_num').'%'];
        }
        $this->assign('job_num',$this->req->param('job_num'));

        if(!empty($this->req->param('name'))){
            $where['name'] = ['like',$this->req->param('name').'%'];
        }
        $this->assign('name',$this->req->param('name'));

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
        $build_model = new Dmbuild;
        $floor_model = new DmFloor;


        $campus = $campus_model->field('cp_id,cp_name')->select()->toArray();
        $this->assign('campus',$campus);

        $build = $build_model->select()->toArray();
        $this->assign('build',$build);

        $floor = $floor_model->select()->toArray();
        $this->assign('floor',$floor);

        $dormitory = $this->model->select()->toArray();
        $this->assign('dormitory',$dormitory);

        //渲染模板
        return $this->fetch();
    }

    public function edit(){
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

        if(!empty($this->req->param('floor_id'))){
            $where['floor_id'] = $this->req->param('floor_id');
        }
        $this->assign('floor_id',$this->req->param('floor_id'));

        if(!empty($this->req->param('dormitory_id'))){
            $where['dormitory_id'] = $this->req->param('dormitory_id');
        }
        $this->assign('dormitory_id',$this->req->param('dormitory_id'));

        if(!empty($this->req->param('job_num'))){
            $where['job_num'] = ['like',$this->req->param('job_num').'%'];
        }
        $this->assign('job_num',$this->req->param('job_num'));

        if(!empty($this->req->param('name'))){
            $where['name'] = ['like',$this->req->param('name').'%'];
        }
        $this->assign('name',$this->req->param('name'));

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
        $build_model = new Dmbuild;
        $floor_model = new DmFloor;


        $campus = $campus_model->field('cp_id,cp_name')->select()->toArray();
        $this->assign('campus',$campus);

        $build = $build_model->select()->toArray();
        $this->assign('build',$build);

        $floor = $floor_model->select()->toArray();
        $this->assign('floor',$floor);

        $dormitory = $this->model->select()->toArray();
        $this->assign('dormitory',$dormitory);

        //渲染模板
        return $this->fetch();
    }



    public function getInfo(){
        if($this->req->isPost()) {

            $build_model = new DmBuild;
            $floor_model = new DmFloor;
            $dmdormitory_model = new DmDormitory;

            $id = $this->req->post('id');
            $vo = $this->model->find($id);

            $build = $build_model->where(['campus_id'=>$vo['campus_id']])->select()->toArray();
            $floor = $floor_model->where(['campus_id'=>$vo['campus_id'],'build_id'=>$vo['build_id']])->select()->toArray();
            $dormitory = $dmdormitory_model->where(['campus_id'=>$vo['campus_id'],'build_id'=>$vo['build_id'],'floor_id'=>$vo['floor_id']])->select()->toArray();
            return json(['status' => 1, 'msg' => '获取成功','data'=>$vo,'build'=>$build,'floor'=>$floor,'dormitory'=>$dormitory]);
        }

        return json(['status' => 0, 'msg' => '获取失败！']);
    }
}
