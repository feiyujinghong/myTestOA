<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------

namespace Auth\Model;
use Think\Model;
class DepartmentModel extends Model{
// 实际数据表名（包含表前缀）
    protected $trueTableName    =   'department';
	protected $_validate = array(
        array('name','require', '必须填写部门名称', Model::MUST_VALIDATE ,'regex',Model::MODEL_INSERT),
        //array('level','require', '必须选择所属级别', Model::MUST_VALIDATE ,'regex',Model::MODEL_INSERT),
    );
    
    public function department_count($map) {
    	if (!is_array($map)) { return false; }
    	return $this->where($map)->count();
    }
    
    public function department($map = array()) {
			return $this->field(array("`id`","`name`","`pid`","`level`","`remarks`"))->where($map)->select();
    }
    
    /**
     * 根据用户ID获取部门
     * @param int $user_id：用户ID
     */
    public function get_user_depat($user_id) {
    	$map = array();
    	$map['uid'] = $user_id;
    	$depat_arr = M("user_department")->where($map)->getField("dept_id",true);
    	$de_map = array();
    	$de_map['id'] = array('IN',$depat_arr);
    	$depat_arr = $this->where($de_map)->getField("name",true);
    	//echo M()->getLastSql();
    	return $depat_arr;
    }
    

}
