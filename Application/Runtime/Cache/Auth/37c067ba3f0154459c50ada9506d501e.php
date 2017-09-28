<?php if (!defined('THINK_PATH')) exit();?><html>
    <head>
        <meta charset="UTF-8">
        <title>林格贝尔在线办公系统</title>
        <link href="/Public/img/title.ico" rel="SHORTCUT ICON" />
        <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/bootstrap.css" media="all">
        <link rel="stylesheet" type="text/css" href="/Public/bootstrap/css/font-awesome.css" media="all">
        <script type="text/javascript" src="/Public/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="/Public/bootstrap/js/bootstrap.js"></script>
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover();
            });
        </script>
        <style>
            body{
                overflow-y: hidden;
                background: #eee;
                background-image: url("/Public/img/furley_bg.png");
            }
            .btn-toolbar{
                font-size: 0;
                margin-top: 10px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <style>
            .navbar-default{
                min-height: 50px;
                padding-right: 0;
                padding-left: 20px;
                background-color: #2f96b4;
                background-image: -moz-linear-gradient(top, #52b2cf, #2f96b4);
                background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#52b2cf), to(#2f96b4));
                background-image: -webkit-linear-gradient(top, #52b2cf, #2f96b4);
                background-image: -o-linear-gradient(top, #52b2cf, #2f96b4);
                background-image: linear-gradient(to bottom, #52b2cf, #2f96b4);
                background-repeat: repeat-x;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff52b2cf', endColorstr='#ff2f96b4', GradientType=0);
                filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
                border-color: #64cceb #64cceb #184552 #2f96b4;
                -webkit-border-radius: 0;
                -moz-border-radius: 0;
                border-radius: 0;
                margin-bottom: 0px;
            }
            .left-content{
                width:100%;
            }
            .left{
                float: left;
                width:13%;
                min-height: 100px;
                border-right: 2px solid darkgray;
                overflow-x: auto;
                overflow-x: hidden;
            }
            .content{
                float:left;
                width:84%;
                margin-left:10px;
                padding-top:20px;
            }

            /*****************导航样式**********************/
            .sidebar-nav .nav-header {
                border-top: 1px solid #ffffff;
                border-bottom: 1px solid #c8c8cb;
                border-left: none;
                color: #333;
                display: block;
                background: #efeff0;
                background: -ms-linear-gradient(bottom, #efeff0, #ffffff);
                background: -moz-linear-gradient(center bottom, #efeff0 0%, #ffffff 100%);
                background: -o-linear-gradient(bottom, #efeff0, #ffffff);
                filter: progid:dximagetransform.microsoft.gradient(startColorStr='#4d5b76', EndColorStr='#6c7a95');
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorStr='#ffffff',EndColorStr='#efeff0')";
                underline:none;
                line-height: 2.5em;
                padding: 0em .25em;
                margin-bottom: 0px;
                text-shadow: none;
                text-transform: none;
            }
            .sidebar-nav {
                width: 100%;
                float: left;
                border-top: none;
                border-left: none;
                margin: 0em;
            }
            .sidebar-nav .nav-header i[class^="icon-"] {
                margin-right: .75em;
            }
            .sidebar-nav .active{
                background: #28b779 !important;
                color: #fff !important;
                font-weight: 900;
            }
            .sidebar-nav .nav-list.collapse.in {
                border-bottom: 1px solid #ccc;
            }
            .sidebar-nav .nav-list {
                margin: 0px;
                border: 0px;
                background: #f6f6f6;
            }
            .sidebar-nav .nav-list > li > a {
                color: #444;
                padding: .5em 1em;
                background-color: white;
            }
            .sidebar-nav .nav-list > li > a:hover {
                color: black;
                background: #99ff99;
            }
            .sidebar-nav .nav-list > li > .lia-active{
                color: black;
                background: #99ff99;
            }
            .sidebar-nav a ul{
                font-weight: normal;
            }
            .sidebar-nav a i{
                margin-right: 10px;
            }
            .sidebar-nav a:hover {
                text-decoration:none;
            }
            .popover-content{
                padding:0px;
            }
            /**********************折叠导航************************/
            .zhedie{
                float: left;
                height:100%;
            }
            .zhedie .zhedie-btn{
                cursor:pointer;
                background-color: white;
                font-size: 25px;
                position: relative;
                color:#999999;
                top:50%;
                left:-10px;
                -moz-transition: all 0.8s ease-in-out; 
                -webkit-transition: all 0.8s ease-in-out; 
                -o-transition: all 0.8s ease-in-out; 
                -ms-transition: all 0.8s ease-in-out; 
                transition: all 0.8s ease-in-out; 
                
            }
            .zhedie .zhedie-btn:hover{
                -moz-transform: rotate(360deg); 
                -webkit-transform: rotate(360deg); 
                -o-transform: rotate(360deg); 
                -ms-transform: rotate(360deg); 
                transform: rotate(360deg); 
            }
            /**********************tabview******************************/
            .close-tabview{
                position: relative;
                left:10px;
                top:-10px;
            }
            .close-tabview:hover{
                color:red;
            }
            .tabs-view{
                display: block;
                white-space: nowrap;
                overflow: hidden;    
                height: 35px;
            }

            .tabs-view li a{
                color: white;
                background-color: #64cceb;
            }
            .tabs-view ul {
                display: block;
                overflow: hidden;
                width:95%;
                float: left;
            }
            .tabs-view span{
                background: ivory;
                float:left;
                height:35px;   
                line-height:35px;   
                overflow:hidden;   
                color: #ff6666;
                display: none;
                width:18px;
                text-align: center;
                font-size: 16px;
            }
            .tabs-view .tabs-left-move{
                margin-right:2px;
                border-top-left-radius:0.3em;
                border-bottom-left-radius:0.3em;
            }
            .tabs-view .tabs-right-move{
                border-top-right-radius:0.3em;
                border-bottom-right-radius:0.3em;
            }
            .nav-tabs > li {
                display: inline-block;
            }
            .tabs-view li a:hover{
                color:black;
            }
        </style>
        <script>
            $(document).ready(function() {
                var win_height = document.body.clientHeight;
                var topHeight = document.getElementById("bs-example-navbar-collapse-1").clientHeight;
                $(".left-content").css("height", win_height - topHeight - 35);
                $(".content").css("height", "100%");
                $("#frame_0").css("height", "100%");
                $(".left").css("height", "100%");
                menu_click();
                //右上角的
                $(".dropdown-menu li a").bind("click", function() {
                    var url = $(this).attr("href");
                    $("#frame_0").attr("src", url);
                    $(".dropdown-menu").click();
                    return false;
                });
                //用户按钮
                $("#user_control").popover({"html": true, "content": user_control_list, "placement": "bottom"});

                //轮询代办任务
                setInterval('get_ajax_msg()', 5000);


                //主菜单绑定样式
                $(".sidebar-nav .collapsed").bind("click", function() {
                    $(this).parent().find("a").removeClass("active");
                    $(this).toggleClass("active");
                });

                $(".zhedie-btn").bind("click", function() {
                    if ($(".left").is(":hidden")) {
                        $(".left").show(500);
                        $(".content").css("width", "84%");
                    } else {
                        $(".left").hide(500);
                        $(".content").css("width", "96%");
                    }
                });

                //tabs-view
                $(".tabs-view").css("margin-left", "10%");
                //tabs左移动
                $(".tabs-left-move").bind("click",function(){
                    var scroll_width = $(".tabs-view ul").scrollLeft();
                    $(".tabs-view ul").scrollLeft(scroll_width-100);
                });
                //tabs左移动
                $(".tabs-right-move").bind("click",function(){
                    var scroll_width = $(".tabs-view ul").scrollLeft();
                    $(".tabs-view ul").scrollLeft(scroll_width+100);
                });
            });


            function close_tab(obj) {
                //关闭tab
                var flag = $(obj).parent().parent().attr("data-flag");
                var prev_flag = $(obj).parent().parent().prev().attr("data-flag");
                $(obj).parent().parent().prev().addClass("active");
                $(obj).parent().parent().remove();
                $("#frame_" + flag).remove();
                $("#frame_" + prev_flag).show();
                window.event.cancelBubble = true;//停止冒泡IE
                event.preventDefault();//停止冒泡firfox
                if ($(".tabs-view ul")[0].scrollWidth < $(".tabs-view").width()) {   // 显示左右切换按钮
                    $(".tabs-view span").hide();
                }
                return;
            }
            function menu_click() {
                //菜单点击事件
                $(".sidebar-nav ul li a").bind("click", function() {
                    $(this).parents(".sidebar-nav").find("a").removeClass("active");
                    $(this).parent().parent().prev().addClass("active");
                    var url = $(this).attr("href");
                    var flag = $(this).attr("data-tabview");
                    var tabName = $(this).html();
                    $(".tabs-view .nav-tabs li").removeClass("active"); //tabs-view 样式
                    //子菜单样式
                    $(".sidebar-nav .nav-list  li .lia-active").removeClass("lia-active");
                    $(this).addClass("lia-active");
                    
                    var is_have = $(".tabs-view .nav-tabs [data-flag='" + flag + "']").html();
                    $(".content iframe").hide(); //隐藏所有iframe
                    if (is_have == undefined) {
                        $(".tabs-view .nav-tabs").append("<li role='presentation' data-flag='" + flag + "' class='active' onclick='showTabContent(\"" + flag + "\")'><a href='#'>" + tabName + "<i class='close-tabview' onclick='close_tab(this)'>x</i></a></li>");
                        $(".content").append("<iframe style='width:100%;' id='frame_" + flag + "' name='content_frame' frameborder='0' src='" + url + "'>");
                        $("#frame_" + flag).css("height", "100%");
                        $(".nav-tabs > li").css("float", "none");
                        $(".tabs-view ul").scrollLeft($(".tabs-view ul").width());
                        if ($(".tabs-view ul")[0].scrollWidth > $(".tabs-view").width()) {   // 显示左右切换按钮
                            $(".tabs-view span").show();
                        }
                    } else {
                        $(".tabs-view .nav-tabs [data-flag='" + flag + "']").addClass("active");
                        $("#frame_" + flag).show();
                        $("#frame_" + flag).attr("src",url);
                    }


                    return false;
                });
            }
            /**
             * tab点击事件
             * @param {type} flag
             * @returns {undefined}
             */
            function showTabContent(flag) {
                $(".tabs-view .nav-tabs li").removeClass("active");
                $(".tabs-view .nav-tabs [data-flag='" + flag + "']").addClass("active");
                $(".content iframe").hide(); //隐藏所有iframe
                $("#frame_" + flag).show();
            }

            function user_control_list() {
                return '<ul class="dropdown-menu" role="menu" style="position:static;display:block;border:0;">' +
                        '<li><a href="#"></a></li>' +
                        '<li><a href="<?php echo ($change_lang_url); ?>"><i class="icon-exchange"></i> <?php echo (L("index_chang_lang")); ?></a></li>' +
                        '<li><a href="#" onclick="url_to_frame(\'user_center_0\')"><i class="icon-user"></i> <?php echo (L("index_user_center")); ?></a></li>' +
                        '<li role="presentation" class="divider"></li>' +
                        '<li><a href="<?php echo U('Public/logout');?>"><i class="icon-sign-out"></i> <?php echo (L("index_login_out")); ?></a></li>' +
                        '</ul>';
            }
            function url_to_frame(flag) {
                var url = "<?php echo U('User/user_centent');?>";
                var is_have = $(".tabs-view .nav-tabs [data-flag='" + flag + "']").html();
                    $(".content iframe").hide(); //隐藏所有iframe
                    if (is_have == undefined) {
                        $(".tabs-view .nav-tabs").append("<li role='presentation' data-flag='" + flag + "' class='active' onclick='showTabContent(\"" + flag + "\")'><a href='#'>用户中心<i class='close-tabview' onclick='close_tab(this)'>x</i></a></li>");
                        $(".content").append("<iframe style='width:100%;' id='frame_" + flag + "' name='content_frame' frameborder='0' src='" + url + "'>");
                        $("#frame_" + flag).css("height", "100%");
                        $(".nav-tabs > li").css("float", "none");
                        $(".tabs-view ul").scrollLeft($(".tabs-view ul").width());
                        if ($(".tabs-view ul")[0].scrollWidth > $(".tabs-view").width()) {   // 显示左右切换按钮
                            $(".tabs-view span").show();
                        }
                    } else {
                        $(".tabs-view .nav-tabs [data-flag='" + flag + "']").addClass("active");
                        $("#frame_" + flag).show();
                        $("#frame_" + flag).attr("src",url);
                    }
                return false;
            }

            function get_ajax_msg() {
                $.ajax({
                    url: "<?php echo U('Auth/Public/getMsg');?>",
                    type: "get",
                    data:{"name":"李耘"},
                    error:function (){
                      alert("qingqicuowu,服务器尾箱");  
                    },
                    success: function(count) {
                        $(".msg-num").html(count).css({"position": "relative", "top": "-10px", "left": "-35px"});
//                        $(".msg-num").html(count);
                    }
                });
            }
            function get_msg() {
                $('#msgModal').modal('show');
                $.get('<?php echo U("Auth/Public/getMsgList");?>', function(data) {
                    $('#msgModal').find(".modal-body").html(data);
                });
            }
            
            
             function read_msg(url){
                $.get(url);
            }
        </script>

        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <!-----------------事务消息----------------->
                <div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo (L("MESSAGE_NOTIFY")); ?></h4>
                            </div>
                            <div class="modal-body" style='text-align: center;'>
                                <i class='icon-spinner'></i>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo (L("close")); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!----------end------------->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <?php if(!empty($r_user['top_pic'])): ?><img src='/<?php echo ($r_user["top_pic"]); ?>' class='img-circle' width='50'>
                    <?php else: ?>
                    <img src='/Public/img/lady.jpg' class='img-circle' width='50'><?php endif; ?>
                    <strong style='color:white;position: relative;top:10px;'>&nbsp;&nbsp;&nbsp;<?php echo ($r_user["username"]); ?> <?php echo (L("WELCOME")); ?></strong>
                    <ul class="nav navbar-nav navbar-right">
                        <li style='font-size:20px;'><a href="#"><span  onclick='get_msg()'><span class="label" id='msg_count'><i class='icon-envelope'></i><i class='label label-danger msg-num'></i></span></span></a></li>
                        <li style='font-size:20px;'><a href="#" id="user_control"><strong style='color:black;'><span class="label"><i class='icon-power-off' style='margin-right:10px;'></i></span></strong></a>
                    </ul>

                    <div class="tabs-view">
                        <span class='tabs-left-move icon-angle-double-left'></span>
                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active" data-flag="0" onclick="showTabContent('0')"><a href="#">桌面</a></li>
                        </ul>
                        <span class='tabs-right-move  icon-angle-double-right'></span>
                    </div>

                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="left-content">
            <div class="left">
                <div class="sidebar-nav">
                    <a href="#menu9" class="nav-header collapsed" data-toggle="collapse"><i class="icon-file-text"></i><?php echo (L("SELF_OFFICE")); ?></a>
                    <ul id="menu9" class="nav nav-list collapse">
                        <li><a href="<?php echo U('Home/Index/sysSmgList');?>" target='content_frame' data-tabview="index_1"><?php echo (L("SYSTEM_MSG")); ?></a></li>
                        <li><a href="<?php echo U('Home/Index/willWorkList');?>" target='content_frame' data-tabview="index_2"><?php echo (L("WILL_DO")); ?></a></li>
                    </ul>
                    <?php  if(checkMenu("Hr/Wage/wageList") || checkMenu("Hr/Recruitment/recruitList") || checkMenu("Hr/BusinessTravel/travel_record") || checkMenu("Hr/Staff/add_base_info") || checkMenu("'Hr/Staff/staff_list") || checkMenu("Hr/Leave/leave_record") || checkMenu("Hr/BusinessTravel/travel_apply")) { ?>
                    <a href="#menu5" class="nav-header collapsed" data-toggle="collapse"><i class="icon-graduation-cap"></i><?php echo (L("HR_MANAGE")); ?></a>
                    <?php }?>
                    <ul id="menu5" class="nav nav-list collapse">
                        <?php if(checkMenu("Hr/Staff/add_base_info")){ ?>
                        <li ><a href="<?php echo U('Hr/Staff/add_base_info');?>" target='content_frame' data-tabview="staff_1"><?php echo (L("STAFF_ADD")); ?></a></li>
                        <?php } if(checkMenu("Hr/Staff/staff_list")){ ?>
                        <li ><a href="<?php echo U('Hr/Staff/staff_list');?>" target='content_frame' data-tabview="staff_2"><?php echo (L("STAFF_LIST")); ?></a></li>
                        <?php } if(checkMenu("Hr/Leave/leave_record")){ ?>
                        <li ><a href="<?php echo U('Hr/Leave/leave_record');?>" target='content_frame' data-tabview="staff_4"><?php echo (L("LEAVE_MANAGE")); ?></a></li>
                        <?php } if(checkMenu("Hr/BusinessTravel/travel_apply")){ ?>
                        <li ><a href="<?php echo U('Hr/BusinessTravel/travel_apply');?>" target='content_frame' data-tabview="staff_5"><?php echo (L("BusinessTravel")); ?></a></li>
                        <?php } if(checkMenu("Hr/BusinessTravel/travel_record")){ ?>
                        <li ><a href="<?php echo U('Hr/BusinessTravel/travel_record');?>" target='content_frame' data-tabview="staff_6"><?php echo (L("BusinessTravel_List")); ?></a></li>
                        <?php } if(checkMenu("Hr/Recruitment/recruitList")){ ?>
                        <li ><a href="<?php echo U('Hr/Recruitment/recruitList');?>" target='content_frame' data-tabview="staff_7"><?php echo (L("recruitList")); ?></a></li>
                        <?php } if(checkMenu("Hr/Wage/wageList")){ ?>
                        <li ><a href="<?php echo U('Hr/Wage/wageList');?>" target='content_frame' data-tabview="staff_8"><?php echo (L("wage")); ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php if(checkMenu('Product/Product/product_list') || checkMenu('Product/Product/add_product') || checkMenu('Product/ProductType/add_product_type') || checkMenu('Product/ProductType/product_type_list')){ ?>
                    <a href="#menu7" class="nav-header collapsed" data-toggle="collapse"><i class="icon-qrcode"></i><?php echo (L("PRODUCT_MANAGE")); ?></a>
                    <?php }?>
                    <ul id="menu7" class="nav nav-list collapse">
                        <?php if(checkMenu('Product/ProductType/add_product_type')){ ?>
                        <li><a href="<?php echo U('Product/ProductType/add_product_type');?>" target='content_frame' data-tabview="product_1"><?php echo (L("PRODUCT_TYPE_ADD")); ?></a></li>
                        <?php } if(checkMenu('Product/ProductType/product_type_list')){ ?>
                        <li><a href="<?php echo U('Product/ProductType/product_type_list');?>" target='content_frame' data-tabview="product_2"><?php echo (L("PRODUCT_TYPE")); ?></a></li>
                        <?php } if(checkMenu('Product/Product/add_product')){ ?>
                        <li><a href="<?php echo U('Product/Product/add_product');?>" target='content_frame' data-tabview="product_3"><?php echo (L("PRODUCT_ADD")); ?></a></li>
                        <?php } if(checkMenu('Product/Product/product_list')){ ?>
                        <li><a href="<?php echo U('Product/Product/product_list');?>" target='content_frame' data-tabview="product_4"><?php echo (L("PRODUCT_LIST")); ?></a></li>
                        <?php }?>
                    </ul>
                    <?php if(checkMenu('Product/Warehouse/warehouselists')) { ?>
                    <a href="#menu8" class="nav-header collapsed" data-toggle="collapse"><i class="icon-home"></i><?php echo (L("WAREHOUSE_MANAGE")); ?></a>
                     <?php } ?>
                    <ul id="menu8" class="nav nav-list collapse">
                        <?php if(checkMenu('Product/Warehouse/warehouselists')) { ?>
                        <li><a href="<?php echo U('Product/Warehouse/warehouselists');?>" target='content_frame' data-tabview="warehouse_1"><?php echo (L("WAREHOUSE_LIST")); ?></a></li>
                        <?php } ?>
                        <?php if(checkMenu('Product/Warehouse/Container')) { ?>
                        <li><a href="<?php echo U('Product/Warehouse/Container');?>" target='content_frame' data-tabview="warehouse_2"><?php echo (L("CONTAINER")); ?></a></li>
                        <?php } ?>
                    </ul>
                     <a href="#menu23" class="nav-header collapsed" data-toggle="collapse"><i class="icon-users"></i>客户管理</a>
                     <ul id="menu23" class="nav nav-list collapse">
                        <li ><a href="<?php echo U('Cli/OpCli/cliList');?>" target='content_frame' data-tabview="cli_1">客户列表</a></li>
                        <li ><a href="<?php echo U('Cli/OpCli/setAdmin');?>" target='content_frame' data-tabview="cli_2">权限设置</a></li>
                        <li ><a href="<?php echo U('Cli/OpCli/updateCliList');?>" target='content_frame' data-tabview="cli_2">变更审核</a></li>
                    </ul>
                     <?php if(checkMenu('Auth/Menu/menulist')){ ?>
                    <a href="#menu1" class="nav-header collapsed" data-toggle="collapse"><i class="icon-cubes"></i>权限管理</a>
                    <?php }?>
                    <ul id="menu1" class="nav nav-list collapse">
                        <?php if(checkMenu('Auth/Menu/menulist')){ ?>
                        <li ><a href="<?php echo U('Menu/menulist');?>" target='content_frame' data-tabview="menu_1">权限列表</a></li>
                        <?php }?>
                    </ul>
                    <?php if(checkMenu('System/SysCode/index')){ ?>
                    <a href="#menu6" class="nav-header collapsed" data-toggle="collapse"><i class="icon-cogs"></i>系统管理</a>
                    <?php }?>
                    <ul id="menu6" class="nav nav-list collapse">
                        <?php if(checkMenu('System/SysCode/index')){ ?>
                        <li ><a href="<?php echo U('System/SysCode/index');?>" target='content_frame' data-tabview="system_0">系统代码管理</a></li>
                        <?php }?>
                    </ul>
                    <?php if(checkMenu('Auth/User/user_list') || checkMenu('Auth/User/create_group') || checkMenu('Auth/User/auth_list')) { ?>
                    <a href="#menu2" class="nav-header collapsed" data-toggle="collapse"><i class="icon-users"></i><?php echo (L("index_user_manage")); ?></a>
                    <?php } ?>
                    <ul id="menu2" class="nav nav-list collapse">
                        <?php  if(checkMenu("Auth/User/user_list")) { ?>
                        <li ><a href="<?php echo U('User/user_list');?>" target='content_frame' data-tabview="user_1"><?php echo (L("index_user_list")); ?></a></li>
                        <?php } if(checkMenu("Auth/Manager/auth_list")) { ?>
                        <li ><a href="<?php echo U('Manager/auth_list');?>" target='content_frame' data-tabview="user_3"><?php echo (L("index_user_group_list")); ?></a></li>
                         <?php }?>
                    </ul>
                    <?php if(checkMenu('Auth/Department/add_department') || checkMenu("Auth/Department/department_show")){ ?>
                    <a href="#menu3" class="nav-header collapsed" data-toggle="collapse"><i class="icon-hospital-o"></i>公司结构</a>
                    <?php }?>
                    <ul id="menu3" class="nav nav-list collapse">
                        <?php if(checkMenu('Auth/Department/add_department')){ ?>
                        <li ><a href="<?php echo U('Department/add_department');?>" target='content_frame' data-tabview="dept_1">添加部门</a></li>
                        <?php } if(checkMenu("Auth/Department/department_show")) { ?>
                        <li ><a href="<?php echo U('Department/department_show');?>" target='content_frame' data-tabview="dept_2">公司结构展示</a></li>
                        <?php }?>
                        <li ><a href="<?php echo U('Department/role_list');?>" target='content_frame' data-tabview="dept_2">角色列表</a></li>
                    </ul>
                    <!----工作流---->
                    <?php if(checkMenu('Workflow/Index/index') || checkMenu("Workflow/Index/appList")){ ?>
                    <a href="#menu4" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exchange"></i>流程管理</a>
                    <?php }?>
                    <ul id="menu4" class="nav nav-list collapse">
                        <?php if(checkMenu("Workflow/Index/index")) { ?>
                        <li ><a href="<?php echo U('Workflow/Index/index');?>" target='content_frame' data-tabview="flow_1">流程管理</a></li>
                        <?php } if(checkMenu("Workflow/Index/appList")) { ?>
                        <li ><a href="<?php echo U('Workflow/Index/appList');?>" target='content_frame' data-tabview="flow_2">流程应用</a></li>
                         <?php }?>
                    </ul>

                    
                    

                </div> 
            </div>
            <div class="zhedie"><span class="zhedie-btn img-circle"><i class="icon-cog"></i></span></div>
            <div class="content">
                <iframe style="width:100%;" id='frame_0' name='content_frame' frameborder='0' src="<?php echo U('Index/desktop');?>" >
            </div>
        </div>

</html>