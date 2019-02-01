<?php
namespace app\index\controller;
use think\Cache;
use think\Config;
use think\console\command\Clear;
use think\Cookie;
use think\Request;
use think\Controller;
use think\Loader;
class Common extends Controller
{

    protected $pk = NULL;            //主键
    protected $model = NULL;            //模型
    protected $vd = '';                //验证器

    protected $search = ['id' => ['>', 0]];    //where搜索条件 []
    protected $order = '';    //排序条件 []

    protected $req = NULL;            //请求对象
    protected $pagesize = 15;            //分页条数

    protected $with = NUll;         //关联对象


    /**
    * 初始化
    */
    protected function _initialize()
    {
        // 检查是否已经登录

        if ( !$this->_checkLogin() )
        {
            // 未登录跳转到主站
            $this->redirect(Config::get('sso_config')['site_url'].'?directurl=' . "http://" . $_SERVER['HTTP_HOST']);
        }

        // 检查权限
        // if ( !$this->_checkAuth(Cookie::get('token'),Cookie::get('rs_id')) )
        // {
        //     //  没有权限
        //     $this->error('您没有该菜单的操作权限。');
        // }


        if($this->model == NULL)
        {
            echo 'Please set a model!';
            exit;
        }

        if($this->pk == NULL){
            $this->pk = 'id';
        }

        $this->req = Request::instance();

        $this->assign('loginName',Cookie::get('ad_name'));
//        $this->assign('avatarImg',Cookie::get('ad_photo'));
        $this->assign('avatarImg','');
        $this->assign('logoutUrl',Config::get('sso_config')['logout_url']);
        parent::_initialize();
        $roleModel = new \app\index\model\Roles;
        $sysModel = new \app\index\model\Sysmodule;
        $rolesAlls = $roleModel->getAllDatas('','rs_id,rs_pid,rs_name')->toArray();

        $rolesAllParam = searchRelationIds(Cookie::get('rs_id'), $rolesAlls, 'rs_pid', 'rs_id', false);
        $auths = $this->sysList(end($rolesAllParam));
        $systemModel = $sysModel->getAuthSon($auths);
        $systemModel? $systemModel: [];
        $this->assign('systemModel', $systemModel);
    }


    /**
     * @description  检查是否登录
     * @author Lang
     * @return bool false - 未登录 ，true-登录
     */
    private function _checkLogin()
    {
        $token = trim($this->request->param('token'));
        if( Cookie::get("token") || $token != '')
        {
            if ( $token == '' )
            {
                $token = Cookie::get("token");
            }
            $res = requestPost(Config::get('sso_config')['login_url'],['token' => $token]);
            $res = json_decode($res,true);

            if ( isset($res['code']) && $res['code'] == 1)
            {
                if ( $token != '' )
                {
                    Cookie::set('token',$token);
                    Cookie::set('ss_id',$res['data']['ss_id']);
                    Cookie::set('ad_uid',$res['data']['ad_uid']);
                    Cookie::set('ad_num',$res['data']['ad_num']);
                    Cookie::set('ad_name',$res['data']['ad_name']);
                    Cookie::set('rs_id',$res['data']['rs_id']);
                    Cookie::set('ad_sex',$res['data']['ad_sex']);
                    Cookie::set('ad_status',$res['data']['ad_status']);
//                    $adminInfo = model('admin')->find(Cookie::get('ad_uid'));
//                    Cookie::set('ad_photo',$adminInfo->ad_photo);

                    return true;
                }
            }
        }

        /* 未登录清楚cookie和cache */
        Cookie::clear();
        Cache::clear();
        return false;
    }


    private function _checkAuth($token,$rsId)
    {
        // 读取权限的缓存是否存在
        $authList = json_decode(Cache::get(Config::get('cache_key')['auth']),true);
        // $authList = '';
        // 缓存不存在
        if ( empty($authList) )
        {
            /* 获取用户对应角色的所有权限ID */
            $roleList = model("roles")->select()->toArray();
            if ( count($roleList)  > 0 )
            {
                $temp = [];
                foreach ( $roleList as $value )
                {
                    $temp[$value['rs_id']] = $value;
                }
                $roleList = $temp;

                /* 获取所有的的权限列表 */
                $authIds = [];
                $roleId = $rsId;
                while ( $roleId != 0 )
                {
                    if ( isset($roleList[$roleId]) )
                    {
                        $authIds[] = $roleList[$roleId]['rs_auth'];
                        $roleId = $roleList[$roleId]['rs_pid'];
                    }
                    else
                    {
                        $roleId = 0;
                    }
                }

                /* 获取所有的权限 */
            //    $authList = model("auth")->where(['au_id' => ['in',implode(",",$authIds)],'au_son' => Config::get('sso_config')['au_son']]);
                 $authList = model("auth")->where(['au_son' => Config::get('sso_config')['au_son']])
                    ->field("au_id,au_pid,au_authurl,au_otherprivileges")
                    ->select()
                    ->toArray();

                Cache::set('auth',json_encode($authList),3600);//存储缓存
            }
        }

        /* 检查当前用户是否有该菜单的操作权限 */
        // 获取当前的访问路径
        $request = Request::instance();
        $module = $request->module();
        $controller = $request->controller();
        $action = $request->action();

        $requstAction = strtolower($module . '/' . $controller . '/' . $action); //操作字符串

        $temp = [];
        foreach ( $authList as $value )
        {
            $temp[$value['au_authurl']] = $value;
        }

        $authList = $temp;

        if ( isset($authList[$requstAction]) )
        {
            // 有权限
            return true;
        }
        else
        {
            // 无权限
            return false;
        }
    }


    /**
    * 列表展示页面
    */
    public function index() {

        $list = $this->model->with($this->with)->where($this->search)->order($this->order)->paginate($this->pagesize);
        $page = $list->render();

        //数据列表
        $this->assign('list',$list);

        //分页标签
        $this->assign('page',$page);
        //搜索条件保存
        $this->assign('search',$this->search);

        $count = $this->model->where($this->search)->count();
        $this->assign('count',$count);
        //渲染模板
        return $this->fetch();
    }


    /**
    * 新增页面
    */
    public function add() {
        return $this->fetch();
    }

    /**
    * 添加数据
    * @param  post form表单字段集合
    * @return json
    */
    public function insert() {

        if($this->req->isPost()){
            $data = $this->req->post();

            //加载模型验证
            if($this->vd != '') {

                $result = $this->validate($data,$this->vd.'.add');

                if(1 != $result) {
                    return json(['status' => 0, 'msg' => $result]);
                }
            }

            if($this->model->allowField(true)->save($data)) {

                return json(['status' => 1, 'msg' => '保存成功！']);
            }
        }

        return json(['status' => 0, 'msg' => '保存失败！']);
    }

    /**
    * 编辑页面
    * @param get id
    */
    public function edit() {
        $list = $this->model->with($this->with)->where($this->search)->order($this->order)->paginate($this->pagesize);
        $page = $list->render();

        //数据列表
        $this->assign('list',$list);

        //分页标签
        $this->assign('page',$page);
        //搜索条件保存
        $this->assign('search',$this->search);

        $count = $this->model->count();
        $this->assign('count',$count);
        //渲染模板
        return $this->fetch();
    }

    /**
     * 根据ID获取数据
     * @return \think\response\Json
     */
    public function getInfo(){
        if($this->req->isPost()) {
            $id = $this->req->post('id');
            $vo = $this->model->find($id);

            return json(['status' => 1, 'msg' => '获取成功','data'=>$vo]);
        }

        return json(['status' => 0, 'msg' => '获取失败！']);
    }

    /**
    * 更新数据
    * @param  post form表单字段集合
    * @return json
    */
    public function update() {
        if($this->req->isPost()) {
            $data = $this->req->post();

            //加载模型验证
            if($this->vd != '') {

                $result = $this->validate($data,$this->vd.'.save');
                if(1 != $result) {
                    return json(['status' => 0, 'msg' => $result]);
                }
            }

            if(empty($data['id'])){
                return json(['status' => 0, 'msg' => '请先点击编辑在修改！']);
            }

            //更新数据
            if($this->model->allowField(true)->save($data, [$this->pk => $data['id']]) !== false ){

                return json(['status' => 1, 'msg' => '更新成功！']);
            }

        }

        return json(['status' => 0, 'msg' => '更新失败！']);
    }

    /**
    * 删除数据
    * @param id     1, [1,2,3]
    * @return json
    */
    public function delete() {
        if($this->req->isGet() || $this->req->isPost()) {
            $data = $this->req->Request();
            $id = $data['id'];
            $id = is_array($id) ? implode(',', $id) : $id;
            if($this->model->where('id','in',$id)->delete()) {

                return json(['status' => 1, 'msg' => '删除成功！']);
            }
        }
        return json(['status' => 0, 'msg' => '删除失败！']);
    }

    /**
    * 更新字段值(status | sort | commend)
    * @param id     主键值
    * @param field  字段名
    * @param fvalue 字段值
    * @return json
    */
    public function setfield() {

        if($this->req->isGet() || $this->req->isPost()) {
            $data = $this->req->Request();

            $id = $data['id'];
            $field = $data['field'];
            $fvalue = $data['fvalue'];
            $m = $this->model->get($id);

            if($m) {
                $m->$field = $fvalue;
                if($m->save() !== false) {

                    return json(['status' => 1, 'msg' => '更新成功！']);
                }
            }
        }
        return json(['status' => 0, 'msg' => '更新失败！']);
    }

    /**
     * 恢复删除数据
     * @param id
     * @return json
     */
    public function reduction(){
        if($this->req->isGet() || $this->req->isPost()) {
            $data = $this->req->Request();
            $id = $data['id'];
            $id = is_array($id) ? implode(',', $id) : $id;
            if($this->model->where('id','in',$id)->update(['status' => 1])) {

                return json(['status' => 1, 'msg' => '恢复成功！']);
            }
        }
        return json(['status' => 0, 'msg' => '恢复失败！']);
    }

    /**
	 * exportExcel
	 * @param $xlsTitle exceltitle
	 * @param $cellData tablehead
	 * @param $data tabledata
	 * @param $type exceltype
	 * @author mupeng <1912959071@qq.com>
	 */
	protected function exportExcel($xlsTitle, $cellData, $data, $type = 'Excel5'){
		$suffix = $type == 'Excel5'? 'xls': 'xlsx';
		$fileName = date('YmdHis').'.'.$suffix;
		\think\Loader::import('phpexcel.PHPExcel');
		$oPhpExcel = new \PHPExcel();
		$cellNum = count($cellData);
		$cellName = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'];
		//所有单元格（行）默认高度
		$oPhpExcel->getActiveSheet(0)->getDefaultRowDimension()->setRowHeight(25);
		$objSheet = $oPhpExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1'); //合并单元格,并且获得当前活动的sheet
		//设置文字居左（HORIZONTAL_LEFT，默认值）中（HORIZONTAL_CENTER）右（HORIZONTAL_RIGHT）
		$oPhpExcel->setActiveSheetIndex(0)->setCellValue('A1', $xlsTitle)->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		// 设置字体大小
		$objSheet->getStyle('A1')->getFont()->setSize(18);
		// 设置字体加粗
		$objSheet->getStyle('A1')->getFont()->setBold(true);
		// 设置标题
		$objSheet->setTitle($xlsTitle);
		// 表头数据处理
		foreach($cellData as $k=>$val){
			// 设置每一列宽度
			$objSheet->getColumnDimension($cellName[$k])->setWidth(16);
			$objSheet->getStyle('A1')->getFont()->setSize(16);
			// 设置水平居中和垂直居中
			$objSheet->getStyle($cellName[$k].'2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			// 设置数据
			$oPhpExcel->getActiveSheet(0)->setCellValue($cellName[$k].'2', $val[0])->getStyle($cellName[$k].'2')->getFont()->setBold(true);
		}
		// 表数据处理
		foreach($data as $key => $v){
			foreach($cellData as $key2 => $v2){
				$objSheet->getStyle($cellName[$key2].($key+'3'))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objSheet->getStyle($cellName[$key2].($key+'3'))->getFont()->setSize(12);
				$oPhpExcel->getActiveSheet(0)->setCellValue($cellName[$key2].($key+'3'), $v[$v2[1]]);	
			}
		}
		// 告诉浏览器的输出类型
		$type == 'Excel5'? header('Content-Type: application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"'): header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');;
		// 告诉浏览器输出文件的名称，attachment新窗口打印inline本窗口打印
		header('Content-Disposition: attachment;filename="'.$fileName.'"');
		// 禁止缓存
		header('Cache-Control: max-age=0');
		$objWriter = \PHPExcel_IOFactory::createWriter($oPhpExcel, $type);
    	$objWriter->save('php://output');
		exit;
	}

	/**
	 * importExcel
	 * @author mupeng <1912959071@qq.com>
	 */
	protected function importExcel($file, $headCount = 3){
		$path = realpath($_SERVER['DOCUMENT_ROOT'].$file);
		if(!file_exists($path)){
			return returnJson('导入文件不存在', -2, '', true);
		}
		\think\Loader::import('phpexcel.PHPExcel');
		$objReader = stristr($path, '.xlsx') === false? \PHPExcel_IOFactory::createReader('Excel5'): \PHPExcel_IOFactory::createReader('Excel2007');
		$phpReader = $objReader->load($path);
		if(!isset($phpReader)) return returnJson('文件导入失败', 0, '', true);
		$worksheet = $phpReader->getAllSheets();
		// 处理数据对象
		foreach($worksheet as $val){
			// 获取表头
			$sheetTitle = $val->getTitle();
			// 获取行数(包括表头)
			$totalRows = $val->getHighestRow();
			// 获取总列数
			$sCols = $val->getHighestColumn();
			$totalCols = \PHPExcel_Cell::columnIndexFromString($sCols);
			$arr = [];
			for ($currentRow=1; $currentRow<=$totalRows; $currentRow++){
				$row = [];
				for ($currentColumn=0; $currentColumn<$totalCols; $currentColumn++){
					$cell =$val->getCellByColumnAndRow($currentColumn, $currentRow);
					$afCol = \PHPExcel_Cell::stringFromColumnIndex($currentColumn+1);
					$bfCol = \PHPExcel_Cell::stringFromColumnIndex($currentColumn-1);
					$col = \PHPExcel_Cell::stringFromColumnIndex($currentColumn);
					$address = $col.$currentRow;
					$value = $val->getCell($address)->getValue();
					// 不能使用公式
					if (substr($value,0,1) == '=') exit(returnJson('不能使用公式', 0, '', true));
					if ($cell->getDataType() == \PHPExcel_Cell_DataType::TYPE_NUMERIC){
						$cellstyleformat = $cell->getStyle($cell->getCoordinate())->getNumberFormat();
						$formatcode = $cellstyleformat->getFormatCode();
						if (preg_match('/^([$[A-Z]*-[0-9A-F]*])*[hmsdy]/i', $formatcode)){
							$value = gmdate("Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($value));
						}else{
							$value = \PHPExcel_Style_NumberFormat::toFormattedString($value, $formatcode);
						}
					}

					if (is_object($value)){
						$value = $value->__toString();
					}
					$row[$currentColumn] = $value;
				}
				$arr[$currentRow] = $row;
			}
			unset($worksheet);
			unset($objReader);
			unset($phpReader);
			for($i = 0; $i< $headCount; $i++){
				array_shift($arr);
			}
			return ['totalrows' => count($arr), 'totalcols' => $totalCols, 'title' => $sheetTitle, 'data' => $arr];
		}
    }
    private function sysList($auth){
		$data = 1;
		switch($auth){
			case 1:
				$data = '2,3,4';
				break;
			case 2:
				$data = '4';
				break;
			case 3:
				$data = '2';
				break;
			case 4:
				$data = '3';
		}
		return $data;
	}

}
