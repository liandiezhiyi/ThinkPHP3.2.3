<?php
namespace Admin\Controller;
use Think\Cache\Driver\Memcache;
use Think\Controller;

use  Think\Request;
use Think\Upload;
class CarController extends CommonController {

    /*
     * 车辆信息列表
     */
    public function carsystemlist(){
        $m=M("carsystem");
        $count      = $m->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach ($list as $key=> $val){
            $c=M('carclass')->where(array('id'=>$val['carsystem_class']))->field('carclass_name')->find();
            $list[$key]['carsystem_class']=$c['carclass_name'];
            $c=M('master')->where(array('id'=>$val['carsystem_master']))->field('master_username')->find();
            $list[$key]['carsystem_master']=$c['master_username'];
        }
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('carsystemlist');
    }
    /*
     * 车辆信息搜索
     */
    public function carsystemSearch()
    {
        //获取关键字
        $keys=I("keywords");
        $this->assign("key",$keys);
        if($keys!="")
        {

            $m=M("carsystem");
            //模糊查询条件

            $map['carsystem_licence']=array('like',"%$keys%");
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
            foreach ($list as $key=> $val){
                $c=M('carclass')->where(array('id'=>$val['carsystem_class']))->field('carclass_name')->find();
                $list[$key]['carsystem_class']=$c['carclass_name'];
                $c=M('master')->where(array('id'=>$val['carsystem_master']))->field('master_username')->find();
                $list[$key]['carsystem_master']=$c['master_username'];
            }
            //dump($list);die;
            // 分页
            $this->assign('list',$list);// 赋值数据集
            $this->assign('page',$show);// 赋值分页输出
            $this->display('carsystemlist'); // 输出模板



        }
        else
        {
            $this->carsystemlist();
        }
    }
    /*
     * 车辆信息添加
     */
    public function carsystemadd(){

        $m = M('carsystem');
        if($_POST)
        {
            $data['carsystem_licence']=trim(I('carsystem_licence'));
            $car=$m->where($data)->select();
            if(count($car)!=0){
                $this->error("该车牌号已存在");
            }else{
                $data['carsystem_class']=trim(I('carsystem_class_id'));
                $data['carsystem_master']=trim(I('carsystem_master_id'));

                $res=$m->add($data);

                if($res)
                {

                    $this->success("添加成功",U('Car/carsystemlist'));
                }
                else
                {
                    $this->error("添加失败");
                }
            }



        }else{
            $class=M('carclass')->select();
            $master=M('access')->where('group_id=13')->select();
            if ($master){
                foreach ($master as $val){
                    $user[]=M('master')->where('id='.$val['uid'])->select();
                }
            }else{
                $map['title']=array('like',"%车辆%");
                $groud=M('group')->where($map)->select();
                $master=M('access')->where('group_id='.$groud['id'])->select();
                if ($master) {
                    foreach ($master as $val) {
                        $user[] = M('master')->where('id=' . $val['uid'])->select();
                    }
                }

            }

            $this->assign("carsystem_class",$class);
            $this->assign("carsystem_master",$user);
            $this->display();
        }

    }
    /*
     * 修改车辆信息
     */
    public function updatecarsystem(){
        $m=M('carsystem');

        if(IS_POST)
        {
            //$map['id']=I('uid');
            $map['carsystem_licence']=trim(I("carsystem_licence"));
            $map['id']=array('neq',I("uid"));

            $resault=$m->where($map)->find();
            if(count($resault)!=0)
            {
                $this->error("车辆已存在");
            }
            else
            {
                $uid=I('uid');
                $data['carsystem_licence']=trim(I('carsystem_licence'));
                $data['carsystem_class']=trim(I('carsystem_class_id'));
                $data['carsystem_master']=trim(I('carsystem_master_id'));

                $res=$m->where(array(id=>$uid))->save($data);

                if($res!==false)
                {
                    $this->success("修改成功",U('Car/carsystemlist'));
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
            $costlist=$m->where(array('id'=>$id))->select();

            $class=M('carclass')->select();
            $master=M('access')->where('group_id=13')->select();
            if ($master){
                foreach ($master as $val){
                    $user[]=M('master')->where('id='.$val['uid'])->select();
                }
            }else{
                $map['title']=array('like',"%车辆%");
                $groud=M('group')->where($map)->select();
                $master=M('access')->where('group_id='.$groud['id'])->select();
                if ($master) {
                    foreach ($master as $val) {
                        $user[] = M('master')->where('id=' . $val['uid'])->select();
                    }
                }

            }
            $this->assign("list",$costlist);
            $this->assign("carsystem_class",$class);
            $this->assign("carsystem_master",$user);
            $this->display();
        }
    }
    /*
     * 删除车辆信息
     */
    public function delcarsystem(){

        $id=I("id");
        $m=M("carsystem");
        $res=$m->where('id='.$id)->delete();
        if($res)
        {
            //$this->ajaxReturn($data);
            $this->success("删除成功",U('Car/carsystemlist'));
        }
        else
        {
            $this->error("删除失败");
        }
    }
    /*
     * 批量删除车辆信息
     */
    public function delcarsystems(){

        $id=I('id');
        $ids = join(',', $id);
        $Mcost=M("carsystem");
        $data = $Mcost->where(array('id' => array('in', $ids)))->delete();
        if($data)
        {
            $this->success("删除成功", U('Car/carsystemlist'));
        }
        else
        {
            $this->error("删除失败");
        }
    }
    /*
     * 汽车部门列表
     */
    public function carclasslist(){
        $m=M("carclass");
        $count      = $m->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display('carclasslist');
    }
    //关键词搜索(汽车部门)
    public function carclassSearch(){

        //获取关键字
        $keys=I("keywords");
        $this->assign("key",$keys);
        if($keys!="")
        {
            $m=M("carclass");
            //模糊查询条件

            $map['carclass_name']=array('like',"%$keys%");
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
            $this->display('carclasslist'); // 输出模板



        }
        else
        {
            $this->carclasslist();
        }
    }
    /*
     * 添加汽车部门
     */
    public function carclassadd(){
        if(IS_POST)
        {
            $m=M("carclass");
            $carclass_name=trim(I("carclass_name"));
            //echo $company_name;die;
            $resault=$m->where(array('carclass_name'=>$carclass_name))->find();
            //dump($resault);die;
            if(count($resault)!=0)
            {
                $this->error("该部门已存在");
            }
            else
            {
                $data['carclass_name']=$carclass_name;
                $data['carclass_info']=trim(I("carclass_info"));
                //$data['cost_expenses']=I("cost_expenses");
                $res=$m->add($data);
                if($res)
                {
                    $this->success("添加成功",U('Car/carclasslist'));
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
    //修改汽车部门
    public function updatecarclass()
    {

        $m=M('carclass');

        if(IS_POST)
        {
            //$map['id']=I('uid');
            $map['carclass_name']=trim(I("carclass_name"));
            $map['id']=array('neq',I("pid"));
            $resault=$m->where($map)->find();
            if(count($resault)!=0)
            {
                $this->error("此部门已存在");
            }
            else
            {
                $uid=I('pid');
                $data['carclass_name']=trim(I("carclass_name"));
                $data['carclass_info']=trim(I("carclass_info"));
                $res=$m->where('id='.$uid)->save($data);

                if($res!==false)
                {
                    $this->success("修改成功",U('Car/carclasslist'));
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
    //删除汽车部门
    public function delcarclass()
    {
        $id=I("id");
        $m=M("carclass");
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
    //批量删除汽车部门
    public function delcarclassed()
    {
        $id=I('id');
        $ids = join(',', $id);
        $Mcost=M("carclass");
        $data = $Mcost->where(array('id' => array('in', $ids)))->delete();
        if($data)
        {
            $this->success("删除成功", U('Car/carclasslist'));
        }
        else
        {
            $this->error("删除失败");
        }
    }
	
}