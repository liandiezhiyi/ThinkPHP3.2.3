<?php
namespace Admin\Controller;
class BasicController extends CommonController {
		
	
	//业务管理------------------------------------------------
	
	public function index()
	{
		$this->CostList();
	}
	
	//收费项目列表
  public function CostList()
  {
  	$Mcost=M("Cost");
  	$count      = $Mcost->count();// 查询满足要求的总记录数
  	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
  	$show       = $Page->show();// 分页显示输出
  	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
  	$list = $Mcost->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
  	$this->assign('Costlist',$list);// 赋值数据集
  	$this->assign('page',$show);// 赋值分页输出
  	$this->display("Costlist"); // 输出模板
  }
  
  //关键词搜索
  public function CostSearch()
  {
  	//获取关键字
  	$keys=I("keywords");
  	$this->assign("key",$keys);
  	if($keys!="")
  	{
  		$Mcost=M("cost");
  		//模糊查询条件
  		 
  		$map['cost_name']=array('like',"%$keys%");
  		//$map['master_nickname']=array('like',"%$keys%");
  		//$map['_logic']='or';
  		$count      = $Mcost->where($map)->count();// 查询满足要求的总记录数
  		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
  		//分页跳转的时候保证查询条件
  
  		foreach($map as $key=>$val) {
  			$Page->parameter[$key]   =   urlencode($val);
  		}
  
  		$show       = $Page->show();// 分页显示输出
  		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
  		$list = $Mcost->where($map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
  		//dump($list);die;
  		// 分页
  		$this->assign('Costlist',$list);// 赋值数据集
  		$this->assign('page',$show);// 赋值分页输出
  		$this->display('Costlist'); // 输出模板
  
  
  	}
  	else
  	{
  		$this->Costlist();
  	}

  }
  
  //新增收费信息
  public function addCost()
  {
  	if(IS_POST)
  	{
  		$Mcost=M("cost");
  		$cost_name=trim(I("cost_name"));
  		$resault=$Mcost->where(array('cost_name'=>$cost_name))->find();
  		if(count($resault)!=0)
  		{
  			$this->error("此收费项目已存在");
  		}
  		else
  		{
  			$data['cost_name']=$cost_name;
  			$data['cost_expenses']=trim(I("cost_expenses"));
  			$res=$Mcost->add($data);
  			if($res)
  			{
  				$this->success("添加成功",U('Basic/CostList'));
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
  
  //修改收费信息
  public function updateCost()
  {
  	$Mcost=M("cost");
  //	$cost_name=I("cost_name");
  	if(IS_POST)
  	{
  		
  		$data['cost_name']=trim(I("cost_name"));
  		$data['id']=array('neq',I("uid"));
  	
  		//$data['cost_expenses']=trim(I("cost_expenses"));
  		$resault=$Mcost->where($data)->select();
  	
  		if(count($resault)!==0 )
  		{
  			$this->error("此收费项目已存在");
  			
  		}
  		else
  		{
  			$map['cost_name']=trim(I("cost_name"));
  			$map['cost_expenses']=trim(I("cost_expenses"));
  			$res=$Mcost->where('id='.I('uid'))->save($map);
  			//判断是否恒等 
  			if($res!==false)
  			{
  				$this->success("修改成功",U('Basic/CostList'));
  			}    
  			else
  			{
  				$this->error("修改失败,您未修改内容");
  			}
  		}
  		
  		//$data['master_username']=$master_username;
  	}
  	else
  	{
  		$id=I("id");
  		$costlist=$Mcost->where(array('id'=>$id))->select();
  		$this->assign("costlist",$costlist);
  		$this->display();
  	}
  
  	
  }
  
  
  
  //删除收费项目
  public function delCost()
  {
  	
  	$Mcost=M("cost");
  	$id=I("id");
  	$res=$Mcost->where('id='.$id)->delete();
  	if($res)
  	{
  		$this->success("删除成功",U('Basic/CostList'));
  	}
  	else
  	{
  		$this->error("删除失败");
  	}
  	 
  }
  
  //批量删除收费项目
  public function delCosts()
  {
  	$id=I('id');
  	$ids = join(',', $id);
  	$Mcost=M("cost");
  	$data = $Mcost->where(array('id' => array('in', $ids)))->delete();
  	if($data)
  	{
  		$this->success("删除成功", U('Basic/CostList'));
  	}
  	else
  	{
  		$this->error("删除失败");
  	}
  }
  
  
  //证明单位（列表）
  public function Companylist()
  {
  
  		$m=M("company");
  		$count      = $m->count();// 查询满足要求的总记录数
  		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
  		$show       = $Page->show();// 分页显示输出
  		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
  		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
  		$this->assign('list',$list);// 赋值数据集
  		$this->assign('page',$show);// 赋值分页输出
  	
  		$this->display("Companylist"); // 输出模板
  	
  	
  }
  
  
  //关键词搜索(证明单位)
  public function CompanySearch()
  {
  	//获取关键字
  	$keys=I("keywords");
  	$this->assign("key",$keys);
  	if($keys!="")
  	{
  		$m=M("company");
  		//模糊查询条件
  			
  		$map['company_name']=array('like',"%$keys%");
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
  		$this->display('Companylist'); // 输出模板
  		
  
  
  	}
  	else
  	{
  		$this->Companylist();
  	}
  }
  
  
  
  //新增证明单位
  public function addCompany()
  {
  	if(IS_POST)
  	{
  		$m=M("company");
  		$company_name=trim(I("company_name"));
  		//echo $company_name;die;
  		$resault=$m->where(array('company_name'=>$company_name))->find();
  		//dump($resault);die;
  		if(count($resault)!=0)
  		{
  			$this->error("此单位已存在");
  		}
  		else
  		{
  			$data['company_name']=$company_name;
  			//$data['cost_expenses']=I("cost_expenses");
  			$res=$m->add($data);
  			if($res)
  			{
  				$this->success("添加成功",U('Basic/CompanyList'));
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
  
  
  
  //修改证明单位
  public function updateCompany()
  {	
  	
  	$m=M('company');
  	
  	if(IS_POST)
  	{
  		//$map['id']=I('uid');
  		$map['company_name']=trim(I("company_name"));
  		//$map['_logic']='and';id!=I('uid')and
  		$resault=$m->where($map)->find();
  		if(count($resault)!=0)
  		{
  			$this->error("此单位已存在");
  		}
  		else
  		{
  			$uid=I('uid');
  			$data['company_name']=trim(I("company_name"));
  			$res=$m->where('id='.$uid)->save($data);
  		
  			if($res)
  			{
  				$this->success("修改成功",U('Basic/CompanyList'));
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
  		json_encode($list1);
  		$this->ajaxReturn($list1);
  		//dump($list1);
  	}
  }
  
  //删除证明单位 
  public function delCompany()
  {
  	$id=I("id");
  	$m=M("company");
  	$res=$m->where('id='.$id)->delete();
  	if($res)
  	{
  		//$this->ajaxReturn($data);
  		$this->success("删除成功",U('Basic/CompanyList'));
  	}
  	else
  	{
  		$this->error("删除失败");
  	}
  
  }
  
  //批量删除证明单位 
  public function delCompanies()
  {
  	$id=I('id');
  	$ids = join(',', $id);
  	$Mcost=M("company");
  	$data = $Mcost->where(array('id' => array('in', $ids)))->delete();
  	if($data)
  	{
  		$this->success("删除成功", U('Basic/CompanyList'));
  	}
  	else
  	{
  		$this->error("删除失败");
  	}
  }
  
  
  //死亡原因列表
  public function DresonList()
  {
  	$m=M("dreson");
  	$count      = $m->count();// 查询满足要求的总记录数
  	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
  	$show       = $Page->show();// 分页显示输出
  	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
  	$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
  	$this->assign('list',$list);// 赋值数据集
  	$this->assign('page',$show);// 赋值分页输出
  	$this->display("DresonList"); // 输出模板
  }
  
  //关键词搜索(死亡原因)
  public function DresonSearch()
  {
  	//获取关键字
  	$keys=I("keywords");
  	$this->assign("key",$keys);
  	if($keys!="")
  	{
  		$m=M("dreson");
  		//模糊查询条件
  			
  		$map['dreson_name']=array('like',"%$keys%");
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
  		$this->display('DresonList'); // 输出模板
  
  
  	}
  	else
  	{
  		$this->DresonList();
  	}
  }
  
  
  
  //删除死亡原因
  public function delDreson()
  {
  	$id=I("id");
  	$m=M("dreson");
  	$res=$m->where('id='.$id)->delete();
  	if($res)
  	{
  		$this->success("删除成功",U('Basic/DresonList'));
  	}
  	else
  	{
  		$this->error("删除失败");
  	}
  
  }
  
  //批量删除死亡原因
  public function delDresons()
  {
  	$id=I('id');
  	$ids = join(',', $id);
  	$Mcost=M("dreson");
  	$data = $Mcost->where(array('id' => array('in', $ids)))->delete();
  	if($data)
  	{
  		$this->success("删除成功", U('Basic/DresonList'));
  	}
  	else
  	{
  		$this->error("删除失败");
  	}
  }
  
  //新增死亡原因
  public function addDreson()
  {
  	if(IS_POST)
  	{
  		$m=M("dreson");
  		$dreson_name=trim(I("name"));
  		//echo $company_name;die;
  		$resault=$m->where(array('dreson_name'=>$dreson_name))->find();
  		//dump($resault);die;
  		if(count($resault)!=0)
  		{
  			$this->error("此原因已存在");
  		}
  		else
  		{
  			$data['dreson_name']=$dreson_name;
  			//$data['cost_expenses']=I("cost_expenses");
  			$res=$m->add($data);
  			if($res)
  			{
  				$this->success("添加成功",U('Basic/DresonList'));
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
  
  
  //修改死亡原因
 public function  updateDreson()
 {
 	$m=M('dreson');
 	 
 	if(IS_POST)
 	{
 		//$map['id']=I('uid');
 		$map['dreson_name']=trim(I("dreson_name"));
 		//$map['_logic']='and';id!=I('uid')and
 		$resault=$m->where($map)->find();
 		if(count($resault)!=0)
 		{
 			$this->error("此原因已存在");
 		}
 		else
 		{
 			$uid=I('uid');
 			$data['dreson_name']=trim(I("dreson_name"));
 			$res=$m->where('id='.$uid)->save($data);
 	
 			if($res)
 			{
 				$this->success("修改成功",U('Basic/DresonList'));
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
 		json_encode($list1);
 		$this->ajaxReturn($list1);
 		//dump($list1);
 	}
 	
 	
 }
  
  
  
  
  //关系设置列表
  public function RelationshipList()
  {
  	$m=M("relationship");
  	$count      = $m->count();// 查询满足要求的总记录数
  	$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
  	$show       = $Page->show();// 分页显示输出
  	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
  	$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
  	$this->assign('list',$list);// 赋值数据集
  	$this->assign('page',$show);// 赋值分页输出
  	$this->display("RelationshipList"); // 输出模板
  }
  
  
  //关键词搜索(关系设置)
  public function RelationshipSearch()
  {
  	//获取关键字
  	$keys=I("keywords");
  	$this->assign("key",$keys);
  	if($keys!="")
  	{
  		$m=M("relationship");
  		//模糊查询条件
  			
  		$map['relationship_name']=array('like',"%$keys%");
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
  		$this->display('RelationshipList'); // 输出模板
  
  
  	}
  	else
  	{
  		$this->RelationshipList();
  	}
  }
  
  
  //删除关系
  public function delRelationship()
  {
  	$id=I("id");
  	$m=M("relationship");
  	$res=$m->where('id='.$id)->delete();
  	if($res)
  	{
  		$this->success("删除成功",U('Basic/RelationshipList'));
  	}
  	else
  	{
  		$this->error("删除失败");
  	}
  
  }
  
  //批量删除关系
  public function delRelationships()
  {
  	$id=I('id');
  	$ids = join(',', $id);
  	$Mcost=M("relationship");
  	$data = $Mcost->where(array('id' => array('in', $ids)))->delete();
  	if($data)
  	{
  		$this->success("删除成功", U('Basic/RelationshipList'));
  	}
  	else
  	{
  		$this->error("删除失败");
  	}
  }
  
  //新增关系
  public function addRelationship()
  {
  	if(IS_POST)
  	{
  		$m=M("relationship");
  		$relationship_name=trim(I("name"));
  		//echo $company_name;die;
  		$resault=$m->where(array('relationship_name'=>$relationship_name))->find();
  		//dump($resault);die;
  		if(count($resault)!=0)
  		{
  			$this->error("此关系已存在");
  		}
  		else
  		{
  			$data['relationship_name']=$relationship_name;
  			//$data['cost_expenses']=I("cost_expenses");
  			$res=$m->add($data);
  			if($res)
  			{
  				$this->success("添加成功",U('Basic/RelationshipList'));
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
  
  //修改关系
  public function updateRelationship()
  {
  	$m=M('relationship');
  		
  	if(IS_POST)
  	{
  		//$map['id']=I('uid');
  		$map['relationship_name']=trim(I("relationship_name"));
  		//$map['_logic']='and';id!=I('uid')and
  		$resault=$m->where($map)->find();
  		if(count($resault)!=0)
  		{
  			$this->error("此关系已存在");
  		}
  		else
  		{
  			$uid=I('uid');
  			$data['relationship_name']=trim(I("relationship_name"));
  			$res=$m->where('id='.$uid)->save($data);
  	
  			if($res)
  			{
  				$this->success("修改成功",U('Basic/RelationshipList'));
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
  		json_encode($list1);
  		$this->ajaxReturn($list1);
  		//dump($list1);
  	}
  }
  
  
  
}