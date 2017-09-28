<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsModel
 *
 * @author xingxiaobing <xingxiaobing@credithc.com>
 */
namespace User\Model;
use Think\Model;

class SysSmsModel extends Model{
	protected  $tableName = "sys_msg";
	
	protected $connection = UC_DB_DSN;
	/**
	 * 添加内部消息内容
	 * @param type $param
	 */
	public function addMsg($param){
		return $this->addAll($param);
	}
	
	
}
