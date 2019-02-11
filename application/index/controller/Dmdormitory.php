<?php

namespace app\index\controller;
use app\index\model\Campus;
use app\index\model\DmBuild;
use app\index\model\DmFloor;
use think\Db;
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

    public function imfile(){
        $path = $this->request->param('up_path');
        $excelResult = $this->importExcel($path, 1);
        $err = $exec = [];
        foreach($excelResult['data'] as $val){
            $campus = Db::name('Campus')->where(['cp_name' => $val[0]])->find();
            if(!$campus){
                array_push($err, $val);
                break;
            }
            $build = Db::name('dmBuild')->where(['build_name' => $val[1]])->find();
            if(!$build){
                array_push($err, $val);
                break;
            }
            $floor = Db::name('dmFloor')->where(['floor_name' => $val[2]])->find();
            if(!$floor){
                array_push($err, $val);
                break;
            }
            $room = Db::name('dmDormitory')->where(['campus_id' => $campus['cp_id'], 'build_id' => $build['id'], 'floor_id' => $floor['id'], 'room_num' => $val[3]])->find();
            if($room){
                array_push($err, $val);
                break;
            }
            if($val[4] > 8){
                echo 5;
                array_push($err, $val);
                break;
            }
            if($val[5] > $val[4]){
                echo 6;
                array_push($err, $val);
                break;
            }
            if($val[6] > $val[4]){
                echo 6;
                array_push($err, $val);
                break;
            }
            
            if($val[7] > $val[4]){
                echo 7;
                array_push($err, $val);
                break;
            }
            
            if($val[8] > $val[4]){
                echo 8;
                array_push($err, $val);
                break;
            }
            
            if($val[9] > $val[4]){
                echo 9;
                array_push($err, $val);
                break;
            }
            
            if($val[10] > $val[4]){
                echo 10;
                array_push($err, $val);
                break;
            }
            
            array_push($exec, ['campus_id' => $campus['cp_id'], 'build_id' => $build['id'], 'floor_id' => $floor['id'], 'room_num' => $val[3], 'several' => $val[4], 'television' => $val[5], 'washer' => $val[6], 'stool' => $val[7], 'desk' => $val[8], 'bed' => $val[9], 'wardrobe' => $val[10]]);
        }
        if($err){
            return ['code' => 0, 'msg' => '上传文件中的校区，楼栋，楼层或者宿舍已存在，或者房间人数，设备数量大于发房间人数'];
        }
        $res = model('dmDormitory')->saveAll($exec);
        if($res)
            return ['code' => 1, 'msg' => '导入成功'];
        else
            return ['code' => 0, 'msg' => '导入失败'];
    }
}
