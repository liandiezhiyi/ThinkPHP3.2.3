<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends AdminBaseController
{
	//登录页面
	public function index()
	{
		// 是否已登录
		if(!empty($_SESSION['admin']))
		{
			redirect(U('Index/index'));
		}
		$this->display();
	}
	
	//登录业务处理
	public  function login()
	{
		if($_POST)
		{		
				$master_username=I("name");
				$master_password=md5(I("password"));
				//echo $master_password;
			if(!empty($master_username)&&!empty($master_password))
			{
				$Muser=M("master");
				$condition['master_username'] = $master_username;
				$res=$Muser->where($condition)->find();
				//dump($res);die;
				if(I("name")==$res["master_username"] && $master_password==$res["master_password"])
				{
					session('nickname', $res['master_nickname']);   // 当前用户昵称
             		session('admin', $res['master_username']); 
             		session('uid', $res['id']);    // 当前用户名  	
             		session('session_start_time', time());//记录会话开始时间！
             		//dump($_SESSION['session_start_time']);die;
             		redirect(U('Index/index'));
             		//$this->success("登录成功",U('Index/index'),3);
				}
				else
				{
					$this->error("用户名或密码不正确");
				}				
			}
			else
			{
				$this->error("用户名或密码不能为空");
			}

		}
	}
	
	public function Logout()
	{
		session_destroy();
		redirect(U('Login/index'));
	}
}