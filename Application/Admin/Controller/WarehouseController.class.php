<?php
namespace Admin\Controller;
class WarehouseController extends CommonController {
	
	//仓库管理部份-------------------------------------------------------------------
	public function index()
	{
		//调用仓库物品管理的方法
		$this->WarehouseProductlist();
	}
	
	
	//区域管理部份-------------------------------------------------------------------
	public function WarehouseClasslist()
	{
		$m=M("warehouseclass");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display("WarehouseClasslist");
	
	}
	
	//区域管理(关键词搜索)
	public function WarehouseClassSearch()
	{
		//获取关键字
		$keys=I("keywords");
		$this->assign("key",$keys);
		if($keys!="")
		{
			$m=M("warehouseclass");
			//模糊查询条件
			$map['warehouseclass_name']=array('like',"%$keys%");	
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
			$this->display('WarehouseClasslist'); // 输出模板
		
		
		}
		else
		{
			$this->WarehouseClasslist();
		}
		
	}
	
	
	
	//区域管理(新增区域)
	public function addWarehouseClass()
	{
		if(IS_POST)
		  	{
		  		$m=M("warehouseclass");
		  		$warehouseclass_name=trim(I("warehouseclass_name"));
		  		//查询是存在同样的区域名称
		  		$resault=$m->where(array('warehouseclass_name'=>$warehouseclass_name))->find();
		  		if(count($resault)!=0)
		  		{
		  			$this->error("此区域已存在");
		  		}
		  		else
		  		{
		  			$data['warehouseclass_name']=$warehouseclass_name;
		  			$data['warehouseclass_info']=trim(I("warehouseclass_info"));
		  			$res=$m->add($data);
		  			if($res)
		  			{
		  				$this->success("添加成功",U('Warehouse/WarehouseClasslist'));
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
	
	
	//区域管理（修改区域）
	public function updateWarehouseClass()
	{
		$m=M("warehouseclass");
		if(IS_POST)
		{
			$data['warehouseclass_name']=trim(I("warehouseclass_name"));
			$data['id']=array('neq',I("uid"));
			$resault=$m->where($data)->select();
		
			if(count($resault)!==0 )
			{
				$this->error("此分类已存在");
		
			}
			else
			{
				$map['warehouseclass_name']=trim(I("warehouseclass_name"));
				$map['warehouseclass_info']=trim(I("warehouseclass_info"));
				$res=$m->where('id='.I('uid'))->save($map);
				//判断是否恒等
				if($res!==false)
				{
					$this->success("修改成功",U('Warehouse/WarehouseClasslist'));
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
			$id=I("id");
			$list=$m->where(array('id'=>$id))->select();
			$this->assign("list",$list);
			$this->display();
		}
		
	}
	
	
	//区域管理（删除区域）
	public function delWarehouseClass()
	{
		$m=M("warehouseclass");
		$id=I("id");
		$res=$m->where('id='.$id)->delete();
		if($res)
		{
			$this->success("删除成功",U('Warehouse/WarehouseClasslist'));
		}
		else
		{
			$this->error("删除失败");
		}
	
	}
	
	
	//区域管理（批理删除区域）
	public function delWarehouseClasses()
	{
		$id=I('id');
		$ids = join(',', $id);
		$m=M("warehouseclass");
		$data = $m->where(array('id' => array('in', $ids)))->delete();
		if($data)
		{
			$this->success("删除成功",U('Warehouse/WarehouseClasslist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	
	
	
	//供应商管理部份------------------------------------------------------------------
	public function SupplierList()
	{
		$m=M("supplier");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display("SupplierList");
	}
	
	
	//供应商管理(关键词搜索)
	public function SupplierSearch()
	{
		//获取关键字
		$keys=I("keywords");
		$this->assign("key",$keys);
		if($keys!="")
		{
			$m=M("supplier");
			//模糊查询条件
			$map['supplier_name']=array('like',"%$keys%");
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
			$this->display('SupplierList'); // 输出模板
	
	
		}
		else
		{
			$this->SupplierList();
		}
	
	}
	
	
	//供应商管理(新增供应商)
	public function addSupplier()
	{
		if(IS_POST)
		{
			$m=M("supplier");
			$supplier_name=trim(I("supplier_name"));
			//查询是存在同样的供应商名称
			$resault=$m->where(array('supplier_name'=>$supplier_name))->find();
			if(count($resault)!=0)
			{
				$this->error("此供应商已存在");
			}
			else
			{
				$data['supplier_name']=$supplier_name;
				$data['supplier_phone']=trim(I("supplier_phone"));
				$data['supplier_info']=trim(I("supplier_info"));
				$res=$m->add($data);
				if($res)
				{
					$this->success("添加成功",U('Warehouse/SupplierList'));
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
	

	//供应商管理（修改供应商）
	public  function updateSupplier()
	{
		$m=M("supplier");
		if(IS_POST)
		{
			$data['supplier_name']=trim(I("supplier_name"));
			$data['id']=array('neq',I("uid"));
			$resault=$m->where($data)->select();
			if(count($resault)!==0 )
			{
				$this->error("此供应商已存在");
			}
			else
			{
				$map['supplier_name']=trim(I("supplier_name"));
				$map['supplier_phone']=trim(I("supplier_phone"));
				$map['supplier_info']=trim(I("supplier_info"));
				$res=$m->where('id='.I('uid'))->save($map);
				//判断是否恒等
				if($res!==false)
				{
					$this->success("修改成功",U('Warehouse/SupplierList'));
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
			$id=I("id");
			$list=$m->where(array('id'=>$id))->select();
			$this->assign("list",$list);
			$this->display();
		}
	}
	
	
	
	
	
	//供应商管理（删除供应商）
	public function delSupplier()
	{
		$m=M("supplier");
		$id=I("id");
		$res=$m->where('id='.$id)->delete();
		if($res)
		{
			$this->success("删除成功",U('Warehouse/SupplierList'));
		}
		else
		{
			$this->error("删除失败");
		}
	
	}
	
	
	//供应商管理（批理删除供应商）
	public function delSuppliers()
	{
		$id=I('id');
		$ids = join(',', $id);
		$m=M("supplier");
		$data = $m->where(array('id' => array('in', $ids)))->delete();
		if($data)
		{
			$this->success("删除成功",U('Warehouse/SupplierList'));
		}
		else
		{
			$this->error("删除失败");
		}
	}
	
	
	
	//仓库物品管理部份----------------------------------------------------------------
	public function WarehouseProductlist()
	{
		$m=M("warehouseproduct");
		$count      = $m->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($list as $key=>$val)
		{
			$warehouseclassname=M("warehouseclass")->where("id=".$val['warehouseproduct_class'])->find();
			$list[$key]["warehouseproduct_class"]=$warehouseclassname["warehouseclass_name"];
			
			$suppliername=M("supplier")->where("id=".$val['warehouseproduct_supplier'])->find();
			$list[$key]["warehouseproduct_supplier"]=$suppliername["supplier_name"];
		}
		
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		
		//区域下拉框
		$warehouseclass=M("warehouseclass")->select();
		$this->assign("warehouseclass",$warehouseclass);
		
		//供应商下拉框
		$supplier=M("supplier")->select();
		$this->assign("supplier",$supplier);
		
		$this->display("WarehouseProductlist");
	}	
	
	
	//仓库物品管理(关键词搜索)
	public function WarehouseProductSearch()
	{
		//获取关键字(输入框)
		$keys=I("keywords");
		
		//区域下拉框
		$warehouseclass=M("warehouseclass")->select();
		$this->assign("warehouseclass",$warehouseclass);
		$this->assign("warehouseclassname",I("class"));
		
		//供应商下拉框
		$supplier=M("supplier")->select();
		$this->assign("supplier",$supplier);
		$this->assign("suppliername",I("supplier"));
		
		$this->assign("key",$keys);
	
		if($_GET)
		{
			$m=M("warehouseproduct");
			//模糊查询条件
			//$map['warehouseproduct_name']=array('like',"%$keys%");
			
			//模糊查询条件
			if($keys!="" && I("class")==null && I("supplier")==null)
			{
				$map['warehouseproduct_name']=array('like',"%$keys%");
			}
			
			elseif($keys==null && I("class")!="" && I("supplier")==null)
			{
				$map['warehouseproduct_class']=I("class");
			}
			
			elseif($keys==null && I("class")==null && I("supplier")!="")
			{
				$map['warehouseproduct_supplier']=I("supplier");
			}
			
			elseif($keys!="" && I("class")!="" && I("supplier")==null)
			{
				$map['warehouseproduct_name']=array('like',"%$keys%");
				$map['warehouseproduct_class']=I("class");
				$map['_logic']='and';
			}
			
			elseif($keys!="" && I("class")==null && I("supplier")!="")
			{
				$map['warehouseproduct_name']=array('like',"%$keys%");
				$map['warehouseproduct_supplier']=I("supplier");
				$map['_logic']='and';
			}
			
			elseif($keys==null && I("class")!="" && I("supplier")!="")
			{	
				$map['warehouseproduct_class']=I("class");
				$map['warehouseproduct_supplier']=I("supplier");
				$map['_logic']='and';
			}
			
			elseif($keys!="" && I("class")!="" && I("supplier")!="")
			{
				$map['warehouseproduct_name']=array('like',"%$keys%");
				$map['warehouseproduct_class']=I("class");
				$map['warehouseproduct_supplier']=I("supplier");
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
			foreach ($list as $key=>$val)
			{
				$warehouseclassname=M("warehouseclass")->where("id=".$val['warehouseproduct_class'])->find();
				$list[$key]["warehouseproduct_class"]=$warehouseclassname["warehouseclass_name"];
				
				$suppliername=M("supplier")->where("id=".$val['warehouseproduct_supplier'])->find();
				$list[$key]["warehouseproduct_supplier"]=$suppliername["supplier_name"];
			}
			// 分页
			$this->assign('list',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			$this->display('WarehouseProductlist'); // 输出模板
	
	
		}
		else
		{
			$this->WarehouseProductlist();
		}
	
	}
	
	
	//仓库物品管理(新增仓库物品)
	public function addWarehouseProduct()
	{
		if(IS_POST)
		{
			$m=M("warehouseproduct");
			$warehouseproduct_name=trim(I("warehouseproduct_name"));
			//查询是存在同样的供应商名称
			$resault=$m->where(array('warehouseproduct_name'=>$warehouseproduct_name))->find();
			if(count($resault)!=0)
			{
				$this->error("此物品已存在");
			}
			else
			{
				$data['warehouseproduct_name']=$warehouseproduct_name;
				$data['warehouseproduct_class']=I("class");
				$data['warehouseproduct_supplier']=I("supplier");
				$data['warehouseproduct_num']=trim(I("warehouseproduct_num"));
				$res=$m->add($data);
				if($res)
				{
					$this->success("添加成功",U('Warehouse/WarehouseProductlist'));
				}
				else
				{
					$this->error("添加失败");
				}
			}
		}
		else
		{
			
			$class=M("warehouseclass")->select();
			$supplier=M("supplier")->select();
			$this->assign("class",$class);
			$this->assign("supplier",$supplier);
			$this->display();
		}
	}
	
	
	//仓库物品管理(修改仓库物品)
	public function updateWarehouseProduct()
	{
		
		$m=M("warehouseproduct");
		if(IS_POST)
		{
			$data['warehouseproduct_name']=trim(I("warehouseproduct_name"));
			$data['id']=array('neq',I("uid"));
			$resault=$m->where($data)->select();
			if(count($resault)!==0 )
			{
				$this->error("此物品已存在");
			}
			else
			{
				$map['warehouseproduct_name']=trim(I("warehouseproduct_name"));
				$map['warehouseproduct_class']=I("class");
				$map['warehouseproduct_supplier']=I("supplier");
				$map['warehouseproduct_num']=trim(I("warehouseproduct_num"));
				$res=$m->where('id='.I('uid'))->save($map);
				//判断是否恒等
				if($res!==false)
				{
					$this->success("修改成功",U('Warehouse/WarehouseProductlist'));
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
			$id=I("id");
			$list=$m->where(array('id'=>$id))->select();
			$this->assign("list",$list);
			
			$class=M("warehouseclass")->select();
			$supplier=M("supplier")->select();
			$this->assign("class",$class);
			$this->assign("supplier",$supplier);
			
			$this->display();
		}

		
	}
	
	
	
	//仓库物品管理（删除仓库物品）
	public function delWarehouseProduct()
	{
		$m=M("warehouseproduct");
		$id=I("id");
		$res=$m->where('id='.$id)->delete();
		if($res)
		{
			$this->success("删除成功",U('Warehouse/WarehouseProductlist'));
		}
		else
		{
			$this->error("删除失败");
		}
	
	}
	
	
	//仓库物品管理（批理删除仓库物品）
	public function delWarehouseProducts()
	{
		$id=I('id');
		$ids = join(',', $id);
		$m=M("warehouseproduct");
		$data = $m->where(array('id' => array('in', $ids)))->delete();
		if($data)
		{
			$this->success("删除成功",U('Warehouse/WarehouseProductlist'));
		}
		else
		{
			$this->error("删除失败");
		}
	}

	
	
}