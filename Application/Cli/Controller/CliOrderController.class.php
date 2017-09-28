<?php
/**
 * Description of CliOrder
 * 客户预订单
 * @author xxb
 */
namespace Cli\Controller;

use Think\Model;

use Think\Auth;

use Auth\Controller\AuthController;
use Product\Controller\ProductController;
use Cli\Controller\OpCliController;

class CliOrderController extends AuthController{
	
	CONST CREATE = 0;
	CONST SUCCESS = 1;
	CONST ERROR = 3;
	public function _initialize() {
		parent::_initialize();
		require_once "./Application/Common/Conf/c_select.php";
		$this->c_s = $con_select;
	}
	/**
	 * 增加订单
	 */
	public function addOrder($id){
		if(IS_POST){
			$data["cli_id"] = I("cli_id");
			$data["cli_name"] = I("cli_name");
			$data["order_time"] = strtotime(I("order_time"));
			$data["remark"] = I("remark");
			$data["add_user"] = UID;
			$data["add_time"] = time();
			$data["status"] = self::CREATE;
			M()->startTrans();
			$order_id = M("cli_order")->add($data);
			$product_id = I("product_id");
			$selling_price = I("Selling_price");
			$count = I("count");
			if($order_id){
				foreach($product_id as $key=>$p_id){
					$son[] = array(
						"order_id"=>$order_id,
						"selling_price"=>$selling_price[$key],
						"product_id"=>$p_id,
						"count"=>$count[$key],
					);
				}
				$ret = M("cli_order_product")->addAll($son);
			}
			if($ret){
				M()->commit();
				$this->success ("提交成功",U("Cli/OpCli/cliList"));
			}else{
				M()->rollback();
				$this->error ("提交失败");
			}
		}
		$data = M("cli")->where(array("id"=>$id))->find();
		$this->assign("data",$data);
		$this->display();
		$productModel = new ProductController;
		$productModel->selectProduct(1);
	}
	/**
	 * 添加产品
	 */
	public function addProduct($ids){
		$ids = trim($ids,",");
		$data = M("product")->where("id IN (".$ids.")")->field("id,product_content,product_price,product_no,product_name,en_name,product_format,product_en_format,product_unit")->select();
		foreach($data as $val){
			echo "<tr>"
			."<td><a class='text-primary del_option'><i class='icon-trash-o'></i></a></td>"
			. "<input type='hidden' name='product_id[]' value=".$val["id"].">"
			. "<td>".checkLanguage($val["product_name"], $val["en_name"])."</td>"
			. "<td>".checkLanguage($val["product_format"], $val["product_en_format"])."</td>"
			. "<td>".$val["product_content"]."</td>"
			. "<td>".$this->c_s["product_unit"][$val["product_unit"]]."</td>"
			. "<td>".$val["product_price"]."</td>"
			. "<td><input type='text' size=5 name='Selling_price[]' value=".$val["product_price"]."></td>"
			. "<td><input type='text' size=5 name='count[]'></td>"
			. "</tr>";
		}
	}
	/**
	 * 订单列表
	 */
	public function orderList($cli_id){
		$cli_id = intval($cli_id);
		$cli = new OpCliController();
		if(!$cli->isAccess($cli_id)){
			$this->error("您没有权限查看");
		}
		$data = $this->lists("cli_order", array("cli_id"=>$cli_id), "id desc");
		$this->assign("data",$data);
		$this->assign("status",array(self::CREATE=>"新建",self::SUCCESS=>"生成合同",self::ERROR=>"订单失效"));
		$this->display();
	}
	/**
	 * 编辑
	 * @param type $id
	 */
	public function update($id){
		$data = M("cli_order")->where(array("id"=>$id))->find();
		$cli = new OpCliController();
		if(!$cli->isAccess($data["cli_id"]) && $data["add_user"] != UID){
				$this->error("您没有修改权限");
		}
		if(IS_POST){
			$data["id"] = I("id");
			$data["cli_id"] = I("cli_id");
			$data["cli_name"] = I("cli_name");
			$data["order_time"] = strtotime(I("order_time"));
			$data["remark"] = I("remark");
			$data["add_user"] = UID;
			$data["add_time"] = time();
			$data["status"] = self::CREATE;
			M()->startTrans();
			$order_id = M("cli_order")->where(array("id"=>$data["id"]))->save($data);
			$product_id = I("product_id");
			$selling_price = I("Selling_price");
			$count = I("count");
			if($order_id){
				M("cli_order_product")->where(array("order_id"=>$data["id"]))->delete();
				foreach($product_id as $key=>$p_id){
					$son[] = array(
						"order_id"=>$order_id,
						"selling_price"=>$selling_price[$key],
						"product_id"=>$p_id,
						"count"=>$count[$key],
					);
				}
				$ret = M("cli_order_product")->addAll($son);
			}
			if($ret){
				M()->commit();
				$this->success ("提交成功",U("Cli/OpCli/cliList"));
			}else{
				M()->rollback();
				$this->error ("提交失败");
			}
		}
		$this->assign("data",$data);
		$this->assign("id",$id);
		$orderData = M("cli_order_product")->where(array("order_id"=>$id))->select();
		$this->assign("data",$data);
		$sql = "select "
			. "a.id,"
			. "a.product_content,"
			. "a.product_price,"
			. "a.product_no,"
			. "a.product_name,"
			. "a.en_name,"
			. "a.product_format,"
			. "a.product_en_format,"
			. "a.product_unit,"
			. "b.selling_price,"
			. "b.count "
			. " from "
			. " cli_order_product as b,product as a "
			. " where b.product_id = a.id "
			. " and b.order_id=".$id;
		$listData = M()->query($sql);
		foreach($listData as $key=>$val){
			$listData[$key]["product_name"] = checkLanguage($val["product_name"], $val["en_name"]);
			$listData[$key]["product_format"] = checkLanguage($val["product_format"], $val["product_en_format"]);
			$listData[$key]["product_unit"] = $this->c_s["product_unit"][$val["product_unit"]];
		}
		$this->assign("listData",$listData);
		$this->display();
		$productModel = new ProductController;
		$productModel->selectProduct(1);
	}
	
	/**
	 * 查看
	 * @param type $id
	 */
	public function showInfo($id){
		$data = M("cli_order")->where(array("id"=>$id))->find();
		$cli = new OpCliController();
		if(!$cli->isAccess($data["cli_id"]) && $data["add_user"] != UID){
				$this->error("您没有查看权限");
		}
		$this->assign("data",$data);
		$this->assign("id",$id);
		$orderData = M("cli_order_product")->where(array("order_id"=>$id))->select();
		$this->assign("data",$data);
		$sql = "select "
			. "a.id,"
			. "a.product_content,"
			. "a.product_price,"
			. "a.product_no,"
			. "a.product_name,"
			. "a.en_name,"
			. "a.product_format,"
			. "a.product_en_format,"
			. "a.product_unit,"
			. "b.selling_price,"
			. "b.count "
			. " from "
			. " cli_order_product as b,product as a "
			. " where b.product_id = a.id "
			. " and b.order_id=".$id;
		$listData = M()->query($sql);
		foreach($listData as $key=>$val){
			$listData[$key]["product_name"] = checkLanguage($val["product_name"], $val["en_name"]);
			$listData[$key]["product_format"] = checkLanguage($val["product_format"], $val["product_en_format"]);
			$listData[$key]["product_unit"] = $this->c_s["product_unit"][$val["product_unit"]];
		}
		$this->assign("listData",$listData);
		$this->display();
		$productModel = new ProductController;
		$productModel->selectProduct(1);
	}
}
