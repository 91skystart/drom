<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:47:"../application/index/tpl/assess\punishment.html";i:1549108321;s:71:"C:\charles\PHPTutorial\WWW\drom\application\index\tpl\index\header.html";i:1548765601;s:69:"C:\charles\PHPTutorial\WWW\drom\application\index\tpl\index\menu.html";i:1548765601;s:71:"C:\charles\PHPTutorial\WWW\drom\application\index\tpl\index\footer.html";i:1548765601;}*/ ?>
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
            <span><a href="javascript:void(0)" style="color: #666;">量化考核管理</a></span>
            <span>></span>
            <span><a href="javascript:void(0)">学生评定管理</a></span>
        </div>
        <div class='search-box'>
            <div class="ipt-box">
                <form  action="<?php echo url('assess/index'); ?>" method='post'>
                    <input placeholder="请输入姓名" value="<?php echo $paramData['keywords']; ?>" name="keywords" class='search-ipt' type="text">
                    <span class='icon-search all-search'></span>
                </form>
            </div>
        </div>
        <div style='margin-top:20px;' class='clearfix'>
            <div style='margin-bottom:20px;' class='nav-tab-box p-l'>
                <span class="tab-item"><a  href="<?php echo url('assess/index'); ?>">学生表扬管理</a></span>
                <span class="tab-item on"><a  href="<?php echo url('assess/punishment'); ?>">学生违纪管理</a></span>
            </div>
        </div>

        <div style='' class='ipt-main-box'>
            <form id="addForm" action="" onsubmit="return false">
                <div class="ipt-box ">
                    <label for="">学号：</label>
                    <input type="text" class='ipt ipt-xs' name="student_num">
                </div>
                <div class="ipt-box ">
                    <label for="">姓名：</label>
                    <input type="text" class='ipt ipt-xs' name="name">
                </div>
                <div class="ipt-box">
                    <label for="">性别：</label>
                    <select class='ipt-xs' name="sex">
                        <option value="">请选择</option>
                        <option value="1">男</option>
                        <option value="2">女</option>
                    </select>
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
                    <label for="">年级：</label>
                    <select class='ipt-xs' name="grade_id">
                        <option value="">请选择</option>
                        <?php if(is_array($gradeList) || $gradeList instanceof \think\Collection || $gradeList instanceof \think\Paginator): $i = 0; $__LIST__ = $gradeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$gradeInfo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $gradeInfo['gd_id']; ?>" ><?php echo $gradeInfo['gd_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>

                    </select>
                </div>
                <div class="ipt-box" style="width: 512px;">
                    <label for="">内容：</label>
                    <input type="text" class='ipt ipt-xs' name="info" style="width:396px;">
                </div>
                <div class="ipt-box" style="width: 512px;margin-left:5px;">
                    <label for="">备注：</label>
                    <input type="text" class='ipt ipt-xs' name="remark" style="width:396px;">
                </div>
                <div class="ipt-box">
                    <label for="">发生日期：</label>
                    <input type="text" class='ipt ipt-xs' name="happen_date">
                </div>

            </form>

            <div class="ipt-box" style="text-align: center;margin:0 0 20px 0;width: 83%" >
                <button class="btn btn-info js-save" data-disable="true" >录入</button>
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
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                    <col width="10%">
                    <col width="10%">
                    <col width="7%">
                    <!--<col width="12%">-->
                </colgroup>
                <thead>
                <tr>
                    <th>序号</th>
                    <th>学号</th>
                    <th>姓名</th>
                    <th>校区</th>
                    <th>楼栋名称</th>
                    <th>楼层名称</th>
                    <th>房间号</th>
                    <th>年级</th>
                    <th>表扬内容</th>
                    <th>发生日期</th>
                    <th>备注</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($list['data']) || $list['data'] instanceof \think\Collection || $list['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $list['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $val['id']; ?></td>
                    <td><?php echo $val['student_num']; ?></td>
                    <td><?php echo $val['name']; ?></td>
                    <td><?php echo $val['campus']['cp_name']; ?></td>
                    <td><?php echo $val['build']['build_name']; ?></td>
                    <td><?php echo $val['floor']['floor_name']; ?></td>
                    <td><?php echo $val['dormitory']['room_num']; ?></td>
                    <td><?php echo $val['grade']['gd_name']; ?></td>
                    <td><?php echo $val['info']; ?></td>
                    <td><?php echo date('Y-m-d',$val['happen_date']); ?></td>
                    <td><?php echo $val['remarks']; ?></td>
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
            elem: '#addForm input[name="happen_date"]',
            format: 'yyyy-MM-dd'
        });
    });

    $(document).on('blur','#addForm input[name="student_num"]',function(){
        var studentNum = $(this).val();
        // if( studentNum )
        // {
        //     // 获取入住学生信息
        //     getStudent(studentNum)
        // }
        getStudent(studentNum)
    });

    function getStudent(studentNum)
    {
        $.get("<?php echo url('changedormitory/getStudent'); ?>",{studentNum:studentNum},function(res){
            if(res.status == 1)
            {
                var data = res.data;
                $('#addForm input[name="student_num"]').val(data.student_num);
                $('#addForm input[name="name"]').val(data.name);
                $('#addForm select[name="sex"]').val(data.sex);
                $('#addForm select[name="campus_id"]').val(data.campus_id);
                html = '<option selected="selected" value="'+ data.build_id+'">'+ data.build.build_name+'</option>';
                $('#addForm select[name="build_id"]').html(html);
                html = '<option selected="selected" value="'+ data.floor_id+'">'+ data.floor.floor_name+'</option>';
                $('#addForm select[name="floor_id"]').html(html);
                html = '<option selected="selected" value="'+ data.dormitory_id+'">'+ data.dormitory.room_num+'</option>';
                $('#addForm select[name="dormitory_id"]').html(html);
                html = '<option selected="selected" value="'+ data.grade_id+'">'+ data.grade_name+'</option>';
                $('#addForm select[name="grade_id"]').html(html);
            }
            else
            {
                $('#addForm input[name="name"]').val('');
                $('#addForm select[name="sex"]').val('');
                $('#addForm select[name="campus_id"]').val('');
                $('#addForm select[name="build_id"]').val('');
                $('#addForm select[name="floor_id"]').val('');
                $('#addForm select[name="dormitory_id"]').html('');
                $('#addForm select[name="grade_id"]').html('');
                layer.msg(res.msg, {icon: 2});
            }
        },'json');
    }

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


        var studentNum = $('#addForm input[name="student_num"]').val();
        if ( studentNum == '' )
        {
            layer.msg('请填写学号！', {icon: 2});
            return;
        }

        var name = $('#addForm input[name="name"]').val();
        if ( name == '' )
        {
            layer.msg('请填写姓名！', {icon: 2});
            return;
        }

        var dormitoryId = $('#addForm select[name="dormitory_id"]').val();
        if ( !dormitoryId )
        {
            layer.msg('请选择房号！', {icon: 2});
            return;
        }

        var gradeId = $('#addForm select[name="grade_id"]').val();
        if ( !gradeId )
        {
            layer.msg('请选择年级！', {icon: 2});
            return;
        }

        var happenDate = $('#addForm input[name="happen_date"]').val();
        if ( happenDate == '')
        {
            layer.msg('请填写发生日期！', {icon: 2});
            return;
        }

        var info = $('#addForm input[name="info"]').val();
        if ( info == '')
        {
            layer.msg('请填写违纪内容！', {icon: 2});
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

            $.post("<?php echo url('assess/savePunishment'); ?>",data,function(res){
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
