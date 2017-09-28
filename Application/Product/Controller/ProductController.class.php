<?php
// +----------------------------------------------------------------------
// | Product-产品
// +----------------------------------------------------------------------
// | Copyright (c) 2015 www.c_o.com
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------
namespace Product\Controller;

use Upload\Controller\UploadController;

use Think\Model;

use Think\Auth;

use Auth\Controller\AuthController;

class ProductController extends AuthController {
	
	public function _initialize() {
		parent::_initialize ();
		require_once "./Application/Common/Conf/c_select.php";
		$this->c_s = $con_select;
		$this->assign("c_s",$this->c_s);
	}
	/**
	 * 判断产品唯一性
	 */
	private  function unique($id=0){
		$map["product_no"] = I("product_no");
		if(!empty($id))
			$map["id"]=array("NEQ",$id);
		$ret = M("product")->where($map)->count();
		if($ret){
			$this->error("该编号已经存在");
		}
		unset($map["product_no"]);
		$map['product_name'] = I("product_name");
		$map['product_format'] = I("product_format");
		$map['product_content'] = I("product_content");
		$ret = M("product")->where($map)->count();
		if($ret){
			$this->error("该产品已经存在");
		}
		
	}
	/**
	 * 添加产品
	 */
	public function add_product() {
		if (IS_POST) {
			$product_id = I("product_id");
			//$this->unique($product_id);
			$product = D('Product');
			$r_product = $product->create();
			$r_product ['add_time'] = time();
			$product_type = $this->get_superior_producttype($r_product['product_type']);
			krsort($product_type);
			foreach ($product_type as $key=>$value) {
				$p_name_arr[] = $value['name'];
			}
			$r_product ['produec_type_str'] = implode("->", $p_name_arr);// 字符串形式
			if (I("post.edit_type") == "edit" && I("post.product_id")) {
				$product_id = intval(I("post.product_id"));
				$r = $product->where(array("id"=>$product_id))->save($r_product);
				$r = $product_id;
			} else {
				$r = $product->add($r_product);
			}
			//$r = $product->add($r_product);
			if (false !== $r) {
				/*//图片
				if (!empty($_FILES)) {
					$user_pic = $this->tp_upload();
					if ($user_pic) {
						$product_pic_path = "SysUploads/".$user_pic['file']['savepath'].$user_pic['file']['savename'];
						$s_product = array();
						$s_product ['product_pic'] = $product_pic_path;
						$s_product ['product_pic_name'] = $_FILES['file']['name'];
						$s = $product->where(array("id"=>$r))->save($s_product);
						//echo M()->getLastSql();exit();
						if (false === $s) {
							$this->error('产品图片上次失败!');
							exit();
						}
					}
				}*/
				if (I("post.upload_update")) {
					$attach_id_str = trim(I("post.upload_update"));
					$upload = new UploadController();
					$upload->updateUpload($attach_id_str, "product",$r);
				}
				$this->success("操作成功",U("product_list"));
				exit();
			} else {
				$this->error("操作失败",U("add_product"));
				exit();
			}
		}
		$upload = new UploadController();
		$this->assign('up_load', $upload->uploadBtn("product"));
		$this->assign("product_info",$this->getNumber());
		$this->assign("product_tree", $this->product_tree());
		$this->display('add_product');
	}
	/**
	 * 获取新的产品编号
	 */
	private  function getNumber(){
		$sql = "select max(id) as max_id from product";
		$data = M()->query($sql);
		$ret = $data[0]["max_id"];
		$num = 10000+$ret+1;
		$new_num = "LGB".substr($num,1);
		$arr["product_no"] = $new_num;
		return $arr;
	}
	/**
	 * 产品编辑
	 */
	public function product_update() {
		if (I("get.id")) {
			$id = intval(I("get.id"));
			$product_info = $this->get_product_info($id);
			$product_info["product_en_bak"]=  str_replace(array("\n","\r","\r\n"), "<br>",$product_info["product_en_bak"]);
			$product_info["product_bak"]=  str_replace(array("\n","\r","\r\n"), "<br>",$product_info["product_bak"]);
			$this->assign("product_info",$product_info);
			$this->assign("edit_type", "edit");
			$this->assign("product_tree", $this->product_tree());
			//上传按钮
			$upload = new UploadController();
			$this->assign('up_load', $upload->uploadBtn("product", $id));
			//图片信息
			$r_attach = getPicInfo('product', $id);
			$this->assign('attach_info',$r_attach);
			
			$this->display("add_product");
		}
	}
	
	/**
	 * 删除产品图片
	 */
	public function dele_pic() {
		if (I("post.pro_id")) {
			$pro_id = intval(I("post.pro_id"));
			$w_arr = array('id'=>$pro_id);
			$s_data = array('product_pic'=>'', 'product_pic_name'=>'');
			$s = D('Product')->save_product($w_arr, $s_data);
			$msg = false !== $s ? "删除成功" : "删除失败！";
			echo $msg;
		}
	}
	
	
	/**
	 * 产品列表
	 */
	public function product_list() {
		$map = array();
		//搜索
		$map = "1=1";
		if (I("get.product_name")) {
			$product_name = trim(I("get.product_name"));
			$map .= " and (product_name like '%".$product_name."%' OR en_name like '%".$product_name."%')";
		}
		
		if (I("get.product_format")) {
			$product_format = trim(I("get.product_format"));
			$map .= " and (product_format like '%".$product_format."%' OR product_en_format like '%".$product_format."%')";
		}
		
		if (I("get.is_self")) {
			$is_self = intval(I("get.is_self"));
			$map .= " and is_self = ".$is_self;
		}
		$product_info = $this->lists("Product", $map);
		$typedata = M("product_type")->select();
		foreach($typedata as $val){
			$type[$val["id"]] = $val;
		}
		foreach ($product_info as $key=>$value) {
			$product_info[$key]['product_unit_ch'] = $this->c_s['product_unit'][$value['product_unit']];
			$product_info[$key]['product_name'] = checkLanguage($value["product_name"],$value["en_name"]);
			$product_info[$key]['product_format'] = checkLanguage($value["product_format"],$value["product_en_format"]);
		}
		$this->assign('product_info', $product_info);
		$this->display();
	}
	
	public function show_product_info() {
		if (I("get.id")) {
			$id = intval(I("get.id"));
			$product_info = $this->get_product_info($id);
			$product_info ['product_unit_ch'] = $this->c_s['product_unit'][$product_info ['product_unit']];
			
			$product_info ['product_name'] = checkLanguage($product_info["product_name"], $product_info["en_name"]);
			$product_info ['product_format'] = checkLanguage($product_info["product_format"], $product_info["product_en_format"]);
			$product_info ['product_bak'] = htmlspecialchars_decode(checkLanguage($product_info["product_bak"], $product_info["product_en_bak"]));
			
			$sql = "select a.name,b.count,b.warnning,b.danger from warehouse as a,warehouse_product as b where a.id = b.warehouse_id and b.product_id=".$id;
			$warehousenum = M()->query($sql);
			$typeNameData = M("product_type")->where(array("id"=>$product_info["product_type"]))->find();
			$this->assign("type_name",  checkLanguage($typeNameData["name"], $typeNameData["en_name"]));
			$this->assign("warehousenum",$warehousenum);
			$this->assign('product_info', $product_info);
			//pic
			$r_attach = getPicInfo('product', $id);
			$this->assign('attach_info',$r_attach);
			$this->display("view");
		}
	}
	
	
	/**
	 * 获得产品信息
	 * @param int $id:产品信息ID
	 */
	public function get_product_info($id) {
		$map = array();
		$map ['id'] = intval($id);
		$product_info = D('Product')->get_product_by_id($map);
		return $product_info;
	}
	
	
	/**
	 * 无线获取上级部门
	 * @param int   $id:产品类型ID
	 * @param array $pro_type
	 */
	public function get_superior_producttype($id, $pro_type = array()) {
		$self_info = M("product_type")->field("id, name, pid")->where('id = '.$id)->find();
		$pro_type [] = $self_info;
		if ($self_info['pid'] > 0) {
			$superior = M("product_type")->field("id, name, pid")->where('id = '.$self_info['pid'])->find();
			return $self_info = $this->get_superior_producttype($superior['id'], $pro_type);
		} else {
			return $pro_type;
		}
	}
	
	public function selectProduct($isCli=0){
		$this->include_header=false;
		$this->assign("isCli",$isCli);
		$this->display(T("Product@Product:selectProduct"));
	}
	
	/**
	 * 根据查询条件返回
	 */
	public function productSearch(){
		$name = I("name");
		$num = I("num");
		$warehouse_id = I("warehouse_id");
		if(!empty($name))
			$map["product_name"] = array("LIKE","%".$name."%");
		if(!empty($num))
			$map["product_no"] = array("LIKE","%".$num."%");
		$data = M("product")->where($map)->limit(5)->select();
		$have_data = M("warehouse_product")->where(array("warehouse_id"=>$warehouse_id))->getField("product_id",true);
		if(cookie("think_language") == "en-us")
			$is_en = 1;
		foreach($data as $val){
			if($is_en == 1){
				$name = $val['en_name'];
				$format = $val['product_en_format'];
			}else{
				$name = $val['product_name'];
				$format = $val['product_format'];
			}
			echo "<li class='list-group-item'>	";
			if(!in_array($val["id"], $have_data))	//如果已经存在该库则不能选择
				echo '<input type="checkbox" name="product[]" value="'.$val["id"].'"> ';
             echo   ' 【编号:】'.$val['product_no']
                        .' 【名称:】'.$name
                        .' 【规格:】'.$format
                        .'</li>';
		}
	}
}