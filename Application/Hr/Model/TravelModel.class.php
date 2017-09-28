<?php
// +----------------------------------------------------------------------
// | CO
// +----------------------------------------------------------------------
// | Copyright (c) 2015 www.c_o.com
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------

namespace Hr\Model;
use Think\Model;

/**
 * 用户组模型类
 * Class StaffModel
 */
class TravelModel extends Model {

    protected $_validate = array(
        array('title','require', '必须填写标题', Model::MUST_VALIDATE ,'regex',Model::MODEL_INSERT),
     
    );
    
    public function get_travel_by_id($map, $field = array("`id`", "`user_id`", "`title`", "`travel_start_time`", "`travel_finish_time`", "`travel_place`", "`travel_info`", "`remarks`")) {
    	
    	return $this->field($field)->where($map)->find();
    	//return M()->getLastSql();
    
    }
	
    

}

