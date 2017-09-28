<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------

namespace Cli\Model;
use Think\Model;
class CliInfoModel extends Model {
	protected $tableName = 'cli';

    protected $_validate = array(
        //array('leave_type','require', '必须填写请假类型', Model::MUST_VALIDATE ,'regex',Model::MODEL_INSERT),
     
    );
    
    public function country($where = array())
    {
    	return $r_country = M("country")->where($where)->select();
	}
    
    /**
     * 根据国家找到城市／地区
     * @param int $id 国家ID
     * @param number $type
     * @return array:
     */
    public function area($id, $type = 0)
    {
    	if (empty($id))
    	{
    		return array();
    	}
    	$id = intval($id);
    	return M("city_area")->where(array("c_id"=>$id, "reid"=>$type))->select();
    }
    
    public function n_area($id)
    {
    	if (empty($id))
    	{
    		return array();
    	}
    	$id = intval($id);
    	return M("city_area")->where(array("reid"=>$id))->select();
    }
    
    /**
     * 添加客户基本信息
     * @param array $c_cli_arr
     * @return boolean
     */
    public function insertCli($c_cli_arr)
    {
    	if (!is_array($c_cli_arr) || empty($c_cli_arr))
    	{
    		return false;
    	}
    	return $this->add($c_cli_arr);
    }
    
    public function saveCli($c_cli_arr ,$base_id)
    {
    	//unset()
    	return $this->where(array('id'=>intval($base_id)))->save($c_cli_arr);
    }
    
    /**
     * 添加联系人信息
     * @param number $cli_id
     * @param array $c_link
     * @return boolean
     */
    public function insertLink($cli_id = 0, $c_link = array(), $insert_type = 1)
    {
    	if(0 == $cli_id && empty($c_link))
    	{
    		return false;
    	}
    	$cli_link_obj = M("cli_link");
    	if (empty($c_link))
    	{
    		$c_link = $cli_link_obj->create();
    		$c_link['cli_id'] = intval($cli_id);
    	}
    	//dump($c_link);
    	$c_link['insert_type'] = $insert_type;
    	return $cli_link_obj->add($c_link);
    }
    
    public function saveLink($link_id, $c_link = array())
    {
    	$link_id = intval($link_id);
    	
    	$cli_link_obj = M("cli_link");
    	if (empty($c_link))
    	{
    		$c_link = $cli_link_obj->create();
    	}
    	//dump($c_link);
    	return $cli_link_obj->where(array('id'=>$link_id))->save($c_link);
    }
	
    /**
     * 添加跟踪信息
     * @param int $cli_id
     * @param array $c_follow
     * @return boolean
     */
    public function insertFollow($cli_id = 0, $c_follow = array(), $insert_type = 1)
    {
    	if(0 == $cli_id && empty($c_follow))
    	{
    		return false;
    	}
    	$cli_follow_obj = M("cli_follow");
    	if (empty($c_follow))
    	{
    		$c_follow = $cli_follow_obj->create();
    		$c_follow['cli_id'] = intval($cli_id);
    	}
    	$c_follow['insert_type'] = $insert_type;
    	$c_follow['follow_time'] = strtotime($c_follow['follow_time']);
    	//dump($c_follow);exit;
    	return $cli_follow_obj->add($c_follow);
    }
    
    /**
     * 获取用户信息
     * @param unknown_type $base_id
     * @param unknown_type $type
     */
    public function cliInfo($base_id, $type, $count=1)
    {
    	$base_id = intval($base_id);
    	$type = trim($type);
    	switch ($type)
    	{
    		case 'base':
    			return $this->baseInfo($base_id);
    			break;
    		case "link":
    			if (1 == $count)
    			{
    				return $this->linkInfo($base_id);
    			}
    			elseif (2 == $count)
    			{
    				return $this->aLinkInfo($base_id);
    			}
    			break;
    		case "infomation":
    			return getPicInfo('cli', $base_id);
    			break;
    		default:
    			break;
    		
    	}
    }
    
    /**
     * 根据基本信息ID获取客户基本信息
     * @param int $base_id
     */
    private function baseInfo($base_id)
    {
    	$r_cli_base = $this->where(array('id'=>$base_id))->find();
    	return $this->OpBaseInfo($r_cli_base);
    }
    
    /**
     * 基本信息处理
     */
    private function OpBaseInfo($baseInfo){
    	if (is_array($baseInfo) && empty($baseInfo))
    	{
    		return $baseInfo;
    	}
    	$r_country = $this->country(array('id'=>$baseInfo['country']));
    	$baseInfo['country_ch'] = $r_country[0]['country'];
    	$r_city = $this->getCity($baseInfo['city']);
    	$op_city = $this->cityAreaStr($baseInfo['country'], $baseInfo['city']);
    	$baseInfo['city_ch'] = $op_city[0];
    	$baseInfo['city_cch'] = $op_city[1];
    	$op_area = $this->areaAreaStr($baseInfo['city'], $baseInfo['area']);
    	$baseInfo['area_ch'] = $op_area[0];
    	$baseInfo['area_cch'] = $op_area[1];
    	return $baseInfo;
    }
    
    /**
     * 根据国家，选择城市ID获取城市下拉单
     */
    public function cityAreaStr($c_id, $city_id)
    {
    	$r_city = $this->area($c_id);
    	$option_str = "<option value=''>请选择</option>";
		foreach ($r_city as $k=>$v)
		{
			if ($city_id == $v["id"])
			{
				$option_str .= '<option selected="selected" value="'.$v["id"].'">'.$v["name"].'</option>';
				$cch = $v["name"];
			}
			else
			{
				$option_str .= '<option value="'.$v["id"].'">'.$v["name"].'</option>';
			}
		}
		return array($option_str, $cch);
		//return $option_str;
    }
    
	/**
     * 根据城市，选择地区ID获取城市下拉单
     */
    public function areaAreaStr($city_id, $area_id)
    {
    	$r_area = $this->n_area($city_id);
    	$option_str = "<option value=''>请选择</option>";
		foreach ($r_area as $k=>$v)
		{
			if ($area_id == $v["id"])
			{
				$option_str .= '<option selected="selected" value="'.$v["id"].'">'.$v["name"].'</option>';
				$cch = $v["name"];
			}
			else
			{
				$option_str .= '<option value="'.$v["id"].'">'.$v["name"].'</option>';
			}
		}
		return array($option_str, $cch);
		
		//return $option_str;
    }
    
    /**
     * 根据ID获得城市地区
     * @param int $id
     */
    public function getCity($id)
    {
    	return M("city_area")->where(array('id'=>$id))->find();
    }
    
    /**
     * 联系人信息
     * @param int $base_id
     */
    private function linkInfo($base_id)
    {
    	return M("cli_link")->where(array('cli_id'=>$base_id, "insert_type"=>1))->find();
    }
    
    private function aLinkInfo($base_id)
    {
    	return M("cli_link")->where(array('cli_id'=>$base_id))->select();
    }
    
    /**
     * 跟踪信息
     */
    public function followInfo($base_id)
    {
    	return M("cli_follow")->where(array('cli_id'=>$base_id))->select();
    }
    
    /**
     * 获取跟踪信息全部内容
     */
    public function followInfoAll($base_id)
    {
    	$r_cli_follow = M("cli_follow")->where(array('cli_id'=>$base_id))->select();
    	foreach ($r_cli_follow as $k=>$v)
    	{
    		$r_cli_follow[$k]['pic'] = getPicInfo('follow', $v['id']);
    	}
    	return $r_cli_follow;
    }
    
    /**
     * 统计客户辅助信息个人
     */
    public function getCount($model,$where)
    {
    	if (!is_array($where) && empty($where))
    	{
    		return '';
    	}
    	
    	return M("$model")->where($where)->count();
    }
    

}

