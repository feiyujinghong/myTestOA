<?php
// +----------------------------------------------------------------------
// | Product-产品类型
// +----------------------------------------------------------------------
// | Copyright (c) 2015 www.c_o.com
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------
namespace Product\Controller;

use Think\Model;

use Think\Auth;

use Auth\Controller\AuthController;

class ProductTypeController extends AuthController {
	
	public function _initialize() {
		parent::_initialize ();
		require_once "./Application/Common/Conf/c_select.php";
		$this->c_s = $con_select;
		$this->assign("c_s",$this->c_s);
	}
	
	/**
	 * 添加产品类型
	 */
	public function add_product_type() {
		if (IS_POST) {
			$product_type = D("ProductType");
			$r_product_type = $product_type->create();
			if (!$r_product_type) {
				exit($product_type->getError());
			}
			$r_product_type['add_time'] = time();
			$r_product_type['add_ip'] = get_client_ip(0);
			
			if (I("post.edit_type") == "edit" && I("post.pro_id")) {
				$w_array = array('id'=>intval(I("post.pro_id")));
				$r = $product_type->where($w_array)->save($r_product_type);
				//echo M()->getLastSql(0);exit();
			} else {
				$r = $product_type->add($r_product_type);
			}
			//$product_type->add($r_product_type);
			
			if (false !== $r) {
				$this->success("操作成功");
			} else {
				$this->error("操作失败");
			}
		}
		$this->assign("product_tree", $this->product_tree());
		$this->display();
	}
	
	/**
	 * 产品编辑
	 */
	public function product_type_edit() {
		if (I("get.id")) {
			$p_type_id = intval(I("get.id"));
			$product_type = D("ProductType");
			$check_next = $product_type->product_type_count(array("pid"=>$p_type_id));
			//dump($check_next);
			if ($check_next) {
				$is_next = 1;
			} else {
				$is_next = 2;	//可以修改结构
			}
			$this->assign('is_next',$is_next);
			$product_type_info = $product_type->where(array("id"=>$p_type_id))->find();
			//dump($product_type_info);
			$this->assign("product_type_info",$product_type_info);
			$this->assign("product_tree", $this->product_tree());
			$this->assign("edit_type", "edit");
			$this->display("edit_product_type");
		}
	}
	
	/**
	 * 删除
	 */
	public function dele_p_t() {
		if (I("get.id")) {
			$product_id = intval(I("get.id"));
			$product_type = D("ProductType");
			$check_next = $product_type->product_type_count(array("pid"=>$product_id));
			if ($check_next) {
				echo "只能删除底级结构";
			} else {
				$r = $product_type->where(array("id"=>$product_id))->delete();
				if ($r !== false) {
					echo "删除成功！";
				} else{
					echo "删除失败！";
				}
			}
		}
	}
	
	/**
	 * 产品结构
	 */
	public function product_type_list() {
		$pid = I('get.pid');
		!empty($pid) ? $map = array('pid'=>$pid) : $map = array('pid'=>0);
		$product_type = D("product_type");
		$product_type_info = $product_type->where($map)->select();
		if(cookie("think_language") == "en-us")
			$is_en = 1;
		foreach ($product_type_info as $key=>$value) {
			$n_map = array('pid'=>$value['id']);
			$next_count = $product_type->product_type_count($n_map);
			$product_type_info[$key]['next_count'] = $next_count;
			$product_type_info[$key]['name'] = $is_en == 1 ? $value["en_name"] : $value["name"];
		}
		$this->pro_type_tree();
		$this->assign('product_type_info', $product_type_info);
		$this->display();
	}
	
	/**
	 * 产品树结构
	 */
	public function pro_type_tree() {
		$product_type = D("product_type");
		$product_type_info = $product_type->product();
		foreach ($product_type_info as $key=>$value) {
			$product_type_info[$key]['pId'] = $product_type_info[$key]['pid'];
		}
		$this->assign('tree_data',json_encode($product_type_info));
		
	}
	
	
}