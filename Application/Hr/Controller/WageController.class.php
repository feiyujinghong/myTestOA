<?php
/**
 * 工资信息管理
 *
 * @author xxb
 */
namespace Hr\Controller;

use Auth\Controller\AuthController;
class WageController  extends \Auth\Controller\AuthController{
	
	private $_status=array(0=>"待发送",1=>"已发送",2=>"已查收");
	/**
	 * 判断是否是工资条管理员（是否拥有添加权限）
	 */
	private function _isManage(){
		$rule = "hr/wage/add";
		return checkMenu($rule);
	}
	/**
	 * 工资条列表
	 */
	public function wageList(){
		$is_manage = $this->_isManage();//当前用户是否为工资条管理员
		if(!$is_manage)
			$map = array("user_id"=>  is_login());
		if(empty($_GET["get_year"]))
			$_GET["get_year"] = date("Y");
		if(empty($_GET["get_month"]))
			$_GET["get_month"] = date("m");
		$map["year"]=intval($_GET["get_year"]);
		$map["month"] = htmlspecialchars($_GET["get_month"]);
		if(!empty($_GET["get_name"]))
			$map["staff_name"] = htmlspecialchars ($_GET["get_name"]);
		$data = $this->lists("wage",$map,"id desc");
		$this->assign("data",$data);
		$this->assign("status",$this->_status);
		
		$this->assign("is_manage",$is_manage); 
		$this->display();
	}
	/**
	 * 增加工资单
	 */
	public function add(){
		if(IS_POST){
			$data = $_POST;
			$data["add_user"] = is_login();
			$data["add_time"] = time();
			$rt = M("wage")->add($data);
			if($_POST["status"]==1)
				$flag = "提交并发送";
			else
				$flag = "保存";
			if($rt){
				$this->success($flag."成功",U("wageList"));
			}else{
				$this->error($flag."失败",U("wageList"));
			}
		}else{
			$month = date("m");
			$year = date("Y");
			if($month == "01"){
				$year --;
			}
			$data["disease"] = '0.00';
			$data["private_day"] = '0.00';
			$data["no_work"] = '0.00';
			$data["late"] = '0.00';
			$data["early"] = '0.00';
			$data["rice"] = '0.00';
			$data["phone"] = '0.00';
			$data["achievements"] = '0.00';
			$data["commission"] = '0.00';
			$data["disease_money"] = '0.00';
			$data["private_money"] = '0.00';
			$data["no_work_money"] = '0.00';
			$data["late_early"] = '0.00';
			$data["insurance"] = '0.00';
			$data["fund"] = '0.00';
			$data["tax"] = '0.00';
			$this->assign("data",$data);
			$this->assign("month",$month);
			$this->assign("year",$year);
			$this->assign("action",U("add"));
			$this->dept_tree(1);//部门结构弹层
			$this->display();
			$this->selectStaff();
		}
	}
	/**
	 * 修改工资条
	 */
	public function update($id){
		$id = intval($id);
		if(IS_POST){
			$data = $_POST;
			$data["add_user"] = is_login();
			$data["add_time"] = time();
			$rt = M("wage")->where(array("id"=>$id))->save($data);
			if($_POST["status"]==1)
				$flag = "提交并发送";
			else
				$flag = "保存";
			if($rt){
				$this->success($flag."成功",U("wageList"));
			}else{
				$this->error($flag."失败",U("wageList"));
			}
		}else{
			$data = M("wage")->where(array("id"=>$id))->find();
			$this->assign("month",$data["month"]);
			$this->assign("year",$data["year"]);
			$this->assign("data",$data);
			$this->assign("action",U("update",array("id"=>$id)));
			$this->dept_tree(1);//部门结构弹层
			$this->display("add");
			$this->selectStaff();
		}
	}
	/**
	 * 工资条查看
	 */
	public function showInfo($id){
		$data = M("wage")->where(array("id"=>$id))->find();
		$this->assign("data",$data);
		$this->display();
	}
}
