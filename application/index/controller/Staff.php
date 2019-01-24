<?php
namespace app\index\controller;
use app\index\model\Admin;
use think\Db;
use app\index\model\JzgUserInfo;
class Staff  extends Common
{
    private $_roleId = 8; // 教职工的角色ID
    private $_sex = [
        1 => '男',
        2 => '女',
        3 => '未知'
    ];

    //员工管理
    protected function _initialize() {
        $this->model = new \app\index\model\Admin;
        $this->order = 'id desc';
        $this->vd = 'Staff';
        parent::_initialize();
    }


    /**
     * @description  员工列表展示
     * @author Lang
     */
    public function index()
    {
        $where = [];
        $paramData = [
            'ad_sname' => trim($this->req->param('ad_sname')),
            'ad_num' => trim($this->req->param('ad_num')),
            'profession' => trim($this->req->param('profession'))
        ];

        if ( $paramData['ad_sname'] != '' )
        {
            $where['ad_sname'] = ['like', "%{$paramData['ad_sname']}%"];
        }

        if ( $paramData['ad_num'] != '' )
        {
            $where['ad_num'] = ['like', "%{$paramData['ad_num']}%"];
        }

        if ( $paramData['profession'] != '' )
        {
            $where['profession'] = ['like', "%{$paramData['profession']}%"];
        }

        list($list,$page) = $this->_getStaffList($where);

        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->assign('paramData',$paramData);
        $this->assign('sexList',$this->_sex);
        return $this->fetch();
    }

    /**
     * @description 职工添加操作
     * @author Lang
     */
    public function add()
    {
        $where = [];
        $paramData = [
            'ad_sname' => trim($this->req->param('ad_sname')),
            'ad_num' => trim($this->req->param('ad_num')),
            'profession' => trim($this->req->param('profession'))
        ];

        if ( $paramData['ad_sname'] != '' )
        {
            $where['ad_sname'] = ['like', "%{$paramData['ad_sname']}%"];
        }

        if ( $paramData['ad_num'] != '' )
        {
            $where['ad_num'] = ['like', "%{$paramData['ad_num']}%"];
        }

        if ( $paramData['profession'] != '' )
        {
            $where['profession'] = ['like', "%{$paramData['profession']}%"];
        }

        list($list,$page) = $this->_getStaffList($where);

        $this->assign('list',$list);
        $this->assign('page',$page);
        $this->assign('paramData',$paramData);
        $this->assign('sexList',$this->_sex);
        return $this->fetch();
    }

    /**
     * @description 根据条件获取职工列表
     * @author Lang
     * @param array $where
     * @return array
     */
    private function _getStaffList($where = [])
    {
        $where['rs_id'] = $this->_roleId;
        $field = 'a.ad_uid,a.ad_num,a.ad_sname,a.ad_sex,a.ad_tel,a.ad_identify,b.id,b.user_id,b.contact_address,b.department,b.profession,b.into_time,b.out_time';
        $list = $this->model->alias('a')
            ->join('jzg_user_info b','a.ad_uid= b.user_id')
            ->where($where)
            ->field($field)
            ->paginate($this->pagesize);
        $page = $list->render();

        return [$list->toArray(),$page];
    }


    /**
     * @description 获取职工的个人信息
     * @author Lang
     * @return \think\response\Json
     */
    public function getInfo()
    {
        if($this->req->isPost())
        {
            /* 判断请求的参数是否合法 */
            $id = intval($this->req->post('id'));
            if ( $id == 0 )
            {
                return json(['status' => 0, 'msg' => '请选择需要编辑的职工！']);
            }

            /* 判断员工信息是否存在 */
            $fields = "a.ad_uid,a.ad_num,a.ad_sname,a.ad_sex,a.ad_tel,a.ad_identify,
                i.department,i.profession,FROM_UNIXTIME(i.into_time,'%Y-%m-%d'),FROM_UNIXTIME(i.out_time,'%Y-%m-%d'),i.contact_address";
            $userInfo = model('admin')->alias("a")
                ->field($fields)
                ->join("jzg_user_info i","i.user_id = a.ad_uid",'left')
                ->where(['a.ad_uid' => $id,'a.rs_id' => $this->_roleId])
                ->find();

            if ( !$userInfo )
            {
                return json(['status' => 0, 'msg' => '该职工不存在！']);
            }

            return json(['status' => 1, 'msg' => '获取成功','data' =>$userInfo ]);
        }

        return json(['status' => 0, 'msg' => '编辑失败！']);
    }


    /**
     * @description 职工信息的更新和添加
     * @author Lang
     * @return \think\response\Json
     */
    public function updateStaff()
    {
        if($this->req->isPost())
        {
            $adUid = $this->req->post("ad_uid");

            /* 请求参数 */
            $adminData = [
                'ad_num' => trim($this->req->post("ad_num")),
                'ad_sname' => trim($this->req->post("ad_sname")),
                'ad_sex' => intval($this->req->post("ad_sex")),
                'ad_tel' => trim($this->req->post("ad_tel")),
                'ad_identify' => trim($this->req->post("ad_identify"))
            ];

            $userData = [
                'department' => trim($this->req->post("department")),
                'profession' => trim($this->req->post("profession")),
                'into_time' => strtotime(trim($this->req->post("into_time"))),
                'out_time' => strtotime(trim($this->req->post("out_time"))),
                'contact_address' => trim($this->req->post("contact_address")),
            ];

            /* 规则验证 */
            if($this->vd != '')
            {
                if ( $adUid > 0  )
                {
                    $result = $this->validate($userData,$this->vd.'.info');
                    if(!$result)
                    {
                        return json(['status' => 0, 'msg' => $result]);
                    }
                }
                else
                {
                    $result = $this->validate($adminData,$this->vd.'.admin');
                    if(!$result)
                    {
                        return json(['status' => 0, 'msg' => $result]);
                    }
                }
            }

            /* 更新和添加操作 */
            $jzgUserModel = new JzgUserInfo;
            Db::startTrans();
            try {

                if ( $adUid > 0 )
                {

                    // 编辑操作
                    $resAdmin = $this->model->where(['ad_uid'=>$adUid])->update($adminData);
                    $resUser = $jzgUserModel->where(['user_id'=>$adUid])->update($userData);
                }
                else
                {
                    // 新增操作
                    $adminData['rs_id'] = $this->_roleId;
                    $this->model->data($adminData);
                    $resAdmin = $this->model->save();

                    if ( $resAdmin !== false )
                    {
                        // 职工的附表
                        $userData['user_id'] = $this->model->ad_uid;
                        $jzgUserModel->data($userData);
                        $resUser = $jzgUserModel->save();
                    }
                    else
                    {
                        $resUser = $resAdmin;
                    }
                }

                if(  $resAdmin !== false &&  $resUser!== false)
                {
                    Db::commit();
                    return json(['status' => 1, 'msg' => $adUid > 0? '更新成功': '添加成功']);
                }
                else
                {
                    return json(['status' => 0, 'msg' => '网络问题,请重新提交!']);
                }

            } catch (\Exception $e) {
                Db::rollback();
                return json(['status' => 0, 'msg' => $adUid > 0? '更新失败': '添加失败']);
            }
        }

        return json(['status' => 0, 'msg' => '保存失败！']);
    }


    /**
     * @description 删除员工操作
     * @author Lang
     * @return \think\response\Json
     */
    public function delStaff()
    {
        if($this->req->isPost())
        {
            $id = intval($this->req->post("id"));

            /* 参数筛选 */
            if ( !$id )
            {
                return json(['status' => 0, 'msg' => '请选择需要删除的员工！']);
            }

            // 判断员工是否存在
            $adminInfo = Admin::get($id);
            if ( !$adminInfo )
            {
                return json(['status' => 0, 'msg' => '删除的员工不存在！']);
            }

            Db::startTrans();
            try {
                /* 删除操作 */
                if (  $adminInfo->delete() )
                {
                    $res = model('jzg_user_info')->where('user_id',$id)->delete();

                    if ( $res )
                    {
                        Db::commit();
                        return json(['status' => 1, 'msg' => '删除成功!']);
                    }
                }

                return json(['status' => 0, 'msg' => '网络问题,请重新提交!']);

            } catch (\Exception $e) {
                Db::rollback();
                return json(['status' => 0, 'msg' => '删除失败!']);
            }
        }

        return json(['status' => 0, 'msg' => '删除失败！']);
    }


    /**
     * @description 导入员工信息
     * @author Lang
     * @return mixed
     */
    public function importStaff()
    {
        return $this->fetch();
    }


    /**
     * @description 执行导入操作
     * @author Lang
     */
    public function doImportStaff()
    {
        if($this->req->isPost())
        {
            // 判断是否上传了文件
            if ( $_FILES['file']['error'] > 0 )
            {
                return json(['status' => 0, 'msg' => $_FILES["file"]["error"]]);
            }

            /* 允许的文件格式 */
            $allowType = ['application/vnd.ms-excel','application/octet-stream'];
            if ( !in_array($_FILES['file']['type'],$allowType) )
            {
                return json(['status' => 0, 'msg' => '上传文件格式错误，请上传文件后缀名是xls格式的']);
            }

            $fielExt = substr(strrchr($_FILES['file']['name'], '.'), 1); // 获取文件的后缀名
            if ( !in_array($fielExt,['xls','xlsx']) )
            {
                return json(['status' => 0, 'msg' => '上传文件格式错误，请上传文件后缀名是xls格式的。']);
            }

            // 判断临时文件是否存在
            if ( !is_uploaded_file($_FILES["file"]["tmp_name"]) )
            {
                return json(['status' => 0, 'msg' => '上传文件失败。']);
            }

            // 本地的文件名
            $fileName = date('YmdHi').rand(1000,9999);

            // 本地的文件路劲
            $filePath=ROOT_PATH . 'public'.DS.'upload'.DS.$fileName.'.'.$fielExt;

            if ( file_exists($filePath) )
            {
                chmod($filePath,0777);
            }

            // 临时文件移动到本地
            if ( !move_uploaded_file($_FILES["file"]["tmp_name"],$filePath))
            {
//                unlink($filePath);
                return json(['status' => 0, 'msg' => '上传文件失败。']);
            }

            /* 解析execl文件 */
            if ($fielExt =='xlsx')
            {
                $phpReader = new \PHPExcel_Reader_Excel2007();
            }
            else if ($fielExt =='xls')
            {
                $phpReader = new \PHPExcel_Reader_Excel5();
            }
            else if ($fielExt=='csv')
            {
                $phpReader = new \PHPExcel_Reader_CSV();

                //默认输入字符集
                $phpReader->setInputEncoding('utf-8');
                //默认的分隔符
                $phpReader->setDelimiter(',');
            }

            $PHPExcel = $phpReader->load($filePath);

            /* 获取一张sheet */
            $currentSheet = $PHPExcel->getSheet(0);

            /*获取表里内容的最大列数*/
            $allColumn = $currentSheet->getHighestColumn();

            /*获取表里内容的最大行数*/
            $allRow = $currentSheet->getHighestRow();

            $saveData = [];
            $title = [
                'A' => 'ad_num',
                'B' => 'ad_sname',
                'C' => 'ad_sex',
                'D' => 'ad_tel',
                'E' => 'ad_identify',
                'F' => 'contact_address',
                'G' => 'department',
                'H' => 'profession',
                'I' => 'into_time',
                'J' => 'out_time'
            ];
            /* 从第二列读取信息 */
            for ($currentRow = 2; $currentRow <= $allRow; $currentRow++)
            {
                for($currentColumn= 'A'; $currentColumn<= $allColumn; $currentColumn++)
                {
                    $address = $currentColumn.$currentRow;
                    $val = $currentSheet->getCell($address)->getValue();
                    $saveData[$currentRow - 2][$title[$currentColumn]] = trim($val);
                }
            }

            // 删除源文件
            unlink($filePath);

            /* 对execl的数据，做处理 */
            if ( count($saveData) == 0 )
            {
                return json(['status' => 0, 'msg' => '没有需要导入的员工信息。']);
            }

            $sex = [
                '男' => 1,
                '女' => 2
            ];

            /*
             * 1、如果性别未匹配到，赋值3，表示未知
             * 2、入职时间和离职时间转换成1970年以来的秒数
             */
            foreach ( $saveData as $key => $value )
            {
                if ( $value['ad_num'] && $value['ad_sname'])
                {
                    $value['ad_sex'] = isset($sex[$value['ad_sex']]) ? $sex[$value['ad_sex']] : 3;
                    if ( $value['into_time'] != '')
                    {
                        $value['into_time'] = intval(($value['into_time'] - 25569) * 3600 * 24);
                    }

                    if ( $value['out_time'] != '')
                    {
                        $value['out_time'] = intval(($value['out_time'] - 25569) * 3600 * 24);
                    }

                    $saveData[$key] = $value;
                }
                else
                {
                    // 学号和姓名不能为空
                    unset($saveData[$key]);
                }
            }

            if ( count($saveData) == 0 )
            {
                return json(['status' => 0, 'msg' => '没有需要导入的员工信息。']);
            }

            /* 执行导入操作 */
            $successTotal = 0;
            $failureList = [];

            $jzgUserCloneModel = new JzgUserInfo();
            $adminConleModel = new Admin();

            foreach ( $saveData as $value )
            {
                $jzgUserModel = clone $jzgUserCloneModel;
                $adminModel = clone $adminConleModel;

                $adminData = [
                    'ad_num' => $value['ad_num'],
                    'ad_sname' => $value['ad_sname'],
                    'ad_sex' => $value['ad_sex'],
                    'ad_tel' => $value['ad_tel'],
                    'ad_identify' => $value['ad_identify'],
                    'rs_id' => $this->_roleId
                ];

                $userData = [
                    'department' => $value['department'],
                    'profession' => $value['profession'],
                    'into_time' => $value['into_time'],
                    'out_time' => $value['out_time'],
                    'contact_address' => $value['contact_address']
                ];

                Db::startTrans();
                try {

                    // 新增操作
                    $result = $this->validate($adminData,$this->vd.'.admin');
                    if($result)
                    {
                        $adminModel->data($adminData);
                        $resAdmin = $adminModel->save();

                        if ( $resAdmin !== false )
                        {
                            // 职工的附表
                            $userData['user_id'] =$adminModel->ad_uid;
                            $jzgUserModel->data($userData);
                            $resUser = $jzgUserModel->save();

                            if ( $resUser !== false)
                            {
                                Db::commit();
                                $successTotal++;
                                continue;
                            }
                            else
                            {
                                $failureList[] = [
                                    'ad_num' => $adminData['ad_num'],
                                    'ad_sname' => $adminData['ad_sname'],
                                    'error' => $jzgUserModel->getError()
                                ];
                            }
                        }
                        else
                        {
                            $failureList[] = [
                                'ad_num' => $adminData['ad_num'],
                                'ad_sname' => $adminData['ad_sname'],
                                'error' => $adminModel->getError()
                            ];
                        }
                    }
                    else
                    {
                        $failureList[] = [
                            'ad_num' => $adminData['ad_num'],
                            'ad_sname' => $adminData['ad_sname'],
                            'error' => $result
                        ];
                    }

                } catch (\Exception $e) {
                    Db::rollback();
                    $failureList[] = [
                        'ad_num' => $adminData['ad_num'],
                        'ad_sname' => $adminData['ad_sname'],
//                        'error' => $e->getMessage()
                    ];
                }
            }

            $responseData = [
                'list' => $failureList,
                'successTotal' => $successTotal,
                'failureTotal' => count($failureList)
            ];
            return json(['status' => 1, 'msg' => '操作成功。','data' => $responseData]);
        }
    }


    /**
     * @description 实例下载
     * @author Lang
     */
    public function example()
    {
        $id = $this->req->param('id');
        switch($id)
        {
            case 1:
                //员工信息导入模板
                $fileName = '员工信息导入模板.xlsx';
                $filePath=ROOT_PATH.'public/static/temple.xlsx';
                break;
            case 2:
                // 员工信息数据实例文件
                $fileName = '员工信息数据实例文件.xlsx';
                $filePath=ROOT_PATH.'public/static/demo.xlsx';
                break;
             default:
                $fileName = '员工信息导入模板.xlsx';
                $filePath=ROOT_PATH.'public/static/demo.xlsx';
                break;
        }

        $contents = file_get_contents($filePath);
        $fileSize = filesize($filePath);
        header("Content-type: application/octet-stream;charset=utf-8");
        header("Accept-Ranges: bytes");
        header("Accept-Length: $fileSize");
        header("Content-Disposition: attachment; filename=".$fileName);
        exit($contents);
    }
}
