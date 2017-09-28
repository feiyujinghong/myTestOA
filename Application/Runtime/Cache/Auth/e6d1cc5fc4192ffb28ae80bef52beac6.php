<?php if (!defined('THINK_PATH')) exit();?>
<style>
    .desktop{
        width:45%;
        float: left;
        margin-right:20px;
    }
</style>
<div class="panel panel-success desktop">
    <!-- Default panel contents -->
    <div class="panel-heading">本月员工生日列表
        <a href="<?php echo U('Hr/Staff/staff_list_bir?bir=bir');?>" target='content_frame' style="float: right;">全部</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>姓名</th>
                <th>日期类型</th>
                <th>日期</th>
                <th>电话</th>
            </tr>
        </thead>
        <?php if(!empty($staff_info)): ?><tbody>
            <?php if(is_array($staff_info)): $i = 0; $__LIST__ = $staff_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo['name']); ?>
                <?php if($vo['sex'] == 1): ?>[男]<?php else: ?>[女]<?php endif; ?>
                </td>
                <td><?php if($vo['bir_type'] == 1): ?>阳历<?php else: ?>农历<?php endif; ?></td>
                <td><?php echo (date("Y-m-d",$vo["birthday"])); ?></td>
                <td><?php echo ($vo["phone"]); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            <?php else: ?>
            <tbody>
                <tr>
                    <td colspan="4">没有数据...</td>
                </tr>
            </tbody><?php endif; ?>
    </table>
</div>
<div class="panel panel-info desktop">
    <!-- Default panel contents -->
    <div class="panel-heading">本月发单预订单</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>客户名称</th>
                <th>发单日期</th>
                <th>操作</th>
            </tr>
        </thead>
        <?php if(!empty($orderData)): ?><tbody>
            <?php if(is_array($orderData)): $i = 0; $__LIST__ = $orderData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo['cli_name']); ?></td>
                <td><?php echo (date("Y-m-d",$vo["order_time"])); ?></td>
                <td><a href=javascript:windowopen("<?php echo U('Cli/CliOrder/showInfo',array('id'=>$vo['id']));?>") data-toggle="tooltip" data-placement="top" title="查看"><i class='icon-eye'></i></a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            <?php else: ?>
            <tbody>
                <tr>
                    <td colspan="4">没有数据...</td>
                </tr>
            </tbody><?php endif; ?>
    </table>
</div>
<div class="panel panel-danger desktop">
    <!-- Default panel contents -->
    <div class="panel-heading">本月客户生日</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>公司名称</th>
                <th>联系人</th>
                <th>生日</th>
                <th>电话</th>
            </tr>
        </thead>
         <?php if(!empty($brithDayData)): ?><tbody>
            <?php if(is_array($brithDayData)): $i = 0; $__LIST__ = $brithDayData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo['company_name ']); ?></td>
                    <td><?php echo ($vo['name ']); ?></td>
                <td><?php echo (date("m-d",$vo["bir"])); ?></td>
                <td><?php echo ($vo['mobile ']); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            <?php else: ?>
            <tbody>
                <tr>
                    <td colspan="4">没有数据...</td>
                </tr>
            </tbody><?php endif; ?>
    </table>
</div>
<div class="panel panel-warning desktop">
    <!-- Default panel contents -->
    <div class="panel-heading">Panel heading</div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="panel panel-warning desktop">
    <!-- Default panel contents -->
    <div class="panel-heading">合同信息</div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="panel panel-warning desktop">
    <!-- Default panel contents -->
    <div class="panel-heading">工作计划</div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>
</div>