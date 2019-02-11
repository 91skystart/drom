<?php

namespace app\index\controller;
use app\index\model\Campus;
use think\Db;
class Dmbuild extends Common
{

    protected function _initialize() {

        $this->model = new \app\index\model\DmBuild;
        $this->order = 'id desc';
        $this->vd = 'DmBuild';
        $this->with = 'campus';

        parent::_initialize();
    }
    
    public function imfile(){
        $path = $this->request->param('up_path');
        $excelResult = $this->importExcel($path, 1);
        $all = model('Campus')->select()->toArray();
        $aCp[0] = [];
        foreach($all as $k => $aa) {
            array_push($aCp[0], $aa['cp_name']);
        }
        
        $err = $exec = [];
        foreach($excelResult['data'] as $val){
            $a1 = Db::name('Campus')->where(['cp_name' => $val[0]])->find();
            if(Db::name('dmBuild')->where(['campus_id' => $a1['cp_id']])->find()){
                return ['code' => 0, 'msg' => $a1['cp_name'].'已存在'];
            }
            
            if(!in_array($val[0], $aCp[0])) array_push($err, $val);
            array_push($exec, ['campus_id' => $a1['cp_id'], 'build_name' => $val[1], 'dm_info' => $val[2]]);
        }
        if($err){
            return ['code' => 0, 'msg' => '上传文件中的校区火舌楼栋已存在'];
        }
        $res = model('dmbuild')->saveAll($exec);
        if($res)
            return ['code' => 1, 'msg' => '导入成功'];
        else
            return ['code' => 0, 'msg' => '导入失败'];
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

    public function delete(){
        $param = $this->request->param();
        model('dmFloor')->where(['build_id' => $param['id']])->delete();
        model('dmDormitory')->where(['build_id' => $param['id']])->delete();
        model('dmBuild')->where(['id' => $param['id']])->delete();
        return json(['status' => 1, 'msg' => '删除成功！']);
    }
}
