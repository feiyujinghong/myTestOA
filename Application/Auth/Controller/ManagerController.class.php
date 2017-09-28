<?php
namespace Auth\Controller;
use Think\Controller;
use Auth\Model\AuthRuleModel;
use Auth\Model\AuthGroupModel;
class ManagerController extends AuthController {
	
	/**
	 * 权限管理首页
	 */
	public function auth_list() {
		$list = $this->lists ( 'AuthGroup', array ('module' => 'admin' ), 'id asc' );
		$list = int_to_string ( $list );
		$this->assign ( '_list', $list );
		$this->assign ( '_use_tip', true );
		$this->display ();
	
	}
	/**
	 * 删除组操作
	 */
	public function change_status() {
		$method = I("get.method");
		switch ($method) {
			case "delete":
				$c_auth_g = array('status' => -1);
				break;
			case "recover":
				$c_auth_g = array('status' => 1);
				break;
			default:
				$this->error("非法参数！");
				break;
		}
		$auth_g_id = I("get.id");
		if (!empty($auth_g_id)) {
			$map = array();
			$map ['id'] = intval($auth_g_id);
			if (D('AuthGroup')->auth_group_update($map, $c_auth_g)) {
				$this->success ( '操作成功!', U ( 'auth_list' ) );
			} else {
				$this->error("删除失败！");
			}
		} else {
			$this->error("非法参数！");
		}
	}
	
	/**
	 * 创建管理员用户组
	 */
	public function create_group() {
		if (empty ( $this->auth_group )) {
			$this->assign ( 'auth_group', array ('title' => null, 'id' => null, 'description' => null, 'rules' => null ) ); //排除notice信息
		}
		$this->display ( 'editgroup' );
	}
	
	/**
     * 编辑管理员用户组
     */
    public function edit_group(){
        $auth_group = M('AuthGroup')->where( array('module'=>'admin','type'=>AuthGroupModel::TYPE_ADMIN) )
                                    ->find( (int)$_GET['id'] );
        //echo M()->getLastSql();
        $this->assign('auth_group',$auth_group);
        $this->meta_title = '编辑用户组';
        $this->display('editgroup');
    }
	
	
	/**
	 * 管理员用户组数据写入/更新
	 * !!!!!!!!!!!BUG
	 */
	public function write_group() {
		if (isset ( $_POST ['rules'] )) {
			sort ( $_POST ['rules'] );
			$_POST ['rules'] = implode ( ',', array_unique ( $_POST ['rules'] ) );
		}
		$_POST ['module'] = 'admin';
		$_POST ['type'] = AuthGroupModel::TYPE_ADMIN;
		$AuthGroup = D ( 'AuthGroup' );
		$data = $AuthGroup->create ();
		if ($data) {
			if (empty ( $data ['id'] )) {
				$r = $AuthGroup->add ();
			} else {
				$r = $AuthGroup->save ();
				//echo M()->getLastSql();exit();
			}
			if ($r === false) {
				$this->error ( '操作失败' . $AuthGroup->getError () );
			} else {
				$this->success ( '操作成功!', U ( 'auth_list' ) );
			}
		} else {
			$this->error ( '操作失败' . $AuthGroup->getError () );
		}
	}
	
	/**
	 * 访问授权页面
	 */
	public function access() {
		$this->updateRules ();
		$auth_group = M ( 'AuthGroup' )->where ( array ('status' => array ('egt', '0' ), 'module' => 'admin', 'type' => AuthGroupModel::TYPE_ADMIN ) )->getfield ( 'id,id,title,rules' );
		$node_list = $this->returnNodes ();
		$map = array ('module' => 'admin', 'type' => AuthRuleModel::RULE_MAIN, 'status' => 1 );
		$main_rules = M ( 'AuthRule' )->where ( $map )->getField ( 'name,id' );
		$map = array ('module' => 'admin', 'type' => AuthRuleModel::RULE_URL, 'status' => 1 );
		$child_rules = M ( 'AuthRule' )->where ( $map )->getField ( 'name,id' );
		
		$this->assign ( 'main_rules', $main_rules );//主菜单
		$this->assign ( 'auth_rules', $child_rules );//URL
		$this->assign ( 'node_list', $node_list );//tree
		$this->assign ( 'auth_group', $auth_group );
		$this->assign ( 'this_group', $auth_group [( int ) $_GET ['group_id']] );
		$this->display ( 'managergroup' );
	}
	
	/**
	 * 后台节点配置的url作为规则存入auth_rule
	 * 执行新节点的插入,已有节点的更新,无效规则的删除三项任务
	 */
	public function updateRules() {
		//需要新增的节点必然位于$nodes
		$nodes = $this->returnNodes ( false );
		$AuthRule = M ( 'AuthRule' );
		$map = array ('module' => 'admin', 'type' => array ('in', '1,2' ) ); //status全部取出,以进行更新
		//需要更新和删除的节点必然位于$rules
		$rules = $AuthRule->where ( $map )->order ( 'name' )->select ();
		
		//构建insert数据
		$data = array (); //保存需要插入和更新的新节点
		foreach ( $nodes as $value ) {
			$temp ['name'] = $value ['url'];
			$temp ['title'] = $value ['title'];
			$temp ['module'] = 'admin';
			if ($value ['pid'] > 0) {
				$temp ['type'] = AuthRuleModel::RULE_URL;
			} else {
				$temp ['type'] = AuthRuleModel::RULE_MAIN;
			}
			$temp ['status'] = 1;
			$data [strtolower ( $temp ['name'] . $temp ['module'] . $temp ['type'] )] = $temp; //去除重复项
		}
		$update = array (); //保存需要更新的节点
		$ids = array (); //保存需要删除的节点的id
		foreach ( $rules as $index => $rule ) {
			$key = strtolower ( $rule ['name'] . $rule ['module'] . $rule ['type'] );
			if (isset ( $data [$key] )) { //如果数据库中的规则与配置的节点匹配,说明是需要更新的节点
				$data [$key] ['id'] = $rule ['id']; //为需要更新的节点补充id值
				$update [] = $data [$key];
				unset ( $data [$key] );
				unset ( $rules [$index] );
				unset ( $rule ['condition'] );
				$diff [$rule ['id']] = $rule;
			} elseif ($rule ['status'] == 1) {
				$ids [] = $rule ['id'];
			}
		}
		if (count ( $update )) {
			foreach ( $update as $k => $row ) {
				if ($row != $diff [$row ['id']]) {
					$AuthRule->where ( array ('id' => $row ['id'] ) )->save ( $row );
				}
			}
		}
		if (count ( $ids )) {
			$AuthRule->where ( array ('id' => array ('IN', implode ( ',', $ids ) ) ) )->save ( array ('status' => - 1 ) );
		
		//删除规则是否需要从每个用户组的访问授权表中移除该规则?
		}
		if (count ( $data )) {
			$AuthRule->addAll ( array_values ( $data ) );
		}
		if ($AuthRule->getDbError ()) {
			trace ( '[' . __METHOD__ . ']:' . $AuthRule->getDbError () );
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * 将用户添加到用户组的编辑页面
	 */
	public function group() {
		$uid = I ( 'uid' );
		$auth_groups = D ( 'AuthGroup' )->getGroups ();
		$user_groups = AuthGroupModel::getUserGroup ( $uid );
		$ids = array ();
		foreach ( $user_groups as $value ) {
			$ids [] = $value ['group_id'];
		}
		$nickname = D ( 'Member' )->getNickName ( $uid );
		$this->assign ( 'nickname', $nickname );
		$this->assign ( 'auth_groups', $auth_groups );
		$this->assign ( 'user_groups', implode ( ',', $ids ) );
		$this->display ();
	}
	
	/**
	 * 将用户添加到用户组,入参uid,group_id
	 */
	public function add_to_group() {
		$uid = I ( 'uid' );
		$gid = I ( 'group_id' );
		if (empty ( $uid )) {
			$this->error ( '参数有误' );
		}
		$AuthGroup = D ( 'AuthGroup' );
		if (is_numeric ( $uid )) { //is_numeric()检测变量是否为数字或数字字符串
			if (is_administrator ( $uid )) {
				$this->error ( '该用户为超级管理员' );
			}
			if (! M ( 'user' )->where ( array ('id' => $uid ) )->find ()) {
				$this->error ( '用户不存在' );
			}
		}
		if ($gid && ! $AuthGroup->checkGroupId ( $gid )) {
			$this->error ( $AuthGroup->error );
		}
		if ($AuthGroup->addToGroup ( $uid, $gid )) {
			$this->success ( '操作成功' );
		} else {
			$this->error ( $AuthGroup->getError () );
		}
	}

}