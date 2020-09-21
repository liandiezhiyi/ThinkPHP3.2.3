<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends AdminBaseController{
	
	
	
	/**
	 * 初始化方法
	 */
	public function _initialize(){
		parent::_initialize();
		
		//登录 验证
		
			if(empty($_SESSION['admin']))
			{
				//$this->error('您还没有登录', U('Login/index'));
				redirect(U('Login/index'));
			} else {
				// 用户
				$this->admin = I('session.admin');
			};
			
			//判断会话是否过期
			if (time() - session('session_start_time') > C('SESSION_OPTIONS')['expire']) {
				session_destroy();//销毁在这里！
				redirect(U('Login/index'));
			}
			
			
		
		  $auth=new \Think\Auth();
		
		$not_check = array('Index/index','Tablet/uploadFile','Oa/uploadFile','Oa/checkNotify','Index/welcome','Login/index','Login/login','Login/logout');
		
		//当前操作的请求                 模块名/方法名
		if(in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $not_check)|| session('admin') == C('ADMIN_NAME')){
			return true;
		}
		$rule_name=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		//echo $rule_name;
		$result=$auth->check($rule_name,$_SESSION['uid']);
		//echo $rule_name;
		if(!$result){
			$this->error('您没有权限访问');
		}
		
		// 分配菜单数据
		/*$nav_data=D('rule')->getTreeData('level','id');
		//dump($nav_data);die;
		//$nav_data=D('rule')->getTreeData('level','order_number,id');
		$assign=array(
				'nav_data'=>$nav_data
		);
		
		$this->assign($assign);
	
		*/
	}
	

		
	
	
	
}
?>