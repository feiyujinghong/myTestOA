<?php

namespace Auth\Controller;

class IndexController extends AuthController {

	public function index() {
		if (cookie("think_language") == "zh-cn")
			$this->assign("change_lang_url", U("index", array("lang" => "en-us")));
		else
			$this->assign("change_lang_url", U("index", array("lang" => "zh-cn")));
		$this->include_header = false;

		//头像信息
		$r_user = M("user")->field(array("`username`", "`top_pic`"))->where(array("id" => $_SESSION['user_auth']['uid']))->find();
		$this->assign("r_user", $r_user);
		$this->assign("title", "林格贝尔在线办公系统");
		$this->display();
	}

	public function desktop() {
		//生日提醒
		$month = date("m", time());
		$staff_info = M("staff_info")->field(array("`id`", "`name`", "`sex`", "`bir_type`", "`birthday`", "`phone`"))
			->where(array("bir_month" => $month))
			->limit(5)
			->select();
		$this->assign('staff_info', $staff_info);
		//订单
		$orderData  =  M("cli_order")->where(array("add_user"=>UID,"order_time"=>array("GT",time())))->limit(5)->order("order_time asc")->select();
		$this->assign("orderData",$orderData);
		//客户生日
		$sql = "select l.name,l.bir,l.mobile,c.company_name,FROM_UNIXTIME(l.bir,'%m') as month from cli_link as l,cli as c where l.cli_id = c.id having month=".date("m")." limit 5";
		$brithDayData = M()->query($sql);
		$this->assign("brithDayData",$brithDayData[0]);
		$this->display();
	}

	public function sendMSGTest() {
		$this->sendMsg($type, $content);
	}

	public function test() {
		$this->nextStepFlow("LEAVE", 0);
	}

}
