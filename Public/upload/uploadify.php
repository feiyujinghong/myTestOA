﻿<?php
/*
Uploadify 后台处理 Demo
Author:wind
Date:2013-1-4
uploadify 后台处理！
*/

//设置上传目录
$path = "uploads/";	

if (!empty($_FILES)) {
	
	//得到上传的临时文件流
	$tempFile = $_FILES['Filedata']['tmp_name'];
	
	//允许的文件后缀
	$fileTypes = array('jpg','jpeg','gif','png'); 
	
	//得到文件原名
	$fileName = iconv("UTF-8","GB2312",$_FILES["Filedata"]["name"]);
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	//接受动态传值
	$files=$_POST['typeCode'];
	
	//最后保存服务器地址
	if(!is_dir($path))
	   mkdir($path);
	if (move_uploaded_file($tempFile, $path.$fileName)){
		echo $fileName."上传成功！";
	}else{
		echo $fileName."上传失败！";
	}
}
?>