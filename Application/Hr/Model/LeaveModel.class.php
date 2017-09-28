<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------

namespace Hr\Model;
use Think\Model;

/**
 * 用户组模型类
 * Class StaffModel
 */
class LeaveModel extends Model {

    protected $_validate = array(
        array('leave_type','require', '必须填写请假类型', Model::MUST_VALIDATE ,'regex',Model::MODEL_INSERT),
     
    );
    
	public function get_leave_by_id($map, $field=array("`id`", "`user_id`", "`leave_type`", "`leave_start_time`", "`leave_finish_time`", "`leave_explain`", "`remarks`")) {
		
		return $this->field($field)->where($map)->find();
	
	}
    

}

