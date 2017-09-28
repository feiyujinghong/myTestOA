<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Auth\Controller;

use User\Api\UserApi;

/**
 * 后台首页控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class PublicController extends \Think\Controller {

    /**
     * 后台用户登录
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function login($username = null, $password = null, $verify = null) {
    	//dump(IS_POST);
    	if (IS_POST) {
            /* 检测验证码 TODO: */
            if (!check_verify($verify)) {
				$this->error('验证码输入错误！');
			}
			/* 调用UC登录接口登录 */
			$User = new UserApi;
			$uid = $User->login($username, $password);
			if (0 < $uid) { //UC登录成功
				/* 登录用户 */
				$Member = D('Member');
				if ($Member->login($uid)) { //登录用户
					//TODO:跳转到登录前页面
					$this->_ruleToSession($uid);	//将权限存储到session
					$this->success('登录成功！', U('Index/index'));
				} else {
					$this->error($Member->getError());
				}
			} else { //登录失败
				switch ($uid) {
					case -1: $error = '用户不存在或被禁用！';
						break; //系统级别禁用
					case -2: $error = '密码错误！';
						break;
					default: $error = '未知错误！';
						break; // 0-接口参数错误（调试阶段使用）
				}
				$this->error($error);
			}
		} else {
			if (is_login()) {
				$this->redirect('Index/index');
			} else {
				$language = cookie("think_language");
				$this->assign("language",$language);
				$this->display('login');
			}
		}
	}

	private function _ruleToSession($uid){
		$group_id = M("auth_group_access")->where(array("uid"=>$uid))->getField("group_id",true);
		$rules = M("auth_group")->where(array("id"=>array("IN",$group_id)))->getField("rules",true);
		if(is_array($rules))
			$rules = implode(",", $rules);
		$rules = trim($rules,",");
		$data = M("auth_rule")->where("id in (".$rules.")")->field("name")->select();
		foreach($data as $val){
			$rt[] = strtolower($val["name"]);
		}
		session("menu",$rt);
	}
	/* 退出登录 */

	public function logout() {
		if (is_login()) {
			D('Member')->logout();
			session('[destroy]');
			$this->success('退出成功！', U('login'));
		} else {
			$this->redirect('login');
		}
	}

	public function showfont() {
		$this->display("header");
		$this->display();
	}

	public function verify() {
		$verify = new \Think\Verify();
		ob_end_clean();
		$verify->entry(1);
	}

	/**
	 * 获取到当前用户的代办工作数量
	 */
	public function getMsg() {
		$count = M()->table("sys_msg")->where(array("to_uid" => is_login(), "status" => 0))->count();
		echo $count;
	}

	/**
	 * 获取代办工作的列表
	 */
	public function getMsgList() {
		$data = M()->table("sys_msg")->where(array("to_uid" => is_login(), "status" => 0))->limit(5)->order("id desc")->select();
		$ret = "<ul class=list-group>";
		foreach ($data as $val) {
			$ret .= "<li class='list-group-item'><a href='" . $val["url"] . "' target='_blank' onclick='read_msg(\"" . U("Auth/Public/read_msg", array("id" => $val["id"])) . "\")'>" . $val["content"] . "</a></li>";
		}
		$ret .= "</ul>";
		echo $ret;
	}

	public function read_msg($id) {
		M("sys_msg")->where(array("id" => $id))->save(array("status" => 1));
	}

}
