<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:48:"../application/index/tpl/staff\import_staff.html";i:1548765601;s:71:"C:\charles\PHPTutorial\WWW\drom\application\index\tpl\index\header.html";i:1548765601;s:69:"C:\charles\PHPTutorial\WWW\drom\application\index\tpl\index\menu.html";i:1548765601;s:71:"C:\charles\PHPTutorial\WWW\drom\application\index\tpl\index\footer.html";i:1548765601;}*/ ?>
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
            <span><a href="javascript:void(0)" class="menu-nav">人员管理</a></span>
            <span>></span>
            <span><a href="javascript:void(0)">员工管理</a></span>
        </div>
        <div style='margin-top:20px;' class='clearfix'>
            <div style='margin-bottom:20px;' class='nav-tab-box p-l'>
                <span class='tab-item'><a  href="<?php echo url('staff/index'); ?>">人员信息</a></span>
                <span class='tab-item'><a  href="<?php echo url('staff/add'); ?>">添加人员</a></span>
                <span class='tab-item on'><a  href="<?php echo url('staff/importStaff'); ?>">一键导入</a></span>
            </div>
        </div>
        <div class='ipt-main-box'>
            <div class="layui-upload upload-file-info">
                <span>选择文件:</span>
                <button type="button" class="layui-btn layui-btn-normal select-file" name="upload_staff" id="upload_staff" >选择文件</button>
                <button type="button" class="layui-btn upload-file-button" id="js_import_staff" data-disable="true">上传文件</button>
            </div>
        </div>

        <div class="c-table-box upload-file-des">
            <p class="upload-file-des-title">上传帮助</p>
            <p>1.为正确上传数据，用户可以先下载<a href="<?php echo url('staff/example',['id' => 1]); ?>" target="_blank">“员工信息导入模板” </a>用户也可以下载带实例的数据的实例文件<a href="<?php echo url('staff/example',['id' => 2]); ?>" target="_blank">“员工信息数据实例文件”</a>作为参考，请务必删除文件内的测试数据。</p>
            <p>2.文件的第一列是字段表示行，无需删除。</p>
            <p>3.从第二列开始可以录入所需的数据，每行对应一条数据。</p>
            <p>4.为保证系统数据安全，系统对所有上传数据有严格的有效要求，对应好每一个字段。</p>
            <p>5.不要修改模板文件的第一行的名称，否则影响数据上传。</p>
        </div>

        <div class='c-table-box upload-file-des' style="display: none;">
            <p class="upload-file-des-title" >导入数据信息</p>
            <p class="import-success-tip"><span class="upload-file-des-title-left">成功导入</span>   成功导入数据<span id="successTotal"></span>条<p>
            <p class="import-failure-tip"><span class="upload-file-des-title-left">错误数据</span>   <span id="failureTotal"></span>条</p>
            <table class="layui-table import-failure-tip" id="import-failure-list" style="display: none;">
                <colgroup>
                    <col width="6%">
                    <col width="10%">
                    <col width="10%">
                    <col width="70%">
                </colgroup>
                <thead></thead>
                <tbody>
                </tbody>
            </table>
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
    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;

        //选完文件后不自动上传
        upload.render({
            elem: '#upload_staff'
            ,url: "<?php echo url('staff/doImportStaff'); ?>" //上传接口
            ,exts: 'xls|jpg'
            ,auto: false
            //,multiple: true
            ,bindAction: '#js_import_staff'
            ,before:function(obj){
                //console.log(obj)
            }
            ,done: function(res){

                if (res.status == 1)
                {
                    var data = res.data;
                    $("#successTotal").html(data.successTotal);
                    $("#failureTotal").html(data.failureTotal);

                    if ( data.failureTotal > 0 )
                    {
                        var resHtml = '';
                        $.each(data.list, function(k, v) {
                            var number = parseInt(k) + 1;
                            resHtml += '<tr><td>' +number+'</td><td>' + v.ad_num+ '</td><td colspan="2" style="text-align: left">'+ v.ad_sname +'</td></tr>';
                        });
                        $("#import-failure-list").find("tbody").html(resHtml);

                        $("#import-failure-list").show();
                    }

                    $(".upload-file-des").show();
                }
                else
                {
                    $("#import-failure-list").hide();
                    $(".upload-file-des").hide();
                    layer.msg(res.msg, {icon: 2});
                }

            }
        });

    });

</script>
</body>
</html>
