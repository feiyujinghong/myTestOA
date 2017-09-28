<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2015 co
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------

namespace Auth\Controller;

use Think\Controller;
use Auth\Model\AuthRuleModel;
use Auth\Model\AuthGroupModel;

/**
 * 后台首页控制器
 * @author lts
 */
class AuthController extends Controller {

	protected $include_header = true;
	

	protected $public_model = array("auth/public","auth/index","home/index");
	/**
	 * 后台控制器初始化
	 */
	protected function _initialize() {
		// 获取当前用户ID
		if (defined('UID'))
			return;
		define('UID', is_login());
		if (!UID) {// 还没登录 跳转到登录页面
			$this->redirect('Public/login');
		}
		/* 读取数据库中的配置 */
		$config = S('DB_CONFIG_DATA');
		if (!$config) {
			$config = api('Config/lists');
			S('DB_CONFIG_DATA', $config);
		}
		C($config); //添加配置
		// 是否是超级管理员
		define('IS_ROOT', is_administrator());
		if (!IS_ROOT && C('ADMIN_ALLOW_IP')) {
			// 检查IP地址访问
			if (!in_array(get_client_ip(), explode(',', C('ADMIN_ALLOW_IP')))) {
				$this->error('403:禁止访问');
			}
		}
		// 检测系统权限
		if (!IS_ROOT) {
			$access = $this->accessControl();
			if (false === $access) {
				$this->error('403:禁止访问');
			} elseif (null === $access) {
				//检测访问权限
				$rule = strtolower(MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME);
				$is_public = in_array(strtolower(MODULE_NAME . '/' . CONTROLLER_NAME),$this->public_model);
				if (!$this->checkRule($rule, array('in', '1,2')) && !$is_public && !IS_ROOT) {
					$this->error('未授权访问!');
				} else {
					// 检测分类及内容有关的各项动态权限
					$dynamic = $this->checkDynamic();
					if (false === $dynamic) {
						$this->error('未授权访问!');
					}
				}
			}
		}

		$this->assign('__MENU__', $this->getMenus());
	}

	/**
	 * 权限检测
	 * @param string  $rule    检测的规则
	 * @param string  $mode    check模式
	 * @return boolean
	 */
	final protected function checkRule($rule, $type = AuthRuleModel::RULE_URL, $mode = 'url') {
		static $Auth = null;
		if (!$Auth) {
			$Auth = new \Think\Auth();
		}
		if (!$Auth->check($rule, UID, $type, $mode)) {
			return false;
		}
		return true;
	}

	/**
	 * 检测是否是需要动态判断的权限
	 * @return boolean|null
	 *      返回true则表示当前访问有权限
	 *      返回false则表示当前访问无权限
	 *      返回null，则表示权限不明
	 *
	 */
	protected function checkDynamic() {
		
	}

	/**
	 * action访问控制,在 **登陆成功** 后执行的第一项权限检测任务
	 *
	 * @return boolean|null  返回值必须使用 `===` 进行判断
	 *
	 *   返回 **false**, 不允许任何人访问(超管除外)
	 *   返回 **true**, 允许任何管理员访问,无需执行节点权限检测
	 *   返回 **null**, 需要继续执行节点权限检测决定是否允许访问
	 */
	final protected function accessControl() {
		$allow = C('ALLOW_VISIT');
		$deny = C('DENY_VISIT');
		$check = strtolower(CONTROLLER_NAME . '/' . ACTION_NAME);
		if (!empty($deny) && in_array_case($check, $deny)) {
			return false; //非超管禁止访问deny中的方法
		}
		if (!empty($allow) && in_array_case($check, $allow)) {
			return true;
		}
		return null; //需要检测节点权限
	}

	/**
	 * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
	 *
	 * @param string $model 模型名称,供M函数使用的参数
	 * @param array  $data  修改的数据
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 */
	final protected function editRow($model, $data, $where, $msg) {
		$id = array_unique((array) I('id', 0));
		$id = is_array($id) ? implode(',', $id) : $id;
		//如存在id字段，则加入该条件
		$fields = M($model)->getDbFields();
		if (in_array('id', $fields) && !empty($id)) {
			$where = array_merge(array('id' => array('in', $id)), (array) $where);
		}

		$msg = array_merge(array('success' => '操作成功！', 'error' => '操作失败！', 'url' => '', 'ajax' => IS_AJAX), (array) $msg);
		if (M($model)->where($where)->save($data) !== false) {
			$this->success($msg['success'], $msg['url'], $msg['ajax']);
		} else {
			$this->error($msg['error'], $msg['url'], $msg['ajax']);
		}
	}

	/**
	 * 禁用条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的 where()方法的参数
	 * @param array  $msg   执行正确和错误的消息,可以设置四个元素 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 */
	protected function forbid($model, $where = array(), $msg = array('success' => '状态禁用成功！', 'error' => '状态禁用失败！')) {
		$data = array('status' => 0);
		$this->editRow($model, $data, $where, $msg);
	}

	/**
	 * 恢复条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 */
	protected function resume($model, $where = array(), $msg = array('success' => '状态恢复成功！', 'error' => '状态恢复失败！')) {
		$data = array('status' => 1);
		$this->editRow($model, $data, $where, $msg);
	}

	/**
	 * 还原条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 */
	protected function restore($model, $where = array(), $msg = array('success' => '状态还原成功！', 'error' => '状态还原失败！')) {
		$data = array('status' => 1);
		$where = array_merge(array('status' => -1), $where);
		$this->editRow($model, $data, $where, $msg);
	}

	/**
	 * 条目假删除
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	protected function delete($model, $where = array(), $msg = array('success' => '删除成功！', 'error' => '删除失败！')) {
		$data['status'] = -1;
		$this->editRow($model, $data, $where, $msg);
	}

	/**
	 * 设置一条或者多条数据的状态
	 */
	public function setStatus($Model = CONTROLLER_NAME) {

		$ids = I('request.ids');
		$status = I('request.status');
		if (empty($ids)) {
			$this->error('请选择要操作的数据');
		}

		$map['id'] = array('in', $ids);
		switch ($status) {
			case -1 :
				$this->delete($Model, $map, array('success' => '删除成功', 'error' => '删除失败'));
				break;
			case 0 :
				$this->forbid($Model, $map, array('success' => '禁用成功', 'error' => '禁用失败'));
				break;
			case 1 :
				$this->resume($Model, $map, array('success' => '启用成功', 'error' => '启用失败'));
				break;
			default :
				$this->error('参数错误');
				break;
		}
	}

	/**
	 * 获取控制器菜单数组,二级菜单元素位于一级菜单的'_child'元素中
	 */
	final public function getMenus($controller = CONTROLLER_NAME) {
		$menus = session('ADMIN_MENU_LIST.' . $controller);
		if (empty($menus)) {
			// 获取主菜单
			$where['pid'] = 0;
			$where['hide'] = 0;
			if (!C('DEVELOP_MODE')) { // 是否开发者模式
				$where['is_dev'] = 0;
			}
			$menus['main'] = M('Menu')->where($where)->order('sort asc')->field('id,title,url')->select();
			$menus['child'] = array(); //设置子节点
			foreach ($menus['main'] as $key => $item) {
				// 判断主菜单权限
				if (!IS_ROOT && !$this->checkRule(strtolower(MODULE_NAME . '/' . $item['url']), AuthRuleModel::RULE_MAIN, null)) {
					unset($menus['main'][$key]);
					continue; //继续循环
				}
				if (strtolower(CONTROLLER_NAME . '/' . ACTION_NAME) == strtolower($item['url'])) {
					$menus['main'][$key]['class'] = 'current';
				}
			}

			// 查找当前子菜单
			$pid = M('Menu')->where("pid !=0 AND url like '%{$controller}/" . ACTION_NAME . "%'")->getField('pid');
			if ($pid) {
				// 查找当前主菜单
				$nav = M('Menu')->find($pid);
				if ($nav['pid']) {
					$nav = M('Menu')->find($nav['pid']);
				}
				foreach ($menus['main'] as $key => $item) {
					// 获取当前主菜单的子菜单项
					if ($item['id'] == $nav['id']) {
						$menus['main'][$key]['class'] = 'current';
						//生成child树
						$groups = M('Menu')->where(array('group' => array('neq', ''), 'pid' => $item['id']))->distinct(true)->getField("group", true);
						//获取二级分类的合法url
						$where = array();
						$where['pid'] = $item['id'];
						$where['hide'] = 0;
						if (!C('DEVELOP_MODE')) { // 是否开发者模式
							$where['is_dev'] = 0;
						}
						$second_urls = M('Menu')->where($where)->getField('id,url');

						if (!IS_ROOT) {
							// 检测菜单权限
							$to_check_urls = array();
							foreach ($second_urls as $key => $to_check_url) {
								if (stripos($to_check_url, MODULE_NAME) !== 0) {
									$rule = MODULE_NAME . '/' . $to_check_url;
								} else {
									$rule = $to_check_url;
								}
								if ($this->checkRule($rule, AuthRuleModel::RULE_URL, null))
									$to_check_urls[] = $to_check_url;
							}
						}
						// 按照分组生成子菜单树
						foreach ($groups as $g) {
							$map = array('group' => $g);
							if (isset($to_check_urls)) {
								if (empty($to_check_urls)) {
									// 没有任何权限
									continue;
								} else {
									$map['url'] = array('in', $to_check_urls);
								}
							}
							$map['pid'] = $item['id'];
							$map['hide'] = 0;
							if (!C('DEVELOP_MODE')) { // 是否开发者模式
								$map['is_dev'] = 0;
							}
							$menuList = M('Menu')->where($map)->field('id,pid,title,url,tip')->order('sort asc')->select();
							$menus['child'][$g] = list_to_tree($menuList, 'id', 'pid', 'operater', $item['id']);
						}
					}
				}
			}
			session('ADMIN_MENU_LIST.' . $controller, $menus);
		}
		return $menus;
	}

	/**
	 * 返回后台节点数据
	 * @param boolean $tree    是否返回多维数组结构(生成菜单时用到),为false返回一维数组(生成权限节点时用到)
	 * @retrun array
	 *
	 * 注意,返回的主菜单节点数组中有'controller'元素,以供区分子节点和主节点
	 *
	 */
	final protected function returnNodes($tree = true) {
		static $tree_nodes = array();
		if ($tree && !empty($tree_nodes[(int) $tree])) {
			return $tree_nodes[$tree];
		}
		if ((int) $tree) {
			$list = M('Menu')->field('id,pid,title,url,tip,hide')->order('sort asc')->select();
//			foreach ($list as $key => $value) {
//				if (stripos($value['url'], MODULE_NAME) !== 0) {
//					$list[$key]['url'] = MODULE_NAME . '/' . $value['url'];
//				}
//			}
			$nodes = list_to_tree($list, $pk = 'id', $pid = 'pid', $child = 'operator', $root = 0);
			foreach ($nodes as $key => $value) {
				if (!empty($value['operator'])) {
					$nodes[$key]['child'] = $value['operator'];
					unset($nodes[$key]['operator']);
				}
			}
		} else {
			$nodes = M('Menu')->field('title,url,tip,pid')->order('sort asc')->select();
//			foreach ($nodes as $key => $value) {
//				if (stripos($value['url'], MODULE_NAME) !== 0) {
//					$nodes[$key]['url'] = MODULE_NAME . '/' . $value['url'];
//				}
//			}
		}
		$tree_nodes[(int) $tree] = $nodes;
		return $nodes;
	}

	/**
	 * 通用分页列表数据集获取方法
	 *
	 *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
	 *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
	 *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
	 *
	 * @param sting|Model  $model   模型名或模型实例
	 * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
	 * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
	 *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
	 *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
	 *
	 * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
	 *
	 * @return array|false
	 * 返回数据集
	 */
	protected function lists($model, $where = array(), $order = '', $field = true) {
		$options = array();
		$REQUEST = (array) I('request.');
		if (is_string($model)) {
			$model = M($model);
		}

		$OPT = new \ReflectionProperty($model, 'options');
		$OPT->setAccessible(true);

		$pk = $model->getPk();
		if ($order === null) {
			//order置空
		} else if (isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']), array('desc', 'asc'))) {
			$options['order'] = '`' . $REQUEST['_field'] . '` ' . $REQUEST['_order'];
		} elseif ($order === '' && empty($options['order']) && !empty($pk)) {
			$options['order'] = $pk . ' desc';
		} elseif ($order) {
			$options['order'] = $order;
		}
		unset($REQUEST['_order'], $REQUEST['_field']);

		if (empty($where)) {
			$where = array('status' => array('egt', 0));
		}
		if (!empty($where)) {
			$options['where'] = $where;
		}
		$options = array_merge((array) $OPT->getValue($model), $options);
		$total = $model->where($options['where'])->count();
		if (isset($REQUEST['r'])) {
			$listRows = (int) $REQUEST['r'];
		} else {
			$listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
		}
		$page = new \Think\Page($total, $listRows, $REQUEST);
		if ($total > $listRows) {
			$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		}
		$p = $page->show();
		$this->assign('_page', $p ? $p : '');
		$this->assign('_total', $total);
		$options['limit'] = $page->firstRow . ',' . $page->listRows;
		
		$model->setProperty('options', $options);
//		echo M()->getLastSql();
		return $model->field($field)->select();
	}

	protected  function page($total){
		if (isset($REQUEST['r'])) {
			$listRows = (int) $REQUEST['r'];
		} else {
			$listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
		}
		$page = new \Think\Page($total, $listRows, $REQUEST);
		if ($total > $listRows) {
			$page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		}
		$p = $page->show();
		$this->assign('_page', $p ? $p : '');
		$this->assign('_total', $total);
		$options['firstRow'] = $page->firstRow;
		$options['listRows'] = $page->listRows;
		return $options;
	}


	/**
	 * 处理文档列表显示
	 * @param array $list 列表数据
	 * @param integer $model_id 模型id
	 */
	protected function parseDocumentList($list, $model_id = null) {
		$model_id = $model_id ? $model_id : 1;
		$attrList = get_model_attribute($model_id, false, 'id,name,type,extra');
		// 对列表数据进行显示处理
		if (is_array($list)) {
			foreach ($list as $k => $data) {
				foreach ($data as $key => $val) {
					if (isset($attrList[$key])) {
						$extra = $attrList[$key]['extra'];
						$type = $attrList[$key]['type'];
						if ('select' == $type || 'checkbox' == $type || 'radio' == $type || 'bool' == $type) {
							// 枚举/多选/单选/布尔型
							$options = parse_field_attr($extra);
							if ($options && array_key_exists($val, $options)) {
								$data[$key] = $options[$val];
							}
						} elseif ('date' == $type) { // 日期型
							$data[$key] = date('Y-m-d', $val);
						} elseif ('datetime' == $type) { // 时间型
							$data[$key] = date('Y-m-d H:i', $val);
						}
					}
				}
				$data['model_id'] = $model_id;
				$list[$k] = $data;
			}
		}
		return $list;
	}

	/**
	 * 部门tree
	 */
	public function department_tree() {
		$department = M('department')->field(true)->select();
		return $this->arrangement_tree($department);
		//$department_tree_arr = D('Common/Tree')->toFormatTree($department,$title="name");
		//return $department_tree_arr;
	}

	/**
	 * 产品类型tree
	 */
	public function product_tree() {
		$department = M('ProductType')->field(true)->select();
		return $this->arrangement_tree($department);
	}

	/**
	 * tree
	 */
	public function arrangement_tree($department) {
		if(cookie("think_language") == "en-us")
			$is_en = 1;
		$department_tree_arr = D('Common/Tree')->toFormatTree($department, $title = $is_en==1 ? "en_name":"name");
		return $department_tree_arr;
	}

	/**
	 * 角色列表
	 */
	public function role_info() {
		$field_array = array("`id`", "`name`", "`remarks`");
		return M("role")->field()->where(array('dr' => 0))->select();
	}

	/**
	 * 获得用户信息
	 * $u_id 用户ID;
	 */
	protected function user_all($u_id) {
		$user_all = array();
		$user_info = M('user')->field(array("`username`", "`sex`", "`email`", "`mobile`", "`last_login_time`", "`role_id`"))
				->where(array("id" => $u_id))->find(); //基本信息
		if (!empty($user_info)) {
			$role_id = $user_info['role_id'];
			$role_name = M("role")->field(array("`name`", "`remarks`"))
					->where(array("id" => $role_id))->find(); //角色信息

			$dept_id = M('user_department')->where(array("uid" => $u_id))->getField("dept_id", true);
			if (!empty($dept_id)) {
				$dept_id_str = implode(",", $dept_id);
				$map = array();
				$map ['id'] = array("IN", $dept_id_str);
				$dept = M('department')->field("`name`")->where($map)->select();
				$dept ['name_str'] = implode(",", array_column($dept, 'name')); //部门数组转为字符串
			}

			$user_all['user_info'] = $user_info;
			$user_all['role'] = $role_name;
			$user_all['dept'] = $dept;
			return $user_all;
		} else {
			return $user_all;
		}
	}

	/*
	 * 部门树结构
	 */

	public function dept_tree($is_url = 0) {
		$depat = D("Auth/Department");
		$depat_info = $depat->department();
		foreach ($depat_info as $key => $value) {
			$depat_info[$key]['pId'] = $depat_info[$key]['pid'];
			if (0 == $is_url) {
				$depat_info[$key]['url'] = U("Staff/staff_list?dept_id=$value[id]");
			}
		}
		if (1 == $is_url) {
			$this->assign('tree_data', json_encode($depat_info));
		} else {
			return json_encode($depat_info);
		}
	}

	/**
	 * 获得最低级部门ID
	 * $dept_id 部门ID
	 */
	public function get_last_depat($dept_id = 1) {
		$department = M("department");
		$r_department = $department->field(array("`id`", "`pid`", "`name`"))->select();
		//dump($r_department);
		$last_depat_arr = $this->get_next_dept($dept_id, $r_department);
//		dump($last_depat_arr);
		foreach ($last_depat_arr as $key => $value) {
			$last_depat_id_arr[] = $value['id'];
		}
		return $last_depat_id_arr;
	}

	/**
	 * 获得下级部门
	 * $dept_id 部门ID
	 */
	public function get_next_dept($dept_id, & $r_department) {
		$arr = array();
		foreach ($r_department as $key => $value) {
			if ($r_department[$key]['pid'] == $dept_id) {
				//$arr[] = $r_department[$key];
				$next_arr = $this->get_next_dept($r_department[$key]['id'], $r_department);
				if (empty($next_arr)) {
					$arr[] = $r_department[$key];
				} else {
					$arr = array_merge($arr, $next_arr);
				}
			}
		}
		return $arr;
	}

	/**
	 * 获得部门下的用户
	 * param int $dept_id:部门ID
	 */
	public function get_dept_user($dept_id = 1) {
		$last_depat_id_arr = $this->get_last_depat($dept_id);
		$map = array();
		array_push($last_depat_id_arr, $dept_id);
		$map['dept_id'] = array('IN', $last_depat_id_arr);
		$r_uid_arr = M("user_department")->where($map)->group("uid")->getField("uid", true);
		$u_map = array();
		$u_map['id'] = array('IN', $r_uid_arr);
		$r_user = M("user")->field(array("`id`", "`name`", "`mobile`"))->where($u_map)->select();
		return $r_user;
	}

	/**
	 * ajax 获得部门下的用户
	 */
	public function query_dept_user() {
		if (I('dept_id')) {
			$user_info = $this->get_dept_user(intval(I('dept_id')));
			if (!empty($user_info)) {
				foreach ($user_info as $key => $value) {
					$data[] = array(
						"id" => $value["id"],
						"name" => $value["name"],
						"mobile" => $value["mobile"],
					);
				}
				echo json_encode(array("ret"=>1,"data"=>$data));
			} else {
				echo json_encode(array("ret"=>0));
			}
		} else {
			echo json_encode(array("ret"=>0));
		}
	}
	
	
	/**
	 * 获得部门下的员工
	 * param int $dept_id:部门ID
	 */
	public function get_dept_staff($dept_id = 1) {
		$last_depat_id_arr = $this->get_last_depat($dept_id);
		$map = array();
		$map['dept_id'] = array('IN', $last_depat_id_arr);
		$r_uid_arr = M("user_department")->where($map)->group("uid")->getField("uid", true);
		//dump($r_uid_arr);
		$u_map = array();
		$u_map['user_id'] = array('IN', $r_uid_arr);
		$r_user = M("staff_info")->field(array("id", "name", "user_id","work_num"))->where($u_map)->select();
		return $r_user;
	}
	/**
	 * ajax 获得部门下的员工
	 */
	public function query_dept_staff() {
		if (I('post.dept_id')) {
			$user_info = $this->get_dept_staff(intval(I('post.dept_id')));
			if (!empty($user_info)) {
				foreach ($user_info as $key => $value) {
					$data[] = array(
						"id" => $value["id"],
						"name" => $value["name"],
						"user_id"=>$value["user_id"] ? $value["user_id"] : 0,
						"work_num"=>$value["work_num"] ? $value["work_num"] : 0,
					);
				}
				echo json_encode(array("ret"=>1,"data"=>$data));
			} else {
				echo json_encode(array("ret"=>0));
			}
		} else {
			echo json_encode(array("ret"=>0));
		}
	}

	/**
	 * 上传图片
	 */
	public function tp_upload() {
		//上传系统用户头像
		//dump($_FILES);
		$upload = new \Think\Upload(); //实例化上传类
		$upload->maxSize = 3145728;
		$upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
		$name = $upload->saveRule = 'uniqid';
		//$name = $upload->saveName = 'time';
		$upload->rootPath = './SysUploads/'; // 设置附件上传根目录
		$path = $upload->savePath = ''; // 设置附件上传（子）目录
		$upload->subName = array('date', 'Ymd');
		$result = $upload->upload();
		if (!$result) {
			return false;
		} else {
			$this->tp_image($upload->rootPath.$result['file']['savepath'],$result['file']['savename']);//生成缩略图
			return $result;
		}
	}
	
	/**
	 * 生成缩略图
	 */
	public function tp_image($path, $pic_name) {
		$image = new \Think\Image(); 
		$image->open($path.$pic_name);
		$image->thumb(550, 450)->save($path.'m_'.$pic_name);
	}
	
	protected function sendMsg($type, $content, $url, $to_users) {
		$smsApi = new \User\Api\SmsApi();
		$smsApi->sendMsg($type, $content, $to_users, $url);
	}

	protected function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
		if ($this->include_header)
			parent::display(T("Auth@Public:header"));
		parent::display($templateFile, $charset, $contentType, $content, $prefix);
	}

	/**
	 * 流程流转
	 * @param type $model
	 * @param type $id
	 */
	protected function workflowRun($model, $app_id, $content, $url, $is_begin = 0) {
		$process_ids = I("process_id");
		$ret = 1;
		if ($is_begin) { //如果是开始流程
			$ret = $this->beginRun($model, $app_id, $content, $url);
		}
		if (!$ret)
			return false;
		if (!empty($process_ids)) {
			foreach ($process_ids as $key => $process_id) {	 //生成流程id和审批人的匹配信息
				$user_id_arr = I("process_user_" . $process_id) . ",";
				$user_id_arr = array_filter(explode(",", $user_id_arr));
				$param[$process_id] = $user_id_arr;
			}
		} else {
			$param["is_end"] = 1;	//标记流程结束
		}
		$workflow = new \Workflow\Model\WorkflowModel();
		$ret1 = $workflow->flowRun($model, $app_id, $param, $content, $url);
		foreach ($process_ids as $key => $process_id) {
			$user_id_arr = I("process_user_" . $process_id) . ",";
			$user_id_arr = array_filter(explode(",", $user_id_arr));
			$this->sendMsg(I("msg_" . $process_id), $content, $url, $to_users); //发送系统消息
		}
		if ($ret && $ret1)
			return true;
	}

	protected function success($message = '', $jumpUrl = '', $ajax = false) {
		parent::success($message, $jumpUrl, $ajax);
		exit;
	}

	protected function beginRun($model, $app_id, $content, $url) {
		$workflow = new \Workflow\Model\WorkflowModel();
		return $workflow->beginRun($model, $app_id, $content, $url);
	}

	/**
	 * 获取下一步骤的经办信息
	 * @param type $model	应用模型
	 * @param type $app_id	应用ID	
	 * @return boolean
	 */
	protected function nextStepFlow($model, $app_id) {
		$this->include_header = false;
		$workflow = new \Workflow\Model\WorkflowModel();
		if ($this->_isFlowOffice($model, $app_id)) { //判断是否处于待办理状态
			$data = $workflow->nextStep($model, $app_id);
			$this->dept_tree(1); //部门结构弹层
			$this->assign("model", $model);
			$this->assign("app_id", $app_id);
			$this->assign("data", $data);
			if ($app_id == 0)
				$this->display(T("Workflow@Public/beginflow"));
			else
				$this->display(T("Workflow@Public/nextStep"));
			$this->selectUser();
		}
		//已经办理的步骤
		$alreadyStepData = $workflow->getFlowAlreadyStep($model, $app_id);
		$this->assign("alreadyStepData", $alreadyStepData);
		$this->display(T("Workflow@Public/alreadyStep"));
	}

	protected function getNowProcessName($model, $app_id) {
		$workflow = new \Workflow\Model\WorkflowModel();
		if (empty($app_id)) { //如果id为空则说明为起始步骤
			$step_data = $workflow->getStartData($model);
		} else {
			$step_data = $workflow->getStepData($model, $app_id);
		}
		return $step_data["process_name"];
	}

	/**
	 * 判断当前步骤是否可以经办
	 * @param type $model
	 * @param type $app_id
	 */
	private function _isFlowOffice($model, $app_id) {
		$ret = M()->table("app_run")->where(array("model" => $model, "app_id" => $app_id, "user_id" => is_login()))->order("id desc")->getField("status");
		return in_array($ret, array(\Workflow\Model\WorkflowModel::ONLY_SAVE, \Workflow\Model\WorkflowModel::IS_APPROVAL));
	}

	/**
	 * 选人控件，默认单选，
	 * @param type $is_single = 1 为单选，0为多选
	 */
	protected function selectUser($is_single = 1) {
		$this->include_header = false;
		$this->assign("is_single", $is_single);
		$this->display(T("Auth@Public/selectUser"));
	}
	/**
	 * 选择人资信息里的员工，只能单选
	 */
	public function selectStaff(){
		$this->include_header = false;
		$this->display(T("Auth@Public/selectStaff"));
	}
}
