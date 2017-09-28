<?php

return array(
	/* 系统数据加密设置 */
	//'DATA_AUTH_KEY' => 'QtC897<VkB5p@T}4$;jSM*l:"^n_gJG-Kuhe2{Y#', //默认数据加密KEY
	/* 数据库配置 */
	'DB_TYPE' => 'mysqli', // 数据库类型
	
	'DB_HOST' => 'localhost', // 服务器地址
	'DB_NAME' => 'co', // 数据库名
	'DB_USER' => 'root', // 用户名
	'DB_PWD' => '123456', // 密码
	
//	'DB_HOST' => '222.170.18.46', // 服务器地址
//	'DB_NAME' => 'co', // 数据库名
//	'DB_USER' => 'admin', // 用户名
//	'DB_PWD' => 'ydz_mysql_!*)@1982', // 密码
	
	'DB_PORT' => '3306', // 端口
	'DB_PREFIX' => '', // 数据库表前缀
	
	//多语言配置
	'LANG_SWITCH_ON' => true, //开启语言包功能        
	'LANG_AUTO_DETECT' => true, // 自动侦测语言
	'DEFAULT_LANG' => 'zh-cn', // 默认语言        
	'LANG_LIST' => 'en-us,zh-cn', //必须写可允许的语言列表
	'VAR_LANGUAGE' => 'lang', // 默认语言切换变量	
	'DEFAULT_CHARSET' => 'utf-8', // 默认输出编码
	'DEFAULT_MODULE' => 'Auth', //默认进入的模块
	'MODULE_DENY_LIST' => array('Common', 'User'), //不可访问
	
	/* 模板相关配置 */
	'TMPL_PARSE_STRING' => array(
		'__BOOTSTRAP__' => __ROOT__ . "/Public/bootstrap",
		'__STATIC__' => __ROOT__ . '/Public/static',
		'__IMG__' => __ROOT__ . '/Public/images',
		'__CSS__' => __ROOT__ . '/Public/css',
		'__JS__' => __ROOT__ . '/Public/js',
		'__PUBLIC__' => __ROOT__ . "/Public",
		'__UPLOAD__' => __ROOT__ . "/Public/upload",
	),
	'DEFAULT_FILTER'        => 'htmlspecialchars',
	//默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR' => 'Auth@Public:error',
	//默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => 'Auth@Public:success',
	'USER_ADMINISTRATOR' => 13,	//超级管理员ID
	
);
