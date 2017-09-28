<?php
// +----------------------------------------------------------------------
// | 图片上传处理
// +----------------------------------------------------------------------
// | Copyright (c) 2015 www.c_o.com
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------
namespace Upload\Controller;

use Think\Controller;

class UploadController extends UploadBaseController {
	
	/**
	 * 获取上传操作页面
	 */
	public function uploadBtn($tableName = "product", $id="") {
		include_once 'UploadBtn.php';
		return $str;
		/*
		$this->assign("tableName",$tableName);
		$uploadBtn = $this->fetch("uploadBtn");
		echo  $uploadBtn;
		*/
	}
	
	/**
	 * 文件上传
	 */
	public function moveUpload() {
		if (I('get.tb')) {
			$tableName = trim(I('get.tb'));
		} else {
			echo json_encode(array('id'=>"获取类型错误！"));
			exit();
		}
		$path = "Uploads/".date("Ym",time())."/".date("d",time())."/";
		
		if (empty($_FILES)) {
			echo json_encode(array('id'=>"获取文件错误！"));
		}
		//得到上传的临时文件流
		$tempFile = $_FILES['Filedata']['tmp_name'];
		
		//得到文件原名
		$fileName = iconv("UTF-8","GB2312",$_FILES["Filedata"]["name"]);
		$fileName_ch = $_FILES["Filedata"]["name"];
		$fileParts = pathinfo($_FILES['Filedata']['name']);
		
		//接受动态传值
		$files = $_POST['typeCode'];
		
		//最后保存服务器地址
		if(!is_dir($path)) {
			$this->create_folder($path);
		}
		
	    $extend = pathinfo($fileName);
	    $extend = strtolower($extend['extension']);
		$show_arr = array("gif", "jpg" ,"png", "jpeg");
	    if (in_array($extend, $show_arr)) {
	    	$is_show = 1;
	    } else {
	    	$is_show = 2;
	    }
		$save_name = rand(1000, 9999).'.'.$extend;
		$save_path = $path.md5($fileName_ch).$save_name;
		if (move_uploaded_file($tempFile, $save_path)) {
			$m_path = $path;
			$m_name = md5($fileName_ch).$save_name;
			if (1 == $is_show) {
				$this->tp_image($m_path,$m_name);//缩略图
			}
			//处理更新
			if (I("get.moduleid")) {
				$primary_id = intval(I("get.moduleid"));
			} else {
				$primary_id = "";
			}
			//insert
			$r = $this->insertUpload($tableName, $fileName_ch, $save_path, $primary_id, $is_show);
			if (1 == $is_show) {
				//小图路径
				$m_img_path = get_m_pic($save_path);
				$img = "<div id=".$r." style='width:120px;float:left;'>";
				$img .= "<img data-toggle='modal' data-target='#myModal' onclick='get_modal($(this))'  title='点击看大图' style='width:100px;height100px;' src='/".$m_img_path."'>";
				$img .= "<br><a data-toggle='modal'  title='点击看大图'  src='/".$m_img_path."'  data-target='#myModal' onclick='get_modal($(this))'>";
				$img .= $fileName_ch;
				$img .= " <a href='javascript:void(0)' onclick='dele_attach(".$r.");'><i class='icon-trash-o'></i></a>";
				$img .= "</a>";
				$img .= "<input type='hidden' value='/".$save_path."'/>";
				$img .= "</div>";
			} else {
				$img = "<div id=".$r." style='width:120px;float:left;'>";
				$fileName = substr(strrchr($fileName_ch, '.'), 1); 
				if($fileName == "doc" || $fileName_ch=="docx"){
					$m_img_path = "Public/img/word.jpg";
				}else if($fileName == "xls" || $fileName_ch=="xlsx"){
					$m_img_path = "Public/img/excel.png";
				}else if($fileName == "pdf"){
					$m_img_path = "Public/img/pdf.jpg";
				}else{
					$m_img_path = "Public/img/file.png";
				}
				$img .= "<img style='width:100px;height100px;' src='/".$m_img_path."'>";
				$img .= "<br><a title='点击下载'  href='/".$save_path."' >".$fileName_ch."</a>";
				$img .= " <a href='javascript:void(0)' onclick='dele_attach(".$r.");'><i class='icon-trash-o'></i></a>";
				$img .= "</div>";
			}
			$r_array = array('id'=>$r, 'path'=>$img);
			echo json_encode($r_array);
		} else {
			echo json_encode(array('id'=>$fileName_ch."上传失败！"));
		}
	}
	
	/**
	 * 生成缩略图
	 */
	private function tp_image($path, $pic_name) {
		$image = new \Think\Image();
		$image->open($path.$pic_name);
		$image->thumb(550, 450)->save($path.'m_'.$pic_name);
	}
	
	/**
	 * 递归创建文件夹
	 */
	private function create_folder($path){
		if (!file_exists($path)){
			$this->create_folder(dirname($path));
			mkdir($path, 0755);
		}
	}
	
	/**
	 * 保存图片数据
	 */
	private function insertUpload($tableName, $fileName_ch, $save_path, $primary_id,$is_show) {
		$c_file = array(
			'module'=>$tableName,
			'name'=>$fileName_ch,
			'url'=>$save_path,
			'add_time'=>time(),
			'is_show'=>$is_show,
		);
		//处理更新
		if (!empty($primary_id)) {
			$c_file['primary_id'] = $primary_id;
		}
		$r = M("attach")->add($c_file);
		if ($r) {
			return $r;
		} else {
			return $fileName_ch."保存数据失败！";
		}
	}
	
	/**
	 * 更新attach
	 * 如果没有更新成功，图片找不到归属模块
	 */
	public function updateUpload($attach_id_str, $module, $module_id)
	{
		$attach_id_arr = explode('|', $attach_id_str);
		$attach_id_str = implode(',', $attach_id_arr);
		$module = trim($module);
		$attach_obj = M("attach");
		$where = "id in (".$attach_id_str.")";
		$r_attach = $attach_obj->field('id ,module')->where($where)->select();
		foreach ($r_attach as $k=>$v)
		{
			if ($v['module'] !== $module)
			{
				return false;
			}
		}
		$r = $attach_obj->where($where)->save(array('primary_id'=>intval($module_id)));
		if (false !== $r)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 *  删除
	 */
	public function dele_attach()
	{
		$id = intval(I("post.id"));
		if (empty($id))
		{
			echo "删除失败！";
			exit();
		}
		if (false !== M("attach")->where(array('id'=>$id))->save(array("is_del"=>1)))
		{
			echo "删除成功！";
			exit();
		}
		else
		{
			echo "删除失败！";
			exit();
		}
	}
	
	/**
	 * 下载文件
	 */
	public function down_file()
	{
		if (empty($_GET['attach_id']))
		{
			echo "找不到文件！";
			exit();
		}
		
		$attach_id = intval($_GET['attach_id']);
		$r_attach = M("attach")->where(array("id"=>$attach_id))->find();
		$path = $r_attach['url'];
		$file_name = $r_attach['name'];
		if (!file_exists($path))
		{
		  echo "找不到文件！";
		  exit;    
		}
		else
		{
			$file = fopen($path,"r"); // 打开文件
			// 输入文件标签
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: ".filesize($path));
			Header("Content-Disposition: attachment; filename=" . $file_name);
			// 输出文件内容
			echo fread($file,filesize($path));
			fclose($file);
			exit();
		}
	}

}