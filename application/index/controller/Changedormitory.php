<?php

namespace app\index\controller;

use app\index\model\DmDormitory;
use app\index\model\DmStay;
use think\Db;
class Changedormitory extends Common
{
    private $_sex = [
        1 => '男',
        2 => '女',
        3 => '未知'
    ];

    //换宿舍
    protected function _initialize() {

        $this->model = new \app\index\model\DmStay;
        $this->order = 'adjust_date DESC,id DESC';
//        $this->vd = 'DmDormitory';
        $this->with = 'campus,build,floor,dormitory';
        parent::_initialize();
    }


    /**
     * @description 学生调往空宿舍页
     * @author Lang
     * @return mixed
     */
    public function index()
    {
        $where = [];
        $paramData = [
            'ad_num' => trim($this->req->param('ad_num'))
        ];

        if ( $paramData['ad_num'] != '' )
        {
            $where['student_num'] = ['like',"%{$paramData['ad_num']}%"];
        }

        list($changeList,$page)= $this->_getExchangeRoom($where);

        //数据列表
        $this->assign('paramData',$paramData);
        $this->assign('list',$changeList);
        $this->assign('page',$page);
        $this->assign('search',$this->search);
        return $this->fetch();
    }

    /**
     * @description 推宿舍
     * @author zwd
     */
    public function delStay(){
        $id = input('id');
        $result = $this->model->where(['id'=>$id])->delete();
        if($result){
            return ['status'=>1,'msg'=>'删除成功'];
        }else{
            return ['status'=>0,'msg'=>'删除失败'];
        }
    }

    /**
     * @description 根据条件获取
     * @author Lang
     * @param array $where
     * @return mixed
     */
    private function _getExchangeRoom($where = [])
    {
        $list = $this->model
            ->with($this->with)
            ->where('before_campus_id > 0 or before_build_id > 0 or before_floor_id > 0 or before_dormitory_id > 0')
            ->where($where)
            ->order($this->order)
            ->paginate($this->pagesize);

        $page = $list->render();
        $list = $list->toArray();

        /* 获取学生之前的入住信息 */
        if ( isset($list['data']) && count($list['data']) > 0 )
        {
            $dormitoryIds = array_column($list['data'], 'before_dormitory_id');

            if ( count($dormitoryIds) > 0 )
            {
                $dormitoryList = model("dmDormitory")->with('campus,build,floor')
                    ->where(['id' => ['in',implode(',',$dormitoryIds)]])
                    ->select()
                    ->toArray();

                if ( count($dormitoryList) > 0 )
                {
                    $dormitoryList = array_column($dormitoryList,NULL,'id');
                    foreach ( $list['data'] as $key => $value )
                    {
                        if ( isset($dormitoryList[$value['before_dormitory_id']]) )
                        {
                            $list['data'][$key]['before_campus'] = $dormitoryList[$value['before_dormitory_id']]['campus'];
                            $list['data'][$key]['before_build'] = $dormitoryList[$value['before_dormitory_id']]['build'];
                            $list['data'][$key]['before_floor'] = $dormitoryList[$value['before_dormitory_id']]['floor'];
                            $list['data'][$key]['before_dormitory'] = [
                                'room_num' => $dormitoryList[$value['before_dormitory_id']]['room_num'],
                                'several' => $dormitoryList[$value['before_dormitory_id']]['several'],
                            ];
                        }
                    }
                }
            }
        }

        return [$list,$page];
    }

    /**
     * @description 执行学生调往空宿舍
     * @author Lang
     * @return \think\response\Json
     */
    public function studentToEmptyRoom()
    {
        if($this->req->isPost())
        {
            /* 请求参数 */
            $postData = [
                'id' => intval($this->req->post('stay_id')),
                'student_num' => trim($this->req->post('student_num')),
                'adjust_date' => trim($this->req->post('adjust_date')),
                'build_id' => intval($this->req->post('build_id')),
                'floor_id' => intval($this->req->post('floor_id')),
                'dormitory_id' => intval($this->req->post('dormitory_id'))
            ];

            /* 参数判断 */
            if ( $postData['id'] == 0 )
            {
                return json(['status'=>0,'msg'=>'请选择要调换宿舍的学生']);
            }

            if ( $postData['build_id'] == 0 )
            {
                return json(['status'=>0,'msg'=>'请选择要调换宿舍的学生']);
            }

            if ( $postData['floor_id'] == 0 )
            {
                return json(['status'=>0,'msg'=>'请选择要调换宿舍的楼层']);
            }

            if ( $postData['dormitory_id'] == 0 )
            {
                return json(['status'=>0,'msg'=>'请选择要调换宿舍的房号']);
            }

            /* 判断学生已经入住宿舍 */
            $stayInfo = DmStay::find($postData['id']);
            if ( !$stayInfo )
            {
                return json(['status'=>0,'msg'=>'请选择要调换宿舍的学生']);
            }
            $stayInfo = $stayInfo->toArray();

            /* 判断宿舍是否存在*/
            $dmdormitoryModel = new DmDormitory();
            $domitoryInfo = $dmdormitoryModel->where(['build_id' => $postData['build_id'],'floor_id' => $postData['floor_id'],'id' => $postData['dormitory_id']])
                ->find();
            if ( !$domitoryInfo )
            {
                return json(['status'=>0,'msg'=>'请选择要调换宿舍的宿舍不存在']);
            }
            $domitoryInfo = $domitoryInfo->toArray();

            /* 判断宿舍是否可以入住 */
            $exchangeDomitoryStayList = model("dmStay")->where(['build_id' => $postData['build_id'],'floor_id' => $postData['floor_id'],'dormitory_id' => $postData['dormitory_id']])
                ->select()
                ->toArray();
            $exchangeDomitoryStayCount = count($exchangeDomitoryStayList);
            if ( $exchangeDomitoryStayCount + 1 > $domitoryInfo['several'] )
            {
                return json(['status'=>0,'msg'=>'请选择要调换宿舍的宿舍已住满']);
            }

            /* 调换的如果已经有学生入住，判断调换的宿舍是否即将入住的学生性别一致 */
            if ( $exchangeDomitoryStayCount != 0 )
            {
                if ( $stayInfo['sex'] != $exchangeDomitoryStayList[0]['sex'] )
                {
                    return json([
                        'status'=> 0,
                        'msg' => "学号{$stayInfo['student_num']}是{$this->_sex[$stayInfo['sex']]}生,调换的宿舍已入住{$this->_sex[$exchangeDomitoryStayList[0]['sex']]}生。"
                    ]);
                }
            }

            /* 更新入住信息 */
            $updateData = [
                'campus_id' => $domitoryInfo['campus_id'],
                'build_id' => $domitoryInfo['build_id'],
                'floor_id' => $domitoryInfo['floor_id'],
                'dormitory_id' => $domitoryInfo['id'],
                'before_campus_id' => $stayInfo['campus_id'],
                'before_build_id' => $stayInfo['build_id'],
                'before_floor_id' => $stayInfo['floor_id'],
                'before_dormitory_id' => $stayInfo['dormitory_id'],
                'adjust_date' => $postData['adjust_date'] != '' ? strtotime($postData['adjust_date']) :null,
            ];

            $res = $this->model->where(['id'=> $stayInfo['id']])->update($updateData);
            if( $res!== false)
            {
                return json(['status'=>1,'msg'=>'调往成功']);
            }
        }
        return json(['status'=>0,'msg'=>'调往失败']);
    }


    /**
     * @description 学生之间交换
     * @author Lang
     * @return mixed
     */
    public function student()
    {
        $where = [];
        $paramData = [
            'ad_num' => trim($this->req->param('ad_num'))
        ];

        if ( $paramData['ad_num'] != '' )
        {
            $where['student_num'] = ['like',"%{$paramData['ad_num']}%"];
        }

        list($changeList,$page)= $this->_getExchangeRoom($where);

        //数据列表
        $this->assign('paramData',$paramData);
        $this->assign('list',$changeList);
        $this->assign('page',$page);
        $this->assign('search',$this->search);
        return $this->fetch();
    }


    /**
     * @description 学生互换宿舍操作
     * @author Lang
     */
    public function swapStudent()
    {
        if($this->req->isPost())
        {
            $postData = [
                'from_student_num' => trim($this->req->post('from_student_num')),
                'to_student_num' => trim($this->req->post('to_student_num'))
            ];

            /* 参数筛选 */
            if ( $postData['from_student_num'] == '' )
            {
                return json(['status'=>0,'msg'=>'请填写学号一']);
            }

            if ( $postData['to_student_num'] == '' )
            {
                return json(['status'=>0,'msg'=>'请填写学号二']);
            }

            /* 学生一和学生二的入住信息 */
            $fromStayInfo = DmStay::where(['student_num' => $postData['from_student_num']])
                ->find();
            if ( !$fromStayInfo )
            {
                return json(['status'=>0,'msg'=>'学号一未入住']);
            }
            $fromStayInfo = $fromStayInfo -> toArray();

            $toStayInfo = DmStay::where(['student_num' => $postData['to_student_num']])
                ->find();
            if ( !$toStayInfo )
            {
                return json(['status'=>0,'msg'=>'学号二未入住']);
            }
            $toStayInfo = $toStayInfo -> toArray();

            /* 判断性别是否一致 */
            if ( $fromStayInfo['sex'] != $toStayInfo['sex'] )
            {
                return json(['status'=>0,'msg'=>'性别不一致，不能对调']);
            }

            /* 判断是否同宿舍 */
            if ($fromStayInfo['dormitory_id'] == $toStayInfo['dormitory_id'])
            {
                return json(['status'=>0,'msg'=>'学好一和学号二同宿舍。']);
            }

            /* 对调操作 */
            $updateData = [
                [
                    'id' => $fromStayInfo['id'],
                    'campus_id' => $toStayInfo['campus_id'],
                    'build_id' => $toStayInfo['build_id'],
                    'floor_id' => $toStayInfo['floor_id'],
                    'dormitory_id' => $toStayInfo['dormitory_id'],
                    'before_campus_id' => $fromStayInfo['campus_id'],
                    'before_build_id' => $fromStayInfo['build_id'],
                    'before_floor_id' => $fromStayInfo['floor_id'],
                    'before_dormitory_id' => $fromStayInfo['dormitory_id'],
                    'adjust_date' => time()
                ],
                [
                    'id' => $toStayInfo['id'],
                    'campus_id' => $fromStayInfo['campus_id'],
                    'build_id' => $fromStayInfo['build_id'],
                    'floor_id' => $fromStayInfo['floor_id'],
                    'dormitory_id' => $fromStayInfo['dormitory_id'],
                    'before_campus_id' => $toStayInfo['campus_id'],
                    'before_build_id' => $toStayInfo['build_id'],
                    'before_floor_id' => $toStayInfo['floor_id'],
                    'before_dormitory_id' => $toStayInfo['dormitory_id'],
                    'adjust_date' => time()
                ],
            ];

            $stayModel = new DmStay();
            $res = $stayModel->saveAll($updateData);
            if ( $res )
            {
                return json(['status'=>1,'msg'=>'调换成功']);
            }
        }

        return json(['status'=>0,'msg'=>'对调失败']);
    }


    /**
     * @description 整间宿舍调往空宿舍
     * @author Lang
     */
    public function emptyRoom()
    {
        // 获取校区的结果集
        $campusList = model("campus")->select();

        $this->assign('campusList',$campusList);
        return $this->fetch();
    }


    /**
     * @description 整间宿舍调往空宿舍
     * @author Lang
     * @return \think\response\Json
     */
    public function roomToEmptyRoom()
    {
        if($this->req->isPost())
        {
            $postData = [
                'from_dormitory_id' => intval($this->req->post('from_dormitory_id')),
                'to_dormitory_id' => intval($this->req->post('to_dormitory_id'))
            ];

            /* 字段排查 */
            if ( $postData['from_dormitory_id'] == 0 )
            {
                return json(['status'=>0,'msg'=>'请选择要调换的宿舍一']);
            }

            if ( $postData['to_dormitory_id'] == 0 )
            {
                return json(['status'=>0,'msg'=>'请选择要调换到的宿舍二']);
            }

            /* 判断宿舍是否都存在 */
            $fromDormitoryInfo = DmDormitory::get($postData['from_dormitory_id']);
            if ( !$fromDormitoryInfo )
            {
                return json(['status'=>0,'msg'=>'选择的宿舍一不存在']);
            }
            $fromDormitoryInfo = $fromDormitoryInfo->toArray();

            $toDormitoryInfo = DmDormitory::get($postData['to_dormitory_id']);
            if ( !$toDormitoryInfo )
            {
                return json(['status'=>0,'msg'=>'选择的宿舍二不存在']);
            }
            $toDormitoryInfo = $toDormitoryInfo->toArray();

            /* 判断调换到宿舍二的床位是否充足 */
            // 宿舍一是否有入住
            $fromDormitoryStudentList = model("dmStay")->where(['dormitory_id' => $postData['from_dormitory_id']])
                ->select()
                ->toArray();
            $fromDormitoryStudentCount = count($fromDormitoryStudentList);
            if ( $fromDormitoryStudentCount == 0)
            {
                return json(['status'=>0,'msg'=>'宿舍一没有学生入住']);
            }

            // 宿舍二是否床位充足
            $toDormitoryStudentList = model("dmStay")->where(['dormitory_id' => $postData['to_dormitory_id']])
                ->select()
                ->toArray();
            $toDormitoryStudentCount = count($toDormitoryStudentList);
            if ( $fromDormitoryStudentCount > $toDormitoryInfo['several'] - $toDormitoryStudentCount )
            {
                return json(['status'=>0,'msg'=>'宿舍二的床位不够，不能对调']);
            }

            /* 宿舍二是否已经入住学生，如果入住了判断是否和宿舍一的入住学生性别是否一致 */
            if ( $toDormitoryStudentCount != 0 )
            {
                if ( $fromDormitoryStudentList[0]['sex'] != $toDormitoryStudentList[0]['sex'] )
                {
                    return json([
                        'status'=>0,
                        'msg'=>'宿舍一住的' . $this->_sex[$fromDormitoryStudentList[0]['sex']] . "生,宿舍二住的" . $this->_sex[$toDormitoryStudentList[0]['sex']] . '生，性别不一致。'
                    ]);
                }
            }

            /* 学生调换宿舍 */
            $updateData = [];
            foreach ( $fromDormitoryStudentList as $value )
            {
                $updateData[]= [
                    'id' => $value['id'],
                    'campus_id' => $toDormitoryInfo['campus_id'],
                    'build_id' => $toDormitoryInfo['build_id'],
                    'floor_id' => $toDormitoryInfo['floor_id'],
                    'dormitory_id' => $toDormitoryInfo['id'],
                    'before_campus_id' => $value['campus_id'],
                    'before_build_id' => $value['build_id'],
                    'before_floor_id' => $value['floor_id'],
                    'before_dormitory_id' => $value['dormitory_id'],
                    'adjust_date' => time()
                ];
            }

            $stayModel = new DmStay();
            $res = $stayModel->saveAll($updateData);
            if ( $res )
            {
                return json(['status'=>1,'msg'=>'调换成功']);
            }
        }

        return json(['status'=>0,'msg'=>'调换失败']);
    }


    /**
     * @description 两间宿舍对调
     * @author Lang
     */
    public function room()
    {
        // 获取校区的结果集
        $campusList = model("campus")->select();

        $this->assign('campusList',$campusList);
        return $this->fetch();
    }


    /**
     * @description 宿舍对调
     * @author Lang
     */
    public function roomToRoom()
    {
        if($this->req->isPost())
        {
            $postData = [
                'from_dormitory_id' => intval($this->req->post('from_dormitory_id')),
                'to_dormitory_id' => intval($this->req->post('to_dormitory_id'))
            ];

            /* 字段排查 */
            if ( $postData['from_dormitory_id'] == 0 )
            {
                return json(['status'=>0,'msg'=>'请选择要调换的宿舍一']);
            }

            if ( $postData['to_dormitory_id'] == 0 )
            {
                return json(['status'=>0,'msg'=>'请选择要调换到的宿舍二']);
            }

            /* 判断宿舍是否都存在 */
            $fromDormitoryInfo = DmDormitory::get($postData['from_dormitory_id']);
            if ( !$fromDormitoryInfo )
            {
                return json(['status'=>0,'msg'=>'选择的宿舍一不存在']);
            }
            $fromDormitoryInfo = $fromDormitoryInfo->toArray();

            $toDormitoryInfo = DmDormitory::get($postData['to_dormitory_id']);
            if ( !$toDormitoryInfo )
            {
                return json(['status'=>0,'msg'=>'选择的宿舍二不存在']);
            }
            $toDormitoryInfo = $toDormitoryInfo->toArray();


            /* 判断宿舍一和宿舍二是否都是空宿舍，是空宿舍则不需要对调 */
            $fromDormitoryStudentList = model("dmStay")->where(['dormitory_id' => $postData['from_dormitory_id']])
                ->select()
                ->toArray();
            $fromDormitoryStudentCount = count($fromDormitoryStudentList);

            $toDormitoryStudentList = model("dmStay")->where(['dormitory_id' => $postData['to_dormitory_id']])
                ->select()
                ->toArray();
            $toDormitoryStudentCount = count($toDormitoryStudentList);

            if ( $fromDormitoryStudentCount == 0 && $toDormitoryStudentCount == 0)
            {
                return json(['status'=>0,'msg'=>'宿舍一和宿舍二都是空宿舍，不需要对调。']);
            }

            /* 判断宿舍一和宿舍二床位是否充足 */
            if ( $fromDormitoryStudentCount > $toDormitoryInfo['several'])
            {
                return json(['status'=>0,'msg'=>'宿舍二床位不足']);
            }

            if ( $toDormitoryStudentCount > $fromDormitoryInfo['several'] )
            {
                return json(['status'=>0,'msg'=>'宿舍一床位不足']);
            }


            /* 判断男女宿舍是否对调 */
            /*if ( $toDormitoryStudentCount != 0  && $fromDormitoryStudentCount != 0)
            {
                if ( $fromDormitoryStudentList[0]['sex'] != $toDormitoryStudentList[0]['sex'] )
                {
                    return json([
                        'status'=>0,
                        'msg'=>'宿舍一住的' . $this->_sex[$fromDormitoryStudentList[0]['sex']] . "生,宿舍二住的" . $this->_sex[$toDormitoryStudentList[0]['sex']] . '生，男女宿舍不能对调。'
                    ]);
                }
            }*/

            /* 学生调换宿舍 */
            $updateData = [];
            //宿舍一对调
            if ( count($fromDormitoryStudentList) > 0 )
            {
                foreach ( $fromDormitoryStudentList as $value )
                {
                    $updateData[]= [
                        'id' => $value['id'],
                        'campus_id' => $toDormitoryInfo['campus_id'],
                        'build_id' => $toDormitoryInfo['build_id'],
                        'floor_id' => $toDormitoryInfo['floor_id'],
                        'dormitory_id' => $toDormitoryInfo['id'],
                        'before_campus_id' => $value['campus_id'],
                        'before_build_id' => $value['build_id'],
                        'before_floor_id' => $value['floor_id'],
                        'before_dormitory_id' => $value['dormitory_id'],
                        'adjust_date' => time()
                    ];
                }
            }

            // 宿舍二对调
            if ( count($toDormitoryStudentList) > 0 )
            {
                foreach ( $toDormitoryStudentList as $value )
                {
                    $updateData[]= [
                        'id' => $value['id'],
                        'campus_id' => $fromDormitoryInfo['campus_id'],
                        'build_id' => $fromDormitoryInfo['build_id'],
                        'floor_id' => $fromDormitoryInfo['floor_id'],
                        'dormitory_id' => $fromDormitoryInfo['id'],
                        'before_campus_id' => $value['campus_id'],
                        'before_build_id' => $value['build_id'],
                        'before_floor_id' => $value['floor_id'],
                        'before_dormitory_id' => $value['dormitory_id'],
                        'adjust_date' => time()
                    ];
                }
            }

            $stayModel = new DmStay();
            $res = $stayModel->saveAll($updateData);
            if ( $res )
            {
                return json(['status'=>1,'msg'=>'对调成功']);
            }
        }

        return json(['status'=>0,'msg'=>'对调失败']);
    }


    /**
     * @description  根据条件获入住的学生信息
     * @author Lang
     */
    public function getStudent()
    {
        $studentNum = trim($this->req->param('studentNum'));

        if ( $studentNum == '' )
        {
            return json(['status'=>0,'msg'=>'请填写学号']);
        }

        // 获取入住学生信息
        $stayInfo = DmStay::get(['student_num' => $studentNum]);
        
        if ( !$stayInfo)
        {
            return json(['status'=>0,'msg'=> "学号" . $studentNum . '的学生未入住宿舍']);
        }
        
        $stayInfo = DmStay::with('campus,build,floor,dormitory')
            ->find($stayInfo['id'])
            ->toArray();

        switch ($stayInfo['sex'])
        {
            case 1 :
                $stayInfo['sex_name'] = '男';
                break;
            case 2 :
                $stayInfo['sex_name'] = '女';
                break;
            case 3 :
                $stayInfo['sex_name'] = '未知';
                break;
            default:
                $stayInfo['sex_name'] = '未知';
                break;
        }

        // 获取该校区的所有楼栋
        $stayInfo['buildList'] = model("Dmbuild")->where(['campus_id' => $stayInfo['campus_id']])
            ->select()
            ->toArray();
        
        $stayInfo['grade_name'] = Db::name('grade')->where(['gd_id'=>$stayInfo['grade_id']])->value('gd_name');
        return json(['status'=>1,'msg'=>'获取成功','data' => $stayInfo]);
    }


    /**
     * @description 筛选出空宿舍
     * @author Lang
     * @return \think\response\Json
     */
    public function getEmptyRoom()
    {
        if($this->req->isPost())
        {
            $campus_id= $this->req->post('campus_id');
            $build_id= $this->req->post('build_id');
            $floor_id= $this->req->post('floor_id');

            /* 获取楼层的所有宿舍 */
            $dormitoryModel = new DmDormitory();
            $dormitoryList = $dormitoryModel->where(['build_id'=>$build_id,'campus_id'=>$campus_id,'floor_id'=>$floor_id])
                ->select()
                ->toArray();

            /* 数据整理 */
            if ( false && count($dormitoryList) > 0 )
            {
                $temp = [];
                $ids = [];
                foreach ( $dormitoryList as $value )
                {
                    $ids[] = $value['id'];
                    $temp[$value['id']] = $value;
                }

                $dormitoryList = $temp;

                /* 判断宿舍下是否已经学生 */
                $stayModel = new DmStay();
                $stayList = $stayModel->field("dormitory_id,COUNT(*) AS num")
                    ->where(['dormitory_id' => ['in',implode(",",$ids)]])
                    ->group("dormitory_id")
                    ->select()
                    ->toArray();

                if ( count($stayList) > 0 )
                {
                    // 删除不是空的宿舍
                    foreach ( $stayList  as $value)
                    {
                        if ( $value['num'] > 0 && $dormitoryList[$value['dormitory_id']] )
                        {
                            unset($dormitoryList[$value['dormitory_id']]);
                        }
                    }
                }
            }

            return json(['status' => 1, 'msg' => '获取成功','data'=>$dormitoryList]);
        }

        return json(['status' => 0, 'msg' => '获取失败！']);
    }
}
