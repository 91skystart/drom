<?php
/**
 *  Vister.php
 *
 * @description 外来人员管理
 */

namespace app\index\controller;

use app\index\model\DmVisit;

class Visiter extends Common
{
    private $_sex = [
        1 => '男',
        2 => '女',
        3 => '未知',
    ];

    //外来人员访问
    protected function _initialize()
    {

        $this->model = new \app\index\model\DmVisit;
        $this->order = 'id desc';
        $this->vd = 'DmVisit';
        $this->with = 'campus,build,floor,dormitory';

        parent::_initialize();
    }

    /**
     *  老师访问列表展示
     */
    public function index()
    {
        /* 条件筛选 */
        $where = [
            'type' => DmVisit::VISIT_TYPE_TEACHER
        ];
        $paramData  = [
            'keywords' => trim($this->req->param('keywords'))
        ];

        //  采访人姓名筛选
        if ( $paramData['keywords'] != '' )
        {
            $where['name']  = ['like' , "%{$paramData['keywords']}%"];
        }

        list($list,$page) = $this->_getList($where);

        // 校区
        $campusList = model("campus")->select();

        $this->assign('sex',$this->_sex);
        $this->assign('campusList',$campusList);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('paramData',$paramData);
        return $this->fetch('teacher');
    }


    /**
     * @description 外来人员访问展示
     * @author Lang
     */
    public function outer()
    {
        /* 条件筛选 */
        $where = [
            'type' => DmVisit::VISIT_TYPE_OUTER
        ];
        $paramData  = [
            'keywords' => trim($this->req->param('keywords'))
        ];

        //  采访人姓名筛选
        if ( $paramData['keywords'] != '' )
        {
            $where['name']  = ['like' , "%{$paramData['keywords']}%"];
        }

        list($list,$page) = $this->_getList($where);

        // 校区
        $campusList = model("campus")->select();

        $this->assign('sex',$this->_sex);
        $this->assign('campusList',$campusList);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('paramData',$paramData);
        return $this->fetch();
    }


    /**
     * @description 保存访客信息
     * @author Lang
     */
    public function saveVisiter()
    {
        if($this->req->isPost())
        {
            /* 参数获取 */
            $saveData = [
                'type' => intval($this->req->post('type')),
                'name' => trim($this->req->post('name')),
                'interviewed_relation' => trim($this->req->post('interviewed_relation')),
                'sex' => intval($this->req->post('sex')),
                'idcard' => trim($this->req->post('idcard')),
                'campus_id' => intval($this->req->post('campus_id')),
                'build_id' => intval($this->req->post('build_id')),
                'floor_id' => intval($this->req->post('floor_id')),
                'dormitory_id' => intval($this->req->post('dormitory_id')),
                'interviewed' => trim($this->req->post('interviewed')),
                'into_date' => trim($this->req->post('into_date')),
                'out_date' => trim($this->req->post('out_date')),
            ];



            /* 参数筛选 */
           /* if ( $saveData['name'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写被访人姓名！']);
            }

            if ( $saveData['interviewed_relation'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写与被访人关系！']);
            }

            if ( !$saveData['sex']  )
            {
                return json(['status' => 0, 'msg' => '请填选择性别！']);
            }

            if ( $saveData['idcard'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写身份证！']);
            }

            if ( !$saveData['campus_id'] )
            {
                return json(['status' => 0, 'msg' => '请选择学区！']);
            }

            if ( !$saveData['build_id'] )
            {
                return json(['status' => 0, 'msg' => '请选择楼栋！']);
            }

            if ( !$saveData['floor_id'] )
            {
                return json(['status' => 0, 'msg' => '请选择楼层！']);
            }

            if ( !$saveData['dormitory_id'] )
            {
                return json(['status' => 0, 'msg' => '请选择房号！']);
            }

            if ( $saveData['interviewed'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写被访人姓名！']);
            }

            if ( $saveData['into_date'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写进入时间！']);
            }

            if ( $saveData['out_date'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写离开时间！']);
            }*/

            if(!is_idcard($saveData['idcard'])){
                return json(['status' => 0, 'msg' => '身份证号输入错误！']);
            }

            if ( $saveData['into_date'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写进入时间！']);
            }

            if ( $saveData['out_date'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写离开时间！']);
            }

            $into_date = strtotime($saveData['into_date']);
            $out_date  = strtotime($saveData['out_date']);
            if($into_date>=$out_date){
                return ['status'=>0,'msg'=>'离开时间不得小于进入时间'];
            }
            if($out_date - $into_date > 86400){
                return ['status'=>0,'msg'=>'最长逗留时间不能超过1天'];
            }


            /* 规则验证 */
            if($this->vd != '')
            {
                if ( $saveData['type'] == 1)
                {
                    // 来访是教师
                    $result = $this->validate($saveData,$this->vd.'.teatch');
                }
                else
                {
                    // 来访是外来人员
                    $result = $this->validate($saveData,$this->vd.'.foreign');
                }

                if(1 != $result)
                {
                    return json(['status' => 0, 'msg' => $result]);
                }
            }

            /* 保存操作 */
            $saveData['into_date'] = strtotime($saveData['into_date']);
            $saveData['out_date'] = strtotime($saveData['out_date']);

            $this->model->data($saveData);
            $res = $this->model->save();

            if ( $res !== false )
            {
                return json(['status' => 1, 'msg' => '添加成功！']);
            }
            else
            {
                return json(['status' => 1, 'msg' => '网络问题,请重新提交!！']);
            }
        }

        return json(['status' => 0, 'msg' => '保存失败！']);
    }


    /**
     * @description 获取列表
     * @author Lang
     * @param array $where
     * @return array
     */
    private function _getList($where=[])
    {
        $list = $this->model->with($this->with)
            ->where($where)
            ->order($this->order)
            ->paginate($this->pagesize);

        $page = $list->render();

        return [$list->toArray(),$page];
    }

    /**
     * @description 获取被访问人信息
     * @author zwd
     */
    public function getdormitory(){
        $data = input('');
        if(!empty($data['campus_id'])){
            $map['campus_id'] = $data['campus_id'];
        }
        if(!empty($data['build_id'])){
            $map['build_id'] = $data['build_id'];
        }
        if(!empty($data['floor_id'])){
            $map['floor_id'] = $data['floor_id'];
        }
        if(!empty($data['dormitory_id'])){
            $map['dormitory_id'] = $data['dormitory_id'];
        }
        $data = model('dm_stay')->where($map)->field('id,name')->select();
        return ['status'=>1,'data'=>$data];
    }



}