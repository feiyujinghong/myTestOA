<?php
return array(
	'DB_PREFIX' => 'work_', // 数据库表前缀
	'TMPL_PARSE_STRING' => array (
		'__BOOTSTRAP__' => __ROOT__."/Public/bootstrap",
		'__IMG__' => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
		'__CSS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/css', 
		'__JS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/js'
	),
);