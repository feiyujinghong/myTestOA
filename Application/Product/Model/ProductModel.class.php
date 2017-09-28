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

class ProductModel extends Model {

	protected $_validate = array(
		array('product_name', 'require', '必须填写名称', Model::MUST_VALIDATE, 'regex', Model::MODEL_INSERT),
		array('en_name','require', '必须填写名称', Model::MUST_VALIDATE ,'regex',Model::MODEL_INSERT),
	);

	public function get_product_by_id($map) {

		return $this->field(true)->where($map)->find();
	}

	public function save_product($map, $s_data) {
		if (!is_array($map) || empty($map)) {
			return false;
		}
		if (!is_array($s_data)) {
			return false;
		}
		$this->where($map)->save($s_data);
		return M()->getLastSql();
	}

}
