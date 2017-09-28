<?php if (!defined('THINK_PATH')) exit();?><legend>
    <p class="text-primary">
        <?php echo (L("PRODUCT_TYPE_ADD")); ?>
    </p>
</legend>
<form action="<?php echo U();?>" method="post" role="form" id ='form' class="form-horizontal">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label"><?php echo (L("PRODUCT_TYPE_TYPENAME")); ?></label>
        <div class="col-sm-10">
            <input type="text" style="width:30%" class="form-control" name="name" id="name" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label"><?php echo (L("PRODUCT_TYPE_TYPENAME_EN")); ?></label>
        <div class="col-sm-10">
            <input type="text" style="width:30%" class="form-control" name="en_name" id="name" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label"><?php echo (L("MENU_SUPERIOR_MENU")); ?></label>
        <div class="col-sm-10">
            <select class="form-control" style="width:30%" name="pid">
                <option value="0">顶级类型</option>
                <?php if(is_array($product_tree)): $i = 0; $__LIST__ = $product_tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$product_tree): $mod = ($i % 2 );++$i;?><option value="<?php echo ($product_tree["id"]); ?>"><?php echo ($product_tree["title_show"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label"><?php echo (L("REMARKS")); ?></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" style="width:30%" name="remarks" value="<?php echo ((isset($info["tip"]) && ($info["tip"] !== ""))?($info["tip"]):''); ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button class="btn btn-primary" id="submit-form" type="submit" target-form="form-horizontal"><?php echo (L("SUBMIT")); ?></button>
            <a class="btn btn-warning" href="<?php echo U('product_type_list');?>"><?php echo (L("RETURN")); ?></a>
        </div>
    </div>
</form>
<script type="text/javascript">
//表单验证
    $(document).ready(function() {
        $('#form').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            	name: {
                    validators: {
                        notEmpty: {
                            message: '类型名称不能为空'
                        },
                    }
                },
            }
        });
    });

</script>