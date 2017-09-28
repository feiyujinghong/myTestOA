<?php

// +----------------------------------------------------------------------
// | Hr-出差
// +----------------------------------------------------------------------
// | Copyright (c) 2015 www.c_o.com
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------

namespace Hr\Controller;

use Think\Model;
use Auth\Controller\AuthController;
use Auth\Controller\DepartmentController;
use Think\Auth;
use Think\Controller;

class BusinessTravelController extends AuthController {

	CONST WORKFLOW_MODEL = "TRAVEL";

	public function _initialize() {
		parent::_initialize();
		require_once "./Application/Common/Conf/c_select.php";
		$this->c_s = $con_select;
		$this->assign("c_s", $this->c_s);
	}

	/**
	 * 出差申请
	 */
	public function travel_apply() {
		if (1 == I('get.dosubmit')) {
			$travel = D('Travel');
			$r_travel = $travel->create();
			if (!$r_travel) {
				exit("操作失败！" . $travel->getError());
			}
			$r_travel['user_id'] = is_login();
			if ($r_travel['travel_start_time'] != '')
				$r_travel['travel_start_time'] = strtotime($r_travel['travel_start_time']);
			if ($r_travel['travel_finish_time'] != '')
				$r_travel['travel_finish_time'] = strtotime($r_travel['travel_finish_time']);

			if (empty($r_travel['id'])) {
				$r = $travel->add($r_travel);
			} else {
				$r = $travel->save($r_travel);
			}
			if (false !== $r) {

				$url = U("Hr/BusinessTravel/showInfo", array("id" => $r));
				$ret = $this->workflowRun(self::WORKFLOW_MODEL, $r, $r_travel["title"], $url, 1);
				$this->success("申请提交成功！", U("travel_record"));
			} else {
				$this->error("申请提交失败！", U("travel_record"));
			}
		} else {
			$uid = intval($_SESSION['user_auth']['uid']);
			$staff_info = M("staff_info")->field(array("`id`", "`name`", "`phone`"))
				->where(array("user_id" => $uid))
				->order('id desc')
				->find();
			$staff_n_p = $staff_info['name'] . "[" . $staff_info['phone'] . "]";
			$this->assign('staff_n_p', $staff_n_p);
			$this->display();
			$this->nextStepFlow(self::WORKFLOW_MODEL, 0);
		}
	}

	/**
	 * 出差记录
	 */
	public function travel_record() {
		$uid = is_login();
		$map = array("user_id" => $uid);
		$travel_info = $this->lists("Travel", $map);
		$this->assign('travel_info', $travel_info);
		$this->display();
	}

	/**
	 * 获得出差信息
	 * @param int $travel_id ：ID
	 */
	public function get_travel_info($travel_id) {
		$map = array();
		$map ['id'] = intval($travel_id);
		$leave_info = D('Travel')->get_travel_by_id($map);
		return $leave_info;
	}

	/**
	 * 编辑出差信息
	 */
	public function up_date_travel() {
		if (I('get.id')) {
			$travel_id = intval(I('get.id'));
			$travel_info = $this->get_travel_info($travel_id);
			$this->assign('travel_info', $travel_info);
			//$uid = intval($_SESSION['user_auth']['uid']);
			$uid = $travel_info['user_id'];
			$staff_info = M("staff_info")->field(array("`id`", "`name`", "`phone`"))
				->where(array("user_id" => $uid))
				->order('id desc')
				->find();
			$staff_n_p = $staff_info['name'] . "[" . $staff_info['phone'] . "]";
			$this->assign('staff_n_p', $staff_n_p);

			$this->display('travel_apply');
		}
	}

	public function showInfo($id) {
		$data = $this->get_travel_info($id);
		$this->assign("data", $data);
		$now_process_name = $this->getNowProcessName(self::WORKFLOW_MODEL, $id);
		if(!empty($now_process_name))
			$this->assign("now_process_name", "<span class='icon-angle-double-right' style='margin-left:10px;margin-right:10px;'></span>" . $now_process_name);
		$this->display();
		$this->nextStepFlow(self::WORKFLOW_MODEL, $id);
	}

}
