<?php

/**
 * 工作流流程流转类
 *
 * @author xxb
 */

namespace Workflow\Model;

use Think\Model;

class WorkflowModel extends Model {

	CONST START = "is_one";

	CONST ONLY_SAVE = 0;
	CONST IS_APPROVAL = 1;
	CONST TURN = 2;
	CONST BACK = 3;
	
	private $_process_status = array(0=>"未接受",1=>"已接受",2=>"办理完成",3=>"已回退");
	/**
	 * 通过应用model获取流程ID
	 * @param varchar $model	应用模型
	 * @return int
	 */
	private function _getFlowIdByCache($model) {
		$cache = get_app_cache();
		$flow_id = $cache[$model];
		return $flow_id;
	}

	/**
	 * 起始数据
	 * @param type $model
	 * @return type
	 */
	public function getStartData($model, $flow_id) {
		if (empty($flow_id))
			$flow_id = $this->_getFlowIdByCache($model);
		$sql = "select "
			. "id,"
			. "flow_id,"
			. "process_name,"
			. "process_type,"
			. "process_to,"
			. "range_user_ids,"
			. "range_dept_ids,"
			. "range_role_ids "
			. " from "
			. "work_flow_process"
			. " where flow_id = " . $flow_id
			. " and process_type = '" . self::START . "'";
		$data = M()->query($sql);
		return $data[0];
	}

	/**
	 * 获取当前步骤的数据
	 * @param type $model
	 * @param type $app_id
	 */
	public function getStepData($model, $app_id) {
		$flow_id = $this->_getFlowIdByCache($model);
		$app_run = M()->table("app_run")->where(array("flow_id" => $flow_id, "app_id" => $app_id, "status" => array("IN", array(0, 1))))->order("id desc")->find();
		$process_data = get_flow_process_cache($flow_id);
		return $process_data[$app_run["process_id"]];
	}

	/**
	 * 是否拥有发起权限
	 */
	public function isStart($model) {
		$uid = is_login();
		if (empty($uid))
			return false;
		$flow_id = $this->_getFlowIdByCache($model);
		$start_data = $this->getStartData($model, $flow_id);
		$process_data = get_flow_process_cache($flow_id);
		$user_ids_arr = $process_data[$start_data["id"]]["step_user_id"];
		return in_array($uid, $user_ids_arr);
	}

	/**
	 * 获取下一步的经办信息
	 */
	public function nextStep($model, $app_id) {
		if (empty($model))
			return false;
		if (empty($app_id)) { //如果id为空则说明为起始步骤
			$step_data = $this->getStartData($model);
		} else {
			$step_data = $this->getStepData($model, $app_id);
			M()->table("app_run")->where(array("model"=>$model,"app_id"=>$app_id,"user_id"=>  is_login(),"status"=>  self::ONLY_SAVE))->save(array("status"=>self::IS_APPROVAL,"approval_time"=>time()));
		}
		$next_process_ids = $step_data["process_to"] . ",";
		$next_process_id_arr = explode(",", $next_process_ids);
		$process_data = get_flow_process_cache($step_data["flow_id"]);	//获取流程步骤缓存信息
		foreach ($next_process_id_arr as $val) {
			if (empty($val))
				continue;
			$data[] = array(
				"process_id" => $process_data[$val]["id"],
				"process_name" => $process_data[$val]["process_name"],
				"process_user_id" => $process_data[$val]["step_user_id"],
			);
		}
		return $data;
	}

	/**
	 * 流程提交流转
	 * @param type $model
	 * @param type $app_id
	 * @param array(process_id => user_ids,process_id => $user_ids,....)
	 */
	public function flowRun($model, $app_id, $param,$content,$url) {
		$flow_id = $this->_getFlowIdByCache($model);
		$remark  =  I("flow_remark");
		$nowData = array("status"=>self::TURN,"end_time"=>time(),"flow_remark"=>$remark);
		$ret = M()->table("app_run")->where(array("model"=>$model,"app_id"=>$app_id,"user_id"=>  is_login(),"status"=>  self::IS_APPROVAL))->save($nowData);
		if($param["is_end"])	//流程结束
			return true;
		foreach ($param as $key => $user_arr) {
			foreach ($user_arr as $user_id)
				$data[] = array(
					"model" => $model,
					"flow_id" => $flow_id,
					"process_id" => $key,
					"user_id" => $user_id,
					"app_id" => $app_id,
					"add_time" => time(),
					"name" => $content,
					"url"=>$url,
					"from_user_id"=>  is_login(),
				);
		}
		$ret = M()->table("app_run")->addAll($data);
		return $ret;
	}

	public function beginRun($model, $app_id,$content,$url) {
		if(empty($model) || empty($app_id) || empty($content) || empty($url))
			return false;
		$flow_id = $this->_getFlowIdByCache($model);
		$process_data = get_flow_process_cache($flow_id);
		foreach($process_data as $val){
			if($val["process_type"] == self::START){
				$process_id = $val["id"];
				break;
			}
		}
		$data = array(
			"model" => $model,
			"flow_id" => $flow_id,
			"process_id" => $process_id,
			"user_id" => is_login(),
			"app_id" => $app_id,
			"add_time" => time(),
			"status"=>self::TURN,
			"name"=>$content,
			"url"=>$url,
			"from_user_id"=>  is_login()
		);
		$ret = M()->table("app_run")->add($data);
		return $ret;
	}
	/**
	 * 获取已经办理完成的步骤信息
	 * @param type $model
	 * @param type $app_id
	 */
	public function getFlowAlreadyStep($model,$app_id){
		$data = M()->table("app_run")->where(array("model"=>$model,"app_id"=>$app_id))->order("id asc")->select();
		$process_data = get_flow_process_cache($data[0]["flow_id"]);	//获取流程步骤缓存信息
		foreach($data as $val){
			$ret[] = array(
				"process_name"=>$process_data[$val["process_id"]]["process_name"],
				"user_name"=>  get_username($val["user_id"]),
				"add_time"=>date("Y-m-d H:i:s",$val["add_time"]),
				"end_time"=>$val["end_time"] ? date("Y-m-d H:i:s",$val["end_time"]) : "尚未办理完成",
				"status"=>$this->_process_status[$val["status"]],
				"flow_remark"=>$val["flow_remark"]
			);
		}
		return $ret;
	}
}
