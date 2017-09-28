<?php
/**
 * Description of CliHelpControler
 *
 * @author xxb
 */
namespace Cli\Controller;

use Think\Model;

use Think\Auth;

use Auth\Controller\AuthController;

class CliHelpController extends AuthController{
	
	/**
	 * 添加求助信息
	 * @param type $id
	 */
	public function addHelp($id){
		$id = intval($id);
		if(IS_POST){
			unset($_POST["help_user_name"]);
			$data = M("cli_help")->create();
			$data["p_id"] = 0;
			$data["add_user_id"] = UID;
			$data["add_time"] = time();
			$ret = M("cli_help")->add($data);
			if($ret){
				$this->sendMsg(array(1), "客户求助:".$data["title"], U("helpComment",array("id"=>$ret)), array($data["help_user_id"]));
				$this->success("提交成功");
			}else{
				$this->error("提交失败");
			}
		}
		$this->assign("id",$id);
		$this->display();
		$this->dept_tree(1);
		$this->selectUser();
	}
	
	/**
	 * 判断是否有权限点评
	 */
	private function _access($id){
		$data = M()->table("cli_help")->where(array("id=$id"))->find();
		if($data["help_user_id"] == UID || $data["add_user_id"] == UID)
			return true;
		$this->error("您没有该求助信息的权限");
	}
	/**
	 * 求助回复
	 * @param type $id
	 */
	public function helpComment($id){
		$id = intval($id);
		$this->_access($id);
		if(IS_POST){
			$content = I("help_content");
			$data=array(
				"add_user_id"=>UID,
				"p_id"=>$id,
				"content"=>$content,
				"add_time"=>time(),
			);
			$ret = M()->table("cli_help")->add($data);
			if($ret)
				$this->success ("回复成功");
			else
				$this->error("回复失败");
		}
		$data = M()->table("cli_help")->where(array("id=$id or p_id=$id"))->select();
		$this->assign("data",$data);
		$this->assign("id",$id);
		$this->display();
	}
	
	public function helpList($cli_id){
		$cli_id = intval($cli_id);
		$map = array("cli_id"=>$cli_id);
		$data = $this->lists("cli_help", $map,"id desc");
		$name = M("cli")->where(array("id"=>$cli_id))->getField("company_name");
		$this->assign("data",$data);
		$this->assign("name",$name);
		$this->assign("cli_id",$cli_id);
		$this->display();
	}
}
