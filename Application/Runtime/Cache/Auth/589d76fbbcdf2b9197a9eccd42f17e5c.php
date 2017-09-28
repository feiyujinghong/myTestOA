<?php if (!defined('THINK_PATH')) exit();?><legend>
    <p class="text-primary">
        权限列表
        <a href='<?php echo U("add");?>' class="btn btn-danger pull-right">添加权限</a>
    </p>
</legend>
<table class='table table-hover'>
<?php if(is_array($main)): foreach($main as $key=>$val): ?><tr class="text-primary">
        <td><?php echo ($val["title"]); ?></td>
        <td><?php echo ($val["url"]); ?></td>
        <td>
            <a href="<?php echo U('edit',array('id'=>$val['id']));?>">编辑</a>
            <a href="javascript:del(<?php echo ($val["id"]); ?>)">删除</a>
        </td>
    </tr>
   <?php  foreach($son[$key] as $sonv){ ?>
        <tr>
        <td style="padding-left:40px;"><?php echo ($sonv["title"]); ?></td>
        <td><?php echo ($sonv["url"]); ?></td>
        <td>
            <a href="<?php echo U('edit',array('id'=>$sonv['id']));?>">编辑</a>
            <a href="javascript:del(<?php echo ($sonv["id"]); ?>)">删除</a>
        </td>
    </tr>
       <?php } endforeach; endif; ?>
    </table>
<script>
    function del(id){
        if(confirm("确定要删除该权限吗？")){
            window.location.href="delete/id/"+id;
        }
    }
</script>