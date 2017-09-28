<?php

namespace Home\Controller;

use Auth\Controller\AuthController;

class IndexController extends AuthController {

	/**
	 * 系统消息列表
	 */
	public function sysSmgList() {
		$map = array("to_uid"=>  is_login());
		$data = $this->lists("sys_msg",$map,"id desc");
		$this->assign("data", $data);
		$this->display();
	}

	/**
	 * 删除系统消息
	 */
	public function delete() {
		$ids = I("ids");
		$ids = trim($ids, ",");
		$ret = M()->table("sys_msg")->where("id in (" . $ids . ")")->delete();
		echo M()->getLastSql();
	}

	/**
	 * 待办流程列表
	 */
	public function willWorkList() {
		$data = M()->table("app_run")->where(array("user_id" => is_login(), "status" => array("IN", array(0, 1))))->select();
		$flow_data = M()->table("work_flow")->field(array("id,flow_name"))->select();
		foreach ($flow_data as $val) {
			$flow_data_cache[$val["id"]] = $val["flow_name"];
		}
		foreach ($data as $key => $val) {
			$data[$key]["flow_name"] = $flow_data_cache[$val["flow_id"]];
			$data[$key]["from_user_name"] = get_username($val["from_user_id"]);
		}
		$status_arr = array(
			\Workflow\Model\WorkflowModel::ONLY_SAVE => "待办理",
			\Workflow\Model\WorkflowModel::IS_APPROVAL => "待审核",
			\Workflow\Model\WorkflowModel::TURN => "已转交",
		);
		$this->assign("status_arr",$status_arr);
		$this->assign("data", $data);
		$this->display();
	}

}
