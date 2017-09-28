<?php
namespace Hr\Controller;
use Think\Model;

use Auth\Controller\AuthController;

use Auth\Controller\DepartmentController;

use Think\Auth;

use Think\Controller;
class StaffController extends AuthController {
	
	public function _initialize() {
		parent::_initialize ();
		require_once "./Application/Common/Conf/c_select.php";
		$this->c_s = $con_select;
		$this->assign("c_s",$this->c_s);
	}
	
	public function add_base_info() {
		if (IS_POST) {
			$staff = D("StaffInfo");
			$c_data = $staff->create();
			if (!$c_data) {
				exit("操作失败！".$staff->getError());
			}
			$birthday_str = trim($_POST ['birthday_str']);
			$c_data ['birthday'] = strtotime($birthday_str);
			if (1 == $c_data['bir_type']) {//阳历
				$c_data ['bir_month'] = date("m", $c_data ['birthday']);
			} else { //阴历
				$lunar = new \Think\Lunar;
    			$ldate=$lunar->convertLunarToSolar(date("Y" ,$c_data ['birthday']), date("m" ,$c_data ['birthday']), date("d" , $c_data ['birthday']));
				$c_data ['bir_month'] = $ldate[1];
			}
			if ($c_data) {
				if (empty($c_data['id'])) {
					$r = $staff->add($c_data);
					$c_data['id'] = $r;
				} else {
					$r = $staff->save($c_data);
					$staff_base_info = $this->read_staff_info("link", $c_data['id']);//联系人信息
					$this->assign('staff_info',$staff_base_info);
					//dump($staff_base_info);
				}
				//echo M()->getLastSql();
			} else {
				$this->error('数据获取失败！');
			}
			if (false === $r) {
				$this->error('添加失败！');
			} else {
				if (!empty($_FILES)) {
					$user_pic = $this->tp_upload();
					if ($user_pic) {
						$user_pic_path = "SysUploads/".$user_pic['file']['savepath'].$user_pic['file']['savename'];
						$s_user = array();
						$s_user ['user_pic'] = $user_pic_path;
						$s = $staff->where(array("id"=>$c_data['id']))->save($s_user);
						if (false === $s) {
							$this->error('员工照片上传失败！');
							exit();
						}
					}
				}
				$this->assign('id',$c_data['id']);
				$this->display("add_link_info");
			}
		} else {
			$this->dept_tree(1);//部门结构弹层
			$this->display();
			$this->selectUser();
		}
	}
	
	public function add_link_info() {
		if (IS_POST) {
			$staff = D("StaffInfo");
			$c_data = $staff->create();
			if (!$c_data) {
				exit("操作失败！".$staff->getError());
			}
			if (empty($c_data['id'])) {
				$this->error('数据获取失败！');
			} else {
				$r = $staff->save();
				if (false !== $r) {
					$this->assign('id',$c_data['id']);
					$satff_link = M("staff_link_info");
					$c_staff_link = $satff_link->create();
					if (!empty($c_staff_link)) {
						$map = array('staff_info_id'=>$c_data['id']);
						$satff_link->where($map)->delete();
						$c_staff_link = operate_post_arr($c_staff_link, 'staff_info_id', $c_data['id']);//数组处理
						//dump($c_staff_link);exit();
						if (false !== $satff_link->addAll($c_staff_link)) {
							$this->assign('id',$c_data['id']);
							$staff_base_info = $this->read_staff_info("work", $c_data['id']);//工作信息
							$this->assign('staff_info',$staff_base_info);
							$this->assign('department_tree',$this->department_tree());//部门树
							$this->display("add_work_info");
						} else {
							//echo M()->getLastSql();
							$this->error('添加联系人信息失败！');
						}
					} else {
						$staff_base_info = $this->read_staff_info("work", $c_data['id']);
						$this->assign('staff_info',$staff_base_info);
						$this->assign('department_tree',$this->department_tree());//部门树
						$this->display("add_work_info");
					}
					
				} else {
					$this->error('添加配偶信息失败！');
				}
			}
		}
	}
	
	/**
	 * 添加联系人信息"上一步"
	 * @param int $staff_id 信息ID
	 */
	public function read_base() {
		if (I('get.id')) {
			$staff_id = intval(I('get.id'));
			$staff_base_info = $this->read_staff_info("base", $staff_id);
			$this->assign('id',$staff_base_info['id']);
			$this->assign('staff_info',$staff_base_info);
			$this->dept_tree(1);//部门结构弹层
			$this->display("add_base_info");
		} else {
			$this->error("数据获取失败！");
		}
	}
	
	public function add_work_info() {
		if (IS_POST) {
			$staff = D("StaffInfo");
			$c_data = $staff->create();
			if (!$c_data) {
				exit("操作失败！".$staff->getError());
			}
			if (empty($c_data['id'])) {
				$this->error('数据获取失败！');
			} else {
				$r = $staff->save();
				if (false !== $r) {
					$this->assign('id',$c_data['id']);
					$this->display("add_annex_info");
				} else {
					$this->error('工作信息添加失败！');
				}
			}
		} else {
			$this->include_header=false;
			$this->display("add_annex_info");
		}
	}
	
	/**
	 * 添加工作信息"上一步"
	 * @param int $staff_id 信息ID
	 */
	public function read_link() {
		if (I('get.id')) {
			$staff_id = intval(I('get.id'));
			$staff_base_info = $this->read_staff_info("link", $staff_id);
			$this->assign('id',$staff_base_info['id']);
			$this->assign('staff_info',$staff_base_info);
			$this->display("add_link_info");
		} else {
			$this->error("数据获取失败！");
		}
	}
	
	public function add_annex_info() {
		if (IS_POST) {
			/*
			dump($_FILES);
			$upload = new \Think\Upload(); //实例化上传类
			$upload->maxSize = 3145728;
			$upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
			//$name = $upload->saveRule = 'uniqid';
			$name = $upload->saveName = 'time';
			$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			$path = $upload->savePath = ''; // 设置附件上传（子）目录
			$upload->subName  = array('date','Ymd');
			$info = $upload->upload();
			dump($upload->getError());
			*/
			if (I('post.id')) {
				$staff_id = intval(I('post.id'));
				$r = D("StaffInfo")->where(array('id'=>$staff_id))->save(array("file_states"=>1));
				//echo M()->getLastSql();
				if ($r !== false) {
					$this->success("操作成功！");
					exit();
				} else {
					$this->error("状态修改失败！");
				}
			
			} else {
				$this->error("数据获取失败！");
			}
		
		} else {
			$this->include_header = false;
			$this->display();
		}
	}
	
	/**
	 * 文件信息"上一步"
	 * @param int $staff_id 信息ID
	 */
	public function read_work() {
		if (I('get.id')) {
			$staff_id = intval(I('get.id'));
			$staff_base_info = $this->read_staff_info("work", $staff_id);
			$this->assign('id',$staff_base_info['id']);
			$this->assign('staff_info',$staff_base_info);
			$this->assign('department_tree',$this->department_tree());//部门树
			$this->display("add_work_info");
		} else {
			$this->error("数据获取失败！");
		}
	}
	
	/**
	 * 上传
	 */
	public function upload() {
		if (I('get.id')) {
			echo $staff_id = intval(I('get.id'));
		} else {
			echo "获取数据失败！";
			exit();
		}
		$path = "Uploads/";
		$path = $path.date("Ym",time())."/".date("d",time())."/";
		if (!empty($_FILES)) {
			
			//得到上传的临时文件流
			$tempFile = $_FILES['Filedata']['tmp_name'];
			//允许的文件后缀
			$fileTypes = array('jpg','jpeg','gif','png'); 
			
			//得到文件原名
			$fileName = iconv("UTF-8","GB2312",$_FILES["Filedata"]["name"]);
			$fileName_ch = $_FILES["Filedata"]["name"];
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			
			//接受动态传值
			$files = $_POST['typeCode'];
			
			//最后保存服务器地址
			if(!is_dir($path))
			   //mkdir($path);
			   $this->create_folder($path);
			   
		    $extend = pathinfo($fileName);   
		    $extend = strtolower($extend['extension']); 
			$save_name = rand(1000, 9999).'.'.$extend;
			$save_path = $path.md5($fileName_ch).$save_name;
			//echo $fileName;exit();
			if (move_uploaded_file($tempFile, $save_path)) {
				
				$c_staff_file = array(
					'staff_info_id'=>$staff_id,
					'name'=>$fileName_ch,
					'path'=>$save_path,
					'time'=>time(),
				);
				if (false !== M("staff_file")->add($c_staff_file)) {
					//echo M()->getLastSql();
					echo $fileName_ch."上传成功！";
				} else {
					echo $fileName_ch."保存数据失败！";
				}
			} else {
				echo $fileName_ch."上传失败！";
			}
		}
	}
	
	/*递归创建文件夹*/
	function create_folder($path){
		if (!file_exists($path)){
			$this->create_folder(dirname($path));
			mkdir($path, 0755);
		}
	}
	
	public function read_staff_info($type, $staff_id) {
		$staff = D("StaffInfo");
		switch ($type) {
			case 'base':
				$field_array = array("`id`", "`user_id`", "`name`", "`bir_type`", "`birthday`", "`sex`", "`card_id`", "`phone`", "`tele`", "`email`", "`qq`",
										"`nation`", "`marriage`", "`political`", "`college`", "`discipline`", "`education`",
										"`household_address`", "`now_address`", "`user_pic`"
									);
			break;
			
			case 'link':
				$field_array = array("`id`", "`spouse_name`", "`spouse_phone`", "`spouse_work_name`","`spouse_position`", "`spouse_work_address`");
				$link_info = $staff->get_link_info($staff_id);	
			break;
			
			case 'work':
				$field_array = array("`id`", "`user_id`", "`work_dept`", "`work_num`", "`work_now`","`work_black`");
			break;
			
			case 'file':
				$field_array = array();
			break;
			
			default:
				$field_array = array("`id`", "`user_id`", "`name`", "`bir_type`", "`sex`", "`birthday`", "`card_id`", "`phone`", "`tele`", "`email`", "`qq`",
										"`nation`", "`marriage`", "`political`", "`college`", "`discipline`", "`education`",
										"`household_address`", "`now_address`", "`user_pic`",
										"`spouse_name`", "`spouse_phone`", "`spouse_work_name`","`spouse_position`", "`spouse_work_address`",
										"`work_dept`", "`work_num`", "`work_now`","`work_black`",					
									);
			break;
			
		}
		
		$staff_info = $staff->get_staff_info($field_array,array('id'=>intval($staff_id)));
		if (!empty($link_info) || "all" == $type) {
			if ("all" == $type) {
				$link_info = $staff->get_link_info($staff_id);
			}
			$staff_info['link_info'] = $link_info;
		}
		if ("work" == $type || "all" == $type) {
			$work_sys = D("Auth/Department")->get_user_depat($staff_info['user_id']);
			//echo $staff_info['user_id'];
			$role_id = M("user")->where(array("id"=>$staff_info['user_id']))->getField("role_id");
			$role_name = M("role")->where(array("id"=>$role_id))->getField("name");
			$staff_info['sys_depat'] = implode(",", $work_sys);
			$staff_info['role_name'] = $role_name;
		}
		return $staff_info;
	}
	
	/**
	 * 员工列表
	 */
	public function staff_list() {
		$map = array();
		//搜索
		if (I("get.name")) {
			$name = trim(I("get.name"));
			$map['name'] = array('like', "%$name%");
		}
		
		if (I("get.card_id")) {
			$card_id = trim(I("get.card_id"));
			$map['card_id'] = array('like', "%$card_id%");
		}
		
		if (I("get.phone")) {
			$phone = trim(I("get.phone"));
			$map['phone'] = array('like', "%$phone%");
		}
		
		if (I("get.household_address")) {
			$household_address = trim(I("get.household_address"));
			$map['household_address'] = array('like', "%$household_address%");
		}
		/*
		 * //部门搜索
		if (I("get.dept_id")) {
			$last_depat_id_arr = $this->get_last_depat(intval(I("get.dept_id")));
			$map = array();
			$map['id'] = array('IN',$last_depat_id_arr);
		}
		*/
		$staff_info = $this->lists("StaffInfo", $map);
		//dump($staff_info);
		$this->assign('staff_info',$staff_info);
		//$this->assign('tree_data',$this->dept_tree());部门结构
		$this->display();
	}
	
	public function staff_list_bir() {
		//本月生日
		if ("bir" === I('get.bir')) {
			$map ['bir_month'] = date("m", time());
		}
		$staff_info = $this->lists("StaffInfo", $map);
		//dump($staff_info);
		$this->assign('staff_info',$staff_info);
		$this->display();
	}
	
	/**
	 * 员工信息详情
	 */
	public function show_user_info() {
		if (I('get.id')) {
			$staff_id = intval(I('get.id'));
			$staff_info = $this->read_staff_info("all", $staff_id);
			//角色
			$role_id = M("user")->where(array("id"=>$staff_info['user_id']))->getField("role_id");
			$role_name = M("role")->where(array("id"=>$role_id))->getField("name");
			$staff_info['role_name'] = $role_name;
			//部门
			$depat_array = D("Auth/department")->get_user_depat($staff_info['user_id']);
			$staff_info['depat_str'] = implode(",", $depat_array);
			//数据翻译
			$staff_info['marriage_ch'] = $this->c_s['marriage'][$staff_info['marriage']];
			$staff_info['sex_ch'] = $this->c_s['sex'][$staff_info['sex']];
			$staff_info['education_ch'] = $this->c_s['education'][$staff_info['education']];
			$this->assign('staff_info', $staff_info);
			//图片信息
			$staff_file_info = M('staff_file')->field(array("`id`", "`name`", "`path`"))->where(array("staff_info_id"=>$staff_id))->select();
			//dump($staff_file_info);
			$this->assign('file_info',$staff_file_info);
			$this->display();
		}
	}
	
	/**
	 * 员工信息编辑
	 */
	public function update_user_info() {
		if (I('get.id')) {
			$staff_id = intval(I('get.id'));
			$staff_base_info = $this->read_staff_info("base", $staff_id);
			//dump($staff_base_info);
			$this->assign('staff_info',$staff_base_info);
			$this->dept_tree(1);//部门结构弹层
			$this->display("add_base_info");
			$this->selectUser();
		
		}
	
	}
	
}