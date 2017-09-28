<?php
// +----------------------------------------------------------------------
// | Cli-客户操作
// +----------------------------------------------------------------------
// | Copyright (c) 2015 www.c_o.com
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------
namespace Cli\Controller;

use Think\Model;

use Cli\Controller\CliBaseController;

use Upload\Controller\UploadController;

class OpCliController extends CliBaseController{
	
	/**
	 * 判断当前用户是否可以查看全局
	 */
	private function _isAdmin(){
		$ret = M("cli_admin")->where(array("admin_user_id"=>UID))->count();
		return $ret;
	}
	/**
	 * 获取组内业务员id
	 */
	private function _isGroup(){
		$user_ids = M("cli_group")->where(array("leader_id"=>UID))->getField("user_ids");
		return $user_ids.",".UID;
	}
	/**
	 * 根据客户ID判断是否有客户查看，点评权限
	 */
	private  function _isGroupByID($id){
		if($this->_isAdmin())
			return true;
		$user_ids = $this->_isGroup();
		dump($user_ids);
		$data = M("cli")->where(array("id"=>$id,"user_id"=>array("IN",$user_ids)))->find();
		return $data;
	}
	
	public function isAccess($cli_id){
		if($this->_isAdmin() || $this->_isGroupByID($cli_id))
			return true;
		else 
			return false;
	}
	
	/**
	 * 客户列表
	 */
	public function cliList()
	{
		if(!$this->_isAdmin()){
			if($user_ids = $this->_isGroup()){
				$map["user_id"]=array("IN",$user_ids,"OR");
				$map["user_id"] = UID;
			}else{
				$map["user_id"] = UID;
			}
		}
		$map["dr"] = 0;
		if(!empty($_GET["company_name"]))
			$map["company_name"] = I("company_name");
		if(!empty($_GET["company_no"]))
			$map["company_no"] = I("company_no");
		if(!empty($_GET["user_id"]))
			$map["user_id"] = I("user_id");
		$r_cli = $this->lists("cli", $map);
		foreach ($r_cli as $k=>$v)
		{
			$r_cli[$k]['source_ch'] = get_code_data("CLI_KEHULAIYUAN", $r_cli[$k]['source']);
			$r_country = $this->_model->country(array('id'=>$r_cli[$k]['country']));
			$r_cli[$k]['country_ch'] = $r_country[0]['country'];
			$r_cli[$k]["source"] = get_code_data("CLI_KEHULAIYUAN", $v["source"]);
			$r_city = $this->_model->getCity($r_cli[$k]['city']);
			$r_cli[$k]['city_ch'] = $r_city['name'];
			$r_area = $this->_model->getCity($r_cli[$k]['area']);
			$r_cli[$k]['area_ch'] = $r_area['name'];
			$where = array('cli_id'=>intval($v['id']));
			$r_cli[$k]['link_count'] = $this->_model->getCount("cli_link",$where);
			$r_cli[$k]['follow_count'] = $this->_model->getCount("cli_follow",$where);
			$auttch_where = array("module"=>"cli", 'primary_id'=>$v['id'],'is_del'=>0);
			$r_cli[$k]['attach_count'] = $this->_model->getCount("attach",$auttch_where);
			$r_cli[$k]['help_count'] = $this->_model->getCount("cli_help",array("cli_id"=>$v["id"],"p_id"=>0));
			$r_cli[$k]['order_count'] = $this->_model->getCount("cli_order",array("cli_id"=>$v["id"]));
		}
		//dump($r_cli);
		$this->assign("cliInfo", $r_cli);
		if($this->_isAdmin()){
			$leader = M("cli_group")->getField("leader_id",true);
			$leader = array_unique($leader);
			$this->assign("leader",$leader);
		}
		$this->display();
		$this->dept_tree(1);
		$this->selectUser();
	}
	
	/**
	 * 添加联系人，支持多个
	 */
	public function addLinks()
	{
		if (IS_POST)
		{
			$base_id = I("post.base_id");
			if (empty($base_id))
			{
				$this->error("参数错误！");
			}
			$base_id = intval($base_id);
			$link_obj = M("cli_link");
			$c_links = $link_obj->create();
			$insert_arr = array();
			foreach ($c_links as $key=>$val)
			{
				foreach ($val as $k=>$v)
				{
					$insert_arr[$k][$key] = $v;
					$insert_arr[$k]['cli_id'] = $base_id;
				}
			}
			//dump($insert_arr);
			$r = $link_obj->addAll($insert_arr);
			if ($r)
			{
				$this->success("操作成功！");
				exit();
			}
			else
			{
				$this->error("操作失败！");
				exit();
			}
		}
		$base_id = I("get.base_id");
		if (empty($base_id))
		{
			$this->error("参数错误！");
		}
		$this->assign('base_id',$base_id);
		$this->display();
	}
	
	/**
	 * 联系人信息列表
	 */
	public function linksHtml()
	{
		$base_id = I("post.base_id");
		if (empty($base_id))
		{
			echo  false;
		}
		$base_id = intval($base_id);
		$r_cli_link = M("cli_link")->where(array('cli_id'=>$base_id))->select();
		if (!empty($r_cli_link))
		{
					
			$str = '<table class="table table-bordered"><thead><tr class="success">
					<th>姓名</th><th>职位</th><th>移动电话</th><th>操作</th></tr></thead><tbody>';
			foreach ($r_cli_link as $k=>$v)
			{
				$str .= "<tr><td>".$v['name']."</td><td>".$v['position']."</td><td>".$v['mobile']."</td><td><a href='editLink/link_id/".$v['id']."'>编辑</a></td></tr>";
			}
			$str .= '</tbody></table>';
			echo $str;
			exit();
		}
		else
		{
			echo  false;		
		}
	}
	
	/**
	 * 编辑联系人信息
	 */
	public function editLink()
	{
		$cli_link_obj = M("cli_link");
		if (IS_POST)
		{
			$link_id = I("post.link_id");
			if (empty($link_id))
			{
				$this->error("参数错误！");
			}
			$link_id = intval($link_id);
			$c_link = $cli_link_obj->create();
			if (false !== $cli_link_obj->where(array('id'=>$link_id))->save($c_link))
			{
				$this->assign("jumpUrl","cliList");
				$this->success("操作成功！");
			}
			else
			{
				$this->assign("jumpUrl","cliList");
				$this->error("操作失败！");
			}
			exit();
		}
		$link_id = I("get.link_id");
		if (empty($link_id))
		{
			$this->error("参数错误！");
		}
		$link_id = intval($link_id);
		$r_link = $cli_link_obj->where(array('id'=>$link_id))->find();
		$this->assign('linkInfo',$r_link);
		$this->display();
	}
	
	/**
	 * 基本信息
	 */
	public function editBase()
	{
		if (IS_POST)
		{
			$base_id = I("post.base_id");
			$count = $this->_model->where(array("company_name"=>I("company_name"),"id"=>array("NEQ",$base_id)))->count();
			if($count > 0){
				$this->error("该客户已经存在");
			}
			if(empty($base_id))
			{
				$this->error('参数错误');
			}
			$base_id = intval($base_id);
			$c_cli = $this->_model->create();
			$r = $this->_model->where(array('id'=>$base_id))->save($c_cli);
			if (false !== $r)
			{
				$this->assign("jumpUrl","cliList");
				$this->success("操作成功！");
			}
			else
			{
				$this->error("操作失败");
			}
			exit();
		}
		
		$base_id = I("get.base_id");
		if (empty($base_id))
		{
			$this->error('参数错误');
		}
		
		// 变更  / 编辑
		if ($this->checkBaseEdit($base_id))
		{
			$this->updateCli($base_id);
			exit();
		}
		else
		{
			$base_id = intval($base_id);
			$r_base = $this->_model->cliInfo($base_id, "base");
			$this->assign('baseInfo',$r_base);
			$this->assign('country_str', $this->country());
			$this->assign("cli_from", get_code_select("CLI_KEHULAIYUAN", $r_base['source']));//客户来源
			$this->display();
		}
	}
	
	/**
	 * 验证是否可以编辑
	 */
	protected function checkBaseEdit($base_id)
	{
		$r_cli = M("cli")->field("`add_time`")->where(array("id"=>intval($base_id)))->find();
		$check_time = $r_cli['add_time'] + 86400;
		$now_time = time();
		if ($check_time < $now_time)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 变更客户信息
	 */
	public function updateCli($base_id)
	{
		$r_cli = $this->_model->cliInfo(intval($base_id), "base");
		$this->assign("baseInfo",$r_cli);
		$this->assign('country_str', $this->country());
		$this->assign("cli_from", get_code_select("CLI_KEHULAIYUAN", $r_cli['source']));//客户来源
		$this->display('updateCli');
	}
	
	/**
	 * 变更
	 */
	public function updateOp()
	{
		if (IS_POST)
		{
			$base_id = I("post.base_id");
			if (empty($base_id))
			{
				$this->error('参数错误');
				exit();
			}
			$r_cli_old = $this->_model->cliInfo(intval($base_id), "base");
			unset($r_cli_old['id']);
			unset($r_cli_old['company_no']);
			unset($r_cli_old['add_time']);
			unset($r_cli_old['dr']);
			unset($r_cli_old['city_ch']);
			unset($r_cli_old['city_cch']);
			unset($r_cli_old['area_ch']);
			unset($r_cli_old['area_cch']);
			unset($r_cli_old['country_ch']);
			$c_cli = $this->_model->create();
			unset($c_cli['company_no']);
			$update_array = array();
			foreach ($c_cli as $k=>$v)
			{
				if ($v != $r_cli_old[$k])
				{
					$update_array[$k]['old'] = $r_cli_old[$k];
					$update_array[$k]['new'] = $v;
				}
			}
			$ch_arr = array(
						"company_name"=>"公司名称", "source"=>"客户来源", "country"=>"国家", "city"=>"城市",
						"area"=>"地区","detailed"=>"详细地址","follow"=>"跟踪周期",
					  );
			$log = "";
			foreach ($update_array as $k=>$v)
			{
				if ("source" == $k)
				{
					$update_array[$k]['old'] = get_code_data("CLI_KEHULAIYUAN", $update_array[$k]['old']);
					$update_array[$k]['new'] = get_code_data("CLI_KEHULAIYUAN", $update_array[$k]['new']);
				}
				$log .= $ch_arr["$k"].":由".$update_array[$k]['old']."申请变更为".$update_array[$k]['new'];
				$log .= "<br/>";
			}
			$insert_arr = array('cli_id'=>$base_id, "update_arr"=>serialize($update_array), 'add_time'=>time(), 'str'=>$log,"add_user"=>UID);
			if (M("cli_update")->add($insert_arr))
			{
				$this->assign("jumpUrl","cliList");
				$this->success("申请变更信息成功，等待审核！");
				exit();
			}
			else
			{
				$this->assign("jumpUrl","cliList");
				$this->error('申请变更信息失败！');
				exit();
			}
		}
	}
	
	/**
	 *  资料信息操作
	 */
	public function informationOp()
	{
		$base_id = I("get.base_id");
		if (empty($base_id))
		{
			$this->error("参数错误！");
			exit();
		}
		$r_infomation = $this->_model->cliInfo($base_id, "infomation");
		$this->assign('infomationInfo',$r_infomation);
		//上传
		$upload = new UploadController();
		$this->assign('up_load', $upload->uploadBtn("cli", $base_id));
		$this->display();
	}
	
	/**
	 * 跟踪信息
	 */
	public function followList()
	{
		$base_id = I("get.base_id");
		if (empty($base_id))
		{
			$this->error("参数错误！");
		}
		$base_id = intval($base_id);
		$r_follow = $this->_model->followInfo($base_id);
		$this->assign('followInfo',$r_follow);
		$this->assign('base_id',$base_id);
		//上传
		$upload = new UploadController();
		$this->assign('up_load', $upload->uploadBtn("follow", $r_follow['id']));
		$this->display('followList');
	}
	
	/**
	 * 跟踪信息编辑
	 */
	public function editFollow()
	{
		$cli_follow_obj = M("cli_follow");
		if (IS_POST)
		{
			$id = I("post.follow_id");
			if (empty($id))
			{
				$this->error("参数错误！");
			}
			$id = intval($id);
			$c_follow = $cli_follow_obj->create();
			$c_follow['follow_time'] = strtotime($c_follow['follow_time']);
			$r = $cli_follow_obj->where(array('id'=>$id))->save($c_follow);
			
			$base_id = $cli_follow_obj->field('cli_id')->where(array('id'=>$id))->find();
			if (false !== $r)
			{
				//U("/Cli/OpCli/followList/base_id/{$base_id['cli_id']}")
				$this->assign("jumpUrl",U("followList",array('base_id'=>$base_id['cli_id'])));
				$this->success("操作成功！");
			}
			else
			{
				$this->error("操作失败");
			}
			exit();
		}
		$id = I("get.follow_id");
		if (empty($id))
		{
			$this->error("参数错误！");
		}
		$id = intval($id);
		$r_follow = $cli_follow_obj->where(array('id'=>$id))->find();
		$this->assign('followInfo',$r_follow);
		//上传
		$upload = new UploadController();
		$this->assign('up_load', $upload->uploadBtn("follow", $id));
		//沟通方式
		$this->assign("follow_type", get_code_select("GOUTONG_TYPE", $r_follow['follow_type']));
		//PIC
		$r_attach = getPicInfo('follow', $id);
		$this->assign('attach_info',$r_attach);
		$this->display();
	}
	
	/**
	 * 跟踪信息添加
	 */
	 public function addFollow()
	 {
	 	$base_id = I("post.base_id");
	 	if (empty($base_id))
	 	{
	 		$data['status'] = 0;
		    $data['content'] = '参数错误!';
		    $this->ajaxReturn($data, "JSON");
		    exit();
	 	}
	 	$base_id = intval($base_id);
	 	$cli_follow_obj = M("cli_follow");
	 	$c_follow = $cli_follow_obj->create();
	 	$c_follow['cli_id'] = $base_id;
	 	$c_follow['follow_time'] = strtotime($c_follow['follow_time']);
	 	$r = $cli_follow_obj->add($c_follow);
	 	if ($r)
	 	{
	 		//修改图片的归属
			if (I("post.upload_update")) {
				$attach_id_str = trim(I("post.upload_update"));
				$upload = new UploadController();
				$upload->updateUpload($attach_id_str, "follow", $r);
			}
	 		
			$data['status'] = 1;
		    $content_str = '<div class="bs-callout bs-callout-info" id="callout-type-dl-truncate">
						    <h4>沟通标题</h4>
						    <p>沟通时间：
						    '.$c_follow["follow_time"].' | 沟通方式：
						    '.$c_follow["follow_type"].' | 联系方式：'.$c_follow["link_type"].'</p>
						    <div style="border-bottom: 1px dashed #5E99BD;"></div>
						    '.htmlspecialchars_decode($c_follow["follow_content"]).'
						    <div style="border-bottom: 1px dashed #5E99BD;margin-bottom: 10px;"></div>
						    <div class="pull-right">
						        <a href="#" ><i class="icon-comment"></i>点评</a>
						        <a href="index.php/Cli/OpCli/editFollow/editFollow/follow_id/'.$r.'"><i class="icon-edit"></i>编辑</a>
						    </div>
						  </div>';
		    $data['content'] = $content_str;
		    $this->ajaxReturn($data, "JSON");
		    exit();
	 	}
	 	else
	 	{
	 		$data['status'] = 0;
		    $data['content'] = '添加失败';
		    $this->ajaxReturn($data, "JSON");
		    exit();
	 	
	 	}
	 }
	
	 /**
	  * 申请变更列表
	  */
	 public function updateCliList()
	 {
		 $sql = "select count(1) as total from cli_update as u,cli as c where u.cli_id = c.id and u.dr = 0";
		 $total = M()->query($sql);
		 $total = $total[0]["total"];
		 $page = $this->page($total);
		 $sql = "select u.id,c.company_name,u.add_user,u.bak,u.add_time,u.is_agree from cli_update as u,cli as c where u.cli_id = c.id and u.dr = 0 limit ".$page['firstRow'].",".$page['listRows'];
		 $data = M()->query($sql);
		 $status = array(0=>"待审核",1=>"申请通过",2=>"申请拒绝");
		foreach ($data as $k=>$v)
		{
			$data[$k]["add_user"] = get_username($v["add_user"]);
			$data[$k]["add_time"] = date("Y-m-d",$v["add_time"]);
			$data[$k]["status"] = $status[$v["is_agree"]];
		}
		$this->assign("updateList", $data);
		$this->display();
	 }
	
	/**
	 * 审批客户变更
	 */
	 public function approval()
	 {
	 	if (IS_POST)
	 	{
	 		$id = I("post.id");
	 		if (empty($id))
	 		{
	 			$this->error("参数错误！");
	 			exit();
	 		}
	 		$is_agree = I("post.is_agree");
	 		if (empty($is_agree))
	 		{
	 			$this->error("请选择审批状态");
	 			exit();
	 		}
	 		$is_agree = intval($is_agree);
	 		$bak = I("post.bak");
	 		$savr_arr = array('is_agree'=>$is_agree,'bak'=>$bak);
	 		$r = M("cli_update")->where(array('id'=>$id))->save($savr_arr);
	 		
	 		if (false !== $r)
	 		{
	 			if (1 == $is_agree)
	 			{
	 				if ($this->synchronousCliInfo($id))
	 				{
	 					//...
	 					
	 					
	 				}
	 				else
	 				{
	 					$this->assign("jumpUrl","updateCliList");
	 					$this->error("数据同步失败！");
	 					exit();
	 				}
	 			
	 			}
	 			$this->assign("jumpUrl","updateCliList");
	 			$this->success("审批成功");
	 		}
	 		else
	 		{
	 			$this->assign("jumpUrl","updateCliList");
	 			$this->error("审批失败！");
	 		}
	 	
	 	
	 	}
	 	$id = I("get.id");
	 	if (empty($id))
	 	{
	 		$this->error("参数错误!");
	 		exit();
	 	}
	 	$id = intval($id);
	 	$r_cli_update = M("cli_update")->where(array('id'=>$id))->find();
	 	$this->assign('updateInfo',$r_cli_update);
	 	if (!empty($r_cli_update['cli_id']))
	 	{
	 		$r_cli = $r_cli = $this->_model->cliInfo(intval($r_cli_update['cli_id']), "base");
	 		$this->assign("baseInfo",$r_cli);
	 	}
	 	$this->display();
	 }
	 
	 /**
	  * 当审批成功时同步信息
	  */
	private function synchronousCliInfo($id)
	{
		$r_cli_update = M("cli_update")->where(array('id'=>intval($id)))->find();
		$synchronous_arr = unserialize($r_cli_update['update_arr']);
		if (empty($r_cli_update['cli_id']))
		{
			return false;
		}
		$update_arr = array();
		foreach ($synchronous_arr as $k=>$v)
		{
			$update_arr[$k] = $synchronous_arr[$k]['new'];
		}
		$r = M('cli')->where(array('id'=>$r_cli_update['cli_id']))->save($update_arr);//同步
		if (false != $r)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	 
	/**
	 * 客户升级
	 */
	public function vipCli()
	{
		$this->display();
	}
	
	/**
	 * 客户权限设置
	 */
	public function setAdmin(){
		###############获取全局###############
		$sql = "select u.name,u.id from user as u,cli_admin as c where c.admin_user_id = u.id";
		$data = M()->query($sql);
		foreach($data as $val){
			$user_ids .= $val["id"].",";
			$user_name .= $val["name"].",";
		}
		$user_ids = trim($user_ids,",");
		$user_name = trim($user_name,",");
		
		#############获取小组列表#############
		$groupData = M("cli_group")->select();
		$userArr = $this->_getUserArr();
		foreach($groupData as $key=>$val){
			$groupData[$key]["leader_id"] = $userArr[$val["leader_id"]];
			if(strpos($val["user_ids"], ",")){
				$user_arr = explode(",", $val["user_ids"]);
				foreach($user_arr as $user_id){
					$user_str .= $userArr[$user_id].",";
				}
			}else{
				$user_str = $userArr[$val["user_ids"]];
			}
			$groupData[$key]["user_ids"] = $user_str;
		}
		$this->assign("groupData",$groupData);
		$this->assign("user_id",$user_ids);
		$this->assign("user_name",$user_name);
		$this->display();
		$this->dept_tree(1); //部门结构弹层
		$this->selectUser();
	}
	/**
	 * 设置全局管理员可以查看所有用户
	 */
	public function setAdminer(){
		$user_ids = I("user_id");
		$data = explode(",", $user_ids);
		foreach($data as $val){
			$inner[] = array("admin_user_id"=>$val);
		}
		M("cli_admin")->where("1=1")->delete();
		$ret = M("cli_admin")->addAll($inner);
		if($ret)
			$this->success ("保存成功");
		else
			$this->error ("保存失败");
	}

	private function _getUserArr(){
		$data = M("user")->field("id,name")->select();
		foreach($data as $val){
			$arr[$val["id"]] = $val["name"];
		}
		return $arr;
	}
	
	/**
	 * 管理小组设置
	 */
	public function groupSet(){
		if(IS_POST){
			$name = I("name");
			$leader_user_id = I("leader_user_id");
			$id = I("id");
			$user_id = I("user_id");
			if(empty($id)){
				$ret = M("cli_group")->add(array("name"=>$name,"leader_id"=>$leader_user_id,"user_ids"=>$user_id));
			}else{
				$ret = M("cli_group")->where(array("id"=>$id))->save(array("name"=>$name,"leader_id"=>$leader_user_id,"user_ids"=>$user_id));
			}
			if($ret)
				$this->success ("保存成功",U("setAdmin"));
			else
				$this->error ("保存失败");
		}
		$id = I("id");
		$data = M("cli_group")->where(array("id"=>$id))->find();
		$userArr = $this->_getUserArr();
		if(strpos($data["user_ids"],",")){
			$user_arr = explode(",",$data["user_ids"]);//获取组员id数组
			foreach($user_arr as $user_id){
				$usernames .= $userArr[$user_id].",";
			}
		}else{
			$usernames = $userArr[$data["user_ids"]];
		}
		$this->assign("leader_name",$userArr[$data["leader_id"]]);
		$this->assign("leader_id",$data["leader_id"]);
		$this->assign("id",$id);
		$this->assign("name",$data["name"]);
		$this->assign("user_ids",$data["user_ids"]);
		$this->assign("usernames",$usernames);
		$this->display();
		$this->dept_tree(1); //部门结构弹层
		$this->selectUser();
	}
	/**
	 * 获取沟通记录的评论信息
	 */
	public function getFlowComment($id){
		$data = M("cli_comment")->where(array("flow_id"=>$id))->select();
		foreach($data as $val){
			$ret[$val["p_id"]][] = $val;
		}
//		$this->display("comment_list");
		$this->_getCliCommentList(0,$ret);
	}
	/**
	 * 用于递归所有的评论
	 * @param type $data
	 */
	public function _getCliCommentList($key,$data){
		foreach($data[$key] as $val){
			echo '<div class="bs-callout bs-callout-danger" style="padding:0px;padding-top:10px;padding-left:20px;margin:0px;margin-top:10px;">';
			echo '<h4 style="font-size:15px;color:#ce4844">评论人：'.$val["add_user_name"].' | 评论时间：'.date("Y-m-d H:i:s",$val["add_time"]).'</h4>';
			echo '<p>'.$val["content"].'</p>';
			echo '<div style="border-bottom: 1px dashed #5E99BD;margin-bottom: 10px;"></div>
    <div style="overflow: hidden">
        <a href="javascript:son_comment('.$val["id"].')" class="pull-right" ><i class="icon-comment"></i>回复</a>&nbsp;
    </div>';
			echo '<div class="comments" id="son_comments_'.$val["id"].'">
        <div class="col-sm-12">
        <textarea class="form-control" id="son_comment_content_'.$val["id"].'"></textarea>
        </div>
        <div  style="width:100%;">
        <a href="javascript:add_son_comment('.$val["flow_id"].','.$val["id"].')" class="pull-right" style="margin-top:10px;margin-right:40px;"><i class="icon-upload"></i>提交点评</a>
        </div>
    </div>';
			if(!empty($data[$val["id"]])){
				$this->_getCliCommentList($val["id"],$data);
			}
			
			echo "</div>";
		}
	}
	/**
	 * 添加评论
	 */
	public function addComment(){
		$data["flow_id"]=I("flow_id");
		$data["p_id"] = I("p_id");
		$data["content"] = I("content");
		$data["add_time"] = time();
		$data["add_user_id"] = UID;
		$data["add_user_name"] = get_username();
		$ret = M("cli_comment")->add($data);
		if($ret)
			echo 1;
		else
			echo 0;
	}
	
	public function delete($id){
		$id = intval($id);
//		$is_jiaoyi = 1; 这里流出接口判断是否正在交易
		if($is_jiaoyi == 1)
			$this->error("客户合同正在交易中，不能删除");
		if(is_administrator()){
			$ret = M("cli")->where(array("id"=>$id))->delete();
			if($ret)
				$this->success("删除成功");
			else
				$this->error("删除失败");
		}else{
			$this->error("您没有权限删除");
		}
	}
	
	public function fenpei($cli_id,$fenpei_user_id){
		$cli_id = intval($cli_id);
		$fenpei_user_id = intval($fenpei_user_id);
		$user_id = M("cli")->where("id=".$cli_id)->getField("user_id");
		$ret = M("cli")->where("id=".$cli_id)->save(array("user_id"=>$fenpei_user_id));
		$data = array(
			"cli_id"=>$cli_id,
			"str"=>"被".  get_username(UID)."由".  get_username($user_id)."分配至".  get_username($fenpei_user_id),
			"add_time"=>time(),
			"dr"=>1,
			"add_user"=>UID,
			"is_agree"=>1
		);
		$ret1  =  M("cli_update")->add($data);
		if($ret && $ret1)
			echo "分配成功";
		else
			echo "分配失败";
	}
}