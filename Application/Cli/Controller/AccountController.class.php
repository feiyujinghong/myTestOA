<?php
/**
 * 合同
 *
 * @author xxb
 */
namespace Cli\Controller;

use Think\Model;

use Think\Auth;
use Upload\Controller\UploadController;
use Auth\Controller\AuthController;
use Product\Controller\ProductController;
use Cli\Controller\OpCliController;

class AccountController extends AuthController{
	
	public function _initialize() {
		parent::_initialize();
		require_once "./Application/Common/Conf/c_select.php";
		$this->c_s = $con_select;
	}
	/**
	 * 开始合同
	 */
	public  function start(){
		$order_id = I("get.id");
		$sql = "select cli.company_name,cli.company_no,cli.id as cli_id,cli_order.order_time,cli_order.remark from cli,cli_order where cli.id = cli_order.cli_id and cli_order.id=".$order_id;
		$data = M()->query($sql);
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
			. " and b.order_id=".$order_id;
		$listData = M()->query($sql);
		foreach($listData as $key=>$val){
			$listData[$key]["product_name"] = checkLanguage($val["product_name"], $val["en_name"]);
			$listData[$key]["product_format"] = checkLanguage($val["product_format"], $val["product_en_format"]);
			$listData[$key]["product_unit"] = $this->c_s["product_unit"][$val["product_unit"]];
		}
		$upload = new UploadController();
		$this->assign('up_load', $upload->uploadBtn("product"));
		$this->assign("data",$data[0]);
		$this->assign("listData",$listData);
		$this->display();
	}
}
