<?php
namespace Admin\Controller;
class RuleController extends CommonController {
	

	//权限控制部份-------------------------------------
		public function index()
	{
		//$this->display();
		$this->userlist();
	}
	//-----------------------------用户列表------------------------
	//用户列表
  public function userlist()
  {
  	$Muser=M("master");
  	 
  	$count      = $Muser->count();// 查询满足要求的总记录数
  	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
  	$show       = $Page->show();// 分页显示输出
  	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
  	$list = $Muser->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
  	foreach ($list as $key=>$val)
  	{
  		$res=M('access')->where('uid='.$val['id'])->select();
  		 
  		foreach ($res as $k1=>$v)
  		{
  			$data=M("group")->where('id='.$v["group_id"])->find();
  			$res["g_name"][$k1]=$data['title'];
  			$list[$key]["gname"]=implode(' ， ', $res["g_name"]);
  		}

  	}
  	
  	
  	$this->assign('userlist',$list);// 赋值数据集
  	$this->assign('page',$show);// 赋值分页输出
  	$this->display("userlist"); // 输出模板
 
  }
  
  //添加用户
  public function adduser()
  {
  	if(IS_POST)
  	{
  		$master_username=trim(I("username"));
  		
  		$Muser=M("master");
  		$resault=$Muser->where(array('master_username'=>$master_username))->find();
	  	if(count($resault)!=0)
	  	{
	  		$this->error("此用户已存在");
	  	}
	  	else
	  	{

	  		$data['master_username']=$master_username;
	  		$data['master_nickname']=trim(I("nickname"));
	  		$data['master_password']=md5(I("password"));
	  		$data['master_createtime']=time();
	  		$data['group_ids']=I('group_ids');
	  		//$res=$Muser->add($data);
	  		$res=D('Master')->addData($data);
	  		//dump($res); die;
	  		if($res)
	  		{

	  			if (!empty($data['group_ids'])) {
	  				foreach ($data['group_ids'] as $k => $v) {
	  					$group=array(
	  							'uid'=>$res,
	  							'group_id'=>$v
	  					);
	  					D('Access')->addData($group);
	  				}
	  			}
	  			$this->success("添加成功",U('Rule/userlist'));
	  		}
	  		else 
	  		{
	  			$this->error("添加失败");
	  		}
	  	}
	}
  	else
  	{
  		$data=M('group')->select();
  		$assign=array(
  				'data'=>$data
  		);
  		$this->assign($assign);
  		$this->display();
  	}
  	
  }
  
  
  
  //修改用户
  public function updateUser()
  {
  	//$Muser=M("master");
  	
  	if(IS_POST){
  		
  		$data=I('post.');
  		//dump($data['uid']);die;
  		// 组合where数组条件
  		$uid=$data['uid'];
  		
  		$map=array(
  				'id'=>$uid
  		);
  		
  		// 修改权限
  		D('Access')->deleteData(array('uid'=>$uid));
  		//dump($res);die;
  		
  		foreach ($data['group_ids'] as $k => $v) {
  			$group=array(
  					'uid'=>$uid,
  					'group_id'=>$v
  			);
  			D('Access')->addData($group);
  		}
  		
  	
  		//$data=array_filter($data);
  		// 如果修改密码则md5
  		if (!empty($data['password'])) {
  			//$data['password']=md5($data['password']);
  			$datares['master_username']=trim($data['username']);
  			$datares['master_nickname']=trim($data['nickname']);
  			$datares['master_password']=md5($data['password']);
  			$datares['master_createtime']=time();
  		}
  		//dump($data);die;
  		// p($data);die;
  		$result=M('Master')->where($map)->save($datares);
  		if($result){
	  			$this->success("修改成功",U('Rule/userlist'));

  		}
  		else
  		{
  			$this->error("修改失败");
  		}
  	}else{
  		$id=I('get.id',0,'intval');
  		// 获取用户数据
  		$user_data=M('master')->find($id);
  		// 获取已加入用户组
  		$group_data=M('access')->where(array('uid'=>$id))->getField('group_id',true);
  		// 全部用户组
  		$data=D('Group')->select();
  		$assign=array(
  				'data'=>$data,
  				'user_data'=>$user_data,
  				'group_data'=>$group_data
  		);
  		//dump($user_data); die;
  		$this->assign($assign);
  		$this->display();
  	} 
  
  }
  
  
  
  
  
  //删除用户及权限
  public function delUser()
  {
  	$id=I("id");
  	$Muser=M("master");
  	$res=$Muser->where('id='.$id)->delete();
  	if($res)
	  {
	  
	  	M("access")->where('uid='.$id)->delete();
	  	$this->success("删除成功",U('Rule/userlist'));
	  }
	  else 
	  {
	  	$this->error("删除失败");
	  }
  	
  }
  
  
  
  
  //批量删除
  public function delUsers()
  {
	  	$id=I('id');
	    $ids = join(',', $id);
	    $Muser=M("master");
	    $data = $Muser->where(array('id' => array('in', $ids)))->delete();
	    if($data)
	    {
	    	M("access")->where(array('uid' => array('in', $ids)))->delete();
	    	$this->success("删除成功", U('Rule/userlist'));
	    }
	    else
	    {
	    	$this->error("删除失败");
	    }
  }
  
  //关键词搜索
  public function UserSearch()
  {
  	//获取关键字
  	$keys=I("keywords");
  	$this->assign("key",$keys);
  	if($keys!="")
  	{
  		//模糊查询条件
  	
  		$map['master_username']=array('like',"%$keys%");
  		$map['master_nickname']=array('like',"%$keys%");
  		$map['_logic']='or';
  		$Muser=M("master");
  		$count      = $Muser->where($map)->count();// 查询满足要求的总记录数	
  		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
  		//分页跳转的时候保证查询条件
  		
  		foreach($map as $key=>$val) {
  			$Page->parameter[$key]   =   urlencode($val);
  		}
  		
  		$show       = $Page->show();// 分页显示输出
  		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
  		$list = $Muser->where($map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
  		foreach ($list as $key=>$val)
  		{
  			$res=M('access')->where('uid='.$val['id'])->select();
  				
  			foreach ($res as $k1=>$v)
  			{
  				$data=M("group")->where('id='.$v["group_id"])->find();
  				$res["g_name"][$k1]=$data['title'];
  				$list[$key]["gname"]=implode(' ， ', $res["g_name"]);
  			}
  		}
  		//dump($list);die;
  		// 分页
  		$this->assign('userlist',$list);// 赋值数据集
  		$this->assign('page',$show);// 赋值分页输出
  		$this->display('userlist'); // 输出模板
  		
  		
  	}
  	else
  	{
		$this->userlist();  		
  	}
  	
  }
  

  
  
  
  
  //---------------------权限管理-------------
  //权限管理
  public function RuleList()
  {
  	$data=D('rule')->getTreeData('tree','id','title');
  	$assign=array(
  			'data'=>$data
  	);
  	$this->assign($assign);
  	$this->display();
  	
  	//$this->display();
  }
  
  
  //添加权限及子权限
  public function AddRule()
  {
  	if(IS_POST)
  	{
  		$m=M("rule");
  		//$pid=I('pid');
  		//如果PId不等于0 则添加子权 限否添加父级权限
  		if(I('pid')!=0)
  		{
  			$data['pid']=I('pid');
  			$data['title']=I("title");
  			$data['name']=I('name');
  			if($m->add($data))
  			{
  				$this->success("新增成功", U('Rule/RuleList'));
  			}
  			else
  			{
  				$this->error("新增失败");
  			}
  		}
  		else
  		{
  			if($m->add($_POST))
  			{
  				$this->success("新增成功", U('Rule/RuleList'));
  			}
  			else
  			{
  				$this->error("新增失败");
  			}
  		}
  	}
  	else
  	{
  		$this->display();
  	}
  }
  
  
  //修改权限
  public function updateRule()
  {
  	$m=M("rule");
  	if($_POST)
  	{
  			$id=I('id');
  			$dataR = array('name'=>trim(I("name")),'title'=>trim(I("title")));
  			$res=$m-> where('id='.$id)->setField($dataR);
  			if($res)
  			{
  				$this->success("修改成功",U('Rule/RuleList'));
  			}
  			else
  			{
  				$this->error("修改失败");
  			}
  	}
  	else
  	{
  		$data=$m->where('id='.I("id"))->select();
  		$this->ajaxReturn($data);
  		//echo I("id");
  	}
  		
  	
  }
  
  //删除权限
  public function delRule()
  {
  	$id=I('id');
  	$map=array(
  			'id'=>$id
  	);
  	$result=D('Rule')->deleteData($map);
  	if($result){
  		$this->success('删除成功',U('Rule/RuleList'));
  	}else{
  		$this->error('请先删除子权限');
  	}
  }
  
  
 
  
  //----------------------------------用户组列表----------------------------
  //用户组列表
  public function GroupList()
  {
  	$m=M("group");
  	$count      = $m->count();// 查询满足要求的总记录数
  	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
  	$show       = $Page->show();// 分页显示输出
  	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
  	$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
  	$this->assign('list',$list);// 赋值数据集
  	$this->assign('page',$show);// 赋值分页输出
  	$this->display("GroupList"); // 输出模板
  }
  

  
  //关键词搜索(用户组)
  public function GroupSearch()
  {
  	//获取关键字
  	$keys=I("keywords");
  	$this->assign("key",$keys);
  	if($keys!="")
  	{
  		$m=M("group");
  		//模糊查询条件
  			
  		$map['title']=array('like',"%$keys%");
  		//$map['master_nickname']=array('like',"%$keys%");
  		//$map['_logic']='or';
  		$count      = $m->where($map)->count();// 查询满足要求的总记录数
  		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
  		//分页跳转的时候保证查询条件
  
  		foreach($map as $key=>$val) {
  			$Page->parameter[$key]   =   urlencode($val);
  		}
  
  		$show       = $Page->show();// 分页显示输出
  		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
  		$list = $m->where($map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
  		//dump($list);die;
  		// 分页
  		$this->assign('list',$list);// 赋值数据集
  		$this->assign('page',$show);// 赋值分页输出
  		$this->display('GroupList'); // 输出模板
  
  
  	}
  	else
  	{
  		$this->GroupList();
  	}
  }
  
  
  
  //添加用户组
  public function addGroup()
  {
  	   	if(IS_POST)
  	{
  		$m=M("group");
  		$title=trim(I("title"));
  		//echo $company_name;die;
  		$resault=$m->where(array('title'=>$title))->find();
  		//dump($resault);die;
  		if(count($resault)!=0)
  		{
  			$this->error("此用户组已存在");
  		}
  		else
  		{
  			$data['title']=$title;
  			//$data['cost_expenses']=I("cost_expenses");
  			$res=$m->add($data);
  			if($res)
  			{
  				$this->success("添加成功",U('Rule/GroupList'));
  			}
  			else
  			{
  				$this->error("添加失败");
  			}
  		}
  	}
  	else
  	{
  		$this->display();
  	}
  }
  
  
  //修改用户组
  public function updateGroup()
  {
  	$m=M('group');
  		
  	if(IS_POST)
  	{
  		//$map['id']=I('uid');
  		$map['title']=trim(I("title"));
  		//$map['_logic']='and';id!=I('uid')and
  		$resault=$m->where($map)->find();
  		if(count($resault)!=0)
  		{
  			$this->error("此用户组已存在");
  		}
  		else
  		{
  			$id=I('id');
  			$data['title']=trim(I("title"));
  			$res=$m->where('id='.$id)->save($data);
  	
  			if($res)
  			{
  				$this->success("修改成功",U('Rule/GroupList'));
  			}
  			else
  			{
  				$this->error("修改失败");
  			}
  		}
  	
  	}
  	else
  	{
  		$id=I("id");
  		$list1=$m->where('id='.$id)->select();
  		//json_encode($list1);
  		$this->ajaxReturn($list1);
  		//dump($list1);
  	}
  }
  
  
  //删除用户组
  public function delGroup()
  {
  	$id=I("id");
  	$m=M("group");
  	$res=$m->where('id='.$id)->delete();
  	if($res)
  	{
  		$this->success("删除成功",U('Rule/GroupList'));
  	}
  	else
  	{
  		$this->error("删除失败");
  	}
  }
  
  
  //批量删除用户组
  public function delGroups()
  {
  	$id=I('id');
  	$ids = join(',', $id);
  	$Mcost=M("group");
  	$data = $Mcost->where(array('id' => array('in', $ids)))->delete();
  	if($data)
  	{
  		$this->success("删除成功", U('Rule/GroupList'));
  	}
  	else
  	{
  		$this->error("删除失败");
  	}
  }
  
  
  
  //-------------------------分配权限（权限————用户组）----------------------
  //分配权限（权限————用户组）
	public function RuleGroup()
	{
	if(IS_POST){
            $data=I('post.');
           
            $map=array(
                'id'=>$data['id']
                );
            $data['rules']=implode(',', $data['rule_ids']);
            //dump($data);die;
            $result=D('Group')->editData($map,$data);
            if ($result) {
                $this->success('分配权限成功',U('Rule/GroupList'));
            }else{
                $this->error('分配权限操作失败');
            }
        }else{
            $id=I('get.id');
            // 获取用户组数据
            $group_data=M('group')->where(array('id'=>$id))->find();
            $group_data['rules']=explode(',', $group_data['rules']);
            // 获取规则数据
            $rule_data=D('Rule')->getTreeData('level','id','title');
            $assign=array(
                'group_data'=>$group_data,
                'rule_data'=>$rule_data
                );
            $this->assign($assign);
            $this->display();
        }
	}  
	
	
	
	
}