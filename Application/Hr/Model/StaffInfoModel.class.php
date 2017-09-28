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
class StaffInfoModel extends Model {

    protected $_validate = array(
        array('name','require', '必须填写姓名', Model::MUST_VALIDATE ,'regex',Model::MODEL_INSERT),
     
    );
    
    public function get_staff_info($field_array = array(),$map = array()) {
    	return $this->field($field_array)->where($map)->find();
    	//return M()->getLastSql();
    }
    
    public function get_link_info($staff_id) {
    	return M("staff_link_info")->field(array("`link_name`", "`link_gx`", "`link_tele`", "`link_work`", "`link_position`", "`link_address`"))
    				->order('id')
    				->where(array('staff_info_id'=>intval($staff_id)))
    				->select();
    	
    }
	
    

}

