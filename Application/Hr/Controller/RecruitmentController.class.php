<?php

// +----------------------------------------------------------------------
// | Hr-招聘
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

class RecruitmentController extends AuthController {

	CONST WORKFLOW_MODEL = "RECRUITMENT";

	private $_acute = array(1=>"紧急",2=>"急",3=>"一般",4=>"有合适人选再进");
	public function _initialize() {
		parent::_initialize();
		require_once "./Application/Common/Conf/c_select.php";
		$this->c_s = $con_select;
		$this->assign("c_s", $this->c_s);
	}

	/**
	 * 用人申请
	 */
	public function recruitment_apply() {
		if (1 == I('get.dosubmit')) {
			$recruitment = D('Recruitment');
			$r_recruitment = $recruitment->create();
			if (!$r_recruitment) {
				exit("操作失败！" . $recruitment->getError());
			}
			if ($r_recruitment['entry_time'] != '')
				$r_recruitment['entry_time'] = strtotime($r_recruitment['entry_time']);
			$r_recruitment['user_id'] = intval($_SESSION['user_auth']['uid']);

			$r = $recruitment->add($r_recruitment);
			//echo M()->getLastSql();
			if ($r) {
				$content = $r_recruitment["department"] . "(" . $r_recruitment["position"] . ")岗位申请";
				$url = U("Hr/Recruitment/showInfo", array("id" => $r));
				$ret = $this->workflowRun(self::WORKFLOW_MODEL, $r, $content, $url, 1);
				$this->success("申请提交成功！", U("recruitList"));
			} else {
				$this->error("申请提交失败！", U("recruitList"));
			}
		} else {
			$uid = is_login();
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
	 * 用人申请列表
	 */
	public function recruitList() {
		$uid = is_login();
		$map = array("user_id" => $uid);
		$data = $this->lists("recruitment", $map);
		$this->assign('data', $data);
		$this->display();
	}

	/**
	 * 查看用人申请
	 */
	public function showInfo($id) {
		$data = D('Recruitment')->where(array("id" => $id))->find();
		$this->assign("data", $data);
		$this->assign("_acute",$this->_acute);
		$now_process_name = $this->getNowProcessName(self::WORKFLOW_MODEL, $id);
		if(!empty($now_process_name))
			$this->assign("now_process_name", "<span class='icon-angle-double-right' style='margin-left:10px;margin-right:10px;'></span>" . $now_process_name);
		$this->display();
		$this->nextStepFlow(self::WORKFLOW_MODEL, $id);
	}

}
