<?php
// +----------------------------------------------------------------------
// | Hr-请假
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
class LeaveController extends AuthController {
	
	CONST WORKFLOW_MODEL = "LEAVE";
	
	public function _initialize() {
		parent::_initialize ();
		require_once "./Application/Common/Conf/c_select.php";
		$this->c_s = $con_select;
		$this->assign("c_s",$this->c_s);
	}
	
	/**
	 * 请假申请
	 */
	public function leave_apply() {
		if (1 == I('get.dosubmit')) {
			$leave = D('Leave');
			$r_leave = $leave->create();
			if (!$r_leave) {
				exit("操作失败！".$leave->getError());
			}
			$r_leave['user_id'] = intval($_SESSION['user_auth']['uid']);
			if ($r_leave['leave_start_time'] != '')
			$r_leave['leave_start_time'] = strtotime($r_leave['leave_start_time']);
			if ($r_leave['leave_finish_time'] != '')
			$r_leave['leave_finish_time'] = strtotime($r_leave['leave_finish_time']);
			$content = get_username()."的请假申请（".date("Y-m-d H:i:s")."）";
			$r_leave["title"] = $content;
			if (empty($r_leave['id'])) {
				$r = $leave->add($r_leave);
			} else {
				$r = $leave->save($r_leave);
			}
			//echo M()->getLastSql();
			if (false !== $r) {
				
				$url = U("Hr/Leave/show_leave_info",array("id"=>$r));
				$ret = $this->workflowRun(self::WORKFLOW_MODEL, $r,$content,$url,1);
				$this->success("申请提交成功！",U("Leave/leave_record"));
			} else {
				$this->error("申请提交失败！",U("Leave/leave_record"));
			}
		} else {
			$uid = intval($_SESSION['user_auth']['uid']);
			$staff_info = M("staff_info")->field(array("`id`", "`name`", "`phone`"))
										->where(array("user_id"=>$uid))
										->order('id desc')
										->find();
			$staff_n_p = $staff_info['name']."[".$staff_info['phone']."]";
			$this->assign('staff_n_p', $staff_n_p);
			$this->display();
			$this->nextStepFlow(self::WORKFLOW_MODEL, 0);
		}
	}
	/**
	 * 请假列表
	 */
	public function leave_record() {
		$uid = intval($_SESSION['user_auth']['uid']);
		$map = array("user_id"=>$uid);
		$leave_info = $this->lists("Leave", $map);
		foreach ($leave_info as $key=>$value) {
			$leave_info[$key]['leave_type_ch'] = $this->c_s['leave'][$value['leave_type']];
		}
		$this->assign('leave_info', $leave_info);
		$this->display();
	}
	
	/**
	 * 获得请假信息
	 * @param int $leave_id ：ID
	 */
	public function get_leave_info($leave_id) {
		$map = array();
		$map ['id'] = intval($leave_id);
		$leave_info = D('Leave')->get_leave_by_id($map);
		$leave_info['leave_type_ch'] = $this->c_s['leave'][$leave_info['leave_type']];
		return $leave_info;
	}
	
	/**
	 * 编辑页面
	 */
	public function up_date_recruitment() {
		if (I('get.id')) {
			$leave_id = I('get.id');
			$leave_info = $this->get_leave_info($leave_id);
			$this->assign('leave_info', $leave_info);
			$uid = $leave_info['user_id'];
			$staff_info = M("staff_info")->field(array("`id`", "`name`", "`phone`"))
										->where(array("user_id"=>$uid))
										->order('id desc')
										->find();
			$staff_n_p = $staff_info['name']."[".$staff_info['phone']."]";
			$this->assign('staff_n_p', $staff_n_p);
			
			$this->display('leave_apply');
		}
	}
	
	/**
	 * 查看请假信息
	 */
	public function show_leave_info() {
		if (I('get.id')) {
			$leave_info = $this->get_leave_info(I('get.id'));
			$this->assign('leave_info', $leave_info);
			$id = I('get.id');
			$uid = $leave_info['user_id'];
			$staff_info = M("staff_info")->field(array("`id`", "`name`", "`phone`"))
										->where(array("user_id"=>$uid))
										->order('id desc')
										->find();
			$staff_n_p = $staff_info['name']."[".$staff_info['phone']."]";
			$this->assign('staff_n_p', $staff_n_p);
			$now_process_name = $this->getNowProcessName(self::WORKFLOW_MODEL, $id);
			if(!empty($now_process_name))
				$this->assign("now_process_name","<span class='icon-angle-double-right' style='margin-left:10px;margin-right:10px;'></span>".$now_process_name);
			$this->display();
			$this->nextStepFlow(self::WORKFLOW_MODEL, $id);
		}
	}
	
	
	
}