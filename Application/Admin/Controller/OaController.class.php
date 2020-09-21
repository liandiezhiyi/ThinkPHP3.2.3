<?php
namespace Admin\Controller;
use Think\Upload;
class OaController extends CommonController {
	
	public function index()
	{
		$this->oaclass();
	}
	
	//档案中心（档案分类部份）----------------------------------------------------------------
	public function oaClasseslist()
	{
		$m=M("oaclasses");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display("oaClasseslist");	
	}
		
	//档案中心（档案分类搜索部份）
	public function OaclassSearch()
	{	
		$keys=I("keywords");
		$this->assign("key",$keys);
		if($keys!="")
		{
			$m=M("oaclasses");
			//模糊查询条件
			$map['oaclasses_name']=array('like',"%$keys%");	
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
			$this->display('oaClasseslist'); // 输出模板
		}
		else
		{
			$this->oaClasseslist();
		}	
	}
	
	//档案中心（新增档案分类部份）
	public function addOaclass()
	{
		if(IS_POST)
		  	{
		  		$m=M("oaclasses");
		  		$oaclasses_name=trim(I("oaclasses_name"));
		  		//查询是存在同样的区域名称
		  		$resault=$m->where(array('oaclasses_name'=>$oaclasses_name))->find();
		  		if(count($resault)!=0)
		  		{
		  			$this->error("此分类已存在");
		  		}
		  		else
		  		{
		  			$data['oaclasses_name']=$oaclasses_name;
		  			$data['oaclasses_info']=trim(I("oaclasses_info"));
		  			//上传图片
		  			$upload = new \Think\Upload();// 实例化上传类
		  			$upload->maxSize   =     3145728 ;// 设置附件上传大小
		  			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		  			$upload->rootPath  =      './uploads/oa/'; // 设置附件上传根目录
		  			$upload->savePath  =     ''; // 设置附件上传（子）目录
		  			$upload->saveName = date('YmdHis',time()).mt_rand(0,9999);
		  			$upload->autoSub = false;//不启用自动保存在子目录
					$upload->subName = array('','');
		  			// 上传单个文件
		  			$info   =   $upload->uploadOne($_FILES['upfile']);
		  			if(!$info){// 上传错误提示错误信息
		  				$this->error($upload->getError());
		  			}
		  			else
		  			{
		  				// 上传成功 获取上传文件信息
		  				$data['oaclasses_url'] = __ROOT__.'/uploads/oa/'.$info['savename'];
		  				//dump($data);die;
		  			}		  			
		  			$res=$m->add($data);
		  			if($res)
		  			{
		  				$this->success("添加成功",U('Oa/oaClasseslist'));
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
	
	
	//档案中心（档案分类修改部份）
	public function updateOaclass()
	{
		$m = M('oaclasses');
		if($_POST)
		{
			$data['oaclasses_name']=trim(I("oaclasses_name"));
	  		$data['id']=array('neq',I("uid"));
	  		$resault=$m->where($data)->select();
	  		if(count($resault)!==0 )
	  		{
	  			$this->error("此分类已存在");
	  		
	  		}
	  		else
	  		{
	  			$data['oaclasses_name']=trim(I("oaclasses_name"));
	  			$data['oaclasses_info']=trim(I("oaclasses_info"));
	  			//上传图片
	  			$upload = new \Think\Upload();// 实例化上传类
	  			$upload->maxSize   =     3145728 ;// 设置附件上传大小
	  			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	  			$upload->rootPath  =      './uploads/oa/'; // 设置附件上传根目录
	  			$upload->savePath  =     ''; // 设置附件上传（子）目录
	  			$upload->saveName = date('YmdHis',time()).mt_rand(0,9999);
	  			$upload->autoSub = false;//不启用自动保存在子目录
	  			$upload->subName = array('','');
	  			// 上传单个文件
	  			$info   =   $upload->uploadOne($_FILES['upfile']);
	  			// 上传成功 获取上传文件信息
	  			$data['oaclasses_url'] = __ROOT__.'/uploads/oa/'.$info['savename'];
	  			if($info)
	  			{
	  				$img=$m->where('id='.I('uid'))->getField('oaclasses_url');
	  				
	  				$root = __ROOT__;
	  				if(strlen($root)>1){
	  					$img = str_replace($root,'.',$img);
	  				}
	  				if(file_exists($img))
	  				{
	  					unlink($img);
	  				}
	  				// 保存当前数据对象
	  				$res=$m->where('id='.I('uid'))->save($data);
	  			}
	  			else
	  			{
	  				//指定字段修改内容
	  				$data1 = array('oaclasses_name'=>trim(I("oaclasses_name")),'oaclasses_info'=>trim(I("oaclasses_info")));
	  				$res=$m-> where('id='.I('uid'))->setField($data1);
	  			}
	  			// 保存当前数据对象
	  			if ($res)
	  			{
	  				$this->success("修改成功",U('Oa/oaClasseslist'));
	  			}
	  			else
	  			{
	  				$this->error("修改失败");
	  			}
	  			
	  		}
		}
		else
		{
			$list=$m->where('id='.I("id"))->select();
			$this->assign("list",$list);
			$this->display();
		}
	}
	
	//档案中心（档案分类删除部份）
	public function delOaclass()
	{
		$id=I("id");
		$m=M("oaclasses");
		//删除缩略图
		$img=$m->where('id='.$id)->getField('oaclasses_url');
			$root = __ROOT__;
			if(strlen($root)>1){
				$img = str_replace($root,'.',$img);
			}
		//删除数据
		$res=$m->where('id='.$id)->delete();
		if($res)
		{
			if(file_exists($img))
			{
				unlink($img);
			}
			$this->success("删除成功",U('Oa/oaClasseslist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	//档案中心（档案分类批量删除部份）
	public function delOaclasses()
	{
		$id=I('id');
		$ids = join(',', $id);
		$m=M("oaclasses");
	
		//删除图片
		$img=$m->where(array('id' => array('in', $ids)))->select();
		foreach ($img as $key=>$val)
		{
			$imgs[]=$img[$key]["oaclasses_url"];	
				
		}
	
		//删除缩略图部份
		foreach ($imgs as $val1)
		{
				$root = __ROOT__;
				if(strlen($root)>1){
					$val1 = str_replace($root,'.',$val1);
				}
			
			$images[]=$val1;
		}
		$data = $m->where(array('id' => array('in', $ids)))->delete();
		if($data)
		{
			//判断缩略图是否存在存在就删除
			foreach ($images as $vo)
			{
				if(file_exists($vo))
				{
					unlink($vo);
				}
			}
				
			$this->success("删除成功",U('Oa/oaClasseslist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	//档案中心（文档管理部份）----------------------------------------------------------------
	
	public function oasystemlist()
	{
		$m=M("oasystem");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		
		
		
		if(I("cid")!="")
		{
			$list = $m->where('oasystem_classes='.I('cid'))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			foreach ($list as $key=>$val)
			{
				$classname=M("oaclasses")->where("id=".$val['oasystem_classes'])->find();
				$list[$key]["oaclasses_name"]=$classname["oaclasses_name"];	
				$list[$key]["oaclasses_id"]=$classname["id"];
				$username=M("master")->where("id=".$val['oasystem_user'])->find();
				$list[$key]["oaclasses_user"]=$username["master_username"];
			}
			
		}else
		{
			//echo 2;die;
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->distinct ( true )->group("oasystem_classes")->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			foreach ($list as $key=>$val)
			{
				$classname=M("oaclasses")->where("id=".$val['oasystem_classes'])->find();
				$list[$key]["oaclasses_name"]=$classname["oaclasses_name"];
				$list[$key]["oaclasses_url"]=$classname["oaclasses_url"];
				$list[$key]["oaclasses_id"]=$classname["id"];
			}
		}
		$this->assign('url',$list[$key]["oaclasses_url"]);// 赋值数据集
		$this->assign('cid',I("cid"));// 赋值数据集
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display("oasystemlist");	
	}
	
	
	
	//文档搜索
	public function OasystemSearch(){
		$curl=I("curl");
		$keys=I("keywords");
		$this->assign("key",$keys);
		$m=M("oasystem");
		if($curl=="")
		{
			if($keys)
			{
				//模糊查询条件
				$m=M("oasystem");
				$map['oasystem_name']=array('like',"%$keys%");
				$map['oasystem_classes']=I("cid");
				$count      = $m->where($map)->count();// 查询满足要求的总记录数
				$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
				//分页跳转的时候保证查询条件
				
				foreach($map as $key=>$val) {
					$Page->parameter[$key]   =   urlencode($val);
				}
				$show       = $Page->show();// 分页显示输出
				
				$list = $m->where($map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
				foreach ($list as $key=>$val)
				{
					$classname=M("oaclasses")->where("id=".$val['oasystem_classes'])->find();
					$list[$key]["oaclasses_name"]=$classname["oaclasses_name"];	
					$list[$key]["oaclasses_id"]=$classname["id"];
					$username=M("master")->where("id=".$val['oasystem_user'])->find();
					$list[$key]["oaclasses_user"]=$username["master_username"];
				}
	
			}
			else
			{
			
				$count      = $m->count();// 查询满足要求的总记录数
				$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
				$show       = $Page->show();// 分页显示输出
				$list = $m->where('oasystem_classes='.I('cid'))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
				foreach ($list as $key=>$val)
				{
					$classname=M("oaclasses")->where("id=".$val['oasystem_classes'])->find();
					$list[$key]["oaclasses_name"]=$classname["oaclasses_name"];	
					$list[$key]["oaclasses_id"]=$classname["id"];
					$username=M("master")->where("id=".$val['oasystem_user'])->find();
					$list[$key]["oaclasses_user"]=$username["master_username"];
				}
				
			
			}
			
		}
		else
		{
			//分类列表
			if($keys)
			{
				$m=M("oaclasses");
				$map['oaclasses_name']=array('like',"%$keys%");
				$count      = $m->where($map)->count();// 查询满足要求的总记录数
				$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
				//分页跳转的时候保证查询条件
				
				foreach($map as $key=>$val) {
					$Page->parameter[$key]   =   urlencode($val);
				}
				$show       = $Page->show();// 分页显示输出
				// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
				$data = $m->order('id desc')->where($map)->select();
					foreach ($data as $val)
					{
						$classname=M("oasystem")->distinct ( true )->group("oasystem_classes")->order('id desc')->where(array('oasystem_classes'=>$val['id']))->select();							
								foreach ($classname as $val1){
									
									$list[] = $m->where(array('id'=>$val1['oasystem_classes']))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->find();
									foreach ($list as $key=>$li){
										$list[$key]['oaclasses_id']=$li['id'];
									}
								}
					} 
				
					if(!$list)
					{
						$this->assign("url","未匹配到数据！");
						$this->display("oasystemlist");return;
					}
					
			}
			else
			{
				$list = $m->distinct ( true )->group("oasystem_classes")->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
				foreach ($list as $key=>$val)
				{
					$classname=M("oaclasses")->where("id=".$val['oasystem_classes'])->find();
					$list[$key]["oaclasses_name"]=$classname["oaclasses_name"];
					$list[$key]["oaclasses_url"]=$classname["oaclasses_url"];
					$list[$key]["oaclasses_id"]=$classname["id"];
					
				}
			}
		
		}
		
		$this->assign('url',$list[$key]["oaclasses_url"]);// 赋值数据集
		$this->assign('cid',I('cid'));// 赋值数据集
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display("oasystemlist");
		
	}
	
	//新增文档
	public function  addOasystem()
	{
		$m=M("oasystem");
		//文件上传
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('xls', 'doc', 'txt', 'pdf');// 设置附件上传类型
		$upload->rootPath  =      './uploads/oa/file/'; // 设置附件上传根目录
		$upload->savePath  =     ''; // 设置附件上传（子）目录
		$upload->saveName = date('YmdHis',time()).mt_rand(0,9999);
		$upload->autoSub = false;//不启用自动保存在子目录
		$upload->subName = array('','');
		if($_POST)
		{
			 $data["oasystem_name"]=trim(I("oasystem_name"));
			 $data["oasystem_content"]=trim(I("oasystem_content"));
			 $data["oasystem_user"]=$_SESSION["uid"];
			 // 上传单个文件
			 $info   =   $upload->uploadOne($_FILES['upfile']);
			 if($info)
			 {
			 	$data['oasystem_url'] = __ROOT__.'/uploads/oa/file/'.$info['savename'];
			 }
			 else
			 {
			 	$data['oasystem_url']="";
			 }
			
			 $data["oasystem_classes"]=I("class_id");
			 $data["oasystem_noticestate"]=I("state");
			 if($data["oasystem_noticestate"]==0)
			 {
			 	$data["oasystem_noticetime"]=time();
			 }else
			 {
			 	$data["oasystem_noticetime"]="";
			 }
			
			$res=$m->add($data);
		  	if($res)
		  	{
		  		//$this->success("添加成功",U('Oa/oasystemlist'));
		  		$count      = $m->count();// 查询满足要求的总记录数
		  		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		  		$show       = $Page->show();// 分页显示输出
		  		
		  		$list = $m->where('oasystem_classes='.I('class_id'))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		  		foreach ($list as $key=>$val)
		  		{
		  			$classname=M("oaclasses")->where("id=".$val['oasystem_classes'])->find();
		  			$list[$key]["oaclasses_name"]=$classname["oaclasses_name"];
		  			$list[$key]["oaclasses_id"]=$classname["id"];
		  			$username=M("master")->where("id=".$val['oasystem_user'])->find();
		  			$list[$key]["oaclasses_user"]=$username["master_username"];
		  		}
		  		
		  		$this->assign("list",$list);
		  		$this->assign('url','');// 赋值数据集
		  		$this->display("oasystemlist");
		  	}
		  	else
		  	{
		  		$this->error("添加失败");
		  	}
			 
		
		}
		else
		{
			$list = M("oaclasses")->select();
			$this->assign('list',$list);// 赋值数据集
			$this->display();
		}
		
	}
	

	
	//修改文档（文档管理部份）
	public function updateOasystem()
	{
		$m=M("oasystem");
		//文件上传
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('xls', 'doc', 'txt', 'pdf');// 设置附件上传类型
		$upload->rootPath  =      './uploads/oa/file/'; // 设置附件上传根目录
		$upload->savePath  =     ''; // 设置附件上传（子）目录
		$upload->saveName = date('YmdHis',time()).mt_rand(0,9999);
		$upload->autoSub = false;//不启用自动保存在子目录
		$upload->subName = array('','');
		if($_POST)
		{
			$data["oasystem_name"]=trim(I("oasystem_name"));
			$data["oasystem_content"]=trim(I("oasystem_content"));
			$data["oasystem_user"]=$_SESSION["uid"];
			// 上传单个文件
			$info   =   $upload->uploadOne($_FILES['upfile']);
			if($info)
			{
				$data['oasystem_url'] = __ROOT__.'/uploads/oa/file/'.$info['savename'];
			}
			else
			{
				$urlimg=$m->where('id='.I('uid'))->getField('oasystem_url');
				$data['oasystem_url']=$urlimg;
			}
				
			$data["oasystem_classes"]=I("class_id");
			$data["oasystem_noticestate"]=I("state");
			if($data["oasystem_noticestate"]==0)
			{
				$data["oasystem_noticetime"]=time();
			}else
			{
				$data["oasystem_noticetime"]="";
			}
			//删除编辑器上传的图片
			$infoimg=$m->where('id='.I('uid'))->getField('oasystem_content');
			upimgs(htmlspecialchars_decode($infoimg), htmlspecialchars_decode($data['oasystem_content']));
			
			//删除缩略图
			$img=$m->where('id='.I('uid'))->getField('oasystem_url');
			
				$root = __ROOT__;
				if(strlen($root)>1){
					$img = str_replace($root,'.',$img);
				}
		
			//$image=I('oasystem_url');
			if(!empty($info))
			{
				if(file_exists($img))
				{
					unlink($img);
				}
			}
			
			
			$res=$m->where('id='.I('uid'))->save($data);
			if($res)
			{
				//$this->success("添加成功",U('Oa/oasystemlist'));
				$count      = $m->count();// 查询满足要求的总记录数
				$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
				$show       = $Page->show();// 分页显示输出
			
				$list = $m->where('oasystem_classes='.I('class_id'))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
				foreach ($list as $key=>$val)
				{
					$classname=M("oaclasses")->where("id=".$val['oasystem_classes'])->find();
					$list[$key]["oaclasses_name"]=$classname["oaclasses_name"];
					$list[$key]["oaclasses_id"]=$classname["id"];
					$username=M("master")->where("id=".$val['oasystem_user'])->find();
					$list[$key]["oaclasses_user"]=$username["master_username"];
				}
			
				$this->assign("list",$list);
				$this->assign('url','');// 赋值数据集
				$this->display("oasystemlist");
			}
			else
			{
				$this->error("修改失败");
			}
		}
		else
		{
			$list=$m->where('id='.I('id'))->select();
			$this->assign("list",$list);
			$cname=M("oaclasses")->select();
			$this->assign("cname",$cname);
			$this->display();
		}
	}
	
	
	//删除文档（文档管理部份）
	public  function  delOasystem()
	{
		$id=I("id");
		$m=M("oasystem");
		//删除文章内的图片
		$contentimg=$m->where('id='.$id)->getField('oasystem_content');
		delete_img(htmlspecialchars_decode($contentimg));
		//删除缩略图
		$img=$m->where('id='.$id)->getField('oasystem_url');
		
			$root = __ROOT__;
			if(strlen($root)>1){
				$img = str_replace($root,'.',$img);
			}
		//删除数据
		$res=$m->where('id='.$id)->delete();
		if($res)
		{						
			if(file_exists($img))
			{
				unlink($img);
			}
			//
			$count      = $m->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
			$show       = $Page->show();// 分页显示输出
			
			$list = $m->where('oasystem_classes='.I('classid'))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			foreach ($list as $key=>$val)
			{
				$classname=M("oaclasses")->where("id=".$val['oasystem_classes'])->find();
				$list[$key]["oaclasses_name"]=$classname["oaclasses_name"];
				$list[$key]["oaclasses_id"]=$classname["id"];
				$username=M("master")->where("id=".$val['oasystem_user'])->find();
				$list[$key]["oaclasses_user"]=$username["master_username"];
			}
			$this->assign("list",$list);
			$this->assign('url',$list[$key]["oaclasses_url"]);// 赋值数据集
			$this->display("oasystemlist");
			
			//$this->success("删除成功");
			
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	//档案中心（文档批量删除部份）
	public function delOasystems()
	{
		$id=I('id');
		$ids = join(',', $id);
		$m=M("oasystem");
		//删除图片
		$img=$m->where(array('id' => array('in', $ids)))->select();
		
		foreach ($img as $key=>$val)
		{
			$imgs[]=$img[$key]["oasystem_url"];
			$infoimg[]=$img[$key]["oasystem_content"];
			
		}
		//删除编辑器上的图片
		foreach ($infoimg as $info)
		{
			//删除编辑器上的图片的方法
			delete_img(htmlspecialchars_decode($info));
		}
		
			//删除缩略图部份
		foreach ($imgs as $val1)
		{
				$root = __ROOT__;
				if(strlen($root)>1){
					$val1 = str_replace($root,'.',$val1);
				}
			$images[]=$val1;
		}
		$data = $m->where(array('id' => array('in', $ids)))->delete();
		
		if($data)
		{
			//判断缩略图是否存在存在就删除
			foreach ($images as $vo)
			{
				if(file_exists($vo))
				{
					unlink($vo);
				}
			}
			
			//$this->success("删除成功");
			$count      = $m->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
			$show       = $Page->show();// 分页显示输出
				
			$list = $m->where('oasystem_classes='.I('classid'))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			foreach ($list as $key=>$val)
			{
				$classname=M("oaclasses")->where("id=".$val['oasystem_classes'])->find();
				$list[$key]["oaclasses_name"]=$classname["oaclasses_name"];
				$list[$key]["oaclasses_id"]=$classname["id"];
				$username=M("master")->where("id=".$val['oasystem_user'])->find();
				$list[$key]["oaclasses_user"]=$username["master_username"];
			}
			$this->assign("list",$list);
			$this->assign('url',$list[$key]["oaclasses_url"]);// 赋值数据集
			$this->display("oasystemlist");
			
			
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	//更多详情（通知）
	public  function moredetail()
	{
		$m=M('oasystem');
		if(I("id"))
		{
			$id=I("id");
			
			$data=$m->where('id='.$id)->find();
			//$this->assign("info1",$data["product_info"]);
			$this->assign("oasystem_name",$data["oasystem_name"]);
			$this->assign("oasystem_content",htmlspecialchars_decode($data["oasystem_content"]));
			$this->assign("oasystem_url",$data["oasystem_url"]);
			$this->assign("id",$id);
		}
		
		//通知部份
		if(I("id") && I("classid"))
		{
			//echo I('id').'--'.I('classid');die;
			//指定字段修改内容
			$data = array('oasystem_noticetime'=>time(),'oasystem_noticestate'=>'0');
	  		$res=$m-> where('id='.I('id'))->setField($data);
	  		if($res)
	  		{
	  			
	  			$count      = $m->count();// 查询满足要求的总记录数
	  			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
	  			$show       = $Page->show();// 分页显示输出
	  			
	  			$list = $m->where('oasystem_classes='.I('classid'))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
	  			foreach ($list as $key=>$val)
	  			{
	  				$classname=M("oaclasses")->where("id=".$val['oasystem_classes'])->find();
	  				$list[$key]["oaclasses_name"]=$classname["oaclasses_name"];
	  				$list[$key]["oaclasses_id"]=$classname["id"];
	  				$username=M("master")->where("id=".$val['oasystem_user'])->find();
	  				$list[$key]["oaclasses_user"]=$username["master_username"];
	  			}
	  			$this->assign("list",$list);
	  			$this->assign('url',$list[$key]["oaclasses_url"]);// 赋值数据集
	  			$this->display("oasystemlist");
	  		
	  		}else
	  		{
	  			$this->error("通知未成功");
	  		}
		}
		$this->display();
	}
	
	
	//档案中心（历史通知）====================================================================================
	public function historynoticlist()
	{
		$m=M("notice");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($list as $key=>$val)
		{
			$oasystem_name=M("oasystem")->where("id=".$val['oasystem_id'])->find();
			$list[$key]["oasystem_name"]=$oasystem_name["oasystem_name"];
			$oaclasses_name=M("oaclasses")->where("id=".$val['oaclass_id'])->find();
			$list[$key]["oaclasses_name"]=$oaclasses_name["oaclasses_name"];
			$master_name=M("master")->where("id=".$val['master_checkuser'])->find();
			$list[$key]["master_checkuser"]=$master_name["master_username"];
		}
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出	

		$c=M("oaclasses");
		$classify_id=$c->select();
		$this->assign("classify_id",$classify_id);
		
		$this->display("historynoticlist");	
	}
	
	
	//通知关键字搜索
	public function NoticfySearch()
	{
		//获取关键字
		//	$keys=I("keywords");
		//$this->assign("key",$keys);
		$cname=I("class_id");
		
		$c=M("oaclasses");
		$classify_id=$c->select();
		$this->assign("classify_id",$classify_id);
		$this->assign("cname",$cname);
		if($_POST)
		{
			$m=M("notice");
			$count      = $m->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			if($cname)
			{
				$list = $m->where("oaclass_id=".$cname)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			}
			else
			{
				$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			}
			foreach ($list as $key=>$val)
			{
				$oasystem_name=M("oasystem")->where("id=".$val['oasystem_id'])->find();
				$list[$key]["oasystem_name"]=$oasystem_name["oasystem_name"];
				$oaclasses_name=M("oaclasses")->where("id=".$val['oaclass_id'])->find();
				$list[$key]["oaclasses_name"]=$oaclasses_name["oaclasses_name"];
				$master_name=M("master")->where("id=".$val['master_checkuser'])->find();
				$list[$key]["master_checkuser"]=$master_name["master_username"];
			}
			$this->assign('list',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			$this->display("historynoticlist");
		}
		else
		{
			$this->historynoticlist();
		}
	}
	
	
	
	//查看通知
	public function checkNotify()
	{
		if($_GET)
		{
			
			$idarr=explode(",", I("id"));
			if(sizeof($idarr)!=1)
			{
				
				foreach ($idarr as $va)
				{
					$dataoasystem[]=M("oasystem")->where("id=".$va)->order('id desc')->find();
				}
				$this->assign('list',$dataoasystem);
				$this->display();
			}
			else
			{
				$datadetail=M("oasystem")->where("id=".I("id"))->find();
				$dataT["oasystem_id"]=$datadetail["id"];
				$dataT["oaclass_id"]=$datadetail["oasystem_classes"];
				$dataT["master_checkuser"]=$_SESSION["uid"];
				$dataT["create_time"]=time();
				if($dataT)
				{
					M("notice")->add($dataT);
				}
				$this->assign("oasystem_name",$datadetail["oasystem_name"]);
				$this->assign("oasystem_content",htmlspecialchars_decode($datadetail["oasystem_content"]));
				$this->assign("oasystem_url",$datadetail["oasystem_url"]);
				$this->display("moredetail");
			}
		}
		else
		{
			$where["oasystem_noticestate"]=0;
			$data=M("oasystem")->where($where)->order('id desc')->select();
			foreach ($data as $key=>$val){
				
					$map["oasystem_id"]=$val["id"];
					$map["master_checkuser"]=$_SESSION["uid"];
					$map["_logic"]='and';
					$list=M("notice")->where($map)->select();
						
					if(!$list)
					{
						$id[]=$val['id'];
					}
			}	
			$datalist["oasystem_id"]=implode(",", $id);
			//$datalist["master_checkuser"]=$_SESSION["uid"];
			$datalist["count"]=count($id);
			$this->ajaxReturn($datalist);
		}	
	}
	
	
	//档案中心（删除历史通知）
	public function delhistorynotice()
	{
		$m=M("notice");
		$id=I("id");
		$res=$m->where('id='.$id)->delete();
		if($res)
		{
			$this->success("删除成功",U('oa/historynoticlist'));
		}
		else
		{
			$this->error("删除失败");
		}
	
	}
	
	
	//档案中心（批量删除历史通知）
	public function delhistorynotices()
	{
		$id=I('id');
		$ids = join(',', $id);
		$m=M("notice");
		$res = $m->where(array('id' => array('in', $ids)))->delete();
		if($res)
		{
			$this->success("删除成功",U('oa/historynoticlist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	
	//档案中心（历史通知）====================================================================================
	
	
	
	
	
	
	//档案中心（实例发展）====================================================================================
	public function historylist()
	{
		$m=M("history");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
	
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display("historylist");
	}
	
	
	
	//关键词搜索
	public function historySearch()
	{
		//获取关键字
		$keys=I("keywords");
		$this->assign("key",$keys);
		if($keys!="")
		{
			$m=M("history");
			//模糊查询条件
	
			$map['history_title']=array('like',"%$keys%");
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
	
			$this->assign('list',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			$this->display('historylist'); // 输出模板
	
	
		}
		else
		{
			$this->historylist();
		}
	
	}
	
	
	//新增发展历史
	public function addhistory()
	{
		$m = M('history');
		if($_POST)
		{
			//上传图片
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','pdf');// 设置附件上传类型
			$upload->rootPath  =      './uploads/'; // 设置附件上传根目录
			$data['history_title'] = trim(I('history_title'));
			$data['history_des'] = trim(I('history_des'));
			$data['history_content'] = trim(I('history_content'));
			$data['history_time']=time();
	
			// 上传单个文件
			$info   =   $upload->uploadOne($_FILES['upfile']);
			//判断是由哪个方法提交图片
			if(I("product_img")!=null && $info!=null )
			{
				$data['history_url'] = __ROOT__.'/uploads/'. $info['savepath'].$info['savename'];
			}
			elseif(!I("product_img") && !$info)
			{
				$this->error($upload->getError('请选择一种上传方式'));
			}
			elseif(I("product_img")!=null && $info==null)
			{
				$data['history_url'] =trim(I("product_img"));
			}
			elseif(I("product_img")==null && $info!=null)
			{
				$data['history_url'] = __ROOT__.'/uploads/'. $info['savepath'].$info['savename'];
			}
	
			// 保存当前数据对象
	
	
			if ($m->add($data))
			{
				$this->success("添加成功",U('Oa/historylist'));
			}
			else
			{
				$this->error("添加失败");
			}
		}else{
			$this->display();
		}
	
	
	}
	
	
	//修改发展历史
	public function updatehistory()
	{
		$m = M('history');
		if($_POST)
		{
			//上传图片
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','pdf');// 设置附件上传类型
			$upload->rootPath  =      './uploads/'; // 设置附件上传根目录
			$data['history_title'] = trim(I('history_title'));
			$data['history_des'] = trim(I('history_des'));
			$data['history_content'] = trim(I('history_content'));
			$data['history_time']=time();
	
			// 上传单个文件
			$info   =   $upload->uploadOne($_FILES['upfile']);
			//判断是由哪个方法提交图片
			if(I("product_img")!=null && $info!=null )
			{
				$data['history_url'] = __ROOT__.'/uploads/'. $info['savepath'].$info['savename'];
			}
			elseif(!I("product_img") && !$info)
			{
				$this->error($upload->getError('请选择一种上传方式'));
			}
			elseif(I("product_img")!=null && $info==null)
			{
				$data['history_url'] =trim(I("product_img"));
			}
			elseif(I("product_img")==null && $info!=null)
			{
				$data['history_url'] = __ROOT__.'/uploads/'. $info['savepath'].$info['savename'];
			}
	
			//删除编辑器上传的图片
			$infoimg=$m->where('id='.I('uid'))->getField('history_content');
			upimgs(htmlspecialchars_decode($infoimg), htmlspecialchars_decode($data['product_info']));
			//die;
			//删除缩略图
			$img=$m->where('id='.I('uid'))->getField('history_url');
			if(stripos($img,'http:') || stripos($img,'https:')== false)
			{
				$img='.'.$img;
			}
			$image=I('product_img');
			if(!empty($info))
			{
				if(file_exists($img))
				{
					unlink($img);
				}
			}
			// 保存当前数据对象
			$res=$m->where('id='.I('uid'))->save($data);
			// 保存当前数据对象
			if ($res)
			{
				$this->success("修改成功",U('Oa/historylist'));
			}
			else
			{
				$this->error("修改失败");
			}
	
		}
		else
		{
	
			$list=$m->where('id='.I("id"))->select();			
			$this->assign("history",$list);
			$this->display();
	
		}
	}
	
	
	//删除历史
	public function delhistory()
	{
		$id=I("id");
		$m=M("history");
		//删除文章内的图片
		$contentimg=$m->where('id='.$id)->getField('history_content');
		delete_img(htmlspecialchars_decode($contentimg));
		//die;
		//删除缩略图
		$img=$m->where('id='.$id)->getField('history_url');
		//dump($img);die;
		if(stripos($img,'http:') || stripos($img,'https:')== false)
		{
	
			$img='.'.$img;
	
		}
		//删除数据
		$res=$m->where('id='.$id)->delete();
		if($res)
		{
			if(file_exists($img))
			{
	
				unlink($img);
			}
			$this->success("删除成功",U('Oa/historylist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	//批理删除历史
	public function delhistorys()
	{
		$id=I('id');
		$ids = join(',', $id);
		$m=M("history");
	
		//删除图片
		$img=$m->where(array('id' => array('in', $ids)))->select();
		foreach ($img as $key=>$val)
		{
			$imgs[]=$img[$key]["history_url"];
			$infoimg[]=$img[$key]["history_content"];
	
		}
		//删除编辑器上的图片
		foreach ($infoimg as $info)
		{
			//删除编辑器上的图片的方法
			delete_img(htmlspecialchars_decode($info));
		}
	
		//删除缩略图部份
		foreach ($imgs as $val1)
		{
	
			if(stripos($val1,'http:') || stripos($val1,'https:')== false)
			{
				$val1='.'.$val1;
	
			}
			$images[]=$val1;
		}
	
		$data = $m->where(array('id' => array('in', $ids)))->delete();
		if($data)
		{
			//判断缩略图是否存在存在就删除
			foreach ($images as $vo)
			{
				if(file_exists($vo))
				{
					unlink($vo);
				}
			}
	
			$this->success("删除成功",U('Oa/historylist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	
	//查看详情
	public function more()
	{
		$id=I("id");
		$data=M("history")->where('id='.$id)->find();
		$this->assign("info",htmlspecialchars_decode($data["history_content"]));
		$this->assign("title",$data["history_title"]);
		$this->assign("time",$data["history_time"]);
		$this->display();
	}
	
	
	//档案中心（实例发展）====================================================================================
	
	
	
	
	//编辑器上传图片
	public function uploadFile()
	{
		//图片文件的生成
		$savename = date('YmdHis',time()).mt_rand(0,9999).'.jpeg';//localResizeIMG压缩后的图片都是jpeg格式
		//生成文件夹
		//$fileName = $_FILES["file"]["name"];
		//图片保存的路径
		$savepath = 'uploads/oa/'.$savename;
		//生成一个URL获取图片的地址
		$url = __ROOT__.'/'.$savepath;
		//返回数据。wangeditor3 需要用到的数据 json格式的
		$data["errno"] = 0;
		$data["data"] = $savepath;
		$data['url'] = "{$url}";
		//可有可无的一段，也就是图片文件移动。
		move_uploaded_file($_FILES["file"]["tmp_name"],$savepath);
		//返回数据
		echo json_encode($data);
	
	}

	
	
	
}