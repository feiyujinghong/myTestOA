<?php
// +----------------------------------------------------------------------
// | Cli-客户
// +----------------------------------------------------------------------
// | Copyright (c) 2015 www.c_o.com
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------
namespace Cli\Controller;

use Think\Model;

use Think\Auth;

use Auth\Controller\AuthController;

class CliBaseController extends AuthController {
	
	public  $_model;
	
	public function _initialize() {
		parent::_initialize ();
		$this->_model = D("CliInfo");
	}
	
	/**
	 * 国家
	 * @return string
	 */
	public function country()
	{
		$r_country = $this->_model->country();
		$c_arr = array();
		foreach ($r_country as $key=>$val)
		{
			$c_arr[$val['ch']][$val['id']] .= $val['country'];
		}
		ksort($c_arr);
		unset($c_arr['']);
		$str = "";
		foreach ($c_arr as $key=>$val)
		{
			$str .= "<b>" .$key. "</b>";
			$str .= "<br/>";
			foreach ($val as $k=>$v)
			{
				$str .= '<a href="javascript:void(0);" class="authorize" onclick="getCity(' .$k. ');"> &nbsp;' .$v. '&nbsp;</a>';
				//$str .= ",";
			}
			$str .= "<br/>";
		}
		return $str;
	}
	
	/**
	 * 城市
	 * @return string
	 */
	public function city()
	{
		if (!I("post.id"))
		{
			echo "";
		}
		$id = intval(I("post.id"));
		$r_countray = $this->_model->country(array('id'=>$id));
		$country_arr = array('id'=>$r_countray[0]['id'],'name'=> $r_countray[0]['country']);
		//dump($country_arr);
		$r_area = $this->_model->area($id);
		//var_dump($r_area);
		$option_str = "<option value=''>请选择</option>";
		foreach ($r_area as $k=>$v)
		{
			$option_str .= '<option value="'.$v["id"].'">'.$v["name"].'</option>';
		}
		//echo  $option_str;
		echo json_encode(array('country'=>$country_arr, 'str'=>$option_str));
	}
	
	/**
	 * 地区
	 * @return string
	 */
	public function area()
	{
		if (!I("post.city_id"))
		{
			echo "";
		}
		$id = intval(I("post.city_id"));
		$r_area = $this->_model->n_area($id);
		$option_str = "<option value=''>请选择</option>";
		foreach ($r_area as $k=>$v)
		{
			$option_str .= '<option value="'.$v["id"].'">'.$v["name"].'</option>';
		}
		echo  $option_str;
		
	}
	
	
	
	/***************************************客户编号*********************************/
	/**
	 * 获取随机种子
	 *@return float
	 */
	private function _get_random_seed() {
		list ( $usec, $sec ) = explode ( ' ', microtime () );
		return ( float ) $sec + (( float ) $usec * 100000);
	}

	/**
	 * 获取随机数
	 *@param int $min	小数边界
	 * @param int $max	大数边界
	 * @return int
	 */
	private function _get_random_number($min, $max) {
		mt_srand ( $this->_get_random_seed () );
		return mt_rand ( $min, $max );
	}

	/**
	 * 获取订单号
	 *@return string
	 */
	function _get_order_code() {
		return $this->_get_random_number ( 100, 999 ) . ( string ) time ();
	}
	/**************客户编号finish*************/
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	public function get_country() {
		$str = "中国、蒙古、朝鲜、韩国、日本、菲律宾、越南、老挝、柬埔寨、缅甸、泰国、马来西亚、文莱、新加坡、印度尼西亚、 东帝汶、 尼泊尔、不丹、孟加拉国、印度、巴基斯坦、斯里兰卡、马尔代夫、 哈萨克斯坦、吉尔吉斯斯坦、塔吉克斯坦、乌兹别克斯坦、土库曼斯坦、 阿富汗、伊拉克、伊朗、叙利亚、约旦、黎巴嫩、以色列、巴勒斯坦、沙特阿拉伯、巴林、卡塔尔、科威特、阿拉伯联合酋长国（阿联酋）、阿曼、也门、格鲁吉亚、亚美尼亚、阿塞拜疆、土耳其、塞浦路斯、 芬兰、瑞典、挪威、冰岛、丹麦 法罗群岛（丹）、 爱沙尼亚、拉脱维亚、立陶宛、白俄罗斯、俄罗斯、乌克兰、摩尔多瓦、 波兰、捷克、斯洛伐克、匈牙利、德国、奥地利、瑞士、列支敦士登、 英国、爱尔兰、荷兰、比利时、卢森堡、法国、摩纳哥、 罗马尼亚、保加利亚、塞尔维亚、马其顿、阿尔巴尼亚、希腊、斯洛文尼亚、克罗地亚、波斯尼亚和墨塞哥维那 、 意大利、梵蒂冈、圣马力诺、马耳他、西班牙、葡萄牙、安道尔、 埃及、利比亚、苏丹、突尼斯、阿尔及利亚、摩洛哥、亚速尔群岛（葡）、马德拉群岛（葡）、 埃塞俄比亚、厄立特里亚、索马里、吉布提、肯尼亚、坦桑尼亚、乌干达、卢旺达、布隆迪、塞舌尔、 乍得、中非、喀麦隆、赤道几内亚、加蓬、刚果共和国（即：刚果（布））、刚果民主共和国（即：刚果（金））、圣多美及普林西比、 毛里塔尼亚、西撒哈拉（注：未独立，详细请看：）、塞内加尔、冈比亚、马里、布基纳法索、几内亚、几内亚比绍、佛得角、塞拉利昂、利比里亚、科特迪瓦、加纳、多哥、贝宁、尼日尔、加那利群岛（西）、 赞比亚、安哥拉、津巴布韦、马拉维、莫桑比克、博茨瓦纳、纳米比亚、南非、斯威士兰、莱索托、马达加斯加、科摩罗、毛里求斯、留尼旺（法）、圣赫勒拿（英）";
		$str1 = "澳大利亚、新西兰、巴布亚新几内亚、所罗门群岛、瓦努阿图、密克罗尼西亚、马绍尔群岛、帕劳、瑙鲁、基里巴斯、图瓦卢、萨摩亚、斐济群岛、汤加、库克群岛（新）、关岛（美）、新喀里多尼亚（法）、法属波利尼西亚、皮特凯恩岛（英）、瓦利斯与富图纳（法）、纽埃（新）、托克劳（新）、美属萨摩亚、北马里亚纳（美） 、 加拿大、美国、墨西哥、格陵兰（丹）、 危地马拉、伯利兹、萨尔瓦多、洪都拉斯、尼加拉瓜、哥斯达黎加、巴拿马、 巴哈马、古巴、牙买加、海地、多米尼加共和国、安提瓜和巴布达、圣基茨和尼维斯、多米尼克、圣卢西亚、圣文森特和格林纳丁斯、格林纳达、巴巴多斯、特立尼达和多巴哥、波多黎各（美）、英属维尔京群岛、美属维尔京群岛、安圭拉（英）、蒙特塞拉特（英）、瓜德罗普（法）、马提尼克（法）、荷属安的列斯、阿鲁巴（荷）、特克斯和凯科斯群岛（英）、开曼群岛（英）、百慕大（英）、 哥伦比亚、委内瑞拉、圭亚那、法属圭亚那、苏里南、 厄瓜多尔、秘鲁、玻利维亚、 巴西、 智利、阿根廷、乌拉圭、巴拉圭";
		$str .= $str1;
		$arr = explode('、', $str);
		$c_arr = array();
		foreach ($arr as $key=>$val) {
			$c_arr[$key]['country'] = trim($val);
			$c_arr[$key]['order'] = $this->getFirstCharter(trim($val));
		}
		M("country")->addAll($c_arr);
	}
	public function getFirstCharter($str){
		if(empty($str)){return '';}
		$fchar=ord($str{0});
		if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
		$s1=iconv('UTF-8','gb2312',$str);
		$s2=iconv('gb2312','UTF-8',$s1);
		$s=$s2==$str?$s1:$str;
		$asc=ord($s{0})*256+ord($s{1})-65536;
		if($asc>=-20319&&$asc<=-20284) return 'A';
		if($asc>=-20283&&$asc<=-19776) return 'B';
		if($asc>=-19775&&$asc<=-19219) return 'C';
		if($asc>=-19218&&$asc<=-18711) return 'D';
		if($asc>=-18710&&$asc<=-18527) return 'E';
		if($asc>=-18526&&$asc<=-18240) return 'F';
		if($asc>=-18239&&$asc<=-17923) return 'G';
		if($asc>=-17922&&$asc<=-17418) return 'H';
		if($asc>=-17417&&$asc<=-16475) return 'J';
		if($asc>=-16474&&$asc<=-16213) return 'K';
		if($asc>=-16212&&$asc<=-15641) return 'L';
		if($asc>=-15640&&$asc<=-15166) return 'M';
		if($asc>=-15165&&$asc<=-14923) return 'N';
		if($asc>=-14922&&$asc<=-14915) return 'O';
		if($asc>=-14914&&$asc<=-14631) return 'P';
		if($asc>=-14630&&$asc<=-14150) return 'Q';
		if($asc>=-14149&&$asc<=-14091) return 'R';
		if($asc>=-14090&&$asc<=-13319) return 'S';
		if($asc>=-13318&&$asc<=-12839) return 'T';
		if($asc>=-12838&&$asc<=-12557) return 'W';
		if($asc>=-12556&&$asc<=-11848) return 'X';
		if($asc>=-11847&&$asc<=-11056) return 'Y';
		if($asc>=-11055&&$asc<=-10247) return 'Z';
		return null;
	}
	*/



}