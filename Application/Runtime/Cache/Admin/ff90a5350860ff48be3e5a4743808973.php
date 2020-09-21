<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="/bysystem/Public/index/css/pintuer.css">
<link rel="stylesheet" href="/bysystem/Public/index/css/admin.css">
<link rel="stylesheet" href="/bysystem/Public/rulegroup/bootstrap.min.css">
<link href="/bysystem/Public/EasyUI/dist/css/component-chosen.css" rel="stylesheet">
	
	
<script src="/bysystem/Public/index/js/jquery.js"></script>
<script src="/bysystem/Public/index/js/pintuer.js"></script>
<script src="/bysystem/Public/index/js/layer.js"></script>

<link rel="stylesheet" href="/bysystem/Public/tanchuang/reveal.css">	

<script src="/bysystem/Public/tanchuang/js/jquery-1.6.2.js"></script>
<script type="text/javascript" src="/bysystem/Public/tanchuang/jquery.reveal.js"></script>
		
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


	

  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder">文档管理</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
   
   
     <?php if($url != '' ): ?><div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" href="<?php echo U('Oa/addOasystem');?>"> 新增文档</a> </li>
        <li>搜索：</li>  
        <form action="<?php echo U('Oa/OasystemSearch');?>" method="GET">
       <input type="hidden" value="<?php echo ($url); ?>" name="curl"/>
        <input type="hidden" value="<?php echo ($cid); ?>" name="cid"/>
	        <li>
	          <input type="text" placeholder="分类名称" name="keywords" value="<?php echo ($key); ?>" class="input" style="width:250px; line-height:17px;display:inline-block" />
	          <button  class="button border-main icon-search"  > 搜索</button>
	        </li>
     	</form> 
      </ul>
  
    </div>
   <?php else: ?>
   <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" href="<?php echo U('Oa/addOasystem');?>"> 新增文档</a> </li>
        <li>搜索：</li>  
        <form action="<?php echo U('Oa/OasystemSearch');?>" method="GET">
        <input type="hidden" value="<?php echo ($url); ?>" name="curl"/>
         <input type="hidden" value="<?php echo ($cid); ?>" name="cid"/>
	        <li>
	          <input type="text" placeholder="文档名称" name="keywords" value="<?php echo ($key); ?>" class="input" style="width:250px; line-height:17px;display:inline-block" />	         
	        </li>
	        
	         <button  class="button border-main icon-search"  > 搜索</button>
     	</form> 
      </ul>
  
    </div><?php endif; ?>
  
   <?php if($url != '' ): ?><div style="width:100%">
    	<ul style="list-style: none;  "> 	
    	<?php if(is_array($list)): endif; ?>
    	 <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="display: inline;line-height: 40px;float:left;margin-left: 30px; margin-bottom:20px;">
    		<div style="background-color:#079bcc; width:185px;height:150px; padding:10px; border-radius:5%;">
    			<a href="<?php echo U('Oa/oasystemlist',array('cid'=>$vo['oaclasses_id']));?>">	
    			<img style="width:100px; float:none; border:3px solid #fff;  display:block;  height:100px;margin:auto auto;  background-color:red;  border-radius:100%; " src="<?php echo ($vo["oaclasses_url"]); ?>">
    			<span style="font-size:16px; color:#fff; display:block;text-align:center;"><?php echo (msubstr($vo["oaclasses_name"],0,10,'utf-8',false)); ?></span>
    			</a>
    			
    		</div>
    		
    		</li><?php endforeach; endif; else: echo "" ;endif; ?>
    		<?php if(substr($url,0,1) != '/' ): echo ($url); endif; ?>
    		
    	</ul>
    </div>
    <?php else: ?>  
    <form action="<?php echo U('Oa/delOasystems');?>" method="POST" id="listform">
    <table class="table table-hover text-center">
      <tr>
        <th width="100" style="text-align:left; padding-left:20px;">ID</th>
        <th width="20%" >文档名称</th>       
        <th width="10%" >编辑人</th>   
        <th width="13%" >所属分类</th>  
        <th width="12%" >通知状态</th>
        <th width="12%" >通知时间</th>  
        <th width="5%" >更多</th>     
        <th width="280">操作</th>
      </tr>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="hidden" name="classid" value="<?php echo ($vo['oaclasses_id']); ?>"/>
        <tr>
          <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" />
           <?php echo ($vo["id"]); ?></td>
           <td ><?php echo ($vo["oasystem_name"]); ?></td>
  			<td ><?php echo ($vo["oaclasses_user"]); ?></td>     
  			<td ><?php echo ($vo["oaclasses_name"]); ?></td>   
  			<td ><?php if($vo['oasystem_noticestate'] == 0): ?><span style="color:gray">已通知</span><?php elseif($vo['oasystem_noticestate'] == 1): ?> <a class="button border-main" href="<?php echo U('Oa/moredetail',array('id'=>$vo['id'],'classid'=>$vo['oaclasses_id']));?>"><span ></span> 通知</a><?php endif; ?></td>   
  			<td ><?php if($vo['oasystem_noticetime'] != 0): echo (date("Y-m-d H:i:s",$vo["oasystem_noticetime"])); endif; ?></td>   
  			<td><a href="<?php echo U('Oa/moredetail',array('id'=>$vo['id']));?>"><span id="more">查看</span></a></td>
          <td><div class="button-group"><?php if($vo['oasystem_noticestate'] == 1): ?><a class="button border-main" href="<?php echo U('Oa/updateOasystem',array('id'=>$vo['id']));?>"><span class="icon-edit"></span> 修改</a><?php endif; ?> <a class="button border-red" href="<?php echo U('Oa/delOasystem',array('id'=>$vo['id'],'classid'=>$vo['oaclasses_id']));?>" onclick="return del(1,1,1)"><span class="icon-trash-o"></span> 删除</a> </div></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      <tr>
        <td style="text-align:left; padding:19px 0;padding-left:20px;"><input type="checkbox" id="checkall"/>
          全选 </td>
        <td colspan="7" style="text-align:left;padding-left:20px;"> <a href="javascript:void(0)"  class="button border-red icon-trash-o" style="padding:5px 15px;" onclick="DelSelect()"> 批量删除</a>
     </td>
      </tr>
      <tr>
        <td colspan="8"><div class="pagelist"><?php echo ($page); ?>  </div></td>
      </tr>
    </table>
    </form><?php endif; ?>
    
  </div>

<script type="text/javascript">

//搜索
function changesearch(){	
		
}

//单个删除
function del(){
	var msg="您确定要删除吗?";
	if(confirm(msg)==true){
		return true;
	}else{return false;}
}

//全选
$("#checkall").click(function(){ 
  $("input[name='id[]']").each(function(){
	  if (this.checked) {
		  this.checked = false;
	  }
	  else {
		  this.checked = true;
	  }
  });
})

//批量删除
function DelSelect(){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){
		var t=confirm("您确认要删除选中的内容吗？");
		if (t==false) return false;		
		$("#listform").submit();		
	}
	else{
		alert("请选择您要删除的内容!");
		return false;
	}
}

//批量排序
function sorts(){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){	
		
		$("#listform").submit();		
	}
	else{
		alert("请选择要操作的内容!");
		return false;
	}
}


//批量首页显示
function changeishome(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){
		
		$("#listform").submit();	
	}
	else{
		alert("请选择要操作的内容!");		
	
		return false;
	}
}

//批量推荐
function changeisvouch(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){
		
		
		$("#listform").submit();	
	}
	else{
		alert("请选择要操作的内容!");	
		
		return false;
	}
}

//批量置顶
function changeistop(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){		
		
		$("#listform").submit();	
	}
	else{
		alert("请选择要操作的内容!");		
	
		return false;
	}
}


//批量移动
function changecate(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){		
		
		$("#listform").submit();		
	}
	else{
		alert("请选择要操作的内容!");
		
		return false;
	}
}

//批量复制
function changecopy(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {		
		Checkbox=true;	
	  }
	});
	if (Checkbox){	
		var i = 0;
	    $("input[name='id[]']").each(function(){
	  		if (this.checked==true) {
				i++;
			}		
	    });
		if(i>1){ 
	    	alert("只能选择一条信息!");
			$(o).find("option:first").prop("selected","selected");
		}else{
		
			$("#listform").submit();		
		}	
	}
	else{
		alert("请选择要复制的内容!");
		$(o).find("option:first").prop("selected","selected");
		return false;
	}
}

</script>
</body>
</html>