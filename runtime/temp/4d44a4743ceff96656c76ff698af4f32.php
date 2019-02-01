<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:42:"../application/index/tpl/repair\index.html";i:1549019525;s:71:"C:\charles\PHPTutorial\WWW\drom\application\index\tpl\index\header.html";i:1548765601;s:69:"C:\charles\PHPTutorial\WWW\drom\application\index\tpl\index\menu.html";i:1548765601;s:71:"C:\charles\PHPTutorial\WWW\drom\application\index\tpl\index\footer.html";i:1548765601;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>home</title>
    <link rel="stylesheet" href="/static/js/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/common.css">
    <link rel="stylesheet" href="/static/css/header.css">
    <link rel="stylesheet" href="/static/css/main.css">
    <link rel="stylesheet" href="/static/css/c_page.css">
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body .c-layer-class .layui-layer-btn .layui-layer-btn0{
            background:#335da7;color:#fff;
        }
    </style>
</head>

<body class="layui-layout-body">
        <div style='' class='row clearfix basic-desktop-container'>
                <div class='topbar-box default-style-color col-lg-12'>
                    <div class='menu-btn'>
                        <span class='icon-menu'></span>
                            <ul class='menu-child-list hide'>
                                <?php if(is_array($systemModel) || $systemModel instanceof \think\Collection || $systemModel instanceof \think\Paginator): if( count($systemModel)==0 ) : echo "" ;else: foreach($systemModel as $key=>$vo): ?>
                                <li><a href="<?php echo $vo['sd_url']; ?>"><?php echo $vo['sd_name']; ?></a></li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>    
                    </div>
                    <div class='topbar col-lg-12 clearfix'>
                        <div style='' class='pull-left'>
                            <h3 style='margin-left:70px;font-size:24px;color:#f5f5f5'>欢迎来到<?php echo \think\Config::get('sushe_text'); ?></h3>
                        </div>
                        <div class='pull-right '>
                            <div class='user-box'>
                                <a href="<?php echo \think\Config::get('sso_config.base_url'); ?>/home/index/usermodify" style="color:#fff;">
                                    <span class='icon-user'></span>
                                </a>
                                <a href="<?php echo \think\Config::get('sso_config.base_url'); ?>/admin/index/index" style="color:#fff;">
                                    <span class='welcome'>欢迎您，<?php echo $loginName; ?></span>
                                </a>
                            </div>
                            <span class='c-line-1'>|</span>
                            <div class='topbar-btn-list'>
                                <span class='btn-item icon-email'></span>
                                <span class='btn-item icon-question'></span>
                                <span class='btn-item icon-skin'></span>
                                <a href="<?php echo $logoutUrl; ?>"><span id='login_out'  class='btn-item icon-close t'></span></a>
                            </div>
                        </div>
                    </div>
                </div>
               
                
          
                
            </div>
<!-- <div class="layui-layout layui-layout-admin">
    <div class="layui-header c-header">
        <span class='icon-menu'></span>
        <div class="layui-logo c-logo">宿舍管理系统</div> -->
        <!-- 头部区域 -->
        <!-- <span class='head-line-1'></span>
        <span class='logo-ps'>科迅软件</span>
        <ul class="layui-nav layui-layout-right nav-user">
            <li  class="layui-nav-item"> -->
                <!-- <a href="javascript:;" class='username'> -->
                    <!--<img src="<?php echo $avatarImg!=''?$avatarImg : ''; ?>http://t.cn/RCzsdCq" class="layui-nav-img">-->
                    <!-- 您好 , <?php echo $loginName; ?> -->
                <!-- </a> -->
                <!--<dl class="layui-nav-child top-nav-child">-->
                    <!--<dd><a href="">基本资料</a></dd>-->
                    <!--<dd><a href="">安全设置</a></dd>-->
                <!--</dl>-->
            <!-- </li>
            <span class='c-s-line'></span>
            <li class="layui-nav-item layui-nav-item-close">
                <a class='icon icon-sign-out' href="<?php echo $logoutUrl; ?>"></a>
            </li>
        </ul>
    </div> -->
<div class="layui-side layui-bg-gray">
    <div class="layui-side-scroll">
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree main-nav-tree"  lay-filter="test">
            <!--<li class="layui-nav-item">-->
                <!--<span class='icon icon-setting'></span>-->
                <!--<a href="javascript:;">系统设置</a>-->
            <!--</li>-->
            <li  style='' class="layui-nav-item">
                <span class='icon icon-xiaoqu'></span>
                <a  class="c-link" data-url="<?php echo url('campus/index'); ?>" href="<?php echo url('campus/index'); ?>">校区管理</a>
            </li>
            <li style='' class="layui-nav-item">
                <span class='icon icon-loudong'></span>
                <a href="javascript:;">楼栋管理</a>
                <dl class="layui-nav-child">
                    <dd><a class="c-link" data-url="<?php echo url('dmbuild/add'); ?>" href="<?php echo url('dmbuild/add'); ?>">楼栋管理</a></dd>
                    <dd><a class="c-link" data-url="<?php echo url('dmfloor/index'); ?>" href="<?php echo url('dmfloor/index'); ?>">楼层管理</a></dd>
                    <dd><a class="c-link" data-url="<?php echo url('dmdormitory/index'); ?>" href="<?php echo url('dmdormitory/index'); ?>">宿舍管理</a></dd>
                </dl>
            </li>
            <li style='' class="layui-nav-item">
                <span class='icon icon-renyuan'></span>
                <a href="javascript:;">人员管理</a>
                <dl class="layui-nav-child">
                    <dd><a class="c-link" data-url="<?php echo url('dmstay/index'); ?>" href="<?php echo url('dmstay/index'); ?>">学生入住</a></dd>
                    <dd><a class="c-link" data-url="<?php echo url('dmbuildmanage/index'); ?>" href="<?php echo url('dmbuildmanage/index'); ?>">楼栋管理员信息</a></dd>
                    <dd><a class="c-link" data-url="<?php echo url('dmdormitorymanage/index'); ?>" href="<?php echo url('dmdormitorymanage/index'); ?>">宿舍管理员信息</a></dd>
                    <dd><a class="c-link" data-url="<?php echo url('bed_manage/index'); ?>" href="<?php echo url('bed_manage/index'); ?>">学生铺位分配</a></dd>
                    <dd><a class="c-link" data-url="<?php echo url('changedormitory/index'); ?>" href="<?php echo url('changedormitory/index'); ?>">换/退宿舍</a></dd>
                    <dd><a class="c-link" data-url="<?php echo url('staff/index'); ?>" href="<?php echo url('staff/index'); ?>">员工管理</a></dd>
                    <dd><a class="c-link" data-url="<?php echo url('visiter/index'); ?>" href="<?php echo url('visiter/index'); ?>">外来人员管理</a></dd>

                </dl>
            </li>
            <li style='' class="layui-nav-item">
                <span class='icon icon-wupin'></span>
                <a href="javascript:;">物品管理</a>
                <dl class="layui-nav-child">
                    <!--<dd><a class="c-link" data-url='' href="javascript:;">公用物品信息</a></dd>-->
                    <dd><a class="c-link" data-url="<?php echo url('repair/index'); ?>" href="<?php echo url('repair/index'); ?>">物品损坏维修管理</a></dd>
                    <dd><a class="c-link" data-url="<?php echo url('honorable/index'); ?>" href="<?php echo url('honorable/index'); ?>">贵重物品进出登记</a></dd>
                </dl>
            </li>
            <!--<li style='' class="layui-nav-item">-->
                <!--<span class='icon icon-guizhang'></span>-->
                <!--<a class="c-link" href="javascript:;">规章制度</a>-->

            <!--</li>-->
            <li style='' class="layui-nav-item">
                <span class='icon icon-lhkh'></span>
                <a href="javascript:;">量化考核管理</a>
                <dl class="layui-nav-child">
                    <dd><a class="c-link" data-url="<?php echo url('assess/index'); ?>" href="<?php echo url('assess/index'); ?>">学生评定管理</a></dd>
                    <dd><a class="c-link" data-url="<?php echo url('dormitoryHygiene/index'); ?>" href="<?php echo url('dormitoryHygiene/index'); ?>">卫生量化考核</a></dd>
                </dl>
            </li>
        </ul>
    </div>
</div>


<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class='route-box'>
            <span class='icon icon-position'></span>
            <span class='title'>当前位置：</span>
            <span>首页</span>
            <span>></span>
            <span><a href="javascript:void(0)">物品损坏维修管理</a></span>
        </div>
        <div class='search-box'>
            <div class="ipt-box">
                <form  action="<?php echo url('repair/index'); ?>" method='post'>
                    <input placeholder="请输入姓名" value="<?php echo $paramData['keywords']; ?>" name="keywords" class='search-ipt' type="text">
                    <span class='icon-search all-search'></span>
                </form>
            </div>
        </div>
        <div style='margin-top:20px;' class='clearfix'>
            <div style='margin-bottom:20px;' class='nav-tab-box p-l'>
                <span class="tab-item on"><a  href="<?php echo url('repair/index'); ?>">故障报修登记</a></span>
                <span class="tab-item"><a  href="<?php echo url('repair/undeal'); ?>">故障报修处理</a></span>
            </div>
        </div>

        <div style='' class='ipt-main-box'>
            <form id="addForm" action="" onsubmit="return false">
                <div class="ipt-box ">
                    <label for="">申报人：</label>
                    <input type="text" class='ipt ipt-xs' name="name">
                </div>
                <div class="ipt-box">
                    <label for="">校区：</label>
                    <select class='ipt-xs select-campus' name="campus_id" >
                        <option value="">请选择</option>
                        <?php if(is_array($campusList) || $campusList instanceof \think\Collection || $campusList instanceof \think\Paginator): $i = 0; $__LIST__ = $campusList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$campusInfo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $campusInfo['cp_id']; ?>" ><?php echo $campusInfo['cp_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>

                    </select>
                </div>
                <div class="ipt-box">
                    <label for="">楼栋名称：</label>
                    <select class='ipt-xs select-build' name="build_id">
                        <option value="">请选择</option>
                    </select>
                </div>
                <div class="ipt-box">
                    <label for="">层数：</label>
                    <select class='ipt-xs select-floor' name="floor_id">
                        <option value="">请选择</option>
                    </select>
                </div>
                <div class="ipt-box">
                    <label for="">房号：</label>
                    <select class='ipt-xs select-dormitory' name="dormitory_id">
                        <option value="">请选择</option>
                    </select>
                </div>

                <div class="ipt-box">
                    <label for="">故障类型：</label>
                    <select class='ipt-xs' name="type">
                        <option value="">请选择</option>
                        <?php if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): $k = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>
                        <option value="<?php echo $k; ?>" ><?php echo $v; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="ipt-box" style="width: 512px;">
                    <label for="">故障内容：</label>
                    <input type="text" class='ipt ipt-xs' name="info" style="width:396px;">
                </div>

                <div class="ipt-box">
                    <label for="">收费：</label>
                    <input type="text" class='ipt ipt-xs' name="charge">
                </div>
                <div class="ipt-box">
                    <label for="">电话：</label>
                    <input type="text" class='ipt ipt-xs' name="phone">
                </div>
                <div class="ipt-box">
                    <label for="">登记日期：</label>
                    <input type="text" class='ipt ipt-xs' name="register_date">
                </div>
                <div class="ipt-box">
                    <label for="">收费员：</label>
                    <input type="text" class='ipt ipt-xs' name="toll_collector">
                </div>
            </form>

            <div class="ipt-box" style="text-align: center;margin:0 0 20px 0;width: 83%" >
                <button class="btn btn-info js-save" data-disable="true" >提交</button>
            </div>
        </div>

        <div class='c-table-box'>
            <table class="layui-table">
                <colgroup>
                    <col width="5%">
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                    <col width="6%">
                    <col width="5%">
                    <col width="10%">
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                    <!--<col width="12%">-->
                </colgroup>
                <thead>
                <tr>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>校区</th>
                    <th>楼栋名称</th>
                    <th>楼层名称</th>
                    <th>房间号</th>
                    <th>故障类型</th>
                    <th>故障内容</th>
                    <th>收费</th>
                    <th>电话</th>
                    <th>登记日期</th>
                    <th>收费员</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($list['data']) || $list['data'] instanceof \think\Collection || $list['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $list['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $val['id']; ?></td>
                    <td><?php echo $val['name']; ?></td>
                    <td><?php echo $val['campus']['cp_name']; ?></td>
                    <td><?php echo $val['build']['build_name']; ?></td>
                    <td><?php echo $val['floor']['floor_name']; ?></td>
                    <td><?php echo $val['dormitory']['room_num']; ?></td>
                    <td><?php echo $type[$val['type']]; ?></td>
                    <td><?php echo $val['info']; ?></td>
                    <td><?php echo $val['charge']; ?></td>
                    <td><?php echo $val['phone']; ?></td>
                    <td><?php echo date('y-m-d',$val['register_date']); ?></td>
                    <td><?php echo $val['toll_collector']; ?></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
        <div class='page-box clearfix'>
            <div style='font-size:16px;color:#333' class='p-l'>
                <span>共</span>
                <span style='margin:0 5px'><?php echo $list['total']; ?></span>
                <span>条记录</span>
            </div>
            <div class='p-r'>
                <!-- 分页 -->
                <div id="c_page"><?php echo $page; ?></div>
            </div>
        </div>
    </div>

</div>

</div>
<script src='/static/js/jquery-3.2.1.min.js'></script>
<script src="/static/js/layui/layui.all.js"></script>
<script>
    //JavaScript代码区域
    layui.use(['element'], function(){
        var element = layui.element;
    });
    var storage = window.localStorage;
    $(".layui-side .layui-nav li").find("a.c-link").each(function (i, item) {
        $(item).on("click", function () {
            var this_menu = $(this).attr("data-url");
            storage["this_menu"] = this_menu;
        })
        //获取当前data-url
        var this_url = storage['this_menu'];
        if ($(item).attr("data-url") == this_url) {
            $(item).parents("li").addClass("layui-nav-itemed");
            $(item).parent().addClass("layui-this");
            $(item).siblings(".c-link").removeClass("layui-this").parents("li").siblings("li").find("dd").removeClass("layui-nav-itemed")
        }
    })
    //搜索
    $(document).on('click','.all-search',function(){
        $(this).parent('form').submit();
    });
</script>
<script src='/static/js/main.js'></script>

<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        laydate.render({
            elem: '#addForm input[name="register_date"]',
            format: 'yyyy-MM-dd'
        });
    });

    /* 校区选择 */
    $(document).on('change','.select-campus',function(){

        var campus_id = $(this).val();

        if(campus_id)
        {
            $.post("<?php echo url('tools/getbuild'); ?>",{campus_id:campus_id},function(res){
                if(res.status == 1)
                {
                    var html = '<option value="">请选择</option>';
                    $.each(res.data, function(k, v) {
                        html+= '<option value="'+ v.id+'">'+ v.build_name+'</option>';
                    });
                    $('#addForm select[name="build_id"]').html(html);
                    $('#addForm select[name="floor_id"]').html('<option value="">请选择</option>');
                    $('#addForm select[name="dormitory_id"]').html('<option value="">请选择</option>');
                }
            },'json');
        }
        else
        {
            $('#addForm select[name="build_id"]').html('<option value="">请选择</option>');
            $('#addForm select[name="floor_id"]').html('<option value="">请选择</option>');
            $('#addForm select[name="dormitory_id"]').html('<option value="">请选择</option>');
        }
    });


    /* 楼栋选择 */
    $(document).on('change','.select-build',function(){

        var campus_id = $('#addForm select[name="campus_id"]').val();
        var build_id = $(this).val();

        if(campus_id && build_id)
        {
            $.post("<?php echo url('tools/getFloor'); ?>",{campus_id:campus_id,build_id:build_id},function(res){
                if(res.status == 1)
                {
                    var html = '<option value="">请选择</option>';
                    $.each(res.data, function(k, v) {
                        html+= '<option value="'+ v.id+'">'+ v.floor_name+'</option>';
                    });
                    $('#addForm select[name="floor_id"]').html(html);
                    $('#addForm select[name="dormitory_id"]').html('<option value="">请选择</option>');
                }
            },'json');
        }
        else
        {
            $('#addForm select[name="floor_id"]').html('<option value="">请选择</option>');
            $('#addForm select[name="dormitory_id"]').html('<option value="">请选择</option>');
        }
    });


    /* 楼层选择 */
    $(document).on('change','.select-floor',function(){

        var campus_id = $('#addForm select[name="campus_id"]').val();
        var build_id = $('#addForm select[name="build_id"]').val();
        var floor_id = $(this).val();

        if(campus_id && build_id && floor_id)
        {
            $.post("<?php echo url('tools/getRoom'); ?>",{campus_id:campus_id,build_id:build_id,floor_id:floor_id},function(res){
                if(res.status == 1){
                    var html = '<option value="">请选择</option>';
                    $.each(res.data, function(k, v) {
                        html+= '<option value="'+ v.id+'">'+ v.room_num+'</option>';
                    });
                    $('#addForm select[name="dormitory_id"]').html(html);
                }
            },'json');
        }else{
            $('#addForm select[name="dormitory_id"]').html('<option value="">请选择</option>');
        }
    });


    /* 保存操作 */
    $(document).on('click','.js-save',function(){


        var name = $('#addForm input[name="name"]').val();
        if ( name == '' )
        {
            layer.msg('请填写申报人姓名！', {icon: 2});
            return;
        }

        var dormitory_id = $('#addForm select[name="dormitory_id"]').val();
        if ( !dormitory_id )
        {
            layer.msg('请选择房号！', {icon: 2});
            return;
        }

        var type = $('#addForm select[name="type"]').val();
        if ( !type )
        {
            layer.msg('请选择故障类型！', {icon: 2});
            return;
        }

        var info = $('#addForm input[name="info"]').val();
        if ( info == '' )
        {
            layer.msg('请填写故障内容！', {icon: 2});
            return;
        }

        var charge = $('#addForm input[name="charge"]').val();
        if ( !charge )
        {
            layer.msg('请填写收费金额！', {icon: 2});
            return;
        }

        var phone = $('#addForm input[name="phone"]').val();
        if ( !phone )
        {
            layer.msg('请填写电话！', {icon: 2});
            return;
        }

        var registerDate = $('#addForm input[name="register_date"]').val();
        if ( registerDate == '')
        {
            layer.msg('请填写登记日期！', {icon: 2});
            return;
        }

        var tollCollector = $('#addForm input[name="toll_collector"]').val();
        if ( tollCollector == '')
        {
            layer.msg('请填写收费员！', {icon: 2});
            return;
        }

        var data = $("#addForm").serializeArray();
        var obj = $(this);
        if(data){

            if ( obj.attr("data-disable") != 'true')
            {
                return;
            }
            obj.attr("data-disable",'false');

            $.post("<?php echo url('repair/saveReport'); ?>",data,function(res){
                if(res.status == 1)
                {
                    layer.msg(res.msg, {icon: 1});
                    setTimeout('location.reload()',3000);
                }
                else
                {
                    obj.attr("data-disable",'true');
                    layer.msg(res.msg, {icon: 2});
                }
            },'json');
        }
    });


</script>
</body>
</html>
