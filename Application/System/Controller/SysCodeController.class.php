<?php

namespace System\Controller;

use Think\Controller;

class SysCodeController extends \Auth\Controller\AuthController {

	private $model;
	public function _initialize() {
		parent::_initialize();
		$this->model = M("code");
	}
	/**
	 * 系统代码管理
	 */
	public function index() {
		$code_data = M("code")->where(array("p_id" => 0))->select();
		$this->assign("code_data", $code_data);
		$this->display();
	}

	/**
	 * 增加主代码
	 */
	public function add() {
		if (IS_POST) {
			$data["name"] = I("name");
			$data["code"] = I("code");
			$data["order"] = I("order");
			$ret = M("code")->add($data);
			$this->_cleanCache();
			if ($ret)
				$this->success("添加成功", U("index"));
			else
				$this->error("添加失败", U("index"));
			exit;
		}
		$this->display();
	}

	/**
	 * 增加子代码
	 * @param type $id
	 * @param type $name
	 */
	public function addSon($id, $name) {
		if (IS_POST) {
			$data["name"] = I("name");
			$data["code"] = I("code");
			$data["order"] = I("order");
			$data["p_id"] = intval(I("p_id"));
			$code_name = I("code_name");
			$ret = M("code")->add($data);
			$this->_cleanCache();
			if ($ret)
				$this->success("添加成功", U("codeList", array("id" => $data["p_id"], "name" => $code_name)));
			else
				$this->error("添加失败", U("codeList", array("id" => $data["p_id"], "name" => $code_name)));
			exit;
		}
		$this->assign("id", $id);
		$this->assign("name", $name);
		$this->display();
	}

	/**
	 * 子代码列表
	 * @param type $id
	 * @param type $name
	 */
	public function codeList($id, $name) {
		$code_list = M("code")->where(array("p_id" => $id))->order(" 'order' asc")->select();
		$this->assign("name", $name);
		$this->assign("id", $id);
		$this->assign("code_list", $code_list);
		$this->display();
	}

	/**
	 * 修改系统代码
	 * @param type $id
	 */
	public function update($id) {
		if (IS_POST) {
			$data["name"] = I("name");
			$data["code"] = I("code");
			$data["order"] = I("order");
			$ret = M("code")->where(array("id" => $id))->save($data);
			$this->_cleanCache();
			if ($ret)
				$this->success("保存成功", U("index"));
			else
				$this->error("保存失败", U("index"));
			exit;
		}
		$data = M("code")->where(array("id" => $id))->find();
		$this->assign("data", $data);
		$this->display();
	}

	/**
	 * 子代码修改
	 * @param type $id
	 * @param type $name
	 */
	public function updateSon($id) {
		if (IS_POST) {
			$data["name"] = I("name");
			$data["code"] = I("code");
			$data["order"] = I("order");
			$data["p_id"] = intval(I("p_id"));
			$code_name = I("code_name");
			$ret = M("code")->where(array("id" => $id))->save($data);
			$this->_cleanCache();
			if ($ret)
				$this->success("修改成功", U("codeList", array("id" => $data["p_id"], "name" => $code_name)));
			else
				$this->error("修改失败", U("codeList", array("id" => $data["p_id"], "name" => $code_name)));
			exit;
		}
		$code_data = M("code")->where(array("id" => $id))->find();
		$data = M("code")->where(array("id" => $code_data["p_id"]))->find();
		$this->assign("data", $data);
		$this->assign("id", $id);
		$this->assign("code_data", $code_data);
		$this->display();
	}

	/**
	 * 禁用、解禁
	 */
	public function Deny($id,$name,$status) {
		$ret = $this->model->where(array("id" => $id))->save(array("status" => $status));
		$p_id = $this->model->where(array("id" => $id))->getField("p_id");
		$this->_cleanCache();
		if ($ret)
			$this->success("禁用成功", U("codeList", array("id" => $p_id, "name" => $name)));
		else
			$this->error("禁用失败", U("codeList", array("id" =>$p_id, "name" => $name)));
		$this->_cleanCache();
		exit;
	}

	private function _cleanCache() {
		S("CODE_CACHE", NULL);
	}

}
