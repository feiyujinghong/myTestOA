<?php

/**
 * 仓库管理类
 *
 * @author xxb
 */

namespace Product\Controller;

use Auth\Controller\AuthController;

class WarehouseController extends AuthController {

	private $_model;
	
	public $c_s;
	CONST IO_PRODUCTS_SESSION = "addIOProduct";

	CONST INNER = 2;//ruku
	CONST OUTER = 1 ;//chuku
	CONST REMOVE = 3; //yiku
	public function _initialize() {
		parent::_initialize();
		$this->_model = M("warehouse");
		require_once "./Application/Common/Conf/c_select.php";
		$this->c_s = $con_select;
	}

	/**
	 * 仓库列表
	 */
	public function warehouselists() {
		$warehouse_data = M("warehouse_admin")->select();
		foreach ($warehouse_data as $val) {
			if ($val["user_id"] == UID)
				$warehouse_ids[] = $val["warehouse_id"];
			$warehouseData[$val["warehouse_id"]][] = $val["user_id"];
		}
		if(empty($warehouse_ids))
			$warehouse_ids = array(0);
		$map = " (id in (" . implode(",", $warehouse_ids) . ") or add_user = " . UID.") ";
		//根据查询条件出结果
		if (!empty($_GET["name"]))
			$map .= " and (name like '%" . I("get.name") . "%' or en_name like '%" . I("get.name") . "%')";
		if (!empty($_GET["num"]))
			$map .= " and num like '%" . I("get.num") . "%'";
		if (!empty($_GET["address"]))
			$map .= " and (address like '%" . I("get.address") . "%' or en_address like '%" . I("get.address") . "%')";
		$data = $this->lists("warehouse", $map);
		$is_admin = is_administrator() ? 1 : $this->checkRule("Product/Warehouse/add");
		foreach ($data as $key => $val) {
			foreach ($warehouseData[$val["id"]] as $val1)
				$data[$key]["admin_name"] .= get_username($val1) . ",";
		}
		$this->assign("is_admin", $is_admin);	//判断是否管理员，拥有添加仓库权限的就是管理员
		$this->assign("data", $data);
		$this->assign("lang",cookie("think_language"));
		$this->display();
	}

	/**
	 * 添加仓库
	 */
	public function add() {
		if (IS_POST) {
			foreach ($_POST as $key => $val) {
				$data[$key] = i($key);
			}
			if ($this->_model->where(array("num" => $data["num"]))->count())
				$this->error("已存在该编号！");
			$data["add_user"] = UID;
			$data["add_time"] = time();
			$admin = $data["admin_id"];
			if (strpos($admin, ",")) {
				$admin_ids = explode(",", $admin);
			} else {
				$admin_ids = array($admin);
			}

			unset($data["admin"]);
			unset($data["admin_id"]);
			M()->startTrans();
			$add_id = $this->_model->add($data);
			foreach ($admin_ids as $val) {
				$admin_data[] = array("warehouse_id" => $add_id, "user_id" => $val);
			}
			$ret = M("warehouse_admin")->addAll($admin_data);
			if ($ret && $add_id) {
				M()->commit();
				$this->success("添加成功", U("warehouselists"));
			} else {
				M()->rollback();
				$this->error("添加失败！");
			}
		} else {
			$this->assign("title", "添加仓库");
			$this->dept_tree(1);
			$this->display();
			$this->selectUser();
		}
	}

	public function update($id) {
		if (IS_POST) {
			foreach ($_POST as $key => $val) {
				$data[$key] = i($key);
			}
			if ($this->_model->where(array("num" => $data["num"], "id" => array("NEQ", $id)))->count())
				$this->error("已存在该编号！");
			$admin = $data["admin_id"];
			if (strpos($admin, ",")) {
				$admin_ids = explode(",", $admin);
			} else {
				$admin_ids = array($admin);
			}

			unset($data["admin"]);
			unset($data["admin_id"]);
			M("warehouse_admin")->where(array("warehouse_id" => $id))->delete();
			M()->startTrans();
			$ret1 = $this->_model->where(array("id" => $id))->save($data);
			foreach ($admin_ids as $val) {
				$admin_data[] = array("warehouse_id" => $id, "user_id" => $val);
			}
			$ret = M("warehouse_admin")->addAll($admin_data);
			if ($ret) {
				M()->commit();
				$this->success("修改成功", U("warehouselists"));
			} else {
				M()->rollback();
				$this->error("修改失败！");
			}
			exit;
		}
		$data = $this->_model->where(array("id" => $id))->find();
		$admin_data = M("warehouse_admin")->where(array("warehouse_id" => $id))->getField("user_id", true);
		foreach ($admin_data as $user_id) {
			$data["admin_name"] .= get_username($user_id) . ",";
			$data["admin_id"] .= $user_id . ",";
		}
		$data["admin_name"] = trim($data["admin_name"], ",");
		$data["admin_id"] = trim($data["admin_id"], ",");
		$this->assign("data", $data);
		$this->assign("title", "编辑仓库");
		$this->dept_tree(1);
		$this->display("add");
		$this->selectUser();
	}
	/**
	 * 删除仓库
	 * @param type $id
	 */
	public function delete($id){
		$count = M("warehouse_product")->where(array("warehouse_id"=>$id,"count"=>array("GT",0)))->count();
		if($count)
			$this->error("该仓库尚有未清理的产品,请清理完产品后删除");
		M("warehouse")->where(array("id"=>$id))->delete();
		M("warehouse_product")->where(array("warehouse_id"=>$id))->delete();
		$this->success("删除成功",U("warehouselists"));
	}
	/**
	 * 查看
	 */
	public function view($id) {
		$baseData = $this->_model->where(array("id" => $id))->find();
		$admin_data = M("warehouse_admin")->where(array("warehouse_id" => $id))->select();
		foreach ($admin_data as $val) {
			$baseData["user_admin"] .= get_username($val["user_id"]) . ",";
		}
		$this->assign("id", $id);
		$this->assign("baseData", $baseData); //仓库基本信息
		$this->display();
	}
	/**
	 * 库存
	 * @param type $id
	 */
	public function warehousenum($id){
		$product_name = I("product_name");
		$product_no = I("product_no");
		$is_self = I("is_self");
		$warning = I("warning");
		if(!empty($product_name)){
			$where .= " and b.product_name like '%".$product_name."%'";
		}
		if(!empty($product_no)){
			$where .= " and b.product_no like '%".$product_no."%'";
		}
		if(!empty($is_self)){
			$where .= " and b.is_self=".$is_self;
		}
		if(!empty($warning)){
			if($warning==1){
				$where .= " and a.count<warnning";
			}else if($warning == 2){
				$where .= " and a.count<danger";
			}
		}
			
		$sql = "select 	a.count,
				a.id,
				b.produec_type_str,
				a.submit,
				a.product_id,
				product_name,
				product_no,
				product_unit,
				product_format,
				is_self ,
				warnning,
				danger
				from warehouse_product as a,product as b where a.product_id = b.id and a.warehouse_id=" . $id . $where ." order by a.id desc";
		$numData = M()->query($sql);
		$io_products_data = session(self::IO_PRODUCTS_SESSION);
		foreach ($io_products_data as $flage_id => $flage_name) {
			$is_checked_data[] = $flage_id;
			$io_products .= "<span class='label label-warning' id='selected_product_$flage_id' style='margin-left:3px;'>$flage_name<i class='icon-times remove_product' flag_id='$flage_id' onclick='remove_product($flage_id)'></i></span>&nbsp;";
		}
		$remove_data = $this->getIsRemove($id);
		$this->assign("remove_data",$remove_data);
		$this->assign("id",$id);
		$this->assign("is_checked_data", $is_checked_data);
		$this->assign("io_products", $io_products);
		$this->assign("numData", $numData); //库存信息
		$this->assign("unit",$this->c_s["product_unit"]);
		//即将到货的货柜里的产品
		$sql = "select sum(b.count) as will_revel,b.product_id from container as a,container_product as b where a.id = b.container_id and a.to_warehouse=".$id." and a.status=1 group by b.product_id";
		$will_data = M()->query($sql);
		foreach($will_data as $val){
			$will[$val["product_id"]] = $val["will_revel"];
		}
		$this->assign("will",$will);
		$this->display();
		$productModel = new ProductController;
		$productModel->selectProduct();
	}
	
	/**
	 * 向仓库添加新的产品
	 */
	public function addProduct() {
		$warehouse_id = I("warehouse_id");
		$ids = trim(I("ids"), ",");
		$ids_arr = explode(",", $ids);
		foreach ($ids_arr as $id) {
			$data[] = array("warehouse_id" => $warehouse_id,"product_id" => $id,"count" => 0);
		}
		$ret = M("warehouse_product")->addAll($data);
		if ($ret) {
			$product_info = M("product")->where(array("id" => array("IN", $ids_arr)))->select();
			foreach ($product_info as $val) {
				echo '<tr class="line_g hover_bg">';
				echo " <td><input type='checkbox' class='select' value='".$val["id"]."' ></td>";
				echo "<td>" . $val["produec_type_str"] . "</td>";
				echo "<td>" . $val["product_name"] . "</td>";
				echo "<td>" . $val["product_no"] . "</td>";
				echo "<td>" . $val["product_unit"] . "</td>";
				echo "<td>" . $val["product_format"] . "</td>";
				echo "<td>" . ($val["is_self"] == 1 ? '是' : '否') . "</td>";
				echo "<td>0</td>";
				echo "</tr>";
			}
		}
	}

	/**
	 * 出入库预选产品
	 * @param int $id
	 */
	public function addIOProduct($id) {
		$sql = "select a.product_name,a.product_format from product as a,warehouse_product as b where a.id = b.product_id and b.id=" . intval($id);
		$data = M()->query($sql);
		$product_name = $data[0]["product_name"] . "【" . $data[0]["product_format"] . "】";
		$array = session(self::IO_PRODUCTS_SESSION);
		if (empty($array))
			$array = array();
		$array[$id] = $product_name;
		session(self::IO_PRODUCTS_SESSION, $array); //将预选的产品加入session
		echo "<span class='label label-warning' id='selected_product_$id' style='margin-left:3px;'>$product_name<i class='icon-times remove_product' flag_id='$id' onclick='remove_product($id)'></i></span>";
	}

	/**
	 * 移除选中的预入库产品
	 * @param type $id
	 */
	public function removeProduct($id) {
		$array = session(self::IO_PRODUCTS_SESSION);
		unset($array[$id]);
		session(self::IO_PRODUCTS_SESSION, $array);
		echo "success";
	}

	/**
	 * 执行出入库
	 */
	public function ioProduct($type) {
		if(!in_array($type,array(self::INNER,self::OUTER,self::REMOVE))){
			$this->error("操作错误");
		}
		
		if(IS_POST){
			if($type == self::REMOVE && !I("to_warehouse_id"))
				$this->error ("没有选择仓库");
			if($type == self::REMOVE){
				$to_warehouse_name = I("to_warehouse_name");
				$to_warehouse_id = I("to_warehouse_id");
			}
			foreach($_POST["ids"] as $key=>$id){
				$num = intval($_POST["num"][$key]);
				if(empty($num))
					continue;
				$batch_number = $_POST["batch_number"][$key];
				$start_time = strtotime($_POST["start_time"][$key]);
				$end_time = strtotime($_POST["end_time"][$key]);
				$warehouse_id = intval($_POST["warehouse_id"][$key]);
				$product_id = intval($_POST["product_id"][$key]);
				$warehouse_num = intval($_POST["warehouse_num"][$key]);
				$remark = intval($_POST["remark"][$key]);
				if($type == self::INNER){
					$sql .= "update warehouse_product set count = count+".abs($num)." where id=$id;";
					$rett = M("warehouse_product_desc")->where(array("warehouse_id"=>$warehouse_id,"product_id"=>$product_id,"batch_number"=>$batch_number))->find();
					if($rett){
						$sql .= "update warehouse_product_desc set count=count+".abs($num)." where id=".$rett["id"].";";
					}else{
						$sql .= "insert into warehouse_product_desc (product_id,warehouse_id,batch_number,count,start_time,end_time,warehouse_num,remark) values "
							. " ($product_id,$warehouse_id,'".$batch_number."',".abs($num).",$start_time,$end_time,'".$warehouse_num."','".$remark."');";
					}
				}else{
					$sql .= "update warehouse_product set count = count-".abs($num)." where product_id=$product_id and warehouse_id = $warehouse_id;";
					$sql .= "update warehouse_product_desc set count = count-".abs($num)." where id=$id;";
				}
				$logData[] = array(
					"warehouse_product_id"=>$id,
					"num"=>$num,
					"warehouse_id"=>$warehouse_id,
					"product_id"=>$product_id,
					"type" => $type,
					"add_time" => time(),
					"user_id" => UID,
					"desc" => $type == self::REMOVE ? "转移到".$to_warehouse_name : "库管操作",
					"url" => "",
				);
				if($type ==  self :: REMOVE){	//移库
					$remove[] = array(
						"product_id"=>$product_id,
						"num"=>$num,
						"to_warehouse_id"=>$to_warehouse_id,
						"from_warehouse_id"=>$warehouse_id,
						"user_id"=>UID,
						"send_time"=>time()
					);
				}
			}
			M()->startTrans();
			if($type ==  self :: REMOVE){	//移库
				M("warehouse_remove")->addAll($remove);
			}
			$sql_e = explode(";", $sql);
			foreach($sql_e as $sql1){
				$ret = M()->execute($sql1);
			}
			$ret1 = M("warehouse_log")->addAll($logData);
			if($ret1){
				M()->commit();
				session(self::IO_PRODUCTS_SESSION,null);
				$this->success("操作成功",U("warehousenum",array("id"=>$warehouse_id)));
			}else{
				M()->rollback();
				$this->error("操作失败");
			}
		}
		
		$io_products_data = session(self::IO_PRODUCTS_SESSION);
		if(empty($io_products_data))
			$this->error("请选择出入库的产品");
		foreach($io_products_data as $id=>$name){
			$list_data[$id]["name"] = $name;
			$w_p_id[] = $id;
		}
		$data = M("warehouse_product")->where(array("id"=>array("IN",$w_p_id)))->select();
		foreach($data as $val){
			$list_data[$val["id"]]["count"] = $val["count"];
			$list_data[$val["id"]]["warehouse_id"] = $val["warehouse_id"];
			$list_data[$val["id"]]["product_id"] = $val["product_id"];
			$outWhere .= " (product_id=".$val["product_id"]." and warehouse_id=".$val["warehouse_id"].") OR"; 
			$outProductName[$val["product_id"]] = $list_data[$val["id"]]["name"];
		}
		$titlearr = $this->_remove_type();
		$this->assign("title",$titlearr[$type]);
		$this->assign("type",$type);
		if($type == self::INNER){	//如果是移库或者出库则显示产品的所有批次号的产品
			$this->assign("list_data",$list_data);
			$this->assign("io_products_data",$io_products_data);
			$this->display();
		}else{
			$outWhere = "(".trim($outWhere,"OR").") and count > 0";
			$list_data = M("warehouse_product_desc")->where($outWhere)->select();
			$this->assign("list_data",$list_data);
			$this->assign("outProductName",$outProductName);
			$this->assign("io_products_data",$io_products_data);
			$this->display("ioProductOut");
			$this->selectWarehouse();
		}
		
		
	}

	private function _remove_type(){
		return $titlearr=array(
			self::INNER => "产品入库",
			self::OUTER=>"产品出库",
			self::REMOVE=>"产品移库"
		);
	}
	/**
	 * 出入库日志列表
	 * @param type $w_p_id
	 */
	public function loglist($w_p_id){
		$total = M("warehouse_log")->where(array("warehouse_product_id"=>$w_p_id))->count();
		$limit = $this->page($total);
		$sql = "select a.product_name,a.product_format,b.id,b.num,b.add_time,b.user_id,b.desc from product as a,warehouse_log as b where a.id = b.product_id and b.warehouse_product_id = $w_p_id  order by b.id desc limit ".$limit["firstRow"].",".$limit["listRows"];
		$data = M()->query($sql);
		$this->assign("data",$data);
		$this->display();
	}
	/**
	 * 库存详情导出
	 */
	public function exportnum($id){
		$product_name = I("product_name");
		$product_no = I("product_no");
		$is_self = I("is_self");
		if(!empty($product_name)){
			$where .= " and b.product_name like '%".$product_name."%'";
		}
		if(!empty($product_no)){
			$where .= " and b.product_no like '%".$product_no."%'";
		}
		if(!empty($is_self)){
			$where .= " and b.is_self=".$is_self;
		}
		$sql = "select 	a.count,
				a.id,
				b.produec_type_str,
				product_name,
				product_no,
				product_unit,
				product_format,
				is_self 
				from warehouse_product as a,product as b where a.product_id = b.id and a.warehouse_id=" . $id . $where ." order by a.id desc";
		$numData = M()->query($sql);
		$title=array(
			"produec_type_str"=>"产品类型",
			"product_name"=>"产品名称",
			"product_no"=>"产品编号",
			"product_unit"=>"计量单位",
			"product_format"=>"规格型号",
			"is_self"=>"是否自产",
			"count"=>'库存数量'
		);
		export_csv($title, $numData, "库存详情");
	}
	
	public function selectWarehouse(){
		$this->include_header = false;
		$this->display("Product@Warehouse:selectWarehouse");
	}
	
	public function warehouseSearch(){
		$name = I("name");
		$num = I("num");
		if(!empty($name))
			$map["name"] = array("LIKE","%".$name."%");
		if(!empty($num))
			$map["num"] = array("LIKE","%".$num."%");
		$data = M("warehouse")->where($map)->limit(5)->select();
		$lang = cookie("thinkphp_language");
		$num = L("WAREHOUSE_NUM");
		$name = L("WAREHOUSE_NAME");
		foreach($data as $val){
			echo "<li class='list-group-item'>	";
			if(!in_array($val["id"], $have_data))	//如果已经存在该库则不能选择
				echo '<input type="radio" name="warehouse_id" value="'.$val["id"].'" obj-name="'.$val["name"].'"> ';
             echo   ' 【'.$num.':】'.$val['num']
                        .' 【'.$name.':】'. ($lang == "en-us" ? $val["en_name"] : $val['name'])
                        .'</li>';
		}
	}
	/**
	 * 转移入库的产品
	 * @param type $warehouseID
	 * @return type
	 */
	public function getIsRemove($warehouseID){
		$data = M("warehouse_remove")->where(array("status"=>0,"to_warehouse_id"=>$warehouseID))->select();
		foreach($data as $val){
			$ret[$val["id"]] = $val["product_id"];
		}
		return $ret;
	}
	/**
	 * 转移入库
	 * @param type $p_id
	 */
	public function removeInnser($p_id,$id){
		$sql = "select c.name,a.product_name,a.product_no,b.user_id,b.id,b.from_warehouse_id,b.send_time,b.num"
			. " from product as a,"
			. " warehouse_remove as b,"
			. " warehouse as c"
			. " where a.id = b.product_id and b.from_warehouse_id = c.id and b.product_id=$p_id and b.to_warehouse_id = $id";
		$data = M()->query($sql);
		$this->assign("data",$data[0]);
		$this->display();
	}
	/**
	 * 确认移库产品入库
	 * @param type $id
	 */
	public function removeInnserSure($id){
		$data = M("warehouse_remove")->where(array("id"=>$id))->find();
		$warehouse_product_id = M("warehouse_product")->where(array("product_id"=>$data["product_id"],"warehouse_id"=>$data["to_warehouse_id"]))->getField("id");
		$from_warehouse_name = M("warehouse")->where(array("id"=>$data["from_warehouse_id"]))->getField("name");
		M()->startTrans();
		$ret = M("warehouse_remove")->where(array("id"=>$id))->save(array(
			"apply_user_id"=>UID,
			"status"=>1,
			"to_time"=>time()
		));
		$sql = "update warehouse_product set count = count+".$data["num"]." where warehouse_id=".$data["to_warehouse_id"]." and product_id=".$data["product_id"];
		M()->execute($sql);
		$logData = array(
			"warehouse_product_id"=>$warehouse_product_id,
			"num"=>$data["num"],
			"warehouse_id"=>$data["to_warehouse_id"],
			"product_id"=>$data["product_id"],
			"type"=>self::INNER,
			"add_time"=>time(),
			"user_id"=>UID,
			"desc"=>$from_warehouse_name."移库接收入库",
		);
		$ret2 = M("warehouse_log")->add($logData);
		if($ret && $ret2){
			M()->commit();
			$this->success("入库成功",U("warehousenum",array("id"=>$data["to_warehouse_id"])));
		}else{
			M()->rollback();
			$this->error("入库失败");
		}
	}
	/**
	 * 查看出入库日志
	 * @param type $id
	 */
	public function showIOInfo($id){
		$this->include_header=false;
		$sql = "select a.num,a.type,a.add_time,a.user_id,a.desc,b.product_name,b.product_no,b.product_format,c.name "
			. " from "
			. " warehouse_log as a,product as b,warehouse as c"
			. " where "
			. " a.warehouse_id = c.id"
			. " and a.product_id = b.id "
			. " and a.id=".$id;
		$data = M()->query($sql);
		$this->assign("type",$this->_remove_type());
		$this->assign("data",$data[0]);
		$this->display();
	}
	/**
	 * 设置预警值
	 * @param type $w_p_id
	 */
	public function warnning($w_p_id){
		if(IS_POST){
			$warnning = I("warnning");
			$danger = I("danger");
			if($danger > $warnning){
				$this->error("高级预警值不能高于低级预警值");
			}
			$ret = M("warehouse_product")->where(array("id"=>$w_p_id))->save(array("warnning"=>$warnning,"danger"=>$danger));
			$warehous_id = M("warehouse_product")->where(array("id"=>$w_p_id))->getField("warehouse_id");
			if($ret){
				$this->success("设置成功",U("warehousenum",array("id"=>$warehous_id)));
			}else{
				$this->error("设置失败");
			}
		}
		$sql = "select warnning,danger,product_no,product_name,product_format,name,en_name from warehouse,product,warehouse_product where "
			. " warehouse.id = warehouse_product.warehouse_id "
			. " and product.id = warehouse_product.product_id"
			. " and warehouse_product.id = ".$w_p_id;
		$data = M()->query($sql);
		$this->assign("w_p_id",$w_p_id);
		$this->assign("data",$data[0]);
		$this->display();
	}
	/**
	 * 货柜管理
	 */
	public function Container(){
		$name = I("name");
		$warehouse_id = I("warehouse_id");
		if(!empty($name))
			$map["name"]=array("like",$name);
		if(!empty($warehouse_id))
			$map["to_warehouse"]=$warehouse_id;
		if(empty($map))
			$map = "1=1";
		$data = $this->lists('container',$map);
		$warehouseData = M("warehouse")->field("id,name")->select();
		foreach($warehouseData as $val){
			$wdata[$val["id"]] = $val["name"];
		}
		$sql = "select count(1) as count,container_id from container_product group by container_id";
		$containerProduct = M()->query($sql);
		foreach($containerProduct as $val){
			$conp[$val["container_id"]] = $val["count"];
		}
		$this->assign("status",array(0=>"仅保存",1=>"已发送",2=>"确认入库"));
		$this->assign("wdata",$wdata);
		$this->assign("conp",$conp);
		$this->assign("data",$data);
		$this->display();
		$this->selectWarehouse();
	}
	/**
	 * 仓库识别码是否重复
	 * @param type $nums
	 */
	public function warehouseNumISHave($nums){
		$numArr = explode(",", trim($nums,","));
		$warehouse_num = M("container_product")->where(array("warehouse_num"=>array("IN",$numArr)))->getField("warehouse_num");
		if(!empty($warehouse_num)){
			echo $warehouse_num;
		}else{
			$warehouse_num = M("warehouse_product_desc")->where(array("warehouse_num"=>array("IN",$numArr)))->getField("warehouse_num");
			if(!empty($warehouse_num))
				echo $warehouse_num;
		}
	}
	/**
	 * 添加货柜
	 */
	public function addContainer(){
		if(IS_POST){
			$data["name"] = I("name");
			$data["to_warehouse"] = I("to_warehouse_id");
			$data["to_time"] = strtotime(I("to_time"));
			$data["send_time"] = strtotime(I("send_time"));
			$data["status"] = I("status");
			$data["remark"] = I("remark");
			$data["status"] =  I("status");
			$data["user_id"] = UID;
			M()->startTrans();
			$container_id = M("container")->add($data);
			$product_id = I("product_id");
			$batch_number = I("batch_number");
			$count = I("count");
			$start_time = I("start_time");
			$end_time = I("end_time");
			$warehouse_num = I("warehouse_num");
			$remark = I("remark");
			foreach($product_id as $key=>$val){
				$son[]=array(
					"container_id"=>$container_id,
					"product_id"=>$val,
					"batch_number"=>$batch_number[$key],
					"count"=>$count[$key],
					"start_time"=>strtotime($start_time[$key]),
					"end_time"=>strtotime($end_time[$key]),
					"warehouse_num"=>$warehouse_num[$key],
					"remark"=>$remark[$key],
				);
			}
			$ret = M("container_product")->addAll($son);
			if($container_id && $ret){
				M()->commit();
				$this->success("添加成功",U("Container"));
			}else{
				M()->rollback();
				$this->error("添加失败");
			}
		}
		$this->display();
		$this->selectWarehouse();
		$productModel = new ProductController;
		$productModel->selectProduct();
	}
	/**
	 * ajax货柜添加产品
	 */
	public function addContainerProduct($ids){
		$ids = trim($ids,",");
		$data = M("product")->where("id IN (".$ids.")")->field("id,product_no,product_name,en_name,product_format,product_en_format,product_unit")->select();
		foreach($data as $val){
			echo "<tr>"
			."<td><a class='text-primary del_option'><i class='icon-trash-o'></i></a></td>"
			. "<td><input type='hidden' name='product_id[]' value=".$val["id"]."><input type='text' name='batch_number[]' size=8></td>"
			. "<td>".checkLanguage($val["product_name"], $val["en_name"])."</td>"
			. "<td>".checkLanguage($val["product_format"], $val["product_en_format"])."</td>"
			. "<td>".$this->c_s["product_unit"][$val["product_unit"]]."</td>"
			. "<td><input type='text' size=5 name='count[]'></td>"
			. "<td><input type='text' size=8 name='start_time[]' onfocus='WdatePicker({skin: \"twoer\"})'></td>"
			. "<td><input type='text' size=8 name='end_time[]' onfocus='WdatePicker({skin: \"twoer\"})'></td>"
			. "<td><input type='text' size=10 name='warehouse_num[]' value=".$val["product_no"]."></td>"
			. "<td><input type='text' size=15 name='remark[]''></td>"
			. "</tr>";
		}
	}
	/**
	 * 货柜查看
	 * @param type $id
	 */
	public function containerView($id){
		$data=M("container")->where(array("id"=>$id))->find();
		$this->assign("data",$data);
		$sql = "select container_product.warehouse_num as warehouse_no,product_no,product_content,start_time,end_time,warehouse_num,remark,product_name,en_name,product_format,product_en_format,batch_number,count,product_unit from product,container_product where product.id = container_product.product_id and container_product.container_id=".$id;
		$productData = M()->query($sql);
		$this->assign("productData",$productData);
		$this->assign("unitData",$this->c_s["product_unit"]);
		$warehouse = M("warehouse")->where(array("id"=>$data["to_warehouse"]))->getField("name");
		$this->assign("warehouse",$warehouse);
		//获取当前用户管理的仓库ID
		$warehouse_id = M("warehouse_admin")->where(array("user_id"=>UID))->getField("warehouse_id",true);
		$this->assign("warehouse_id",$warehouse_id);
		$this->display();
	}
	/**
	 * 货柜入库
	 */
	public function containerInner($id){
		//获取当前用户管理的仓库ID
		$warehouse_id = M("warehouse_admin")->where(array("user_id"=>UID))->getField("warehouse_id",true);
		$data=M("container")->where(array("id"=>$id))->find();
		if(!in_array($data["to_warehouse"],$warehouse_id) && !is_administrator()){	//仓库管理员和系统管理员拥有入库权限
			$this->error("您没有改仓库的入库权限，请联系管理员");
		}
		if($data["status"] != 1){
			$this->error("该货柜状态不可入库",U("containerView",array("id"=>$id)));
		}
		$procutData = M("container_product")->where(array("container_id"=>$id))->select();
		M("container")->where(array("id"=>$id))->save(array("status"=>2));//将状态改成已经入库
		foreach($procutData as $val){
			//修改库存
			$sql = "update warehouse_product set count = count+".$val["count"]." where warehouse_id=".$data["to_warehouse"]." and product_id=".$val["product_id"];
			$ret = M()->execute($sql);
			if(!$ret){	//如果不存在产品则自动插入
				$innerProduct["warehouse_id"] = $data["to_warehouse"];
				$innerProduct["product_id"] = $val["product_id"];
				$innerProduct["count"] = $val["count"];
				M("warehouse_product")->add($innerProduct);
			}
			//写入库存明细
			$sql = "update warehouse_product_desc set count=count+".$val["count"]."  where warehouse_id=".$data["to_warehouse"]." and product_id=".$val["product_id"]." and batch_number = '".$val["batch_number"]."'";
			$ret = M()->execute($sql);
			if(!$ret){	//如果不存在该批次产品则自动插入
				$innerProductDesc["warehouse_id"] = $data["to_warehouse"];
				$innerProductDesc["product_id"] = $val["product_id"];
				$innerProductDesc["count"] = $val["count"];
				$innerProductDesc["start_time"] = $val["start_time"];
				$innerProductDesc["end_time"] = $val["end_time"];
				$innerProductDesc["batch_number"] = $val["batch_number"];
				$innerProductDesc["warehouse_num"] = $val["warehouse_num"];
				$innerProductDesc["remark"] = $val["remark"];
				M("warehouse_product_desc")->add($innerProductDesc);
			}
			$log["num"] = $val["count"];
			$log["warehouse_id"] = $data["to_warehouse"];
			$log["product_id"] = $val["product_id"];
			$log["type"] = self::INNER;
			$log["add_time"] = time();
			$log["user_id"] = UID;
			$log["desc"] = "货柜入库";
			$log["url"] = U("containerView",array("id"=>$data["id"]));
			//写入日志
			M("warehouse_log")->add($log);
		}
		$this->success("入库成功");
	}
	/**
	 * 货柜编辑
	 * @param type $id
	 */
	public function containerUpdate($id){
		$data=M("container")->where(array("id"=>$id))->find();
		if($data["user_id"] != UID)
			$this->error("您没有该货柜的编辑权限");
		if(IS_POST){
			$data["name"] = I("name");
			$data["to_warehouse"] = I("to_warehouse_id");
			$data["to_time"] = strtotime(I("to_time"));
			$data["send_time"] = strtotime(I("send_time"));
			$data["status"] = I("status");
			$data["remark"] = I("remark");
			$data["status"] =  I("status");
			$data["user_id"] = UID;
			M("container_product")->where("container_id=".$id)->delete();
			M()->startTrans();
			$container_id = M("container")->where(array("id"=>$id))->save($data);
			$product_id = I("product_id");
			$batch_number = I("batch_number");
			$count = I("count");
			$start_time = I("start_time");
			$end_time = I("end_time");
			$warehouse_num = I("warehouse_num");
			$remark = I("remark");
			foreach($product_id as $key=>$val){
				$son[]=array(
					"container_id"=>$id,
					"product_id"=>$val,
					"batch_number"=>$batch_number[$key],
					"count"=>$count[$key],
					"start_time"=>strtotime($start_time[$key]),
					"end_time"=>strtotime($end_time[$key]),
					"warehouse_num"=>$warehouse_num[$key],
					"remark"=>$remark[$key],
				);
			}
			$ret = M("container_product")->addAll($son);
			if($ret){
				M()->commit();
				$this->success("添加成功",U("Container"));
			}else{
				M()->rollback();
				$this->error("添加失败");
			}
		}
		$this->assign("data",$data);
		$sql = "select warehouse_num,remark,start_time,end_time,product.id as product_id,product_name,en_name,product_format,product_en_format,batch_number,count,product_unit from product,container_product where product.id = container_product.product_id and container_product.container_id=".$id;
		$productData = M()->query($sql);
		$this->assign("productData",$productData);
		$this->assign("unitData",$this->c_s["product_unit"]);
		$warehouse = M("warehouse")->where(array("id"=>$data["to_warehouse"]))->getField("name");
		$this->assign("warehouse",$warehouse);
		$this->display("addContainer");
		$this->selectWarehouse();
		$productModel = new ProductController;
		$productModel->selectProduct();
	}
	/**
	 * 货柜删除
	 * @param type $id
	 */
	public function containerDelete($id){
		$rt = M("container")->where(array("id"=>$id))->delete();
		$rt1 = M("container_product")->where(array("container_id"=>$id))->delete();
		if($rt){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
	}
	/**
	 * 库存产品详情
	 * @param type $id
	 * @param type $product_id
	 */
	public function productDesc($id,$product_id){
		$map = array("warehouse_id"=>$id,"product_id"=>$product_id,"count"=>array("GT",0));
		$data = $this->lists("warehouse_product_desc",$map);
		$product_data = M("product")->where(array("id"=>$product_id))->find();
		$this->assign("unit",$this->c_s["product_unit"]);
		$this->assign("product_data",$product_data);
		$this->assign("data",$data);
		$this->display();
	}
	/**
	 * 上报申请数量
	 * @param type $warehouse_id
	 * @param type $product_id
	 */
	public function submitProduct($warehouse_id,$product_id,$submit){
		$ret = M("warehouse_product")->where(array("warehouse_id"=>$warehouse_id,"product_id"=>$product_id))->save(array(
			"submit"=>$submit,
			"submit_time"=>time()
		));
		if($ret){
			echo 1;
		}else{
			echo 0;
		}
	}
	/**
	 * 导出提报的信息
	 * @param type $warehouse_id
	 */
	public function exportSubmitInfo($warehouse_id){
		$sql = "select a.count,a.submit,FROM_UNIXTIME(a.submit_time,'%Y-%m-%d') as submit_time,product_name,product_format,product_content"
			. " from "
			. "warehouse_product as a,product as b "
			. " where "
			. " a.product_id = b.id"
			. " and a.submit > 0";
		$data = M()->query($sql);
		foreach($data as $key=>$val){
			$data[$key]["product_name"] = str_replace(",","/",$val["product_name"]);
		}
		$title=array(
			"product_name"=>"产品名称",
			"product_format"=>"有效成分",
			"product_content"=>"含量",
			"count"=>"当前库存",
			"submit"=>"上报数量",
			"submit_time"=>'上报时间'
		);
		export_csv($title, $data, "提报信息详情");
	}
}
