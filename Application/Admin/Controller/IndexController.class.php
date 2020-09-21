<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends CommonController {
	
	//主页
  public function index()
  {
  	if(session('admin') == C('ADMIN_NAME'))
  	{
  		$nav_data=D('rule')->getTreeData('level','id');
  	}else
  	{
  		$nav_data=D('rule')->getTreeDataR('level','id');
  	}
  	// 分配菜单数据
  	
  	// dump($nav_data);die;
  	 //$nav_data=D('rule')->getTreeData('level','order_number,id');
  	 $assign=array(
  	 'nav_data'=>$nav_data
  	 );
  	 $this->assign($assign);
  	$this->display();
  }
  
  //主页
  public function welcome()
  {
  	//$this->Is_Login();
  	$this->display();
  }
  
  
  
  
  

  
  
}