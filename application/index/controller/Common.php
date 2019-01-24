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
        if ( !$this->_checkAuth(Cookie::get('token'),Cookie::get('rs_id')) )
        {
            //  没有权限
            $this->error('您没有该菜单的操作权限。');
        }


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
//                $authList = model("auth")->where(['au_id' => ['in',implode(",",$authIds)],'au_son' => Config::get('sso_config')['au_son']])
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

        $count = $this->model->count();
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

}
