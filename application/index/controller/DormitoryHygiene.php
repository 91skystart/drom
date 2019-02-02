<?php
/**
 * DormitoryHygiene.php
 *
 * @description 卫生量化考核
 */
namespace app\index\controller;

class DormitoryHygiene extends Common
{

    protected function _initialize() {

        $this->model = new \app\index\model\DmDormitoryHygiene;
        $this->order = 'id desc';
        $this->vd = 'DmDormitoryHygiene';
        $this->with = 'campus,build,floor,dormitory,grade,bclass';

        parent::_initialize();
    }


    /**
     * @description 卫生检查统计
     * @author Lang
     */
    public function index()
    {
        /* 参数获取 */
        $where = [];
        $paramData  = [
            'keywords' => trim($this->req->param('keywords')),
        ];

        /* 条件筛选 */
        if ( $paramData['keywords'] != '' )
        {
            $where['name']  = ['like' , "%{$paramData['keywords']}%"];
        }

        $list = $this->model->with($this->with)
            ->where($where)
            ->order($this->order)
            ->paginate($this->pagesize);
        foreach($list as &$value){
            $value['remarks'] = strlen($value['remark']) > 15 ? substr($value['remark'],0,15)."..." : $value['remark'];;
        }
        $page = $list->render();

        $campusList = model("campus")->select();
        $gradeList = model("grade")->select();

        $this->assign('campusList',$campusList);
        $this->assign('gradeList',$gradeList);
        $this->assign('list', $list->toArray());
        $this->assign('page', $page);
        $this->assign('paramData',$paramData);
        return $this->fetch();
    }


    /**
     * @description 卫生检查统计
     * @author Lang
     */
    public function statistics()
    {
        /* 参数获取 */
        $where = [];
        $buildList = [];
        $floorList = [];
        $dormitoryList = [];
        $paramData  = [
            'campus_id' => intval($this->req->param('campus_id')),
            'build_id' => intval($this->req->param('build_id')),
            'floor_id' => intval($this->req->param('floor_id')),
            'dormitory_id' => intval($this->req->param('dormitory_id')),
            'gd_id' => intval($this->req->param('gd_id')),
            'score' => trim($this->req->param('score')),
        ];

        /* 条件筛选 */
        if ( $paramData['campus_id'] > 0)
        {
            $where['campus_id']  = $paramData['campus_id'];
            $buildList = model("DmBuild")->where(['campus_id' => $paramData['campus_id']])
                ->select();
        }

        if ( $paramData['build_id'] > 0)
        {
            $where['build_id']  = $paramData['build_id'];
            $floorList = model("dmFloor")->where(['build_id' => $paramData['build_id']])
                ->select();
        }

        if ( $paramData['floor_id'] > 0)
        {
            $where['floor_id']  = $paramData['floor_id'];
            $dormitoryList = model("dmDormitory")->where(['floor_id' => $paramData['floor_id']])
                ->select();
        }

        if ( $paramData['dormitory_id'] > 0)
        {
            $where['dormitory_id']  = $paramData['dormitory_id'];
        }

        if ( $paramData['gd_id'] > 0)
        {
            $where['gd_id']  = $paramData['gd_id'];
        }

        if ( $paramData['score'] > 0)
        {
            $where['score']  = $paramData['score'];
        }

        $list = $this->model->with($this->with)
            ->where($where)
            ->order($this->order)
            ->paginate($this->pagesize);

        $page = $list->render();

        /* 默认的筛选条件 */
        $campusList = model("campus")->select();
        $gradeList = model("grade")->select();

        $this->assign('campusList',$campusList);
        $this->assign('buildList',$buildList);
        $this->assign('floorList',$floorList);
        $this->assign('dormitoryList',$dormitoryList);
        $this->assign('gradeList',$gradeList);
        $this->assign('list', $list->toArray());
        $this->assign('page', $page);
        $this->assign('paramData',$paramData);
        return $this->fetch();
    }


    /**
     * @description 保存卫生检查
     * @author Lang
     */
    public function saveHygiene()
    {
        if ( $this->req->isPost()){
            /* 参数 */
            $saveData = [
                'campus_id' => intval($this->req->post('campus_id')),
                'build_id' => intval($this->req->post('build_id')),
                'floor_id' => intval($this->req->post('floor_id')),
                'dormitory_id' => intval($this->req->post('dormitory_id')),
                'gd_id' => intval($this->req->post('gd_id')),
                'score' => trim($this->req->post('score')),
                'exam_date' => trim($this->req->post('exam_date')),
                'remark' => trim($this->req->post('remark'))
            ];

            $postData = $this->req->post();
            /* 卫生图片 */
            if ( isset($postData['img']) && count($postData['img'])  > 0 ){
                $postData['img'] = str_replace('\\','/',$postData['img']);
                $saveData['image'] = json_encode($postData['img']);
            }else{
                $saveData['image'] = json_encode([]);
            }

            /* 验证 */
            if($this->vd != ''){
                $result = $this->validate($saveData,$this->vd.'.add');
                if(1 != $result){
                    return json(['status' => 0, 'msg' => $result]);
                }
            }

            /* 保存检查信息 */
            $saveData['exam_date'] = strtotime($saveData['exam_date'] );
            if ($this->model->allowField(true)->save($saveData) ){
                return json(['status' => 1, 'msg' => '保存成功！']);
            }else{
                return json(['status' => 1, 'msg' => '网络问题,请重新提交!！']);
            }
        }

        return json(['status' => 0, 'msg' => '保存失败！']);
    }

}
