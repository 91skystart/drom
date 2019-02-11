<?php

namespace app\index\controller;
use app\index\model\Campus;
use app\index\model\DmBuild;
use app\index\model\DmFloor;
use app\index\model\DmDormitory;
use think\Db;
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
//         $aRoel = Db::name('Roles')->select();
//         $ed = searchRelationIds(7, $aRoel, 'rs_pid', 'rs_id',false);
// print_r(end($ed));
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

    public function imfile(){
        $path = $this->request->param('up_path');
        $excelResult = $this->importExcel($path, 1);
        $aRoel = Db::name('Roles')->select();
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
            if(!$room){
                array_push($err, $val);
                break;
            }

            $gh = Db::name('Admin')->where(['ad_num' => $val[4]])->find();
            $ed = searchRelationIds($gh['rs_id'], $aRoel, 'rs_pid', 'rs_id',false);
            if(!$gh || !(end($ed) == 2)){
                array_push($err, $val);
                break;
            }
           
            if($val[5] != $gh['ad_sname']){
                array_push($err, $val);
                break;
            }
            if(!preg_match('/^1[3,4,5,6,7,8,9][\d]{1}[\d]{8}$/',$val[6])){
                array_push($err, $val);
                break;
            }
            array_push($exec, ['campus_id' => $campus['cp_id'], 'build_id' => $build['id'], 'floor_id' => $floor['id'], 'dormitory_id' => $room['id'], 'job_num' => $val[4], 'name' => $val[5], 'phone' => $val[6]]);
        }
        if($err){
            return ['code' => 0, 'msg' => '上传文件中的校区、楼栋、楼层、者宿舍有误，或工号、姓名、电话有误'];
        }
        $res = model('dmDormitoryManage')->saveAll($exec);
        if($res)
            return ['code' => 1, 'msg' => '导入成功'];
        else
            return ['code' => 0, 'msg' => '导入失败'];
    }
}
