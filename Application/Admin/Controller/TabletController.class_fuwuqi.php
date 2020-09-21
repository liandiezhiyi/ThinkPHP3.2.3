<?php
namespace Admin\Controller;
use Think\Controller;

use  Think\Request;
use Think\Upload;
class TabletController extends CommonController {
	//平板管理-------------------------------------------------
	
	public function index()
	{
		$this->Prcductlist();
	}
	
	//商品分类列表-----------------------------------------------
	public function productClasslist()
	{
		$m=M("classify");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display("productClasslist");
	}
	
	
	//关键词搜索
	public function classsifySearch()
	{
		//获取关键字
		$keys=I("keywords");
		$this->assign("key",$keys);
		if($keys!="")
		{
			$m=M("classify");
			//模糊查询条件
				
			$map['classify_name']=array('like',"%$keys%");
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
			$this->display('productClasslist'); // 输出模板
	
	
		}
		else
		{
			$this->productClasslist();
		}
	
	}
	
	
	//新增分类
	public function addClassify()
	{
		if(IS_POST)
	  	{
	  		$m=M("classify");
	  		$classify_name=trim(I("classify_name"));
	  		$resault=$m->where(array('classify_name'=>$classify_name))->find();
	  		if(count($resault)!=0)
	  		{
	  			$this->error("此分类已存在");
	  		}
	  		else
	  		{
	  			$data['classify_name']=$classify_name;
	  			$data['classify_info']=trim(I("classify_info"));
	  			$res=$m->add($data);
	  			if($res)
	  			{
	  				$this->success("添加成功",U('Tablet/productClasslist'));
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
	
	//修改分类
	public function updateClassify()
	{
	  	$m=M("classify");
	  	if(IS_POST)
	  	{
	  		$data['classify_name']=trim(I("classify_name"));
	  		//$data['classify_info']=trim(I("classify_info"));
	  		$data['id']=array('neq',I("uid"));
	  		$resault=$m->where($data)->select();
	  	
	  		if(count($resault)!==0 )
	  		{
	  			$this->error("此分类已存在");
	  			
	  		}
	  		else
	  		{
	  			$map['classify_name']=trim(I("classify_name"));
	  			$map['classify_info']=trim(I("classify_info"));
	  			$res=$m->where('id='.I('uid'))->save($map);
	  			//判断是否恒等 
	  			if($res!==false)
	  			{
	  				$this->success("修改成功",U('Tablet/productClasslist'));
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
	  		//页面显示 
	  		$id=I("id");
	  		$list=$m->where(array('id'=>$id))->select();
	  		$this->assign("list",$list);
	  		$this->display();
	  	}
  
	}
	
	//删除分类
	public function delClassify()
	{
		$m=M("classify");
		$id=I("id");
		$res=$m->where('id='.$id)->delete();
		if($res)
		{
			$this->success("删除成功",U('Tablet/productClasslist'));
		}
		else
		{
			$this->error("删除失败");
		}
		
	}
	
	//批理删除分类
	public function delClassifies()
	{
		$id=I('id');
	  	$ids = join(',', $id);
	  	$m=M("classify");
	  	$data = $m->where(array('id' => array('in', $ids)))->delete();
	  	if($data)
	  	{
	  		$this->success("删除成功",U('Tablet/productClasslist'));
	  	}
	  	else
	  	{
	  		$this->error("删除失败");
	  	}
	}
	
	
	
	//区域设置列表--------------------------------------------------
	public function locallist()
	{
		$m=M("local");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		foreach ($list as $val)
		{
			$classid=explode(",",$val["classify_local"]);//字符串转数组
			foreach ($classid as $key=>$v1)
			{
				$dataname[]=M("classify")->where("id=".$v1)->find();
				foreach ($dataname as $k=>$val1)
				{
					$val["c_name"][$key]=$dataname[$k]["classify_name"];
					$val["classify_name"]=implode(' ， ', $val["c_name"]);
				}
			}
			
			$datalist[]=$val;
		}
		
		$this->assign('list',$datalist);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display("locallist");
	}
	
	
	//关键词搜索
	public function localSearch()
	{
		//获取关键字
		$keys=I("keywords");
		$this->assign("key",$keys);
		if($keys!="")
		{
			$m=M("local");
			//模糊查询条件
	
			$map['local_name']=array('like',"%$keys%");
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
			foreach ($list as $val)
			{
				$classid=explode(",",$val["classify_local"]);//字符串转数组
				foreach ($classid as $key=>$v1)
				{
					$dataname[]=M("classify")->where("id=".$v1)->find();
					foreach ($dataname as $k=>$val1)
					{
						$val["c_name"][$key]=$dataname[$k]["classify_name"];
						$val["classify_name"]=implode(' ， ', $val["c_name"]);
					}
				}
				
				$datalist[]=$val;
			}
			// 分页
			$this->assign('list',$datalist);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			$this->display('locallist'); // 输出模板
	
	
		}
		else
		{
			$this->locallist();
		}
	
	}
	
	//新增区域
	public function addLocal()
	{
		$m=M("local");
		if(IS_POST)
		{	
			$local_name=trim(I("local_name"));
			$resault=$m->where(array('local_name'=>$local_name))->find();
			if(count($resault)!=0)
			{
				$this->error("此区域已存在");
			}
			else
			{
				$data['local_name']=$local_name;
				$data['local_info']=trim(I("local_info"));
				$temp_x=$_POST['question'];
				$data["classify_local"]=implode(',',$temp_x);
				
				$res=$m->add($data);
				if($res)
				{
					$this->success("添加成功",U('Tablet/locallist'));
				}
				else
				{
					$this->error("添加失败");
				}
			}
		}
		else
		{
	
			//实例化数据表
			$c=M("classify");
			$classify_localid=$c->select();	
			$this->assign("classify_localid",$classify_localid);
			
			$this->display();
			
			
		}
		
	}
	
	
	//修改区域
	public function updateLocal()
	{
		$m=M("local");
		if(IS_POST)
	  	{
	  		$data['local_name']=trim(I("local_name"));
	  		//$data['classify_info']=trim(I("classify_info"));
	  		$data['id']=array('neq',I("uid"));
	  		$resault=$m->where($data)->select();
	  		
	  		if(count($resault)!==0 )
	  		{
	  			$this->error("此区域已存在");
	  		
	  		}
	  		else
	  		{
	  			$map['local_name']=trim(I("local_name"));
	  			$map['local_info']=trim(I("local_info"));
	  			$temp_x=$_POST['question'];
	  			$map["classify_local"]=implode(',',$temp_x);

	  			$res=$m->where('id='.I('uid'))->save($map);
	  			//判断是否恒等 
	  			if($res!==false)
	  			{
	  				$this->success("修改成功",U('Tablet/locallist'));
	  			}    
	  			else
	  			{
	  				$this->error("修改失败,您未修改内容");
	  			}
	  		}
	  	}
	  	else
	  	{
	  		//页面显示 
	  		//区域
	  		$id=I("id");
	  		$list=$m->where(array('id'=>$id))->select();
	  		foreach ($list as $key=>$v)
	  		{
	  			$list[$key]["classid"]=explode(",",$v["classify_local"]);//字符串转数组
	  		}
	  		$this->assign("list",$list);
	  		//分类
	  		$c=M("classify");
	  		$classify_localid=$c->select();
	  		$this->assign("classify_localid",$classify_localid);
	  		$this->display();
	  	}
  
		
	}
	
	//删除区域
	public function delLocal()
	{
		$m=M("local");
		$id=I("id");
		$res=$m->where('id='.$id)->delete();
		if($res)
		{
			$this->success("删除成功",U('Tablet/locallist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	//批理删除区域
	public function delLocals()
	{
		$id=I('id');
		$ids = join(',', $id);
		$m=M("local");
		$data = $m->where(array('id' => array('in', $ids)))->delete();
		if($data)
		{
			$this->success("删除成功",U('Tablet/locallist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	
	//商品设置列表---------------------------------------------------
	public function Productlist()
	{
		$m=M("product");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		foreach ($list as  $key=>$val)
		{
			$classname=M("classify")->where("id=".$val['product_classify'])->find();
			//dump($classname);die;
			$list[$key]["classify_name"]=$classname["classify_name"];
			
		}
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		
		$c=M("classify");
		$classify_id=$c->select();
		$this->assign("classify_id",$classify_id);
		
		$this->display("Productlist");
	}
	
	
	//关键词搜索
	public function productSearch()
	{
		//获取关键字
		$keys=I("keywords");
		$cname=I("class_id");
	
		$c=M("classify");
		$classify_id=$c->select();
		$this->assign("classify_id",$classify_id);
		$this->assign("cname",$cname);
	
		$this->assign("key",$keys);
	
		$m=M("product");
	
		//dump($_GET);die;
		if($_GET)
		{
			//模糊查询条件
			if($keys!="" && $cname==null)
			{
				$map['product_name']=array('like',"%$keys%");
			}
			elseif($keys==null && $cname!="")
			{
				$map['product_classify']=$cname;
			}
			elseif($keys!="" && $cname!="")
			{
				$map['product_name']=array('like',"%$keys%");
				$map['product_classify']=$cname;
				$map['_logic']='and';
			}
				
			$count      = $m->where($map)->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
			//分页跳转的时候保证查询条件
	
			foreach($map as $key=>$val) {
				$Page->parameter[$key]   =   urlencode($val);
			}
	
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->where($map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			foreach ($list as  $key=>$val)
			{
				$classname=M("classify")->where("id=".$val['product_classify'])->find();
				//dump($classname);die;
				$list[$key]["classify_name"]=$classname["classify_name"];
					
			}
			$this->assign('list',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			$this->display('Productlist'); // 输出模板
	
	
		}
		else
		{
			$this->Productlist();
		}
	
	}
	
	
	//新增商品
	public function addProduct()
	{
		$m = M('product');
		if($_POST)
		{
				//上传图片
				$upload = new \Think\Upload();// 实例化上传类
				$upload->maxSize   =     3145728 ;// 设置附件上传大小
				$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','pdf');// 设置附件上传类型
				$upload->rootPath  =      './uploads/'; // 设置附件上传根目录
				$data['product_name'] = trim(I('product_name'));
				$data['product_price'] = trim(I('product_price'));
				$data['product_num'] = trim(I('product_num'));
				$data['product_info'] = trim(I('product_info'));
				
				// 上传单个文件
				$info   =   $upload->uploadOne($_FILES['upfile']);
				//判断是由哪个方法提交图片
				if(I("product_img")!=null && $info!=null )
				{
					$data['product_img'] = __ROOT__.'/uploads/'. $info['savepath'].$info['savename'];
				}
				elseif(!I("product_img") && !$info)
				{
					$this->error($upload->getError('请选择一种上传方式'));
				}
				elseif(I("product_img")!=null && $info==null)
				{
					$data['product_img'] =trim(I("product_img"));
				}
				elseif(I("product_img")==null && $info!=null)
				{
					$data['product_img'] = __ROOT__.'/uploads/'. $info['savepath'].$info['savename'];
				}
				$data['product_classify'] = trim(I('class_id'));
				// 保存当前数据对象
			
				if ($m->add($data))
				{
					$this->success("添加成功",U('Tablet/Productlist'));
				}
				else
				{
					$this->error("添加失败");
				}
		}
		else
		{
			$c=M("classify");
			$classify_id=$c->select();
			$this->assign("classify_id",$classify_id);
	
			$this->display();
		
		}
		
		
	}

	
	//修改商品
	public function updateProduct()
	{
		$m = M('product');	
		
		if($_POST)
		{			
			//上传图片
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize   =     3145728 ;// 设置附件上传大小
			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','pdf');// 设置附件上传类型
			$upload->rootPath  =      './uploads/'; // 设置附件上传根目录
			$data['product_name'] = trim(I('product_name'));
			$data['product_price'] = trim(I('product_price'));
			$data['product_num'] = trim(I('product_num'));
			$data['product_info'] = trim(I('product_info'));
		
			// 上传单个文件
			$info   =   $upload->uploadOne($_FILES['upfile']);
			//判断是由哪个方法提交图片
			if(I("product_img")!=null && $info!=null )
			{
				$data['product_img'] = __ROOT__.'/uploads/'. $info['savepath'].$info['savename'];
			}
			elseif(!I("product_img") && !$info)
			{
				$this->error($upload->getError('请选择一种上传方式'));
			}
			elseif(I("product_img")!=null && $info==null)
			{
				$data['product_img'] =trim(I("product_img"));
			}
			elseif(I("product_img")==null && $info!=null)
			{
				$data['product_img'] = __ROOT__.'/uploads/'. $info['savepath'].$info['savename'];
			}
			$data['product_classify'] = trim(I('class_id'));
			
			//删除编辑器上传的图片
			$infoimg=$m->where('id='.I('uid'))->getField('product_info');
			upimgs(htmlspecialchars_decode($infoimg), htmlspecialchars_decode($data['product_info']));
			//die;
			//删除缩略图
			$img=$m->where('id='.I('uid'))->getField('product_img');
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
				$this->success("修改成功",U('Tablet/Productlist'));
			}
			else
			{
				$this->error("修改失败");
			}
		}
		else
		{
			
			$list=$m->where('id='.I("id"))->select();
			$this->assign("list",$list);
			
			$c=M("classify");
			$classify_id=$c->select();
			$this->assign("classify_id",$classify_id);
		
			$this->display();
		
		}
	}
	
	//删除商品
	public function delProduct()
	{
		$id=I("id");
		$m=M("product");
		//删除文章内的图片
		$contentimg=$m->where('id='.$id)->getField('product_info');
		delete_img(htmlspecialchars_decode($contentimg));
		//die;
		//删除缩略图
		$img=$m->where('id='.$id)->getField('product_img');
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
			$this->success("删除成功",U('Tablet/Productlist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	//批理删除商品
	public function delProducts()
	{
		$id=I('id');
		$ids = join(',', $id);
		$m=M("product");
		
		//删除图片
		$img=$m->where(array('id' => array('in', $ids)))->select();
		foreach ($img as $key=>$val)
		{
			$imgs[]=$img[$key]["product_img"];
			$infoimg[]=$img[$key]["product_info"];
			
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
			
			$this->success("删除成功",U('Tablet/Productlist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	//编辑器上传图片
	public function uploadFile()
	{
		//图片文件的生成
		$savename = date('YmdHis',time()).mt_rand(0,9999).'.jpeg';//localResizeIMG压缩后的图片都是jpeg格式
		//生成文件夹
		//$fileName = $_FILES["file"]["name"];
		//图片保存的路径
		$savepath = 'uploads/images/'.$savename;
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
	

	//查看详情
	public function more()
	{
		$id=I("id");
		$data=M("product")->where('id='.$id)->find();
		//$this->assign("info1",$data["product_info"]);
		$this->assign("product_name",$data["product_name"]);
		$this->assign("info",htmlspecialchars_decode($data["product_info"]));
		$this->display();
	}
	
	
	
	
	

	//订单管理部份
	public function  orderlist()
	{
	
		$m=M("order");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
	
		foreach ($list as  $key=>$val)
		{
			$username=M("master")->where("id=".$val['order_user'])->find();
			//dump($classname);die;
			$list[$key]["order_user"]=$username["master_username"];
				
			$orderarea=M("local")->where("id=".$val['order_area'])->find();
			//dump($classname);die;
			$list[$key]["order_area"]=$orderarea["local_name"];
				
	
		}
	
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
	
		//限时取消订单
		$data=$m->select();
		foreach ($data as $k=>$v)
		{
			if($v["order_state"]==1)
			{
				$limttime=86400;
				$time=time();
					
				if($time-$v["order_create"]>$limttime)
				{
						
					$result = $m->where('id='.$v['id'])->setField('order_state','3');
	
				}
	
			}
				
		}
	
	
		$this->display("orderlist");
	}
	
	
	
	
	//关键词搜索
	public function orderSearch()
	{
	
		$m=M("order");
		//获取关键字
		$keys=I("keywords");
		$this->assign("key",$keys);
	
		//获取订单状态
		$state=I("state");
		//	echo $state;die;
		$this->assign("uuid",$state);
	
	
		$where["master_username"]=I("keywords");
		if($_POST)
		{
			//模糊查询条件
			if($keys!="" && I("state")==null)
			{
	
				if(substr($keys, 0,3)=="YZX")
				{
					$map['order_num']=array('like',"%$keys%");
				}else
				{
					$username=M("master")->where($where)->find();
					$map["order_user"]=$username['id'];
				}
	
	
			}
			elseif($keys==null && $state!="")
			{
				$map['order_state']=$state;
			}
			elseif($keys!="" && $state!="")
			{
				if(substr($keys, 0,3)=="YZX")
				{
					$map['order_num']=array('like',"%$keys%");
				}else
				{
					$username=M("master")->where($where)->find();
					$map["order_user"]=$username['id'];
				}
				$map['order_state']=$state;
				$map['_logic']='and';
			}
				
	
			$count      = $m->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->where($map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
				
			foreach ($list as  $key=>$val)
			{
				$username=M("master")->where("id=".$val['order_user'])->find();
				//dump($classname);die;
				$list[$key]["order_user"]=$username["master_username"];
	
				$orderarea=M("local")->where("id=".$val['order_area'])->find();
				//dump($classname);die;
				$list[$key]["order_area"]=$orderarea["local_name"];
	
					
			}
				
				
				
			$this->assign('list',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			$this->display('orderlist'); // 输出模板
	
	
		}
		else
		{
			$this->orderlist();
		}
	
	}
	
	
	
	//修改订单状态
	public function updateState()
	{
		$m=M("order");
		$where["id"]= I("id");
		$state["order_state"]=I("stateid");
		$res=$m->where($where)->setField($state);
		if($res)
		{
			$this->success("更改成功，订单已完成",U('Tablet/orderlist'));
		}
		else
		{
			$this->error("更改失败");
		}
	
	}
	
	
	
	
	//订单详情
	
	public function ordermore()
	{
		$map['ordetail_ornum']=I("order_num");
		//$id["order_num"]= I("order_num");
		$m=M("ordetail");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->where($map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($list as  $key=>$val)
		{
				
			$product_name=M("product")->where("id=".$val['ordetail_id'])->find();
			//dump($classname);die;
			$list[$key]["ordetail_id"]=$product_name["product_name"];
			$list[$key]["product_img"]=$product_name["product_img"];
				
			$id["order_num"]= $val['ordetail_ornum'];
			$order=M("order")->where($id)->find();
			$list[$key]["area"]=$order["order_sign"];
		}
	
		//dump($list);die;
		$this->assign('list',$list);// 赋值数据集
		//$this->assign('num',I("order_num"));
		$this->assign('page',$show);// 赋值分页输出
		$this->display();
	
	}
	
	
	
	
	
}