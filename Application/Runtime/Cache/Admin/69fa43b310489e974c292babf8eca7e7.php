<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="/Public/index/css/pintuer.css">
<link rel="stylesheet" href="/Public/index/css/admin.css">
<link rel="stylesheet" href="/Public/rulegroup/bootstrap.min.css">
<link href="/Public/EasyUI/dist/css/component-chosen.css" rel="stylesheet">
	
	
<script src="/Public/index/js/jquery.js"></script>
<script src="/Public/index/js/pintuer.js"></script>
<script src="/Public/index/js/layer.js"></script>

<link rel="stylesheet" href="/Public/tanchuang/reveal.css">	

<script src="/Public/tanchuang/js/jquery-1.6.2.js"></script>
<script type="text/javascript" src="/Public/tanchuang/jquery.reveal.js"></script>
		
<style type="text/css">
	.grouptable td{ padding:0}
</style>

<style type="text/css">
#winpop {
 width:250px;
 height:0px;
 position:absolute;
 right:5px;
 top:5px;
 border:1px solid #666;
 margin:0;
 padding:1px;
 overflow:hidden;
 display:none;
}
#winpop .title1{
 width:100%;
 height:22px;
 line-height:20px;
 background:#FFCC00;
 font-weight:bold;
 text-align:center;
 font-size:12px;
}
#winpop .con1{
 width:100%;
 height:90px;
 font-weight:bold;
 font-size:14px;
 color:#FF0000;
 text-decoration:underline;
  text-align: center;
  padding-top:10px;
}
.close1{
 position:absolute;
 right:4px;
 top:-1px;
 color:#FFF;
 cursor:pointer
}
</style>
</head>
<script type="text/javascript">
function require() {
	 //var url = ;
	  $.post("<?php echo U('Oa/checkNotify');?>",function(data) {
		  
		
		  if (data!= '' && data.count!=0) {
			  tips_pop();
			  var url = "<?php echo U('Oa/checkNotify');?>?id=" + data.oasystem_id;
			  $(".con1").html('<p>您有<span style="color:blue;font-size:16px;">&nbsp;'+data.count+'&nbsp;</span>则新通知未查看</p>'+'<p><a href="'+url+'">立即查看</a></p>');
			 // alert(data.oasystem_id+'--------------'+data.master_checkuser+'---------------'+data.count);
		  }
	  });
	//  setTimeout('require()',3000);
}


function tips_pop(){
 var MsgPop=document.getElementById("winpop");
 var popH=parseInt(MsgPop.style.height);//将对象的高度转化为数字
 if(popH==0)
 {
	 MsgPop.style.display="block";//显示隐藏的窗口
	 show=setInterval("changeH('up')",2);
 }
 else
 { 
	 hide=setInterval("changeH('down')",2);
 }
}
function changeH(str){
 var MsgPop=document.getElementById("winpop");
 var popH=parseInt(MsgPop.style.height);
 if(str=="up")
 {
 	if(popH<=100)
	{
	 MsgPop.style.height=(popH+4).toString()+"px";
 	}
 	else
	{ 
		clearInterval(show);
	}
 }
 if(str=="down")
 { 
	 if(popH>=4)
 	 { 
	 	MsgPop.style.height=(popH-4).toString()+"px";
 	 }
	 else
	 { 
		clearInterval(hide); 
		MsgPop.style.display="none"; //隐藏DIV
	 }
 }
}

window.onload=function(){
 var oclose=document.getElementById("close1");
 document.getElementById('winpop').style.height='0px';
 //setTimeout("tips_pop()",3000);
 oclose.onclick=function(){tips_pop()}
 require();
}
</script>


<body>
<div id="winpop">
 <div class="title1">未查看消息通知<span class="close1" id="close1">X</span></div>
 <div class="con1"></div>
</div>


	

<!--<!DOCTYPE html>
<html>

 <head>
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />
  <link rel="stylesheet" href="/Public/css/main.css" />
  <link rel="stylesheet" href="/Public/tanchuang/css/message.css" />
  <script src="/Public/tanchuang/js/jquery-1.6.2.js"></script>
 </head>

 <body onload="javascript:return require();">
 -->
  
  <div class="admin-main">
   <blockquote class="layui-elem-quote">
    <p>管理后台</p >
        
   </blockquote>
   <fieldset class="layui-elem-field">
    <legend></legend>
    <div class="layui-field-box">
     <fieldset class="layui-elem-field layui-field-title">
      <legend>版本号:# v0.01 2016-11-20</legend>
      <div class="layui-field-box">
       <p>1、基本布局 tab + iframe</p >
       <p>2、动态添加，删除tab</p >
       <p>3、表格样式</p >
       <p>4、分页组件</p >
      </div>
     </fieldset>
    </div>
   </fieldset>
  </div>
 </body>
<!-- <script type="text/javascript">

function require1() {
	 var url = "<?php echo U('Oa/checkNotify');?>";
	  $.get(url,function(data) {
		  if (data != '') {
			  tips_pop();
			  /*$.messager.show({
					title:'未查看消息通知',
					msg:'<p style="font-size:16px;">您有<span style="color:blue">'+data.count+'</span>则通知未查看</p>',
					showType:'show',
					style:{
						left:'',
						right:0,
						top:document.body.scrollTop+document.documentElement.scrollTop,
						bottom:''
					}
				});*/
			//  alert(data.oasystem_id+'--------------'+data.master_checkuser+'---------------'+data.count);
	             // 这里写提醒的方式
	         }
		 
		  
	  });
	 
}






	</script>
	 -->
	
</html>