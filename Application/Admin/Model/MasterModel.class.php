<?php
namespace Admin\Model;
use Think\Model;
/**
 * 基础model
 */
class MasterModel extends Model{
	
	/**
	 * 获取全部数据
	 * @param  string $type  tree获取树形结构 level获取层级结构
	 * @param  string $order 排序方式
	 * @return array         结构数据
	 */
	public function getTreeData($type='tree',$order='',$name='name',$child='id',$parent='pid'){
		// 判断是否需要排序
		if(empty($order)){
			$data=$this->select();
		}else{
			$data=$this->order($order.' is null,'.$order)->select();
		}
		// 获取树形或者结构数据
		if($type=='tree'){
			$data=\Org\Nx\Data::tree($data,$name,$child,$parent);
		}elseif($type="level"){
			$data=\Org\Nx\Data::channelLevel($data,0,'&nbsp;',$child);
		}
		return $data;
	}
	
	

	 // 删除数据

	public function deleteData($map){
		$count=$this
		->where(array('pid'=>$map['id']))
		->count();
		if($count!=0){
			return false;
		}
		$result=$this->where($map)->delete();
		return $result;
	}
	
	
	
	
	//添加数据
	public function addData($data){
		// 去除键值首尾的空格
		foreach ($data as $k => $v) {
			$data[$k]=trim($v);
		}
		$id=$this->add($data);
		return $id;
	}
	
	
	
	public function editData($map,$data){
		// 去除键值首位空格
		foreach ($data as $k => $v) {
			$data[$k]=trim($v);
		}
		$result=$this->where($map)->save($data);
		return $result;
	}
	
}


?>