<?php

namespace Workflow\Controller;

use Think\Controller;
use Auth\Controller\AuthController;

class IndexController extends AuthController {

	CONST DENY = 1;
	CONST UNDENY = 0;

	public function index() {
		$type_data = M("type")->select();
		foreach ($type_data as $val) {
			$tree_data[] = array(
				"id" => $val["id"],
				"name" => $val["name"],
				"pId" => $val["pid"],
			);
		}
		$flow_list = M("flow")->select();
		$this->assign("flow_list", $flow_list);
		$this->assign("tree_data", json_encode($tree_data));

		$this->display();
	}

	/**
	 * 流程编辑
	 * @param type $flow_id
	 */
	public function updateFlow($flow_id) {
		if (IS_POST) {
			$data["flow_name"] = trim(I("flow_name"));
			$data["cat_id"] = trim(I("cat_id"));
			$data["flow_desc"] = trim(I("flow_desc"));
			$data["flow_type"] = 0;
			$data["status"] = 1;
			$data["dateline"] = time();
			$data["updatetime"] = time();
			$ret = M("flow")->where(array("id" => $flow_id))->save($data);
			if ($ret) {
				$this->success("修改成功", U("index"));
				exit;
			} else {
				$this->success("修改失败", U("update"));
			}
		}
		$type = M('type')->field(true)->select();
		$type_tree = D('Common/Tree')->toFormatTree($type, $title = "name");
		$flow_data = M("flow")->where(array("id" => $flow_id))->find();
		$this->assign("flow_data", $flow_data);
		$this->assign("type_tree", $type_tree);
		$this->display();
	}

	public function addType() {
		if (!empty($_POST["name"])) {
			$array = array(
				"name" => trim($_POST["name"]),
				"pid" => intval($_POST["pid"])
			);
			$add_id = M("type")->add($array);
			if ($add_id) {
				$ret = array("status" => 1, "info" => L("ADD_SUCCESS"));
			} else {
				$ret = array("status" => 0, "info" => L("ADD_ERROR"));
			}
			exit(json_encode($ret));
		}
		$this->display();
	}

	/**
	 * 添加流程
	 */
	public function add() {
		if (IS_POST) {
			$data["flow_name"] = trim(I("flow_name"));
			$data["cat_id"] = trim(I("cat_id"));
			$data["flow_desc"] = trim(I("flow_desc"));
			$data["flow_type"] = 0;
			$data["status"] = 0;
			$data["dateline"] = time();
			$data["updatetime"] = time();
			$ret = M("flow")->add($data);
			if ($ret) {
				$this->success("添加成功", U("index"));
				exit;
			} else {
				$this->success("添加失败", U("add"));
			}
		}
		$type = M('type')->field(true)->select();
		$type_tree = D('Common/Tree')->toFormatTree($type, $title = "name");
		$this->assign("type_tree", $type_tree);
		$this->display();
	}

	/**
	 * 流程禁用
	 * @param type $flow_id
	 */
	public function Deny($flow_id) {
		$ret = M("flow")->where(array("id" => $flow_id))->save(array("status" => self::DENY));
		if ($ret)
			$this->success("禁用成功", U("index"));
		else
			$this->error("禁用失败", U("index"));
	}

	/**
	 * 流程解除禁用
	 * @param type $flow_id
	 */
	public function UnDeny($flow_id) {
		$ret = M("flow")->where(array("id" => $flow_id))->save(array("status" => self::UNDENY));
		if ($ret)
			$this->success("解除成功", U("index"));
		else
			$this->error("解除禁用失败", U("index"));
	}

	public function appList(){
		$data = M("flow_app")->select();
		$workflow_data = M("flow")->select();
		foreach($workflow_data as $val){
			$workflow[$val["id"]] = $val["flow_name"];
		}
		$this->assign("workflow",$workflow);
		$this->assign("data",$data);
		$this->display();
	}
	/**
	 * 增加APP
	 */
	public function addApp(){
		if(IS_POST){
			$data["name"] = I("name");
			$data["model"] = I("model");
			$data["flow_id"] = I("flow_id");
			$ret = M("flow_app")->add($data);
			if($ret){
				$this->success("保存成功",U("appList"));
				S("WORK_FLOW_CACHE",NULL);
			}else{
				$this->error("保存失败",U("appList"));
			}
			exit;
		}
		$model_list = get_code_select("APP_FLOW");
		$workflow_data = M("flow")->select();
		$this->assign("workflow_data",$workflow_data);
		$this->assign("model_list",$model_list);
		$this->display();
	}
	/**
	 * 修改app
	 */
	public function updateApp($id){
		if(IS_POST){
			$data["name"] = I("name");
			$data["model"] = I("model");
			$data["flow_id"] = I("flow_id");
			$ret = M("flow_app")->where(array("id"=>$id))->add($data);
			if($ret){
				$this->success("保存成功",U("appList"));
				S("WORK_FLOW_CACHE",NULL);
			}else{
				$this->error("保存失败",U("appList"));
			}
			exit;
		}
		$workflow_data = M("flow")->select();
		$app_data = M("flow_app")->where(array("id"=>$id))->find();
		$model_list = get_code_select("APP_FLOW",$app_data["model"]);
		$this->assign("id",$id);
		$this->assign("app_data",$app_data);
		$this->assign("workflow_data",$workflow_data);
		$this->assign("model_list",$model_list);
		$this->display();
	}
	
	public function deleteApp($id){
		$is_del = M("flow_app")->where(array("id"=>$id))->delete();
		if($is_del){
			$this->success ("删除成功",U("appList"));
			S("WORK_FLOW_CACHE",NULL);
		}else{ 
			$this->success ("删除失败",U("appList"));
		}
	}
}
