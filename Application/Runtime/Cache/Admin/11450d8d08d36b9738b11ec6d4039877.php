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


	

<script type="text/javascript" src="/bysystem/Public/EasyUI/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/bysystem/Public/EasyUI/js/chosen.jquery.js"></script>

<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>新增仓库物品</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" onsubmit=" return ss()" action="<?php echo U('Warehouse/addWarehouseProduct');?>">  
 
      <div class="form-group">
        <div class="label">
          <label>物品名称：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value=""  name="warehouseproduct_name" data-validate="required:请输物品名称" />        
        </div>
      </div>
      
      
      	<div class="form-group">
	        <div class="label">
	          <label>所属区域：</label>
	        </div>
	        <div class="field">
	        			 <select name="class" onblur="ss()" id="class"  class="input w50 "  >
							<option value="0" selected="selected">请选择</option>
	                        	<?php if(is_array($class)): $i = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["warehouseclass_name"]); ?>   </option><?php endforeach; endif; else: echo "" ;endif; ?>
	                        </select> 
	                        <span id="span1" style="color:#ee3333; margin-left:30px;  line-height: 2.5rem;"></span>
	        </div>
       </div> 
      
      
      	<div class="form-group">
	        <div class="label">
	          <label>供应商：</label>
	        </div>
	        <div class="field">
	        			 <select name="supplier"  onblur="ss()" id="supplier"  class="input w50 "  >
							<option value="0" selected="selected">请选择</option>
	                        	<?php if(is_array($supplier)): $i = 0; $__LIST__ = $supplier;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vs["id"]); ?>"><?php echo ($vs["supplier_name"]); ?>   </option><?php endforeach; endif; else: echo "" ;endif; ?>
	                        </select> 
	                        <span id="span2" style="color:#ee3333; margin-left:30px;  line-height: 2.5rem;"></span>
	        </div>
       </div> 
      
      
 
      
      <div class="form-group">
        <div class="label">
          <label>数量：</label>
        </div>
        <div class="field">
         <input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" class="input w50" value="" name="warehouseproduct_num"  data-validate="required:请输物品数量" />
        </div>
      </div>     
      
        
      
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

<script type="text/javascript">
function ss()
{
	var slt = $("select[name='class']").val();
	if(slt==0)
	{
		$("#span1").html("请选择区域");
		return false;
		
	}
	else{
		$("#span1").html("");
		
		
	}
	
	
	var supplier = $("select[name='supplier']").val();
	if(supplier==0)
	{
		$("#span2").html("请选择供应商");
		return false;
	}
	else
	{
		$("#span2").html("");
	}

	return true;
	
}
	


</script>

	<script type="text/javascript">
		$('.form-control-chosen').chosen({
		  allow_single_deselect: true,
		  width: '100%'
		});
		$('.form-control-chosen-required').chosen({
		  allow_single_deselect: false,
		  width: '100%'
		});
		$('.form-control-chosen-search-threshold-100').chosen({
		  allow_single_deselect: true,
		  disable_search_threshold: 100,
		  width: '100%'
		});
		$('.form-control-chosen-optgroup').chosen({
		  width: '100%'
		});

		$(function() {
		  $('[title="clickable_optgroup"]').addClass('chosen-container-optgroup-clickable');
		});
		$(document).on('click', '[title="clickable_optgroup"] .group-result', function() {
		  var unselected = $(this).nextUntil('.group-result').not('.result-selected');
		  if(unselected.length) {
		    unselected.trigger('mouseup');
		  } else {
		    $(this).nextUntil('.group-result').each(function() {
		      $('a.search-choice-close[data-option-array-index="' + $(this).data('option-array-index') + '"]').trigger('click');
		    });
		  }
		});
	</script>
</body></html>