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
    <div class="panel-head"><strong class="icon-reorder"> 权限管理</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o " href="<?php echo U('Rule/AddRule');?>"   data-reveal-id="myModal"> 新增权限</a> </li>
       <!-- <li>搜索：</li>  
        <form action="<?php echo U('Rule/RuleSearch');?>" method="GET">
	        <li>
	          <input type="text" placeholder="证明单位" name="keywords" value="<?php echo ($key); ?>" class="input" style="width:250px; line-height:17px;display:inline-block" />
	          <button  class="button border-main icon-search"  > 搜索</button>
	        </li>
     </form>   --> 
      </ul>
    </div>
    <form action="<?php echo U('Basic/delCompanies');?>" method="POST" id="listform">

    <table class="table table-hover text-center1">
      <tr>
        <!-- <th width="100" style="text-align:left; padding-left:20px;">ID</th> -->
        <th >权限名称</th>
        <th >权限</th>  
        <th width="310">操作</th>
      </tr>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['pid'] > 0): ?><tr style="display:none"> <?php else: ?><tr><?php endif; ?>
        
          <!-- <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" />
           <?php echo ($vo["id"]); ?></td> -->
          <td width="35%" >
		<?php if($vo["pid"] == 0): ?><a class="zd" href="javascript:void(0)" style="cursor:pointer" level="<?php echo ($vo["pid"]); ?>">[+]</a><?php endif; ?>
         <a  class="zd" href="javascript:void(0)" style="cursor:pointer" level="<?php echo ($vo["pid"]); ?>"></a>
          <?php echo ($vo["_name"]); ?>
          </td>
          <td width="35%" ><?php echo ($vo["name"]); ?></td>     
          
          <td><div class="button-group"><a class="moduser1 button border-main icon-plus-square-o " pid="<?php echo ($vo['id']); ?>"  href="<?php echo U('Rule/AddRule');?>"   data-reveal-id="myModal"> 新增子权限</a>
          <a  data-reveal-id="myModal1" class="moduser button border-main" href="<?php echo U('Rule/updateRule',array('id'=>$vo['id']));?>"> <span class="icon-edit"></span> 修改</a> 
          <a class="button border-red" href="<?php echo U('Rule/delRule',array('id'=>$vo['id']));?>" onclick="return del(1,1,1)"><span class="icon-trash-o"></span> 删除</a> </div></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <!--   <tr>
        <td style="text-align:left; padding:19px 0;padding-left:20px;"><input type="checkbox" id="checkall"/>
          全选 </td>
        <td colspan="7" style="text-align:left;padding-left:20px;"> <a href="javascript:void(0)"  class="button border-red icon-trash-o" style="padding:5px 15px;" onclick="DelSelect()"> 批量删除</a>
     </td>
      </tr>-->
      <tr> 
        <td colspan="8"><div class="pagelist"><?php echo ($page); ?>  </div></td>
      </tr>
    </table>
    </form>
    	
  </div>


<script type="text/javascript">

//弹框添加子权限部分
$('.moduser1').click(function(){
	  var id=$(this).attr('pid');
    	$(".pid").attr("value",id)
    	
   // });
//return false;
});


//弹框修改权限部份
$('.moduser').click(function(){
	//var id=$(this).attr('href');
	//alert(id);return false;
    $.get($(this).attr('href'),function(data){
    	
    	//alert(data[0]['title']);
    	$("#title").attr("value",data[0]['title'])
    	$("#name").attr("value",data[0]['name'])
    	$(".id").attr("value",data[0]['id'])
    	
    	
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



//获取当前的 a 标签
$('a.zd').click(function(){

    //找到当前所在的tr
    var tr = $(this).parent().parent();
    
    //获取当前的级别level
    var cur_level = $(this).attr('level');
   //alert(cur_level);
    //获取当前a标签的内容
    var opt = $(this).html();
    //判断当前是否为[-]
    if(opt == '[-]')
    {
        //是，则在当前tr中，取出子分类并隐藏.nextAll()和preAll()获取的是兄弟节点
        tr.nextAll('tr').each(function(){
        	//再判断a标签内 level是否大于 当前cur_level值
        	if($(this).find('a.zd').attr('level') > cur_level)
        	{
        		$(this).hide();
        		//大于，则隐藏
        	}
        	else
        	{
        		return false;
        	}
        });

        $(this).html('[+]');
    }

    else
    {
    	//若当前是[+] ,则其子分类应展示
    	tr.nextAll('tr').each(function(){
    		if($(this).find('a.zd').attr('level') > cur_level)
    		{
    			$(this).show();
    			if($(this).find('a.zd').html()== '[+]')
    			{
    				return false;
    			}
    		}
    		else
			{
    			
				return false;
			}
    	});
    	$(this).html('[-]');
    }
})


</script>

<!-- 新增 -->
<div id="myModal" class="reveal-modal">


	<form method="post"  class="form-x" action="<?php echo U('Rule/AddRule');?>">
	<input type="hidden" name="pid" class='pid' value="0">
      <label>名称：</label> <input type="text"  style="width:50%; font-size: 14px;padding: 10px;border: solid 1px #ddd;line-height: 20px;
    /* display: block; */border-radius: 3px;-webkit-appearance: none;"  value=""  name="title" data-validate="required:请输入权限" />
    <br><br><label>权限：</label> <input type="text"  style="width:50%; font-size: 14px;padding: 10px;border: solid 1px #ddd;line-height: 20px;
    /* display: block; */border-radius: 3px;-webkit-appearance: none;"  value=""  name="name" data-validate="required:请输入权限" /><label>输入模块/控制器/方法即可 例如 :Admin/Rule/index</label>
            <br><br> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button  style=" padding: 10px 30px;    border-color: #0ae;    color: #fff;       line-height: 20px; background-color: #0ae;border: solid 1px #ddd;    border-radius: 4px;    font-size: 14px;"  type="submit"> 提交</button>
           
    </form> 
    

</div>
<!-- 新增 -->

<!-- 修改 -->
<div id="myModal1" class="reveal-modal">


	<form method="post"  class="form-x" action="<?php echo U('Rule/updateRule');?>">
	
<input type="hidden" name="id" class="id" value=""/>
      <label>名称：</label> <input type="text" id="title"  class="name"  style="width:50%; font-size: 14px;padding: 10px;border: solid 1px #ddd;line-height: 20px;
    /* display: block; */border-radius: 3px;-webkit-appearance: none;"  value=""  name="title" data-validate="required:请输入证明单位名称" />
           <br><br><label>权限：</label> <input type="text" id="name"  style="width:50%; font-size: 14px;padding: 10px;border: solid 1px #ddd;line-height: 20px;
    /* display: block; */border-radius: 3px;-webkit-appearance: none;"  value=""  name="name" data-validate="required:请输入权限" />
    <label>输入模块/控制器/方法即可 例如 :Admin/Rule/index</label>
            <br><br> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <button  style=" padding: 10px 30px;    border-color: #0ae;    color: #fff;       line-height: 20px; background-color: #0ae;border: solid 1px #ddd;    border-radius: 4px;    font-size: 14px;"  type="submit"> 提交</button>
           
    </form> 
    

</div>
<!-- 修改 -->
</body>
</html>