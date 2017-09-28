<?php
// +----------------------------------------------------------------------
// | CO
// +----------------------------------------------------------------------
// | Copyright (c) 2015 www.c_o.com
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------

namespace Product\Model;
use Think\Model;


class ProductTypeModel extends Model {

    protected $_validate = array(
        array('name','require', '必须填写名称', Model::MUST_VALIDATE ,'regex',Model::MODEL_INSERT),
     
    );
    
    /**
     * 判断是否有下级
     */
 	public function product_type_count($map) {
    	if (!is_array($map)) { return false; }
    	return $this->where($map)->count();
    } 
	
	public function product($map = array()) {
    	
    	return $this->field(array("`id`","`name`","`pid`", "`remarks`"))->where($map)->select();
    
    }
    

}

