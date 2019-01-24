<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:39:"../application/index/tpl/staff\add.html";i:1545363100;s:55:"D:\wwwroot\dorm\application\index\tpl\index\header.html";i:1545372212;s:53:"D:\wwwroot\dorm\application\index\tpl\index\menu.html";i:1545785666;s:55:"D:\wwwroot\dorm\application\index\tpl\index\footer.html";i:1543992410;}*/ ?>
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
            <span><a href="javascript:void(0)">员工管理</a></span>
        </div>
        <div class='search-box'>
            <div class="ipt-box">
                <form  action="<?php echo url('staff/index'); ?>" method='post'>
                    <input placeholder="请输入姓名" value="<?php echo $paramData['ad_sname']; ?>" name="ad_sname" class='search-ipt' type="text">
                    <span class='icon-search all-search'></span>
                </form>
            </div>

        </div>
        <div style='margin-top:20px;' class='clearfix'>
            <div style='margin-bottom:20px;' class='nav-tab-box p-l'>
                <span class='tab-item'><a  href="<?php echo url('staff/index'); ?>">人员信息</a></span>
                <span class='tab-item on'><a  href="<?php echo url('staff/add'); ?>">添加人员</a></span>
                <span class='tab-item'><a  href="<?php echo url('staff/importStaff'); ?>">一键导入</a></span>
            </div>
            <div class='p-r'>
                <form id="search_from" action="<?php echo url('staff/index'); ?>" method='post'>
                    <input type="text" name="ad_num" placeholder="工号" value="<?php echo $paramData['ad_num']; ?>" class="ipt ipt-xs">
                    <input type="text" name="profession" placeholder="工种" value="<?php echo $paramData['profession']; ?>" class="ipt ipt-xs">
                    <button class="btn btn-info" type="submit">搜索</button>
                </form>
            </div>
        </div>
        <div style='' class='ipt-main-box'>
            <form id="editForm" action="" onsubmit="return false">
                <input type="hidden" name="ad_uid" value="0"/>
                <div class="ipt-box">
                    <label for="">工号：</label>
                    <input type="text" class='ipt ipt-xs' name="ad_num">
                </div>
                <div class="ipt-box">
                    <label for="">姓名：</label>
                    <input type="text" class='ipt ipt-xs' name="ad_sname">
                </div>
                <div class="ipt-box">
                    <label for="">性别：</label>
                    <select class='ipt-xs' name="ad_sex">
                        <option value="">请选择</option>
                        <option value="1">男</option>
                        <option value="2">女</option>
                    </select>
                </div>
                <div class="ipt-box">
                    <label for="">电话：</label>
                    <input type="text" class='ipt ipt-xs' name="ad_tel">
                </div>
                <div class="ipt-box">
                    <label for="">联系地址：</label>
                    <input type="text" class='ipt ipt-xs' name="contact_address">
                </div>
                <div class="ipt-box">
                    <label for="">聘用部门：</label>
                    <input type="text" class='ipt ipt-xs' name="department">
                </div>
                <div class="ipt-box">
                    <label for="">工种：</label>
                    <input type="text" class='ipt ipt-xs' name="profession">
                </div>
                <div class="ipt-box">
                    <label for="">身份证：</label>
                    <input type="text" class='ipt ipt-xs' name="ad_identify">
                </div>
                <div class="ipt-box">
                    <label for="">任职日期：</label>
                    <input type="text" class='ipt ipt-xs' name="into_time">
                </div>
                <div class="ipt-box">
                    <label for="">离职日期：</label>
                    <input type="text" class='ipt ipt-xs' name="out_time">
                </div>
                <button class='btn btn-info js-save' data-disable="true">添加</button>
            </form>
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
                    <col width="7%">
                    <col width="7%">
                    <col width="7%">
                </colgroup>
                <thead>
                <tr>
                    <th>序号</th>
                    <th>工号</th>
                    <th>姓名</th>
                    <th>性别</th>
                    <th>电话</th>
                    <th>身份证</th>
                    <th>联系地址</th>
                    <th>聘用部门</th>
                    <th>工种</th>
                    <th>任职日期</th>
                    <th>离职日期</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($list['data']) || $list['data'] instanceof \think\Collection || $list['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $list['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $val['ad_uid']; ?></td>
                    <td><?php echo $val['ad_num']; ?></td>
                    <td><?php echo $val['ad_sname']; ?></td>
                    <td><?php echo $sexList[$val['ad_sex']]; ?></td>
                    <td><?php echo $val['ad_tel']=='0'?'-':$val['ad_tel']; ?></td>
                    <td><?php echo $val['ad_identify']; ?></td>
                    <td><?php echo $val['contact_address']; ?></td>
                    <td><?php echo $val['department']; ?></td>
                    <td><?php echo $val['profession']; ?></td>
                    <td><?php echo $val['into_time']; ?></td>
                    <td><?php echo $val['out_time']; ?></td>
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
            elem: '#editForm input[name="into_time"]'
        });
        laydate.render({
            elem: '#editForm input[name="out_time"]'
        });
    });

    /* 编辑的内容回写 */
    $(document).on('click','.js-edit',function(){
        var id = $(this).attr('data-id');

        if(id){
            $.post("<?php echo url('staff/getInfo'); ?>",{id:id},function(res){

                if(res.status == 1)
                {
                    var data = res.data;
                    $('#editForm').find('input[name="ad_uid"]').val(data.ad_uid);
                    $('#editForm').find('input[name="ad_num"]').val(data.ad_num);
                    $('#editForm').find('input[name="ad_sname"]').val(data.ad_sname);
                    $('#editForm').find('select[name="ad_sex"]').val(data.ad_sex);
                    $('#editForm').find('input[name="ad_tel"]').val(data.ad_tel);
                    $('#editForm').find('input[name="ad_identify"]').val(data.ad_identify);
                    $('#editForm').find('input[name="department"]').val(data.department);
                    $('#editForm').find('input[name="profession"]').val(data.profession);
                    $('#editForm').find('input[name="into_time"]').val(data.into_time);
                    $('#editForm').find('input[name="out_time"]').val(data.out_time);
                    $('#editForm').find('input[name="contact_address"]').val(data.contact_address);
                }
            },'json');
        }
    });


    /* 保存操作 */
    $(document).on('click','.js-save',function(){
        var data = $("#editForm").serializeArray();
        var obj = $(this);
        if(data)
        {
            if ( obj.attr("data-disable") != 'true')
            {
                return;
            }
            obj.attr("data-disable",'false');
            $.post("<?php echo url('staff/updateStaff'); ?>",data,function(res){
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

    $(document).on('click','.js-del',function(){

        var id = $(this).attr('data-id');
        var adNum = $(this).attr('data-num');
        if ( !id )
        {
            layer.msg('请选择需要删除的员工', {icon: 2});
            return;
        }

        layer.confirm('确定要删除工号 '+adNum+' 吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){

            $.post("<?php echo url('staff/delStaff'); ?>",{id:id},function(res){
                if(res.status == 1)
                {
                    layer.msg(res.msg, {icon: 1});
                    setTimeout('location.reload()',3000);
                }
                else
                {
                    layer.msg(res.msg, {icon: 2});
                }
            },'json');

        }, function(){

        });

    });
</script>
</body>
</html>
