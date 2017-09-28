<?php
// 本类由系统自动生成，仅供测试用途
namespace Workflow\Controller;
class DemoController extends \Auth\Controller\AuthController {
    
    protected function model()
    {
        if($this->_obj_model)
            return $this->_obj_model;
        return $this->_obj_model = D('flow');
    }
    
    public function index(){
	    
        $map = array(
            'is_del'=>0,
        );
        $page='';
        $list = array();
        $count = $this->model()->where($map)->count('id');
        if ($count > 0)
        {
            import("@.Org.Util.Page");
            $p = new \Page($count, 5);
            //分页跳转的时候保证查询条件
            foreach ($_GET as $key => $val) {
                if (!is_array($val)) {
                    $p->parameter .= $key.'=' . urlencode($val) . '&';
                }
            }
             //分页显示
            $page = $p->show();
            
            $list = $this->model()->relation(true)->field('id,form_id,flow_name,flow_desc,updatetime,dateline')->where($map)->order('id desc')->limit($p->firstRow . ',' . $p->listRows)->select();

        }
        $this->assign('page', $page);
        $this->assign('list', $list);

        $this->display();
    }
    
    public function add()
    {
        self::edit();
    }
    public function edit()
    {
        $flow_id = intval(I('flow_id'));
        
        $one = array();
        
        if($flow_id>0)
        {
            $map = array(
                'id'=>$flow_id,
                'is_del'=>0,
            );
            $one = $this->model()->where($map)->find();
            if(!$one)
            {
                $this->error('未找到表单数据，请返回重试!');
            }
        
        }
        if(IS_GET)
        {
            $map = array(
                'is_del'=>0
            );
            $form_list = D('form')->field('id,form_name')->where($map)->select();
            
            $this->assign('one',$one);
            $this->assign('form_list',$form_list);
            $this->display('edit');
        }
         else
        {
            $flow_name = trim(I('post.flow_name',''));
            if(empty($flow_name))
            {
                $this->error('请填写表单名称!',U('/'.$this->_controller.'/add'));
            }
            $data = array(
                'flow_name'=>$flow_name,
                'form_id'=>intval(I('post.form_id')),
                'flow_desc'=>trim(I('post.flow_desc','')),
                'updatetime'=>time(),
            );
            if($flow_id>0)
            {
                if($this->model()->where(array('id'=>$flow_id))->save($data))
                {
                    
                    $this->success('编辑成功。',U('/'.$this->_controller.'/edit/flow_id/'.$flow_id));
                }else
                {
                    $this->error('编辑失败，请重试!');
                }
            }else
            {
                $data['dateline'] = time();
                $flow_id = $this->model()->add($data);
                if($flow_id<=0)
                {
                    $this->error('添加失败，请重试!');
                }
                $this->success('添加成功。',U('/'.$this->_controller));
            }
            
            
           
        }
        
        
    }
    //用户选择控件
    public function super_dialog()
    {
        $op = trim(I('get.op'));//选择方式  user 用户  dept部门  role 角色
        if(!$op) $op = 'user';
        $this->include_header = false;
        $this->assign('op',$op);
        $this->display();
    }
    

  
}