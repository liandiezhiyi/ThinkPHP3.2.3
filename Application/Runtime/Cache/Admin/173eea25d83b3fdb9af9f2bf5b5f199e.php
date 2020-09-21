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


	
  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 关系设置列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o " href="<?php echo U('Basic/addRelationshipList');?>"   data-reveal-id="myModal"> 新增关系</a> </li>
        <li>搜索：</li>  
        <form action="<?php echo U('Basic/RelationshipSearch');?>" method="GET">
	        <li>
	          <input type="text" placeholder="关系" name="keywords" value="<?php echo ($key); ?>" class="input" style="width:250px; line-height:17px;display:inline-block" />
	          <button  class="button border-main icon-search"  > 搜索</button>
	        </li>
     </form>  
      </ul>
    </div>
    <form action="<?php echo U('Basic/delRelationships');?>" method="POST" id="listform">
    <table class="table table-hover text-center">
      <tr>
        <th width="100" style="text-align:left; padding-left:20px;">ID</th>
        <th width="10%">关系名称</th>
            
        <th width="310">操作</th>
      </tr>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" />
           <?php echo ($vo["id"]); ?></td>
          <td><?php echo ($vo["relationship_name"]); ?></td>
                  
          
          <td><div class="button-group"> <a data-reveal-id="myModal1" class="moduser button border-main" href="<?php echo U('Basic/updateRelationship',array('id'=>$vo['id']));?>"><span class="icon-edit"></span> 修改</a> <a class="button border-red" href="<?php echo U('Basic/delRelationship',array('id'=>$vo['id']));?>"" onclick="return del(1,1,1)"><span class="icon-trash-o"></span> 删除</a> </div></td>
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
    </form>
    
    
    	
  </div>

<script type="text/javascript">
//弹框修改数据部份
$('.moduser').click(function(){
	//  var id=$(this).attr('href');
    $.get($(this).attr('href'),function(data){
    	$(".name").attr("value",data[0]['relationship_name'])
    	$(".id").attr("value",data[0]['id'])
    	//alert(data[0]['company_name']);
    	
    });
//return false;
});

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

<!-- 新增 -->
<div id="myModal" class="reveal-modal">


	<form method="post"  class="form-x" action="<?php echo U('Basic/addRelationship');?>">

      <label>关系名称：</label> <input type="text"  style="width:50%; font-size: 14px;padding: 10px;border: solid 1px #ddd;line-height: 20px;
    /* display: block; */border-radius: 3px;-webkit-appearance: none;"  value=""  name="name" data-validate="required:请输入证明单位名称" />
              <button  style=" padding: 10px 30px;    border-color: #0ae;    color: #fff;       line-height: 20px; background-color: #0ae;border: solid 1px #ddd;    border-radius: 4px;    font-size: 14px;"  type="submit"> 提交</button>
           
    </form> 
    

</div>
<!-- 新增 -->

<!-- 修改 -->
<div id="myModal1" class="reveal-modal">
	<form method="post"  class="form-x" action="<?php echo U('Basic/updateRelationship');?>">
	
<input type="hidden" name="uid" class="id" value=""/>
      <label>死亡原因：</label> <input type="text" class="name"  style="width:50%; font-size: 14px;padding: 10px;border: solid 1px #ddd;line-height: 20px;
    /* display: block; */border-radius: 3px;-webkit-appearance: none;"  value=""  name="relationship_name" data-validate="required:请输入证明单位名称" />
           
              <button  style=" padding: 10px 30px;    border-color: #0ae;    color: #fff;       line-height: 20px; background-color: #0ae;border: solid 1px #ddd;    border-radius: 4px;    font-size: 14px;"  type="submit"> 提交</button>
           
    </form> 
    
</div>

<!-- 修改 -->
</body>
</html>