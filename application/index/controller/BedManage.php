<?php
/**
 *  BedManage.php
 *
 * @description 学生铺位分配管理
 */

namespace app\index\controller;


use app\index\model\Admin;
use app\index\model\Bclass;
use app\index\model\Campus;
use app\index\model\DmBuild;
use app\index\model\DmDormitory;
use app\index\model\DmFloor;
use app\index\model\DmStay;
use app\index\model\Grade;
use app\index\model\SxdStudentInfo;
use think\Db;

class BedManage extends Common
{

    protected function _initialize()
    {
        $this->model = new \app\index\model\DmDormitory;
        $this->order = 'id desc';
        $this->vd = 'DmDormitory';
        $this->with = 'campus,build,floor,dormitory';

        parent::_initialize();
    }

    /**
     * @description 学校床位展示
     * @author Lang
     */
    public function index()
    {
        // 参数筛选
        $where = [];
        $paramData = [
            'campus_id' => intval($this->req->param('campus_id')),
            'build_id' => intval($this->req->param('build_id')),
        ];

        // 获取所有的学区信息
        $campusList = model('campus')->select()
            ->toArray();

        // 如果没有选择校区，默认显示第一个校区信息
        if ( $paramData['campus_id'] == 0)
        {
            $paramData['campus_id'] = isset($campusList['0']) ?  $campusList['0']['cp_id'] : 0;
        }

        /* 条件筛选 */
        // 学区搜索
        if ( $paramData['campus_id'] > 0)
        {
            $where['campus_id'] = $paramData['campus_id'];
        }

        // 楼栋筛选
        if ( $paramData['build_id'] > 0)
        {
            $where['id'] = $paramData['build_id'];
        }

        $dmBuildModel = new DmBuild();
        $list = $dmBuildModel->where($where)->order($this->order)->paginate($this->pagesize,false, [
            'query' => $this->req->param()]);

        $page = $list->render();
        $list = $list->toArray();
        $buildList = $list['data'];

        // 获取楼层的所有信息
        if ( count($buildList) > 0 )
        {
            $buildIds = []; // 所有楼栋的ID集合
            $temp = [];
            foreach ( $buildList as $value)
            {
                $buildIds[] = $value['id'];
                $value['floor_total'] = 0 ; // 楼层总数
                $value['dormitory_total'] = 0; // 房间总数
                $value['bed_total'] = 0; // 床位总数
                $value['bed_check_total'] = 0; // 入住总数
                $temp[$value['id']] =  $value;
            }

            $buildList = $temp;

            /* 获取楼栋下的楼层 */
            $floorList = model('dmFloor')->where(['build_id'=>['in', $buildIds]])
                ->field("build_id,COUNT(*) AS num")
                ->group("build_id")
                ->select()
                ->toArray();
            if ( count($floorList) > 0 )
            {
                foreach ( $floorList as $value)
                {
                    if ( isset($buildList[$value['build_id']]) )
                    {
                        $buildList[$value['build_id']]['floor_total'] = $value['num'];
                    }
                }
            }

            /* 获取楼栋下的房间 */
            $dormitoryList = model('dmDormitory')->where(['build_id'=>['in', $buildIds]])
                ->select()
                ->toArray();

            if ( count($dormitoryList) > 0 )
            {
                /* 获取每栋的已经入住人数 */
                foreach ( $dormitoryList as $value)
                {
                    if ( isset($buildList[$value['build_id']]) )
                    {
                        $buildList[$value['build_id']]['dormitory_total'] += 1;
                        $buildList[$value['build_id']]['bed_total'] += $value['several'];
                    }
                }
            }

            /* 获取楼栋下的所有入住人数 */
            $stayList = model("dmStay")->where(['build_id'=>['in', $buildIds]])
                ->field("build_id,COUNT(*) AS num")
                ->group("build_id")
                ->select()
                ->toArray();

            if ( count($stayList) > 0 )
            {
                foreach ( $stayList as $value)
                {
                    if ( isset($buildList[$value['build_id']]) )
                    {
                        $buildList[$value['build_id']]['bed_check_total'] = $value['num'];
                    }
                }
            }

            /* 楼栋数据整理 */
            foreach ( $buildList as $key => $value )
            {
                // 剩余房间数
                $value['bed_empty_total'] = $value['bed_total'] - $value['bed_check_total'];

                // 床位入住率
                if ( $value['bed_total'] == 0 )
                {
                    $value['bed_check_rate'] = 0;
                }
                else
                {
                    $value['bed_check_rate'] = floor($value['bed_empty_total'] * 100/$value['bed_total']);
                }

                $buildList[$key] = $value;
            }
        }

        $list['data'] = $buildList;

        // select的楼栋说明
        $buildModel = new Dmbuild();
        $buildList = $buildModel->where(['campus_id'=>$paramData['campus_id']])->select();

        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->assign('campusList',$campusList);
        $this->assign('buildList',$buildList);
        $this->assign('campusId',$paramData['campus_id']);
        $this->assign('buildId',$paramData['build_id']);

        return $this->fetch('index');
    }


    /**
     * @description 楼栋展示
     * @author Lang
     */
    public function builder()
    {
        // 参数筛选
        $where = [];
        $paramData = [
            'build_id' => intval($this->req->param('id')),
            'floor_id' => intval($this->req->param('floor_id')),
            'dormitory_id' => intval($this->req->param('dormitory_id')),
        ];

        if ( $paramData['build_id'] > 0)
        {
            $where['build_id'] = $paramData['build_id'];
        }

        if ( $paramData['floor_id'] > 0 )
        {
            $where['id'] = $paramData['floor_id'];
        }

        // 判断楼栋是否存在
        $builderInfo = Dmbuild::get($paramData['build_id']);
        if ( empty( $builderInfo))
        {
            $this->error('请选择楼栋');
        }

        /* 获取楼栋下的所有楼层 */
        $dmFloorModel = new DmFloor();
        $list = $dmFloorModel->where($where)
            ->order($this->order)
            ->paginate(2,false, ['query' => $this->req->param()]);

        $page = $list->render();
        $list = $list->toArray();

        /* 获取楼层的所有房间 */
        if ( count($list['data']) > 0  )
        {
            $floorList = [];
            $floorIds = [];
            foreach ( $list['data'] as $value)
            {
                $value['room'] = [];
                $floorList[$value['id']] = $value;
                $floorIds[] = $value['id'];
            }

            /* 获取房间号 */
            $dormitoryWhere = []; // 宿舍筛选条件
            $stayWhere = []; // 学生入住筛选条件
            if ( $paramData['dormitory_id'] > 0 )
            {
                $dormitoryWhere['id'] = $paramData['dormitory_id'];
                $stayWhere['dormitory_id'] = $paramData['dormitory_id'];
            }
            else
            {
                $dormitoryWhere['floor_id'] = ['in', $floorIds];
                $stayWhere['floor_id'] = ['in', $floorIds];
            }

            // 房间筛选
            $dormitoryList = model('dmDormitory')->where($dormitoryWhere)
                ->order("room_num ASC")
                ->select()
                ->toArray();

            // 根据房间号统计学生入住总数
            $stayList = model("dmStay")->where($stayWhere)
                ->field("dormitory_id,COUNT(*) AS num")
                ->group("dormitory_id")
                ->select()
                ->toArray();

            $stayList = array_column($stayList,null,'dormitory_id');
            if ( count($dormitoryList) > 0 )
            {
                foreach ( $dormitoryList as $value )
                {
                    if ( isset($floorList[$value['floor_id']]) )
                    {
                        if ( isset($stayList[$value['id']]))
                        {
                            $value['check_in_count'] = $stayList[$value['id']]['num'];
                        }
                        else
                        {
                            $value['check_in_count'] = 0;
                        }
                        $value['room_leave_count'] = $value['several'] - $value['check_in_count'];
                        $floorList[$value['floor_id']]['room'][] = $value;
                    }
                }
            }

            $list['data'] = $floorList;
        }

        // 筛选的楼层
        $floorList = $dmFloorModel->where(['build_id' => $paramData['build_id']])
            ->select()
            ->toArray();

        // 筛选的房间
        $dormitoryList = [];
        if ( $paramData['floor_id'] > 0 )
        {
            $dormitoryList = model('dmDormitory')->where(['floor_id' => $paramData['floor_id']])
                ->select()
                ->toArray();
        }

        /* 渲染 */
        $this->assign('builderInfo',$builderInfo);
        $this->assign('paramData',$paramData);
        $this->assign('floorList', $floorList);
        $this->assign('dormitoryList', $dormitoryList);
        $this->assign('list', $list);
        $this->assign('page',$page);
        return $this->fetch();
    }


    /**
     * @description  房间展示
     * @author Lang
     * @return mixed
     */
    public function room()
    {
        $where = [];
        $paramData = [
            'dormitory_id' => intval($this->req->param('id')),
            'student_name' => trim($this->req->param('student_name'))
        ];

        if ( $paramData['dormitory_id'] > 0 )
        {
            $where['dormitory_id'] = $paramData['dormitory_id'];
        }
        else
        {
            // 没有宿舍ID，直接返回错误
            $this->error();
        }

        if ( $paramData['student_name'] != '' )
        {
            $where['name'] = ['like','%'.$paramData['student_name'].'%'];
        }

        // 获取宿舍信息
        $dormitoryInfo = DmDormitory::with('floor,build')
            ->find($paramData['dormitory_id'])
            ->toArray();

        if ( empty($dormitoryInfo) )
        {
            $this->error();
        }

        $dormitoryInfo['check_in_count'] = model("dmStay")->where(['dormitory_id' => $paramData['dormitory_id']])
            ->count();

        $dmStayList = model('dmStay')->where($where)
            ->with("grade,bclass,dormitory")
            ->select()
            ->toArray();

        $this->assign('studentName',$paramData['student_name']);
        $this->assign('dormitoryInfo',$dormitoryInfo);
        $this->assign('list',$dmStayList);
        return $this->fetch();
    }


    /**
     * @description 学生分配宿舍页面展示
     * @author Lang
     * @return mixed
     */
    public function allot()
    {
        /* 请求参数 */
        $paramData = [
            'dormitory_id' => intval($this->req->param('id')),
            'student_no' => trim($this->req->param('student_no')),
            'campus_id' => intval($this->req->param('campus_id')),
            'gd_id' => intval($this->req->param('gd_id')),
            'cl_id' => intval($this->req->param('cl_id')),
            'ad_sex' => intval($this->req->param('ad_sex'))
        ];

        // 没有宿舍ID，直接返回错误
        if ( $paramData['dormitory_id']== 0 )
        {
            $this->error('请选择房间');
        }

        // 获取宿舍信息
        $dormitoryInfo = DmDormitory::with('floor,build')
            ->find($paramData['dormitory_id'])
            ->toArray();

        // 判断宿舍是否存在
        if ( empty($dormitoryInfo) )
        {
            $this->error('请选择房间');
        }

        /* 条件筛选 */
        $where = [];
        $gradeList = []; // 年级
        $bclassList = []; // 班级

        // 学号查询
        if ( $paramData['student_no'] != '' )
        {
            $where['ad_num'] = ['like','%'.$paramData['student_no'].'%'];
        }

        // 校区筛选
        if ( $paramData['campus_id'] > 0 )
        {
            $where['a.cp_id'] = $paramData['campus_id'];
            $gradeList = model('grade')->select()
                ->toArray();
        }

        // 年级筛选
        if ( $paramData['gd_id'] > 0 )
        {
            $where['a.gd_id'] = $paramData['gd_id'];
            $gradeList = model('grade')->select()
                ->toArray();
        }

        // 班级筛选
        if ( $paramData['cl_id'] > 0 )
        {
            $where['a.cl_id'] = $paramData['cl_id'];
            $bclassList = model("bclass")->select()
                ->toArray();
        }

        // 性别筛选
        if ( $paramData['ad_sex'] > 0 )
        {
            $where['ad_sex'] = $paramData['ad_sex'];
        }

        /* 获取所有的学生信息 */
        $roleId = 3; // 学生角色ID
        $studentModel = new SxdStudentInfo();
        $fields = "a.ad_uid,a.ad_num,a.ad_sname,a.ad_sex,a.cp_id,a.gd_id,a.cl_id,a.ad_identify,a.ad_tel,g.gd_name,b.cl_name";
        $list = $studentModel
            ->alias("s")
            ->join("admin a","s.ad_uid = a.ad_uid")
            ->join("grade g","g.gd_id = a.gd_id")
            ->join("bclass b","b.cl_id = a.cl_id")
            ->field($fields)
            ->where(['rs_id' => $roleId,'ad_status' => 1,'is_quarter' => SxdStudentInfo::QUARTER_WAIT])
            ->where($where)
            ->paginate($this->pagesize,false, [
            'query' => $this->req->param()]
            );
        $page = $list->render();
        $list = $list->toArray();

        // 学区
        $campusList = model('campus')->select()
            ->toArray();
        if ( count($campusList) > 0)
        {
            $temp = [];
            foreach ( $campusList as $value )
            {
                $temp[$value['cp_id']] = $value;
            }
            $campusList = $temp;
        }

        /* 传参 */
        $this->assign('campusList',$campusList);
        $this->assign('gradeList',$gradeList);
        $this->assign('bclassList',$bclassList);
        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->assign('param',$paramData);
        $this->assign('dormitoryInfo',$dormitoryInfo);
        $this->assign('urls', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].substr($_SERVER['REQUEST_URI'], 0, 18).'room/id/'.$this->request->param('id').'.html');
        return $this->fetch();
    }


    /**
     * @description 根据条件获取年级
     * @author Lang
     * @return \think\response\Json
     */
    public function getGrade()
    {
        if($this->req->isPost()) {
            $campusId= $this->req->post('campus_id');
            $gradeModel = new Grade();
            $list = $gradeModel->where([])
                ->select();

            return json(['status' => 1, 'msg' => '获取成功','data'=>$list]);
        }

        return json(['status' => 0, 'msg' => '获取失败！']);
    }

    /**
     * @description 根据条件获取班级
     * @author Lang
     * @return \think\response\Json
     */
    public function getBclass()
    {
        if($this->req->isPost()) {
            $campusId= $this->req->post('campus_id');
            $gdId= $this->req->post('gd_id');
            $bclassModel = new Bclass();
            $list = $bclassModel->where(['gd_id'=>$gdId,'cp_id'=>$campusId])
                ->select();

            return json(['status' => 1, 'msg' => '获取成功','data'=>$list]);
        }

        return json(['status' => 0, 'msg' => '获取失败！']);
    }


    /**
     * @description 执行分配操作
     * @author Lang
     */
    public function doAllot()
    {
        /**
         * 1、宿舍是否满了
         * 2、学生入住是否满了
         * 3、男女是否混住
         * 4、入住成功
         * 5、添加入住信息，修改bp_sxd_student_info入住字段
         *   修改bp_dm_domitory表的已经入住人数字段 ？
         */
        $sexList = [
            1 => '男',
            2 => '女',
            3 => '未知'
        ];

        $ids = trim($this->req->post('ids'));
        $dormitoryId = intval($this->req->post('dormitory_id'));

        /* 判断字段是否存在 */
        if ( $dormitoryId == 0)
        {
            return json(['status' => 0, 'msg' => '请求错误！']);
        }

        if ( $ids == '' )
        {
            return json(['status' => 0, 'msg' => '请求错误！']);
        }

        /* 判断数据是否存在 */
        $dormitoryInfo = DmDormitory::with('floor,build')
            ->find($dormitoryId)
            ->toArray();

        if ( empty($dormitoryInfo) )
        {
            return json(['status' => 0, 'msg' => '请选择需要分配的宿舍！']);
        }

        /* 判断宿舍是否已经住满 */
        $stayStudentList = model("dmStay")->where(['dormitory_id' => $dormitoryId])
            ->select()
            ->toArray();
        $stayStudentTotal = count($stayStudentList);

         if ( $dormitoryInfo['several'] > 0 && $stayStudentTotal == $dormitoryInfo['several'] )
         {
            return json(['status' => -1, 'msg' => '宿舍已经住满！']);
         }

        /* 学生ID处理 */
        $idsList = explode(",",$ids);
        
        $temp = [];
        foreach ( $idsList as $value)
        {
            $temp[] = intval($value);
        }
        $idsList = $temp;

        /* 判断学生是否能全部入住到宿舍 */
        if (  $dormitoryInfo['several'] > 0 && $stayStudentTotal + count($idsList) > $dormitoryInfo['several'] )
        {
            return json(['status=>0','msg'=>'宿舍容纳不下,还能住'.($dormitoryInfo['several']-$stayStudentTotal).'人']);
        }

        $studentModel = new SxdStudentInfo();
        $fields = "a.*,s.is_quarter,s.is_del";
        $studentList = $studentModel->alias("s")
            ->join("admin a","s.ad_uid = a.ad_uid")
            ->where(['s.ad_uid'=>['in',implode(",",$idsList)],'is_quarter' => SxdStudentInfo::QUARTER_WAIT])
            ->field($fields)
            ->select()
            ->toArray();

        // 判断学生数目是否匹配
        if( empty($studentList) || count($studentList) != count($idsList))
        {
            return json(['status=>0','msg'=>'学生信息不存在或学生已经分配过房间，请刷新页面']);
        }

        /*
         * 判断宿舍入住学生性别
         * 2、宿舍未安排学生，不判断宿舍的学生性别，只判断入住人员性别
         * 3、宿舍已经入住学生。判断宿舍的学生性别和入住人员性别
         */

        /* 判断入住学生的性别是否一致 */
        $studentSex = $errCampus = [] ;
        foreach ( $studentList as $value )
        {
            if ( isset($studentSex[$value['ad_sex']]) )
            {
                $studentSex[$value['ad_sex']] += 1;
            }
            else
            {
                $studentSex[$value['ad_sex']] = 1;
            }
            if($dormitoryInfo['campus_id'] != $value['cp_id']){
                array_push($errCampus, $value);
            }
        }
        iF($errCampus){
            return json(['status' => 0, 'msg' => '分配对象的校区必须一致']);
        }

        if ( count($studentSex) > 1)
        {
            return json(['status=>0','msg'=>'分配不合理，男女不能分配到一个房间']);
        }

        /* 判断入住学生的性别和已经入住宿舍的学生性别 */
        if ( $stayStudentTotal != 0 )
        {
            // 已入住学生的性别
            $stayStudentSex = $stayStudentList[0]['sex'];
            if ( !isset($studentSex[$stayStudentSex]) )
            {
                return json(['status=>0','msg'=>'宿舍已经分配了'.$sexList[$stayStudentSex].'生，男女不能分配到一个房间']);
            }
        }

        /* 学生入住分配 */
        $saveDataList =[];
        foreach($studentList as $val)
        {
            $saveDataList[] = [
                'ad_uid' => $val['ad_uid'],
                'student_num' => $val['ad_num'],
                'name' => $val['ad_sname'],
                'sex' => $val['ad_sex'],
                'campus_id' => $dormitoryInfo['campus_id'],
                'build_id' => $dormitoryInfo['build_id'],
                'floor_id' => $dormitoryInfo['floor_id'],
                'dormitory_id' => $dormitoryId,
                'grade_id' => $val['gd_id'],
                'class_id' => $val['cl_id'],
                'phone' => $val['ad_tel'],
                'idcard' => $val['ad_identify'],
                'record_date' =>time(),
            ];
        }

        $dmstayModel = new DmStay();
        if($saveDataList){

            Db::startTrans();
            try {

                $dmstayModel->saveAll($saveDataList);

                //更新用户附属表分配字段
                $res = $studentModel->where(['ad_uid'=>['in',implode(",",$idsList)]])
                    ->update(['is_quarter'=>SxdStudentInfo::QUARTER_SUCCESS]);

                if( $res !== false)
                {
                    Db::commit();
                    return json(['status' => 1, 'msg' => '分配宿舍成功!']);
                }
                else
                {
                    return json(['status' => 0, 'msg' => '网络问题,请重新提交!']);
                }

            } catch (\Exception $e) {

                Db::rollback();
                return json(['status' => 0, 'msg' => '提交失败!']);
            }
        }

        return json(['status' => 0, 'msg' => '分配失败！']);
    }
}