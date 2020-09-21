<?php
namespace Admin\Model;
use Think\Model;
/**
 * 权限规则model
 */
class GroupModel extends Model{

	/**
	 * 传递主键id删除数据
	 * @param  array   $map  主键id
	 * @return boolean       操作是否成功
	 */
	public function deleteData($map){
		$result=$this->where($map)->delete();
		if ($result) {
			$group_map=array(
				'group_id'=>$map['id']
			);
			// 删除关联表中的组数据
			$result=D('Access')->deleteData($group_map);
		}
		return true;
	}


	/**
	 * 修改数据
	 * @param   array   $map    where语句数组形式
	 * @param   array   $data   数据
	 * @return  boolean         操作是否成功
	 */
	public function editData($map,$data){
		// 去除键值首位空格
		foreach ($data as $k => $v) {
			$data[$k]=trim($v);
		}
		$result=$this->where($map)->save($data);
		return $result;
	}
	

}
