<?php
// +----------------------------------------------------------------------
// | Cli-客户
// +----------------------------------------------------------------------
// | Copyright (c) 2015 www.c_o.com
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------
namespace Cli\Controller;

use Cli\Controller\CliBaseController;

use Upload\Controller\UploadController;

class CliController extends CliBaseController{
	
	public function addCli()
	{
		//select
		$this->assign("cli_from", get_code_select("CLI_KEHULAIYUAN"));
		$this->assign('cli_code', $this->_get_order_code());//客户可以保证编号唯一
		$this->assign('country_str', $this->country());
		$this->assign("auth_user", $_SESSION['user_auth']['username']);
		$this->display('baseCli');
	}
	
	/*
	 * 基本
	 */
	public function insertCliBase()
	{
		if (IS_POST)
		{
//			$count = $this->_model->where(array("company_name"=>I("company_name")))->count();
//			if($count > 0){
//				$this->error("该客户已经存在");
//			}
			$c_cli = $this->_model->create();
			if (I("post.base_id"))
			{
				$base_id = intval(I("post.base_id"));
				if (false !== $this->_model->saveCli($c_cli, $base_id)) {
					$r = $base_id;
					$r_link = $this->_model->cliInfo($r, "link");
					$this->assign('cli_info', $r_link);
				}
				else
				{
					$r = false;
				}
			}
			else
			{
				$count = $this->_model->where(array("company_name"=>I("company_name")))->count();
				if($count > 0){
					$this->error("该客户已经存在");
				}
				
				$c_cli['add_time'] = time();
				$c_cli["user_id"] = UID;
				$r = $this->_model->insertCli($c_cli);//客户信息
			}
			if(false !== $r)
			{
				$this->assign('base_id', $r);
				$this->display("linkCli");
				exit();
			}
			else
			{
				$this->error("基本信息添加失败！");
				exit();
			}
		}
		$this->display("baseCli");
	}
	
	/**
	 * 联系人
	 */
	public function insertCliLink()
	{
		$base_id = I("post.base_id");
		if (empty($base_id))
		{
			$this->error("数据错误！");
			exit();
		}
		$base_id = intval($base_id);
		$link_id = I("post.link_id");
		if (!empty($link_id))
		{
			$link_id = intval($link_id);
			$r = $this->_model->saveLink($link_id);
			$r_infomation = $this->_model->cliInfo($base_id, "infomation");
			$this->assign('cli_info',$r_infomation);//资料
		}
		else
		{
			$r = $this->_model->insertLink($base_id);
		}
		if (false !== $r)
		{
			$this->assign('base_id', $base_id);
			$upload = new UploadController();
			$this->assign('up_load', $upload->uploadBtn("cli", $base_id));
			$this->display('informationCli');
			exit();
		}
		else
		{
			$this->error("联系人信息保存失败！");
		}
	}
	
	/**
	 * 资料信息
	 */
	public function insertInformation()
	{
		$base_id = I("post.base_id");
		if (empty($base_id))
		{
			$this->error("数据错误！");
			exit();
		}
		$this->assign('base_id', $base_id);
		//跟踪类型
		$this->assign("follow_type", get_code_select("GOUTONG_TYPE"));
		//上传
		$upload = new UploadController();
		$this->assign('up_load', $upload->uploadBtn("follow"));
		$this->display("followCli");
	}
	
	/**
	 * 跟踪信息
	 */
	public function insertFollow()
	{
		$base_id = I("post.base_id");
		if (empty($base_id))
		{
			$this->error("数据错误！");
			exit();
		}
		$r = $this->_model->insertFollow($base_id);
		if ($r)
		{
			//修改图片的归属
			if (I("post.upload_update")) {
				$attach_id_str = trim(I("post.upload_update"));
				$upload = new UploadController();
				$upload->updateUpload($attach_id_str, "follow",$r);
			}
			$this->assign("jumpUrl",U('OpCli/cliList'));
			$this->success("操作成功！");
		}
		else
		{
			$this->error("操作失败！");
		}
	}
	
	
	public function cliInfo()
	{
		$base_id = I("param.base_id");
		$info_type = I("param.type");
		$op_type = I("param.op_type");
		$tpl = I("param.tpl");
		if (empty($base_id) || empty($info_type) || empty($op_type))
		{
			return;
		}
		$base_id = intval($base_id);
		$info_type = trim($info_type);
		$r_cli_info = $this->_model->cliInfo($base_id, $info_type);
		//dump($r_cli_info);
		//exit();
		if (1 == $op_type)
		{
			if (empty($tpl))
			{
				$this->error("未找到模版");
			}
			//select
			if ($info_type == "base")
			{
				$this->assign("cli_from", get_code_select("CLI_KEHULAIYUAN", $r_cli_info['source']));
				$this->assign('country_str', $this->country());
			}
			$this->assign('base_id',$base_id);
			$this->assign('cli_info',$r_cli_info);
			$this->assign("auth_user", $_SESSION['user_auth']['username']);
			$this->display("$tpl");
		}
		else
		{
			return $r_cli_info;
		}
	}
	
	/**
	 * 添加 城市/地区
	 */
	public function cityAreaAdd()
	{
		if (IS_POST)
		{
			$city = I("post.city");
			$area = I("post.area");
			$country_id = I("post.country_id");
			if (empty($country_id))
			{
				$this->error("参数错误！");
				exit();
			}
			if (empty($city) || empty($area))
			{
				$this->error("城市或地区不可为空！");
				exit();
			}
			$city = trim(I("post.city"));
			$area = trim(I("post.area"));
			$country_id = intval(I("post.country_id"));
			$city_area = M("city_area");
			
			$r = $city_area->add(array('c_id'=>$country_id, 'name'=>$city, 'reid'=>0));
			if ($r)
			{
				$r_a = $city_area->add(array('c_id'=>$country_id, 'name'=>$area, 'reid'=>$r));
				if ($r_a)
				{
					$this->success("操作成功！");
					exit;
				}
				else
				{
					$this->error("操作失败！");
				}
			}
			else
			{
				$this->error("操作失败！");
				exit();
			}
		}
		$country_id = I("get.country_id");
		if (empty($country_id))
		{
			$this->error("请选择国家！");
			exit();
		}
		$r_country = $this->_model->country(array('id'=>intval($country_id)));
		$this->assign('country_name',$r_country[0]['country']);
		$this->assign('country_id', $country_id);
		$this->display();
	}
	
	/**
	 * 客户信息
	 */
	public function showCliInfo()
	{
		$base_id = I("get.id");
		if (empty($base_id))
		{
			$this->error("参数错误！");
		}
		$base_id = intval($base_id);
		//$this->checkSelfCli();
		$r_base = $this->_model->cliInfo($base_id, 'base');
		$r_link = $this->_model->cliInfo($base_id, 'link', 2);
		$r_infomation = $this->_model->cliInfo($base_id, 'infomation');
		$r_follow_all = $this->_model->followInfoAll($base_id);//跟踪信息
		$this->assign('baseInfo', $r_base);
		$this->assign('linkInfo', $r_link);
		$this->assign('infomationInfo', $r_infomation);
		$this->assign('followInfo', $r_follow_all);
		$change_log  = M("cli_update")->where(array("cli_id"=>$base_id))->select();
		$this->assign("change_log",$change_log);
		$this->display();
	}
	
	/**
	 * 判断客户归属
	 */
	public function checkSelfCli($base_id)
	{
		
	}


}