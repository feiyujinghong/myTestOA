<?php

// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Auth\Controller;

/**
 * 后台配置控制器
 * @author yangweijie <yangweijiester@gmail.com>
 */
class MenuController extends AuthController {

	/**
	 * 新增菜单
	 */
	public function add() {
		if (IS_POST) {
			$Menu = D('Menu');
			$data = $Menu->create();
			if ($data) {
				$id = $Menu->add();
				if ($id) {
					session('ADMIN_MENU_LIST', null);
					//记录行为
					action_log('update_menu', 'Menu', $id, UID);
					$this->success('新增成功', Cookie('__forward__'));
				} else {
					$this->error('新增失败');
				}
			} else {
				$this->error($Menu->getError());
			}
		} else {
			$menus = M('Menu')->field(true)->select();
			//dump(M()->getLastSql());
			$menus = D('Common/Tree')->toFormatTree($menus);
			$menus = array_merge(array(0 => array('id' => 0, 'title_show' => '顶级菜单')), $menus);
			$this->assign('Menus', $menus);
			$this->display('edit');
		}
	}

	/**
	 * 权限菜单
	 */
	public function menulist() {
		$menuData = M("menu")->select();
		foreach($menuData as $val){
			if($val["pid"] == 0){
				$main[$val["id"]] = $val;
			}else{
				$son[$val["pid"]][] = $val;
			}
		}
		$this->assign("son", $son);
		$this->assign("main", $main);
		$this->display();
	}

	/**
	 * 编辑配置
	 * @author yangweijie <yangweijiester@gmail.com>
	 */
	public function edit($id = 0) {
		if (IS_POST) {
			$Menu = D('Menu');
			$data = $Menu->create();
			if ($data) {
				if ($Menu->save() !== false) {
					session('ADMIN_MENU_LIST', null);
					//记录行为
					action_log('update_menu', 'Menu', $data['id'], UID);
					$this->success('更新成功', U("menulist"));
				} else {
					$this->error('更新失败');
				}
			} else {
				$this->error($Menu->getError());
			}
		} else {
			$info = array();
			/* 获取数据 */
			$info = M('Menu')->field(true)->find($id);
			$menus = M('Menu')->field(true)->select();
			$menus = D('Common/Tree')->toFormatTree($menus);

			$menus = array_merge(array(0 => array('id' => 0, 'title_show' => '顶级菜单')), $menus);
			$this->assign('Menus', $menus);
			if (false === $info) {
				$this->error('获取后台菜单信息错误');
			}
			$this->assign('info', $info);
			$this->meta_title = '编辑后台菜单';
			$this->display();
		}
	}
	/**
	 * 删除权限
	 * @param type $id
	 */
	public function delete($id){
		$ret = M("menu")->where(array("id"=>$id))->delete();
		if($ret){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
	}
}
