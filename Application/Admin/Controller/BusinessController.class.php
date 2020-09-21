<?php
namespace Admin\Controller;
use Think\Controller;
class BusinessController extends CommonController {

	
	//业务管理-------------------------------------------------
	
	public function index()
	{
		$this->BusinessList();
	}
  public function BusinessList()
  {
  	$this->display();
  }
  
  public function yuyuelist()
  { 	
  	$this->display();
  
  }
  
  
  
}