<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:45:"../application/index/tpl/bed_manage\room.html";i:1545128648;s:55:"D:\wwwroot\dorm\application\index\tpl\index\header.html";i:1545372212;s:53:"D:\wwwroot\dorm\application\index\tpl\index\menu.html";i:1545785666;s:55:"D:\wwwroot\dorm\application\index\tpl\index\footer.html";i:1543992410;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>home</title>
    <link rel="stylesheet" href="/static/js/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/common.css">
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
<div class="layui-layout layui-layout-admin">
    <div class="layui-header c-header">
        <span class='icon-menu'></span>
        <div class="layui-logo c-logo">宿舍管理系统</div>
        <!-- 头部区域 -->
        <span class='head-line-1'></span>
        <span class='logo-ps'>科迅软件</span>
        <ul class="layui-nav layui-layout-right nav-user">
            <li  class="layui-nav-item">
                <a href="javascript:;" class='username'>
                    <!--<img src="<?php echo $avatarImg!=''?$avatarImg : ''; ?>http://t.cn/RCzsdCq" class="layui-nav-img">-->
                    您好 , <?php echo $loginName; ?>
                </a>
                <!--<dl class="layui-nav-child top-nav-child">-->
                    <!--<dd><a href="">基本资料</a></dd>-->
                    <!--<dd><a href="">安全设置</a></dd>-->
                <!--</dl>-->
            </li>
            <span class='c-s-line'></span>
            <li class="layui-nav-item layui-nav-item-close">
                <a class='icon icon-sign-out' href="<?php echo $logoutUrl; ?>"></a>
            </li>
        </ul>
    </div>
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
            <span><a href="javascript:void(0)">学生铺位分配</a></span>
        </div>
        <div class='search-box'>
            <div class="ipt-box">
                <form  action="<?php echo url('bed_manage/room',['id' => $dormitoryInfo['id']]); ?>" method='post'>

                    <input placeholder="请输入学生姓名"  name="student_name" value="<?php echo $studentName; ?>" class='search-ipt' type="text">
                    <span class='icon-search all-search'></span>
                </form>
            </div>
        </div>

        <div class='c-table-box' style="border-top:0px;">
            <table class="layui-table" style="width:15%;float:left;">
                <colgroup>
                    <col width="6%">
                    <col width="10%">
                    <col width="8%">
                    <col width="8%">
                    <col width='8%'>
                    <col width="10%">
                    <col width="10%">
                    <col width="7%">
                    <col width="8%">
                </colgroup>
                <thead>
                <tr>
                    <th><?php echo $dormitoryInfo['build']['build_name']; ?> <?php echo $dormitoryInfo['room_num']; ?></th>
                </tr>

                </thead>
                <tbody>
                <tr>
                    <td style="border: 0px;">
                        <p style="line-height: 26px;">
                            所在层数:<?php echo $dormitoryInfo['floor']['floor_name']; ?> <br />
                            房间号: <?php echo $dormitoryInfo['room_num']; ?><br />
                            总床位数: <?php echo $dormitoryInfo['several']; ?><br />
                            剩余床位:<?php echo $dormitoryInfo['several'] - $dormitoryInfo['check_in_count']; ?>
                        </p>
                        <br />
                        <a class="btn btn-info" href="<?php echo url('bed_manage/allot',['id'=> $dormitoryInfo['id']]); ?>">分配学生</a>
                    </td>
                </tr>

                </tbody>
            </table>


            <table class="layui-table" style="width:80%;float:right">
                <colgroup>
                    <col width="6%">
                    <col width="10%">
                    <col width="8%">
                    <col width="8%">
                    <col width='8%'>
                    <col width="10%">
                    <col width="10%">
                    <col width="7%">
                    <col width="8%">
                    <col width='6%'>
                    <col width="6%">
                    <col width="6%">
                </colgroup>
                <thead>
                <tr>
                    <th colspan="9">入住学生</th>
                </tr>

                </thead>
                <tbody>
                <tr>
                    <td>序号</td>
                    <td>学号</td>
                    <td>姓名</td>
                    <td>性别</td>
                    <td>年级</td>
                    <td>班级</td>
                    <td>房间号</td>
                    <td>身份证</td>
                    <td>电话</td>
                </tr>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $val['id']; ?></td>
                    <td><?php echo $val['student_num']; ?></td>
                    <td><?php echo $val['name']; ?></td>
                    <td><?php echo $val['sex']==1?'男':'女'; ?></td>
                    <td><?php echo $val['grade']['gd_name']; ?></td>
                    <td><?php echo $val['bclass']['cl_name']; ?></td>
                    <td><?php echo $val['dormitory']['room_num']; ?></td>
                    <td><?php echo $val['idcard']; ?></td>
                    <td><?php echo $val['phone']; ?></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
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

</body>
</html>