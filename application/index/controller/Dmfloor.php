<?php

namespace app\index\controller;
use app\index\model\Campus;
use app\index\model\DmBuild;
use think\Db;
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

    public function delete(){
        $param = $this->request->param();
        model('dmDormitory')->where(['floor_id' => $param['id']])->delete();
        model('dmFloor')->where(['id' => $param['id']])->delete();
        return json(['status' => 1, 'msg' => '删除成功！']);
    }

    public function imfile(){
        $path = $this->request->param('up_path');
        $excelResult = $this->importExcel($path, 1);
        $err = $exec = [];
        foreach ($excelResult['data'] as $val){
            $cpName = Db::name('Campus')->where(['cp_name' => $val[0]])->find();
            if(!$cpName){
                array_push($err, $val);
                break;
            }
            $build = Db::name('dmBuild')->where(['build_name' => $val[1]])->find();
            if(!$build){
                array_push($err, $val);
                break;
            }
            $floor = Db::name('dmFloor')->where(['campus_id' => $cpName['cp_id'], 'build_id' => $build['id'], 'floor_name' => $val[2]])->find();
            if($floor){
                array_push($err, $val);
                break;
            }
            array_push($exec, ['campus_id' => $cpName['cp_id'], 'build_id' => $build['id'], 'floor_name' => $val[2]]);
        }
        if($err){
            return ['code' => 0, 'msg' => '上传文件中校区、楼栋不存在或者楼层已重复'];
        }
        $res = model('dmFloor')->saveAll($exec);
        if($res)
            return ['code' => 1, 'msg' => '导入成功'];
        else
            return ['code' => 0, 'msg' => '导入失败'];
        
    }

}
