<?php

namespace app\index\controller;
use app\index\model\Campus;
use app\index\model\DmBuild;
use app\index\model\DmFloor;
class Dmdormitory extends Common
{

    protected function _initialize() {

        $this->model = new \app\index\model\DmDormitory;
        $this->order = 'id desc';
        $this->vd = 'DmDormitory';
        $this->with = 'campus,build,floor';

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

        if(!empty($this->req->param('id'))){
            $where['id'] = $this->req->param('id');
        }
        $this->assign('id',$this->req->param('id'));

        if(!empty($this->req->param('room_num'))){
            $where['room_num'] = ['like',$this->req->param('room_num').'%'];
        }
        $this->assign('room_num',$this->req->param('room_num'));

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
        $build_model = new DmBuild;
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

        if(!empty($this->req->param('id'))){
            $where['id'] = $this->req->param('id');
        }
        $this->assign('id',$this->req->param('id'));

        if(!empty($this->req->param('room_num'))){
            $where['room_num'] = ['like',$this->req->param('room_num').'%'];
        }
        $this->assign('room_num',$this->req->param('room_num'));


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
        $build_model = new DmBuild;
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

            $id = $this->req->post('id');
            $vo = $this->model->find($id);

            $build = $build_model->where(['campus_id'=>$vo['campus_id']])->select()->toArray();
            $floor = $floor_model->where(['campus_id'=>$vo['campus_id'],'build_id'=>$vo['build_id']])->select()->toArray();
            return json(['status' => 1, 'msg' => '获取成功','data'=>$vo,'build'=>$build,'floor'=>$floor]);
        }

        return json(['status' => 0, 'msg' => '获取失败！']);
    }
}
