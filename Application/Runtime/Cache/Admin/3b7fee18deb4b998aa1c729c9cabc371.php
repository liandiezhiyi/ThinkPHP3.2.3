<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="/bysystem/Public/index/css/product_pintuer.css">
<link rel="stylesheet" href="/bysystem/Public/index/css/admin.css">

<link rel="stylesheet" href="/bysystem/Public/index/jumbotron-narrow.css">

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

<script src="/bysystem/Public/wangEditor/release/wangEditor.min.js" ></script>

<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>新增文档</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" onsubmit=" return ss()"  action="<?php echo U('Oa/addOasystem');?>" enctype="multipart/form-data">  
 
 		<div class="form-group">
	        <div class="label">
	          <label>选择分类：</label>
	        </div>
	        <div class="field">
	        			 <select name="class_id"  onblur="ss()" id="class_id"  class="input w50 "  >
							<option value="0" selected="selected">请选择</option>
	                        	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["oaclasses_name"]); ?>   </option><?php endforeach; endif; else: echo "" ;endif; ?>
	                        </select> 
	                        <span id="span" style="color:#ee3333; margin-left:30px;  line-height: 2.5rem;"></span>
	        </div>
       </div> 
 
      <div class="form-group">
        <div class="label">
          <label>文档名称：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value=""  name="oasystem_name" data-validate="required:请输入分类名称" />
          <div class="tips"></div>
        </div>
      </div>
    <div class="form-group">
        <div class="label">
          <label>文档通知：</label>
        </div>
        <div class="field">
         <input type="radio" name="state" value="0"  checked/>通知 &emsp;
  		<input type="radio" name="state" value="1" />暂不通知
        <!--  <input type="text" class="input w50" value="" name="oasystem_content"  /> -->
        </div>
      </div>  
    
       <div class="form-group">
        <div class="label">
          <label>文档内容：</label>
        </div>
        <div class="field">
        
        <div style="width:85%" id="editor">   </div> 
        <textarea rows="10" cols="10" id="editor_content"  name="oasystem_content" style="display:none;"></textarea>

         <script>
        var E = window.wangEditor;
        var editor = new E('#editor');
        editor.customConfig.uploadImgServer = "<?php echo U('Oa/uploadFile');?>";  // 上传图片到服务器
        editor.customConfig.uploadFileName = "file";      //文件名称  也就是你在后台接受的 参数值
        editor.customConfig.uploadImgHeaders = {    //header头信息 
            'Accept': 'text/x-json',
        }
        // 将图片大小限制为 3M
        editor.customConfig.uploadImgMaxSize = 3 * 1024 * 1024   //默认为5M
        editor.customConfig.uploadImgShowBase64 = false;   // 使用 base64 保存图片
        // editor.customConfig.customAlert = function (info) { //自己设置alert错误信息
        //     // info 是需要提示的内容
        //     alert('自定义提示：' + '图片上传失败，请重新上传')
        // };
       // editor.customConfig.debug = true; //是否开启Debug 默认为false 建议开启 可以看到错误
        // editor.customConfig.debug = location.href.indexOf('wangeditor_debug_mode=1') > 0; // 同上 二选一
        //图片在编辑器中回显
        editor.customConfig.uploadImgHooks = {  
            error: function (xhr, editor) {
                alert("2：" + xhr + "请查看你的json格式是否正确，图片并没有上传");
                // 图片上传出错时触发  如果是这块报错 就说明文件没有上传上去，直接看自己的json信息。是否正确
                // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
            },
            fail: function (xhr, editor, result) {
				//alert(result);
                //  如果在这出现的错误 就说明图片上传成功了 但是没有回显在编辑器中，我在这做的是在原有的json 中添加了
                //  一个url的key（参数）这个参数在 customInsert也用到
                //  
                alert("1：" + xhr + "请查看你的json格式是否正确，图片上传了，但是并没有回显");
            },
            success:function(xhr, editor, result){
                //成功 不需要alert 当然你可以使用console.log 查看自己的成功json情况 
                //
				//alert(console.log(result))
                // insertImg('https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png')
            },
            customInsert: function (insertImg, result, editor) {
				//alert(result.url);
                //console.log(result);
                // 图片上传并返回结果，自定义插入图片的事件（而不是编辑器自动插入图片！！！）
                // insertImg 是插入图片的函数，editor 是编辑器对象，result 是服务器端返回的结果
                // 举例：假如上传图片成功后，服务器端返回的是 {url:'....'} 这种格式，即可这样插入图片：
                insertImg(result.url);
            }
        };
        editor.customConfig.showLinkImg = true; //是否开启网络图片，默认开启的。
        
        var editor_content = $('#editor_content');
		 editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            editor_content.val(html);
         };
        
        editor.create()
    </script>
        
        </div>
      </div>     
    
    
      
         <div class="form-group">
        <div class="label">
          <label>上传文档：</label>
        </div>
        <div class="field">
         <dd  class="mselector">
        <input type="file" id="file" name="upfile" accept=".xls,.doc,.txt,.pdf"   multiple>
         <button class="btn btn-lg btn-info btnimg" type="button" style="margin-top:-10px; margin-left:10px;" >上传文档</button>
           <span id="em"></span> 
           <span id="span1" style="color:#ee3333; margin-left:30px; line-height: 2.5rem;"></span>
          </dd>
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
<script>

function ss()
{
	//下拉列表
	var slt=document.getElementById("class_id");
	if(slt.value=="0")
	{
		//alert("请选择商品分类");
		$("#span").html("请选择文档分类");
		return false;
	}else
	{
		$("#span").html("");
	}
	 
	var content=$("#editor_content").val();
	var file=$("#file").val();
	
	
	if(content.length==0 && file.length==0)
	{
		$("#span1").html("提示：请填写文档内容或上传文档");
		return false;
	}
	else
	{
		$("#span1").html("");
	}
		
}





$("input[type='file']").change(function(e) {
	
	var imagename=document.getElementById('file').files[0].name
	$("#em").html(imagename);
});



</script>

</body></html>