<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsApi
 *
 * @author xingxiaobing <xingxiaobing@credithc.com>
 */

namespace User\Api;

use User\Api\Api;
use User\Model\SysSmsModel;
use User\Model\PhoneMsgModel;
use User\Model\UcenterMemberModel;

class SmsApi extends Api {

	private $_skd;
	private $_password;

	CONST SYS_MSG = 1;
	CONST PHONE_MSG = 2;

	/**
	 * 构造方法，实例化操作模型
	 */
	protected function _init() {
		$this->_skd = "SDK-BBX-010-22060";
		$this->_password = "0@f728@4";
	}

	/**
	 * 发送手机短信
	 * @param int $uid 发送人id
	 * @param type $content 短信内容
	 * @param array $to_users 用户id
	 */
	private function _phoneMsg($uid, $content, $to_users) {
		$userModel = new UcenterMemberModel();
		$user_phone = $userModel->getUserFieldById($to_users, array("id,mobile"));
		$time = date("Y-m-d H:i:s");
		foreach ($user_phone as $val) {
			$param[] = array(
				"uid" => $uid,
				"content" => $content,
				"to_phone" => $val["mobile"],
				"time" => $time,
				"to_user" => intval($val["id"])
			);
			$phone_num[] = $val["mobile"];
		}
		$result = $this->_sendPhone($content, implode(",", $phone_num));
		if (!$result["status"])
			return $result;
		$phoneModel = new PhoneMsgModel();
		$result = $phoneModel->addMsg($param);
		return true;
	}

	private function _sendPhone($content, $phone_num) {
		if (is_array($phone_num))
			$phone_num = implode(",", $string);
		$phone_num = trim($phone_num, ",");
		$flag = 0;
		//要post的数据 

		$argv = array(
			'sn' => $this->_skd,
			'pwd' => strtoupper(md5($this->_skd . $this->_password)),
			'mobile' => $phone_num,
			'content' => iconv("utf-8", "UTF-8//IGNORE", $content), //短信内容
			'ext' => '',
			'stime' => '', //定时时间 格式为2011-6-29 11:09:21
			'msgfmt' => '',
			'rrid' => ''
		);
		//构造要post的字符串 
		foreach ($argv as $key => $value) {
			if ($flag != 0) {
				$params .= "&";
				$flag = 1;
			}
			$params.= $key . "=";
			$params.= urlencode($value);
			$flag = 1;
		}
		$length = strlen($params);
		//创建socket连接 
		$fp = fsockopen("sdk.entinfo.cn", 8061, $errno, $errstr, 10) or exit($errstr . "--->" . $errno);
		//构造post请求的头 
		$header = "POST /webservice.asmx/mdsmssend HTTP/1.1\r\n";
		$header .= "Host:sdk.entinfo.cn\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . $length . "\r\n";
		$header .= "Connection: Close\r\n\r\n";
		//添加post的字符串 
		$header .= $params . "\r\n";
		//发送post的数据 
		fputs($fp, $header);
		$inheader = 1;
		while (!feof($fp)) {
			$line = fgets($fp, 1024); //去除请求包的头只显示页面的返回数据 
			if ($inheader && ($line == "\n" || $line == "\r\n")) {
				$inheader = 0;
			}
			if ($inheader == 0) {
				// echo $line; 
			}
		}

		$line = str_replace("<string xmlns=\"http://entinfo.cn/\">", "", $line);
		$line = str_replace("</string>", "", $line);
		$result = explode("-", $line);
		if (count($result) > 1)
			return array("status" => 0, "code" => $line);
		else
			return array("status" => 1, "code" => $line);
	}

	/**
	 * 发送内部消息
	 * @param type $content
	 * @param type $to_users
	 */
	private function _sysMsg($uid, $content, $url,$to_users) {
		$time = date("Y-m-d H:i:s");
		foreach ($to_users as $val) {
			$param[] = array(
				"from_uid" => $uid,
				"content" => $content,
				"to_uid" => $val,
				"time" => $time,
				"status" => 0,
				"url" => $url
			);
		}
		$smsModel = new SysSmsModel();
		return $result = $smsModel->addMsg($param);
	}

	public function sendMsg($type, $content, $to_users, $url = "") {
		$uid = intval(is_login());
		if (empty($uid))
			return false;
		$to_users = string_to_array($to_users);
		if (in_array(self::SYS_MSG, $type))
			$this->_sysMsg($uid, $content, $url,$to_users);
		if (in_array(self::PHONE_MSG, $type))
			$this->_phoneMsg($uid, $content, $to_users);
	}

}
