<?php
namespace Auth\Controller;
use Think\Controller;
class DepartmentController extends AuthController {
	/**
	 * 添加修改部门
	 */
	public function add_department() {
		if (IS_POST) {
			$department = D('Department');
			$_POST['add_time'] = time();
			$_POST['add_ip'] = get_client_ip(0);
			if (I('post.id')) {
				$_POST['id'] = intval(I('post.id'));
			}
			$c_department = $department->create();
			//var_dump($c_department);exit();
			if (!$c_department) {
				exit("操作失败！".$department->getError());
			} else  {
				if (empty($c_department[id])) {
					$r = $department->add();
				} else {
					$r = $department->save ();
				}
				if (false === $r) {
					$this->error ( '操作失败' . $department->getError () );
				} else {
					$this->success('操作成功',U ( 'add_department' ));
				}
			}
		} else {
			$department_tree = $this->department_tree();
			//dump($department_tree);
			$this->assign('department_tree',$department_tree);
			$this->display();
		}
	
	}
	
	public function department_show() {
		$pid = I('get.pid');
		!empty($pid) ? $map = array('pid'=>$pid) : $map = array('pid'=>0);
		$department = D('Department');
		$r_department = $department->where($map)->select();
		foreach ($r_department as $key=>$value) {
			$n_map = array('pid'=>$value['id']);
			$next_count = $department->department_count($n_map);
			$r_department[$key]['next_count'] = $next_count;
		}
		//dump($r_department);
		$this->assign('department',$r_department);
		
		$department_tree = $this->department_tree();//树形数组
		$this->assign('department_tree',$department_tree);
		
		$this->display();
	}
	
	/**
	 * 编辑
	 */
	public function department_edit() {
		if (I("get.id")) {
			$de_id = intval(I("get.id"));
			$department = D('Department');
			$de_info = $department->department(array('id'=>$de_id));
			$this->assign("de_info",$de_info[0]);
			
			$department_tree = $this->department_tree();
			$this->assign('department_tree',$department_tree);
			$this->display("add_department");
		}
	
	}
	
	/**
	 * 添加角色
	 */
	public function add_role() {
		if (IS_POST) {
			$role_obj = M("role");
			$c_role = $role_obj->create();
			if (I("post.roleid")) {
				$map = array('id'=>intval(I("post.roleid")));
				$r = $role_obj->where($map)->save($c_role);
			} else {
				$r = $role_obj->add();
			}
			if (false !== $r) {
				$this->assign("jumpUrl","role_list");
				$this->success("操作成功！");
			} else {
				$this->success("操作失败！");
			}
		}
		$this->display();
	}
	
	/**
	 * 角色列表
	 */
	public function role_list() {
		$map = array();
		$map['id'] = array(array('gt',1),array('gt',0), 'or') ;
		$role_info = $this->lists("role", $map, 'id');
		$this->assign('role_info',$role_info);
		$this->display();
	}
	
	/**
	 * 编辑
	 */
	public function edit() {
		if (I("get.id")) {
			$id = I("get.id");
			$map = array('id'=>$id);
			$r_role = M("role")->where($map)->find();
			$this->assign('role_info',$r_role);
			$this->display('add_role');
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	

}