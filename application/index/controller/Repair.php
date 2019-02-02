<?php
/**
 *  Repair.php
 *
 * @description 物品维修损害管理
 */

namespace app\index\controller;


use app\index\model\DmDormitory;
use app\index\model\DmHitch;

class Repair extends Common
{
    // 物品损坏的类型
    private $_type = [
        1 => '人为',
        2 => '自然'
    ];

    //物品损坏维修
    protected function _initialize() {

        $this->model = new \app\index\model\DmHitch;
        $this->order = 'id desc';
        $this->vd = 'DmHitch';
        $this->with = 'campus,build,floor,dormitory';

        parent::_initialize();
    }


    /**
     * @description 故障报修登记表
     * @author Lang
     */
    public function index()
    {
        $where = [];
        $paramData  = [
            'keywords' => trim($this->req->param('keywords'))
        ];

        //  申报人姓名筛选
        if ( $paramData['keywords'] != '' )
        {
            $where['name']  = ['like' , "%{$paramData['keywords']}%"];
        }

        list($list,$page) = $this->_getList($where);

        $campusList = model("campus")->select();

        $this->assign('campusList',$campusList);
        $this->assign('type',$this->_type);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('paramData',$paramData);
        return $this->fetch();
    }


    /**
     * @description 未处理的
     * @author Lang
     */
    public function undeal()
    {
        /* 参数获取 */
        $where = [
            'status' => 0 // 未处理过的报修登记
        ];
        $paramData  = [
            'keywords' => trim($this->req->param('keywords')),
        ];

        /* 条件筛选 */
        //  申报人姓名筛选
        if ( $paramData['keywords'] != '' )
        {
            $where['name']  = ['like' , "%{$paramData['keywords']}%"];
        }


        list($list,$page) = $this->_getList($where);

        $campusList = model("campus")->select();

        $this->assign('campusList',$campusList);
        $this->assign('type',$this->_type);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('paramData',$paramData);
        return $this->fetch();
    }


    /**
     * @description 处理过的订单
     * @author Lang
     * @return mixed
     */
    public function deal()
    {
        /* 参数获取 */
        $where = [
            'status' => 1 // 处理过的报修登记
        ];
        $paramData  = [
            'keywords' => trim($this->req->param('keywords')),
        ];

        /* 条件筛选 */
        //  申报人姓名筛选
        if ( $paramData['keywords'] != '' )
        {
            $where['name']  = ['like' , "%{$paramData['keywords']}%"];
        }

        list($list,$page) = $this->_getList($where);

        $campusList = model("campus")->select();

        $this->assign('campusList',$campusList);
        $this->assign('type',$this->_type);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('paramData',$paramData);
        return $this->fetch();
    }


    /**
     * @description 处理故障报修
     * @author Lang
     */
    public function dealReport()
    {
        if ( $this->req->isPost() )
        {
            /* 参数获取 */
            $id = intval($this->req->post('id'));
            $saveData = [
                'name' => trim($this->req->post('name')),
                'campus_id' => intval($this->req->post('campus_id')),
                'build_id' => intval($this->req->post('build_id')),
                'floor_id' => intval($this->req->post('floor_id')),
                'dormitory_id' => intval($this->req->post('dormitory_id')),
                'type' => intval($this->req->post('type')),
                'info' => trim($this->req->post('info')),
                'charge' => floatval($this->req->post('charge')),
                'phone' => trim($this->req->post('phone')),
                'handle_date' => strtotime(trim($this->req->post('handle_date'))),
                'construction' => trim($this->req->post('construction'))
            ];

            /* 条件筛选 */
            if ( !$id )
            {
                return json(['status' => 0, 'msg' => '请选择需要处理的报修故障！']);
            }

            /*if ( $saveData['name'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写申请人姓名！']);
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

            if ( !$saveData['charge'] )
            {
                return json(['status' => 0, 'msg' => '请填写收费金额！']);
            }

            if ( $saveData['phone'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写电话！']);
            }

            if ( $saveData['handle_date'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写处理日期！']);
            }

            if ( $saveData['construction'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写施工人员！']);
            }*/

            $repairInfo = $this->model->get($id);
            if ( !$repairInfo )
            {
                return json(['status' => 0, 'msg' => '请选择需要处理的报修故障！']);
            }

            /* 验证 */
            if($this->vd != '')
            {
                $result = $this->validate($saveData,$this->vd.'.Save');

                if(1 != $result)
                {
                    return json(['status' => 0, 'msg' => $result]);
                }
            }

            /* 处理故障操作 */
            $saveData['status'] = 1; // 故障已处理
            $res = $this->model->where(['id'=>$id])->update($saveData);

            if(  $res !== false)
            {
                return json(['status' => 1, 'msg' => '提交成功！']);
            }
            else
            {
                return json(['status' => 0, 'msg' => '网络问题,请重新提交!']);
            }
        }

        return json(['status' => 0, 'msg' => '提交失败！']);
    }


    /**
     * @description  保存登记报表
     * @author Lang
     */
    public function saveReport()
    {
        if($this->req->isPost())
        {
            /* 参数获取 */
            $saveData = [
                'name' => trim($this->req->post('name')),
                'campus_id' => intval($this->req->post('campus_id')),
                'build_id' => intval($this->req->post('build_id')),
                'floor_id' => intval($this->req->post('floor_id')),
                'dormitory_id' => intval($this->req->post('dormitory_id')),
                'type' => intval($this->req->post('type')),
                'info' => trim($this->req->post('info')),
                'charge' => floatval($this->req->post('charge')),
                'phone' => trim($this->req->post('phone')),
                'register_date' => trim($this->req->post('register_date')),
                'toll_collector' => trim($this->req->post('toll_collector'))
            ];

            /* 条件筛选 */
           /* if ( $saveData['name'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写申请人姓名！']);
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

            if ( !$saveData['charge'] )
            {
                return json(['status' => 0, 'msg' => '请填写收费金额！']);
            }

            if ( $saveData['phone'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写电话！']);
            }

            if ( $saveData['register_date'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写登记日期！']);
            }

            if ( $saveData['toll_collector'] == '' )
            {
                return json(['status' => 0, 'msg' => '请填写收费员！']);
            }*/
            if(!is_numeric($saveData['charge'])){
                return json(['status' => 0, 'msg' => '收费字段为数字！']);
            }

            if(!is_mobile($saveData['phone'])){
                return json(['status' => 0, 'msg' => '手机号验证错误！']);
            }

            if($this->vd != '')
            {
                $result = $this->validate($saveData,$this->vd.'.Add');

                if(1 != $result)
                {
                    return json(['status' => 0, 'msg' => $result]);
                }
            }

            /* 保存数据 */
            $saveData['register_date'] = strtotime($saveData['register_date']);

            $this->model->data($saveData);
            $res = $this->model->save();

            if ( $res !== false )
            {
                return json(['status' => 1, 'msg' => '提交成功！']);
            }
            else
            {
                return json(['status' => 1, 'msg' => '网络问题,请重新提交!！']);
            }
        }

        return json(['status' => 0, 'msg' => '提交失败！']);
    }


    /**
     * @description  获取报修记录
     * @author Lang
     */
    public function getReport()
    {
        $id = intval($this->req->param('id'));

        if ( $id == 0 )
        {
            return json(['status' => 0, 'msg' => '请选择需要处理的报修故障！']);
        }

        $reportInfo = $this->model->with($this->with)->find($id);
        if ( !$reportInfo )
        {
            return json(['status' => 0, 'msg' => '请选择需要处理的报修故障！']);
        }

        /* 获取宿舍的信息 */
        // 获取楼栋信息
        $buildList = model("Dmbuild")->where(['campus_id' => $reportInfo->campus_id])
            ->select()
            ->toArray();

        // 获取楼层信息
        $floorList = model("dmFloor")->where(['build_id' => $reportInfo->build_id])
            ->select()
            ->toArray();

        // 获取宿舍
        $dormitoryList = model("dmDormitory")->where(['floor_id' => $reportInfo->floor_id])
            ->select()
            ->toArray();

        $data = [
            'info' => $reportInfo,
            'build' => $buildList,
            'floor' => $floorList,
            'dormitory' => $dormitoryList
        ];
        return json(['status' => 1, 'data' => $data]);
    }


    /**
     * @description 获取列表
     * @author Lang
     * @param array $where
     * @return array
     */
    private function _getList($where=[])
    {
        $repairModel = new DmHitch();
        $list = $repairModel->with($this->with)
            ->where($where)
            ->order($this->order)
            ->paginate($this->pagesize);
        foreach($list as &$value){
            $value['infos'] = strlen($value['info']) > 15 ? substr($value['info'],0,15)."..." : $value['info'];
        }
        $page = $list->render();

        return [$list->toArray(),$page];
    }

}
