<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2015 co
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------

namespace Auth\Controller;

use User\Api\UserApi;

/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class UserController extends AuthController {

	/**
	 * 用户管理首页
	 */
	public function user_list() {

		$nickname = I('nickname');
		$map['status'] = array('egt', 0);
		if (is_numeric($nickname)) {
			$map['uid|nickname'] = array(intval($nickname), array('like', '%' . $nickname . '%'), '_multi' => true);
		} else {
			$map['nickname'] = array('like', '%' . (string) $nickname . '%');
		}

		$list = $this->lists('Member', $map);
		int_to_string($list);
		$this->assign('_list', $list);
		$this->meta_title = '用户信息';
		$this->display();
	}

	/**
	 * 修改昵称初始化
	 * @author huajie <banhuajie@163.com>
	 */
	public function updateNickname() {
		$nickname = M('Member')->getFieldByUid(UID, 'nickname');
		$this->assign('nickname', $nickname);
		$this->meta_title = '修改昵称';
		$this->display('updatenickname');
	}

	/**
	 * 修改昵称提交
	 * @author huajie <banhuajie@163.com>
	 */
	public function submitNickname() {
		//获取参数
		$nickname = I('post.nickname');
		$password = I('post.password');
		empty($nickname) && $this->error('请输入昵称');
		empty($password) && $this->error('请输入密码');

		//密码验证
		$User = new UserApi ();
		$uid = $User->login(UID, $password, 4);
		($uid == - 2) && $this->error('密码不正确');

		$Member = D('Member');
		$data = $Member->create(array('nickname' => $nickname));
		if (!$data) {
			$this->error($Member->getError());
		}

		$res = $Member->where(array('uid' => $uid))->save($data);

		if ($res) {
			$user = session('user_auth');
			$user ['username'] = $data ['nickname'];
			session('user_auth', $user);
			session('user_auth_sign', data_auth_sign($user));
			$this->success('修改昵称成功！');
		} else {
			$this->error('修改昵称失败！');
		}
	}

	/**
	 * 修改密码初始化
	 * @author huajie <banhuajie@163.com>
	 */
	public function updatePassword() {
		$this->meta_title = '修改密码';
		$this->display('updatepassword');
	}

	/**
	 * 修改密码提交
	 * @author huajie <banhuajie@163.com>
	 */
	public function submitPassword() {
		//获取参数
		$password = I('post.old');
		empty($password) && $this->error('请输入原密码');
		$data ['password'] = I('post.password');
		empty($data ['password']) && $this->error('请输入新密码');
		$repassword = I('post.repassword');
		empty($repassword) && $this->error('请输入确认密码');

		if ($data ['password'] !== $repassword) {
			$this->error('您输入的新密码与确认密码不一致');
		}

		$Api = new UserApi ();
		$res = $Api->updateInfo(UID, $password, $data);
		if ($res ['status']) {
			$this->success('修改密码成功！');
		} else {
			$this->error($res ['info']);
		}
	}

	/**
	 * 用户行为列表
	 * @author huajie <banhuajie@163.com>
	 */
	public function action() {
		//获取列表数据
		$Action = M('Action')->where(array('status' => array('gt', - 1)));
		$list = $this->lists($Action);
		int_to_string($list);
		// 记录当前列表页的cookie
		Cookie('__forward__', $_SERVER ['REQUEST_URI']);

		$this->assign('_list', $list);
		$this->meta_title = '用户行为';
		$this->display();
	}

	/**
	 * 新增行为
	 * @author huajie <banhuajie@163.com>
	 */
	public function addAction() {
		$this->meta_title = '新增行为';
		$this->assign('data', null);
		$this->display('editaction');
	}

	/**
	 * 编辑行为
	 * @author huajie <banhuajie@163.com>
	 */
	public function editAction() {
		$id = I('get.id');
		empty($id) && $this->error('参数不能为空！');
		$data = M('Action')->field(true)->find($id);

		$this->assign('data', $data);
		$this->meta_title = '编辑行为';
		$this->display('editaction');
	}

	/**
	 * 更新行为
	 * @author huajie <banhuajie@163.com>
	 */
	public function saveAction() {
		$res = D('Action')->update();
		if (!$res) {
			$this->error(D('Action')->getError());
		} else {
			$this->success($res ['id'] ? '更新成功！' : '新增成功！', Cookie('__forward__'));
		}
	}

	/**
	 * 会员状态修改
	 * @author 朱亚杰 <zhuyajie@topthink.net>
	 */
	public function changeStatus($method = null) {
		$id = array_unique((array) I('id', 0));
		if (in_array(C('USER_ADMINISTRATOR'), $id)) {
			$this->error("不允许对超级管理员执行该操作!");
		}
		$id = is_array($id) ? implode(',', $id) : $id;
		if (empty($id)) {
			$this->error('请选择要操作的数据!');
		}
		$map ['uid'] = array('in', $id);
		switch (strtolower($method)) {
			case 'forbiduser' :
				$this->forbid('Member', $map);
				break;
			case 'resumeuser' :
				$this->resume('Member', $map);
				break;
			case 'deleteuser' :
				$this->delete('Member', $map);
				break;
			default :
				$this->error('参数非法');
		}
	}

	public function add($username = '', $password = '', $repassword = '', $role_id = '', $email = '', $mobile = '', $name = '', $department = array()) {
		if (IS_POST) {
			/* 检测密码 */
			if ($password != $repassword) {
				$this->error('密码和重复密码不一致！');
				exit();
			}

			if (empty($department)) {
				$this->error('所属部门不能为空！');
				exit();
			}
			/* 调用注册接口注册用户 */
			$User = new UserApi ();
			$uid = $User->register($username, $password, $email, $role_id, $mobile, $name);
			if (0 < $uid) { //注册成功
				$user = array('uid' => $uid, 'nickname' => $username, 'status' => 1);

				if (!M('Member')->add($user)) {
					$this->error('用户添加失败！');
				} else {
					if (!empty($department)) {
						$user_depar = array();
						foreach ($department as $key => $value) {
							$user_depar[$key]['dept_id'] = $value;
							$user_depar[$key]['uid'] = $uid;
						}
						if (M("user_department")->addAll($user_depar)) { //添加部门
							if (!empty($_FILES['file']['name'])) {
								$file_res = $this->tp_upload();
								if ($file_res) {
									$s_user = array();
									$s_user['top_pic'] = "SysUploads/" . $file_res['file']['savepath'] . $file_res['file']['savename'];
									$s_toppic = M('user')->where(array('id = ' . $uid))->save($s_user);
									if (false !== $s_toppic) {
										$this->success('用户添加成功！', U('user_list'));
									} else {
										$this->error('用户头像保存失败！');
									}
								} else {
									$this->error('用户头像上传失败！');
								}
							}
							$this->success('用户添加成功！', U('user_list'));
						} else {
							$this->error('用户所属部门添加失败！');
						}
					} else {
						$this->error('用户所属部门获取失败！');
					}
				}
			} else { //注册失败，显示错误信息
				$this->error($this->showRegError($uid));
			}
		} else {
			$this->assign('department_tree', $this->department_tree()); //部门树
			$this->assign('role', $this->role_info());
			$this->display();
		}
	}

	/**
	 * 获取用户注册错误信息
	 * @param  integer $code 错误编码
	 * @return string        错误信息
	 */
	private function showRegError($code = 0) {
		switch ($code) {
			case - 1 :
				$error = '用户名长度必须在16个字符以内！';
				break;
			case - 2 :
				$error = '用户名被禁止注册！';
				break;
			case - 3 :
				$error = '用户名被占用！';
				break;
			case - 4 :
				$error = '密码长度必须在6-30个字符之间！';
				break;
			case - 5 :
				$error = '邮箱格式不正确！';
				break;
			case - 6 :
				$error = '邮箱长度必须在1-32个字符之间！';
				break;
			case - 7 :
				$error = '邮箱被禁止注册！';
				break;
			case - 8 :
				$error = '邮箱被占用！';
				break;
			case - 9 :
				$error = '手机格式不正确！';
				break;
			case - 10 :
				$error = '手机被禁止注册！';
				break;
			case - 11 :
				$error = '手机号被占用！';
				break;
			default :
				$error = '未知错误';
		}
		return $error;
	}

	/**
	 * 用户中心
	 */
	public function user_centent() {
		$session_user_auth = session('user_auth');
		if (!empty($session_user_auth)) {
			$user_id = $session_user_auth['uid'];
			$ucentent_info = $this->user_all($user_id);
			$this->assign('ucentent_info', $ucentent_info);
			$this->display();
		} else {
			$this->error("请退出重新登录！");
		}
	}

	/**
	 * 修改用户
	 * @param type $id
	 */
	public function update($id) {
		if (UID != $id && !is_administrator()) {
			$this->error("抱歉,您没有权限修改用户信息,请联系管理员");
		}
		if (IS_POST) { //保存提交内容
			$data["username"] = I("username");
			$data["password"] = I("password");
			if (!empty($data["password"])){
				$userAPI = new UserApi;
				$userAPI->updatePassword($id,$data["password"]);
				unset($data["password"]);
			}
			
			$data["name"] = I("name");
			$data["sex"] = I("sex");
			$data["status"] = I("status");
			$data["mobile"] = I("mobile");
			$data["email"] = I("email");
			$department = I("department");
			$data["role_id"] = I("role_id");
			if (!empty($_FILES['file']['name'])) {
				$file_res = $this->tp_upload();
				if ($file_res) {
					$s_user = array();
					$data['top_pic'] = "SysUploads/" . $file_res['file']['savepath'] . $file_res['file']['savename'];
				} else {
					$this->error('用户头像上传失败！');
				}
			}

			$ret = M("user")->where(array("id" => $id))->save($data);
			if(!$data["password"]){
			}
			if (!empty($department)) {
				$user_depar = array();
				foreach ($department as $key => $value) {
					$user_depar[$key]['dept_id'] = $value;
					$user_depar[$key]['uid'] = $id;
				}
				$result = M("user_department")->where(array("uid"=>$id))->delete();
				
				if($result)
					$ret2 = M("user_department")->addAll($user_depar);
			}
			if($ret || $ret2){
				$this->success("修改成功",U("user_list"));
			}else{
				$this->error("修改失败");
			}
		}
		$data = M("user")->where(array("id" => $id))->find();
		$this->assign('department_tree', $this->department_tree()); //部门树
		$dept_id = M("user_department")->where(array("uid"=>$id))->getField("dept_id");
		$this->assign("id", $id);
		$this->assign("dept_id",$dept_id);
		$this->assign('role', $this->role_info());
		$this->assign("data", $data);
		$this->display("add");
	}

}
