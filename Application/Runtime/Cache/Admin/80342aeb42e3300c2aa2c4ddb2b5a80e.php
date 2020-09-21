<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="/Public/index/css/product_pintuer.css">
<link rel="stylesheet" href="/Public/index/css/admin.css">

<link rel="stylesheet" href="/Public/index/jumbotron-narrow.css">

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
		  if (data != ''  && data.count!=0) {
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


 
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>编辑分类</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="<?php echo U('Oa/updateOaclass');?>" enctype="multipart/form-data">  
 	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="hidden" name="uid" value="<?php echo ($vo["id"]); ?>">
      <div class="form-group">
        <div class="label">
          <label>分类名称：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="<?php echo ($vo["oaclasses_name"]); ?>"  name="oaclasses_name" data-validate="required:请输入分类名称" />
          <div class="tips"></div>
        </div>
      </div>
      
       <div class="form-group">
        <div class="label">
          <label>分类图标：</label>
        </div>
        <div class="field">
         <dd  class="mselector">
        <input type="file" id="file" name="upfile" accept="image/gif,image/pdf,image/jpeg,image/jpg,image/png"   multiple>
         <button class="btn btn-lg btn-info btnimg" type="button" style="margin-top:-10px; margin-left:10px;" >上传图片</button>
          <span id="em"></span>
          <span style="color:red">如无需修改图标，则不上传</span>
          </dd>
        </div>
      </div>   
  
      
      <div class="form-group">
        <div class="label">
          <label>备注：</label>
        </div>
        <div class="field">
         <input type="text" class="input w50" value="<?php echo ($vo["oaclasses_info"]); ?>" name="oaclasses_info"  />
        </div>
      </div><?php endforeach; endif; else: echo "" ;endif; ?>  
      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
$("input[type='file']").change(function(e) {
	
	var imagename=document.getElementById('file').files[0].name
	$("#em").html(imagename);
});
</script>

</body></html>