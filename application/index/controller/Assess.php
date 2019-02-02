<?php
/**
 * Assess.php
 *
 * @description 学生评定管理
 */
namespace app\index\controller;

class Assess extends Common
{
    const TYPE_PRAISE = 1; // 表扬
    const TYPE_PUNISHMENT = 2; // 惩罚

    protected function _initialize() {

        $this->model = new \app\index\model\DmAssess;
        $this->order = 'id desc';
        $this->vd = 'DmAssess';
        $this->with = 'campus,build,floor,dormitory,grade,bclass';

        parent::_initialize();
    }



    public function index()
    {
        /* 参数获取 */
        $where = [
            'type' => self::TYPE_PRAISE
        ];
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
     * @description  保存表扬
     * @author Lang
     */
    public function savePraise()
    {
        if ( $this->req->isPost() )
        {
            $saveData = [
                'student_num' => trim($this->req->post('student_num')),
                'name' => trim($this->req->post('name')),
                'campus_id' => intval($this->req->post('campus_id')),
                'build_id' => intval($this->req->post('build_id')),
                'floor_id' => intval($this->req->post('floor_id')),
                'dormitory_id' => intval($this->req->post('dormitory_id')),
                'grade_id' => intval($this->req->post('grade_id')),
                'happen_date' => trim($this->req->post('happen_date')),
                'info' => trim($this->req->post('info')),
                'remark' => trim($this->req->post('remark')),
                'type' => self::TYPE_PRAISE
            ];

            if($this->vd != '')
            {
                $result = $this->validate($saveData,$this->vd.'.add');

                if(1 != $result)
                {
                    return json(['status' => 0, 'msg' => $result]);
                }
            }

            $saveData['happen_date'] = strtotime($saveData['happen_date'] );

            if ($this->model->allowField(true)->save($saveData) )
            {
                return json(['status' => 1, 'msg' => '保存成功！']);
            }
            else
            {
                return json(['status' => 1, 'msg' => '网络问题,请重新提交!！']);
            }
        }

        return json(['status' => 0, 'msg' => '保存失败！']);
    }


    /**
     * @description 学生惩罚列表
     * @author Lang
     */
    public function punishment()
    {
        /* 参数获取 */
        $where = [
            'type' => self::TYPE_PUNISHMENT
        ];
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
     * @description 保存惩罚信息
     * @author Lang
     * @return \think\response\Json
     */
    public function savePunishment()
    {
        if ( $this->req->isPost() )
        {
            $saveData = [
                'student_num' => trim($this->req->post('student_num')),
                'name' => trim($this->req->post('name')),
                'campus_id' => intval($this->req->post('campus_id')),
                'build_id' => intval($this->req->post('build_id')),
                'floor_id' => intval($this->req->post('floor_id')),
                'dormitory_id' => intval($this->req->post('dormitory_id')),
                'grade_id' => intval($this->req->post('grade_id')),
                'happen_date' => trim($this->req->post('happen_date')),
                'info' => trim($this->req->post('info')),
                'remark' => trim($this->req->post('remark')),
                'type' => self::TYPE_PUNISHMENT
            ];

            if($this->vd != '')
            {
                $result = $this->validate($saveData,$this->vd.'.add');

                if(1 != $result)
                {
                    return json(['status' => 0, 'msg' => $result]);
                }
            }

            $saveData['happen_date'] = strtotime($saveData['happen_date'] );

            if ($this->model->allowField(true)->save($saveData) )
            {
                return json(['status' => 1, 'msg' => '保存成功！']);
            }
            else
            {
                return json(['status' => 1, 'msg' => '网络问题,请重新提交!！']);
            }
        }

        return json(['status' => 0, 'msg' => '保存失败！']);
    }
}

