<?php
/**
 * Honorable.php
 *
 * @description 贵重物品进出登记
 */
namespace app\index\controller;

class Honorable extends Common
{

    protected function _initialize() {

        $this->model = new \app\index\model\DmHonorable;
        $this->order = 'id desc';
        $this->vd = 'DmHonorable';
        $this->with = 'campus,build,floor,dormitory';

        parent::_initialize();
    }


    /**
     * @description  贵重物品登记列表展示
     * @author Lang
     * @return mixed
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
        $page = $list->render();

        $campusList = model("campus")->select();

        $this->assign('campusList',$campusList);
        $this->assign('list', $list->toArray());
        $this->assign('page', $page);
        $this->assign('paramData',$paramData);
        return $this->fetch();
    }


    /**
     * @description  保存贵重物品出楼记录
     * @author Lang
     */
    public function saveLog()
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
                'goods_name' => trim($this->req->post('goods_name')),
                'moveout_date' => trim($this->req->post('moveout_date')),
            ];

            if($this->vd != '') {

                $result = $this->validate($saveData,$this->vd.'.add');

                if(1 != $result) {
                    return json(['status' => 0, 'msg' => $result]);
                }
            }

            $saveData['moveout_date'] = strtotime($saveData['moveout_date'] );

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
