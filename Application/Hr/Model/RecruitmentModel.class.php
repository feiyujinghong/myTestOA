<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: lts
// +----------------------------------------------------------------------

namespace Hr\Model;
use Think\Model;

/**
 * 用户组模型类
 * Class StaffModel
 */
class RecruitmentModel extends Model {

    protected $_validate = array(
        array('department','require', '必须填写用人部门', Model::MUST_VALIDATE ,'regex',Model::MODEL_INSERT),
     
    );
    
	
    

}

