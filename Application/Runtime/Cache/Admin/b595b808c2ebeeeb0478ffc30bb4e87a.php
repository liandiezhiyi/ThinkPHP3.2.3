<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>后台管理中心</title>  
    <link rel="stylesheet" href="/Public/index/css/pintuer.css">
    <link rel="stylesheet" href="/Public/index/css/admin.css">
    <script src="/Public/index/js/jquery.js"></script> 
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
  <div class="logo margin-big-left fadein-top">
    <h1><img src="/Public/images/y.jpg" class="radius-circle rotate-hover" height="50" alt="" />后台管理中心</h1>
  </div>
  <div class="head-l"><!--  <a class="button button-little bg-green" href="" target="_blank"><span class="icon-home"></span> 前台首页</a>--> &nbsp;&nbsp;<a href="##" class="button button-little bg-blue"><span class="icon-wrench"></span> 清除缓存</a> &nbsp;&nbsp;<a class="button button-little bg-red" href="<?php echo U('Login/Logout');?>"><span class="icon-power-off"></span> 退出登录</a> &nbsp;&nbsp;<span style="color:#fff;margin-left:20px;" >当前用户：<?php echo ($_SESSION['admin']); ?></span> </div>
</div>
<div class="leftnav">
  <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
 
 <?php if(is_array($nav_data)): foreach($nav_data as $key=>$v): if(empty($v['_data'])): ?><h2><span class="icon-user"></span><?php echo ($v['title']); ?></h2>
  <?php else: ?>
   <h2><span class="icon-user"></span><?php echo ($v['title']); ?></h2>
  <ul style="display:block1">

   		<?php if(is_array($v['_data'])): foreach($v['_data'] as $key=>$n): ?><li class="<?php if((MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME) == $n['name']): ?>active<?php endif; ?>"><a href="<?php echo U($n['name']);?>" target="right"><span class="icon-caret-right"></span>  <?php echo ($n['title']); ?></a></li><?php endforeach; endif; ?>
  </ul><?php endif; endforeach; endif; ?> 
  

  
</div>

  
<script type="text/javascript">
$(function(){
  $(".leftnav h2").click(function(){
	  $(this).next().slideToggle(200);	
	  $(this).toggleClass("on"); 
  })
  $(".leftnav ul li a").click(function(){
	    $("#a_leader_txt").text($(this).text());
  		$(".leftnav ul li a").removeClass("on");
		$(this).addClass("on");
  })
});



</script>
<ul class="bread">
   <li><a href="<?php echo U('Rule/index');?>" target="right" class="icon-home"> 首页</a></li>
  <!-- <li><a href="##" id="a_leader_txt">网站信息</a></li>
  <li><b>当前语言：</b><span style="color:red;">中文</php></span>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;切换语言：<a href="##">中文</a> &nbsp;&nbsp;<a href="##">英文</a> </li>-->
</ul>
<div class="admin">
  <iframe scrolling="auto" rameborder="0" src="<?php echo U('index/welcome');?>" name="right" width="100%" height="100%"></iframe>
</div>
<div style="text-align:center;">
</div>
  


</body>
</html>