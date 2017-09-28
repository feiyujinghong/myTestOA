<?php

namespace Workflow\Controller;

use Think\Controller;
use Auth\Controller\AuthController;

class RunController extends AuthController {
	
	/**
	 * 流程流转
	 */
	public function Run(){
		$model = I("model");
		$app_id = I("app_id");
		$data = M()->table("app_run")->where(array("model"=>$model,"app_id"=>$app_id,"user_id"=>  is_login()))->order("id desc")->find();
		$ret = $this->workflowRun($model,$app_id,$data["name"],$data["url"]);
		if($ret)
			$this->success ("转交成功",U("Home/index/willWorkList"));
		else
			$this->error("转交失败",U("Home/index/willWorkList"));
	}
}
